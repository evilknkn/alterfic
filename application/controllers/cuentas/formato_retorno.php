<?php 
date_default_timezone_set('America/Mexico_City');
class Formato_retorno extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }

	public function getClientes()
	{
		$this->load->model('users/clientes_model');
		$db = $this->clientes_model;

		$data['menu'] 			= 'menu/menu_admin';
		$data['body'] 			= 'admin/solicitudes/lista_clientes';
		$data['lista_clientes'] = $db->lista_clientes();
		$this->load->view('layer/layerout', $data);

	}

	public function create($id_cliente = null)
	{	
		$this->load->model('users/clientes_model');
		$this->load->model('tool/formato_retorno_model');
		$db = $this->clientes_model;
		$db2 = $this->formato_retorno_model;

		$info = $db->datos_cliente(array('id_cliente' => $id_cliente));
		
		$data['menu'] 			= 'menu/menu_admin';
		$data['body'] 			= 'admin/solicitudes/formatoRetorno/formato_retorno_pagos';
		$data['id_cliente'] 	= $id_cliente;
		$data['nombre_cliente'] = $info->nombre_cliente;
		$data['comision_porcentaje']= $info->comision;
		$data['folio_cliente']  = 'ANG-00001';
		$data['comision_empresa']= number_format(0,2);
		$data['sobrante']		= number_format(0,2);
		$data['empresas'] 		= $db2->get_query('ad_catalogo_empresa',array('tipo_usuario'=>1), true);

		$this->load->view('layer/layerout', $data);

		//$seek_folio 			= $db->get_like_query('ad_folio_cliente', array('folio_cliente'=> $deposito->clave_folio), array("id_cliente" => $deposito->id_cliente, "id_deposito" => $id_deposito));
	}

	public function banco_empresa()
	{	
		$this->load->model('tool/formato_retorno_model');
		$id_empresa = $this->input->post('id_empresa');
		$db = $this->formato_retorno_model;

		$data['bancos'] = $db->bancos_empresa($id_empresa);

		return $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function guardar_deposito()
	{	
		$this->load->model('tool/formato_retorno_model');
		$this->load->helper('funciones_externas');

		$db = $this->formato_retorno_model;

		$comison_cliente = $this->input->post('comision_cliente');
		$folio_cliente = $this->input->post('folio_cliente');

		$data = array(	'id_empresa' 	=> $this->input->post('id_empresa'),
						'id_banco' 		=> $this->input->post('id_banco'),
						'monto' 		=> $this->input->post('monto'),
						'fecha_deposito'=> formato_fecha_ddmmaaaa($this->input->post('fecha')),
						'folio_cliente'	=> $this->input->post('folio_cliente'));

		$reg_id =$db->insert_query('ad_formato_retorno_deposito', $data);

		$total_depositos = $db->sum_montos_retorno($folio_cliente);
		$total_retornos  = $db->sum_montos_formato($folio_cliente);
		$monto_deposito = round($total_depositos[0]->monto, 2);
		$monto_retorno  = round($total_retornos[0]->monto, 2);
		$comision_empresa= round(($total_depositos[0]->monto / 1.16) * $comison_cliente, 2);

		//print_r($comision_empresa);exit;

		$response['comision'] = number_format($comision_empresa,2);
		$response['total_depositos_sobrante'] = number_format((($monto_deposito - $monto_retorno) - $comision_empresa), 2) ;
		$response['total_depositos'] = number_format($monto_deposito,2);
		$response['deposito_id'] 	= $reg_id;
		$response['success'] = 'true';

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function delete_deposito()
	{
		$this->load->model('tool/formato_retorno_model');
		$this->load->helper('funciones_externas');

		$db = $this->formato_retorno_model;

		$comison_cliente = $this->input->post('comision_cliente');
		$folio_cliente = $this->input->post('folio_cliente');

		$db->detele_query('ad_formato_retorno_deposito', array('id_reg' => $this->input->post('deposito_id') ));

		$total_depositos = $db->sum_montos_retorno($folio_cliente);
		$total_retornos  = $db->sum_montos_formato($folio_cliente);
		
		$monto_deposito = round($total_depositos[0]->monto, 2);
		$monto_retorno  = round($total_retornos[0]->monto, 2);
		$comision_empresa= round(($total_depositos[0]->monto / 1.16) * $comison_cliente, 2);

		$response['comision'] = number_format($comision_empresa,2);
		$response['total_depositos_sobrante'] = number_format((($monto_deposito - $monto_retorno) - $comision_empresa), 2) ;
		$response['total_depositos'] = number_format($monto_deposito,2);
		
		$response['success'] = 'true';

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function keepDataForma()
	{	
		$this->load->model('tool/formato_retorno_model');	
		$this->load->model('users/clientes_model');
		$db = $this->formato_retorno_model;

		$id_cliente 		= $this->input->post('id_cliente');
		$folio_cliente 		= $this->input->post('folio_cliente');
		$tipo_retorno 		= $this->input->post('tipo_retorno');
		$nombre_cheque 		= $this->input->post('nombre');
		$monto 				= $this->input->post('monto');
		$folio_cheque 		= $this->input->post('parametro');
		$comison_cliente = $this->input->post('comision_cliente');

		$total_depositos = $db->sum_montos_retorno($folio_cliente);
		$total_retornos  = $db->sum_montos_formato($folio_cliente);

		$monto_deposito = round($total_depositos[0]->monto, 2);
		$monto_retorno  = round($total_retornos[0]->monto, 2) + $monto;
		$comision_empresa= round(($total_depositos[0]->monto / 1.16) * $comison_cliente, 2);

		if($monto_retorno > $monto_deposito)
		{
			$data['success'] = 'false';
			$data['txtAlert']= 'El monto ingresado es mayor al monto a retornar verifique que sea correcta la cifra';

		}else{
			$data_insert = array('id_cliente' 	=> $this->input->post('id_cliente'),
					'folio_cliente' => $this->input->post('folio_cliente'),
					'tipo_retorno' 	=> $this->input->post('tipo_retorno'),
					'nombre' 		=> $this->input->post('nombre'), 
					'monto'			=> $this->input->post('monto'),
					'parametro' 	=> $this->input->post('parametro'));

			$reg_id = $db->insert_query('ad_formato_retorno', $data_insert);
			
			$total_retornos_gral  = $db->sum_montos_formato($folio_cliente);

			$data['success'] = 'true';
			$data['forma_id'] = $reg_id;

			$data['total_depositos_sobrante'] = number_format((($monto_deposito - $monto_retorno) - $comision_empresa), 2) ;
			
			//$data['total_depositos'] = number_format($monto_deposito - round($total_retornos_gral[0]->monto,2), 2) ;
			$data['total_formato'] 	= number_format($total_retornos_gral[0]->monto,2);

		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function delete_forma()
	{
		$this->load->model('tool/formato_retorno_model');
		$this->load->helper('funciones_externas');

		$db = $this->formato_retorno_model;

		$comison_cliente = $this->input->post('comision_cliente');
		$folio_cliente = $this->input->post('folio_cliente');

		$db->detele_query('ad_formato_retorno', array('id_formato' => $this->input->post('forma_id') ));

		$total_depositos = $db->sum_montos_retorno($folio_cliente);
		$total_retornos  = $db->sum_montos_formato($folio_cliente);
		
		$monto_deposito = round($total_depositos[0]->monto, 2);
		$monto_retorno  = round($total_retornos[0]->monto, 2);
		$comision_empresa= round(($total_depositos[0]->monto / 1.16) * $comison_cliente, 2);

		$data['total_depositos_sobrante'] = number_format((($monto_deposito - $monto_retorno) - $comision_empresa), 2) ;
		$data['total_formato'] 	= number_format($monto_retorno,2);
		
		$response['success'] = 'true';

		return $this->output->set_content_type('application/json')->set_output(json_encode($data));		
	}

	public function data_deposito()
	{
		$this->load->model('tool/formato_retorno_model');
		$this->load->helper('funciones_externas');

		$db = $this->formato_retorno_model;

		$comison_cliente = $this->input->post('comision_cliente');
		$folio_cliente = $this->input->post('folio_cliente');

		//////


		//////

		$total_depositos = $db->sum_montos_retorno($folio_cliente);
		$total_retornos  = $db->sum_montos_formato($folio_cliente);
		
		$monto_deposito = round($total_depositos[0]->monto, 2);
		$monto_retorno  = round($total_retornos[0]->monto, 2);
		$comision_empresa= round(($total_depositos[0]->monto / 1.16) * $comison_cliente, 2);

		$response['deposito'] = '';
		$response['comision'] = number_format($comision_empresa,2);
		$response['total_depositos_sobrante'] = number_format((($monto_deposito - $monto_retorno) - $comision_empresa), 2) ;
		$response['total_depositos'] = number_format($monto_deposito,2);
		
		$response['success'] = 'true';


		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}
