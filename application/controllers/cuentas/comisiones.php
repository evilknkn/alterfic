<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Comisiones extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }
	public function index()
	{	
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/comision_model');
		$this->load->model('cuentas/resumen_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/comision/lista_clientes');

		$data['clientes'] = $this->clientes_model->lista_clientes();
		$data['db_com'] = $this->comision_model;

		$empresas = $this->comision_model->lista_empresas(array('ace.tipo_usuario' => 1));

		$total_gastos = 0 ;
		foreach($empresas as $empresa):
			$salida_gastos = gastos_cuenta($this->resumen_model, $empresa->id_empresa, $empresa->id_banco);

			$total_gastos = $total_gastos + $salida_gastos;
		endforeach;

		$data['gastos'] = $total_gastos;
		
		$this->load->view('layer/layerout', $data);
	}

	public function detalle_comision($id_cliente)
	{
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/comision/detalle_comision');

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;
		# creamos la session con la fecha de detalle para generar el archivo excel 
		$array_session = array('fecha_ini_comision' => $fecha_ini, 'fecha_fin_comision' => $fecha_fin);
		$this->session->set_userdata($array_session);

		$data['id_cliente'] = $id_cliente;
		$data['cliente'] = $this->clientes_model->datos_cliente(array('id_cliente'=>$id_cliente));
		$data['depositos'] = $this->comision_model->detalle_depositos(array('ad.id_cliente'=>$id_cliente, 'adc.fecha_movimiento >=' => $fecha_ini, 'adc.fecha_movimiento <=' => $fecha_fin ));
		$data['db_com'] = $this->comision_model;
		
		$this->load->view('layer/layerout', $data);
	}

	public function salida_comision()
	{
		$this->load->model('cuentas/comision_model');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/comision/lista_retiros');

		$data['retiros'] = $this->comision_model->lista_retiros();
		
		$this->load->view('layer/layerout', $data);
	}

	public function retiro_comision()
	{
		$this->load->model('cuentas/comision_model');
		$this->load->model('catalogo/empresas_model');
		$this->load->model('cuentas/salida_model');
		$this->load->model('cuentas/detalle_cuenta_model');

		$this->form_validation->set_rules('folio_retiro', 'folio de retiro', 'required|trim|callback_unique_folio');
		$this->form_validation->set_rules('monto_retiro', 'monto', 'required');
		$this->form_validation->set_rules('fecha_retiro', 'fecha de retiro', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('empresa', 'empresa', 'required');
		$this->form_validation->set_rules('id_banco', 'banco', 'required');
		$this->form_validation->set_rules('detalle_salida', 'detalle de retiro', 'required');

		$this->form_validation->set_message('required', 'El campo %s es requerido');
		
		if($this->form_validation->run()):

			$array = array(	'fecha_salida'	=>	formato_fecha_ddmmaaaa($this->input->post('fecha_retiro')),
							'monto_salida'	=>	$this->input->post('monto_retiro'),
							'folio_salida'	=> 	trim($this->input->post('folio_retiro')),
							'detalle_salida'=>	$this->input->post('detalle_salida'));

			$reg = $this->salida_model->insert_salida($array);

			$datos = array(	'id_empresa'		=>	$this->input->post('empresa'),
							'id_banco'			=>	$this->input->post('id_banco'),
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_retiro')),
							'folio_mov'			=> 	trim($this->input->post('folio_retiro')),
							'tipo_movimiento'	=>	'salida_comision');

			$this->detalle_cuenta_model->insert_movimiento($datos);

			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' registró un retiro en comisiones por '.$this->input->post('monto_retiro').' de la empresa con id '. $this->input->post('empresa').' y con id de banco '. $this->input->post('id_banco').'.' ,
                            'lugar'     =>  'Deposito',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

			$this->session->set_flashdata('success', 'Retiro agregado correctamente.');
			redirect(base_url('cuentas/comisiones/salida_comision'));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/comision/form_retiro');

			$data['empresas']	= $this->empresas_model->lista_empresas();
			
			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function bancos_empresa()
	{
		$this->load->model('catalogo/catalogo_banco_model', 'banco_model');
		$id_empresa = $this->input->post('id_empresa');

		$bancos = $this->banco_model->bancos_empresa($id_empresa);

		echo '<option value = "">Seleccione un banco</option>';
		foreach($bancos as $banco):
			echo '<option value="'.$banco->id_banco.'">'.$banco->nombre_banco.'</option>';
		endforeach;
	}


	public function clientes_pagos()
	{
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');

		$db = $this->clientes_model;

		$data['menu'] 			= 'menu/menu_admin';
		$data['body'] 			= 'admin/cuentas/comision/pagos/lista_clientes';
		$data['list_clientes'] 	= $db->lista_clientes();
		$data['db_com'] 		= $this->comision_model;
		
		
		$this->load->view('layer/layerout', $data);
	}

	public function detalle_pagos($id_cliente = null)
	{
		$this->load->model('users/clientes_model');	
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');

		$db = $this->comision_model;

		$data['menu'] 			= 'menu/menu_admin';
		$data['body'] 			= 'admin/cuentas/comision/pagos/lista_depositos_asignados';
		$data['list_deopsito'] 	= $db->lista_depositos_asignados($id_cliente);
		
		$this->load->view('layer/layerout', $data);
	}

	public function pagos_deposito()
	{
		$this->load->model('users/clientes_model');	
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');

		$deposito_id = $this->input->post('deposito_id');

		$data['lista_pagos']=$this->comision_model->lista_pagos_deposito($deposito_id);
		print_r($data['lista_pagos']);exit;
		return json_decode($data);

	}

	#### callbacks de validaciones
	function unique_folio($folio)
	{	
		$this->load->model('validate_model');

		$search_folio = $this->validate_model->unique_folio(trim($folio));

		if(count($search_folio) > 0 ):
			$this->form_validation->set_message('unique_folio', 'Este folio ya  esta registrado.');
            return FALSE;
		else:
			return true;
		endif;
	}

	function fecha_limite($fecha)
	{	
		$fecha_insert = formato_fecha_ddmmaaaa($fecha);
		$date_now = date('Y/m/d');
		$date_msg = date('d/m/Y');
		//print_r($fecha_insert);exit;
		if($fecha_insert > $date_now):
			$this->form_validation->set_message('fecha_limite', 'La fecha no puede ser mayor a el día de hoy ('.$date_msg.').');
            return FALSE;
		else:
			return TRUE;
		endif;
	}
}