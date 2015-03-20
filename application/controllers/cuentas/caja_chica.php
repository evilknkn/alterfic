<?php 
class Caja_chica extends CI_Controller
{
	public function index()
	{	
		$this->load->model('cuentas/caja_chica_model', 'caja_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');

		$datos_empresa = $this->caja_model->empresa(array('ace.tipo_usuario'=>3));

		$fecha = fechas_rango_inicio(date('m'));


		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;
		
		$filtro = array('adc.id_empresa' => $datos_empresa->id_empresa, 'adc.id_banco' => $datos_empresa->id_banco);

		//$data['movimientos'] 	= $this->movimiento_model->lista_movimientos($filtro, $fecha_ini, $fecha_fin);
		$data['movimientos'] 	= $this->movimiento_model->lista_movimientos($filtro, $fecha_ini, $fecha_fin);
		$data['db_mov'] 	= $this->movimiento_model;
		$data['menu'] 		= 'menu/menu_admin';
		$data['empresa']	= $datos_empresa;
		$data['id_empresa'] = $datos_empresa->id_empresa;
		$data['id_banco']	= $datos_empresa->id_banco;
		$data['body']	= 'admin/cuentas/caja_chica/inicio_fondo';

		$this->load->view('layer/layerout', $data);
	}

	public function insert_deposito($id_empresa, $id_banco)
	{	
		$this->load->model('cuentas/caja_chica_model', 'caja_model');
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');

		$datos_empresa = $this->caja_model->empresa(array('ace.tipo_usuario'=>3));

		$this->form_validation->set_rules('fecha_depto' ,'fecha del depósito', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_depto' ,'monto del depósito', 'required');

		if($this->form_validation->run()):
			$folio_ant = $this->depositos_model->numero_folio('CAJA', $id_empresa);
			
			$folio_mov = generar_folio('CAJA', ($folio_ant+1) );

			$array = array('fecha_deposito' => formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
			 				'monto_deposito' => $this->input->post('monto_depto'),
			 				'folio_depto'	=> 	$folio_mov);

			$reg = $this->depositos_model->registra_depto($array);

			$datos = array(	'id_empresa'		=>	$id_empresa,
							'id_banco'			=>	$id_banco,
							'id_movimiento'		=> 	$reg,
							'folio_mov'			=> 	$folio_mov,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
							'tipo_movimiento'	=>	'deposito');

			$this->movimiento_model->insert_movimiento($datos);


			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' registró  un deposito en caja chica por '.$this->input->post('monto_depto').' con folio '.$folio_mov.'.' ,
                            'lugar'     =>  'Deposito',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

			$this->session->set_flashdata('success', 'El depósito se guardo correctamente');
			redirect(base_url('cuentas/caja_chica/'));
		else:
			$data['body']	= 'admin/cuentas/caja_chica/form_insertar_deposito';
			$data['menu'] 	= 'menu/menu_admin';
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']	= $id_banco;

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

