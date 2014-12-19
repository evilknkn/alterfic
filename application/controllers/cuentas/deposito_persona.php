<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Deposito_persona extends CI_Controller
{
	public function index()
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas_helper');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/deposito_persona/lista_depositos');

		$data['empresas'] 	= $this->depositos_model->lista_empresas(array('ace.tipo_usuario' => 2));
		$data['db']			= $this->depositos_model;
		$data['db_mov']		= $this->movimiento_model;

		$this->load->view('layer/layerout', $data);
	}

	public function detalle_cuenta($id_empresa, $id_banco)
	{	
		$this->load->model('cuentas/depositos_model');
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');


		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/deposito_persona/detalle_deposito');

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;

		$datos_empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'acb.id_banco' => $id_banco));
		$data['empresa'] = $datos_empresa;

		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco);

		$data['movimientos'] 	= $this->movimiento_model->lista_movimientos($filtro, $fecha_ini, $fecha_fin );
		$data['clientes']	= $this->clientes_model->lista_clientes();

		$data['id_empresa'] = $id_empresa;
		$data['id_banco']	= $id_banco;
		$data['db'] = $this->depositos_model;
		$data['db_mov'] = $this->movimiento_model;
		$data['db_cliente'] = $this->clientes_model;

		$this->load->view('layer/layerout', $data);
	}

	public function insert_deposito($id_empresa, $banco)
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));

		$this->form_validation->set_rules('fecha_depto' ,'fecha del depoósito', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_depto' ,'monto del depoósito', 'required');
	//	$this->form_validation->set_rules('folio_depto' ,'folio', 'required|trim|callback_unique_folio');

		if($this->form_validation->run()):
			
			//$slug = strtoupper($empresa->nombre_empresa[0].$empresa->nombre_empresa[1]).strtoupper($empresa->nombre_banco[0]).rand(0,100);
			$folio_ant = $this->depositos_model->numero_folio($empresa->clave_cta, $id_empresa);
			
			$folio_mov = generar_folio($empresa->clave_cta, ($folio_ant+1) );

			$array = array('fecha_deposito' => formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
			 				'monto_deposito' => $this->input->post('monto_depto'),
			 				'folio_depto'	=> 	$folio_mov);

			$reg = $this->depositos_model->registra_depto($array);

			$datos = array(	'id_empresa'		=>	$id_empresa,
							'id_banco'			=>	$banco,
							'id_movimiento'		=> 	$reg,
							'folio_mov'			=> 	$folio_mov,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
							'tipo_movimiento'	=>	'deposito');

			$this->detalle_cuenta_model->insert_movimiento($datos);


			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' registró  un deposito por '.$this->input->post('monto_depto').' a la empresa '. $empresa->nombre_empresa.' en banco '. $empresa->nombre_banco.' con folio '.$folio_mov.'.' ,
                            'lugar'     =>  'Deposito',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

			$this->session->set_flashdata('success', 'El depósito se guardo correctamente');
			redirect(base_url('cuentas/deposito_persona/detalle_cuenta/'.$id_empresa.'/'.$banco));
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/deposito_persona/form_depto');

			$data['empresa'] 	= $empresa;
			$data['id_banco'] 	= $banco; 
		
			$this->load->view('layer/layerout', $data);
		endif;	
	}

	public function editar_deposito($id_empresa, $id_banco, $id_deposito)
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));
		$dt_deposito = $this->depositos_model->detalle_deposito(array('adc.id_empresa'=>$id_empresa, 'adc.id_banco' => $id_banco, 'ad.id_deposito' => $id_deposito));
		
		$this->form_validation->set_rules('fecha_depto' ,'fecha del depoósito', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_depto' ,'monto del depoósito', 'required');
		$this->form_validation->set_rules('folio_depto' ,'folio', 'required|trim|callback_unique_folio_other['.$dt_deposito->id_detalle.']');

		if($this->form_validation->run()):

			$dt_depositos = array(	'fecha_movimiento' 	=>  formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
									'folio_mov' 		=>	trim($this->input->post('folio_depto')));

			$this->depositos_model->actualiza_detalle_cuenta($dt_depositos, $this->input->post('id_detalle'));

			$deposito 	= array('fecha_deposito' => formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
								'monto_deposito' => $this->input->post('monto_depto'),
								'folio_depto'	 =>	trim($this->input->post('folio_depto')) );

			$this->depositos_model->actualiza_deposito($deposito, $this->input->post('id_deposito'));

			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' modificó el deposito con folio '.$this->input->post('folio_depto').' los datos anteriores eran: no. folio '.$dt_deposito->folio_depto.', monto '.$dt_deposito->monto_deposito.', fecha deldepto '.$dt_deposito->folio_depto.' de la empresa '. $dt_deposito->nombre_empresa.' en banco '. $dt_deposito->nombre_banco.'.' ,
                            'lugar'     =>  'Deposito edición',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

            $this->session->set_flashdata('success', 'Deposito actualizado correctamente.');
            redirect(base_url('cuentas/deposito_persona/editar_deposito/'.$id_empresa.'/'.$id_banco.'/'.$id_deposito));
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/deposito_persona/editar_deposito');
			
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']	= $id_banco;
			$data['empresa'] = $empresa;
			$data['deposito'] = $dt_deposito;

			$this->load->view('layer/layerout', $data);
		endif;
	}

	################ Callback ################################
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

	function unique_folio_other($folio, $id_detalle)
	{
		$this->load->model('validate_model');

		$search_folio = $this->validate_model->unique_folio_other(trim($folio), $id_detalle);

		if(count($search_folio) > 0 ):
			$this->form_validation->set_message('unique_folio_other', 'Este folio ya  esta registrado.');
            return FALSE;
		else:
			return true;
		endif;
	}

	function fecha_limite()
	{	
		$fecha_insert = formato_fecha_ddmmaaaa($this->input->post('fecha_depto'));
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