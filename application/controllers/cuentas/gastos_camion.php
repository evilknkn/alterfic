<?php 
class Gastos_camion extends CI_Controller
{
	public function index()
	{	
		$this->load->model('cuentas/caja_chica_model', 'caja_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');

		$datos_empresa = $this->caja_model->empresa(array('ace.tipo_usuario'=>3, 'ace.id_empresa' => 48));

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
		$data['body']	= 'admin/cuentas/gastos_camion/inicio_fondo';

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
			$folio_ant = $this->depositos_model->numero_folio('GACAM', $id_empresa);
			
			$folio_mov = generar_folio('GACAM', ($folio_ant+1) );

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
			redirect(base_url('cuentas/gastos_camion/'));
		else:
			$data['body']	= 'admin/cuentas/gastos_camion/form_insertar_deposito';
			$data['menu'] 	= 'menu/menu_admin';
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']	= $id_banco;

			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function saldo_gasto_camion()
	{
	//	echo 'llegamos';exit;
		$this->load->model('cuentas/gastos_camion_model', 'gastos_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('utilerias');

		$month 	= ( $this->input->post('mes') < 10)? '0'.$this->input->post('mes'): $this->input->post('mes');

		$year 	= $this->input->post('ano');
		$date_now = $year.'-'.$month;

		$deposito = $this->gastos_model->total_depositos($date_now);
		$salida   = $this->gastos_model->total_salida($date_now);
		$saldo 	  = $deposito->total_deposito - $salida->total_salida;

		$deposito_gral 		= $this->gastos_model->total_depositos_gral();
		$salida_gral  		= $this->gastos_model->total_salida_gral();
		$saldo_disponible 	= $deposito_gral->total_deposito - $salida_gral->total_salida;

		$data[] = array('deposito' => convierte_moneda($deposito->total_deposito), 
						'salida' =>convierte_moneda($salida->total_salida),
						'saldo' => convierte_moneda($saldo), 
						'deposito_gral' => convierte_moneda($deposito_gral->total_deposito),
						'salida_gral' => convierte_moneda($salida_gral->total_salida),
						'saldo_disponible' => convierte_moneda($saldo_disponible));
		//print_r($data);exit;
		echo json_encode($data);
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

