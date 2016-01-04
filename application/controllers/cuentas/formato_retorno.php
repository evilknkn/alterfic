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

		$data = array(	'id_empresa' 	=> $this->input->post('id_empresa'),
						'id_banco' 		=> $this->input->post('id_banco'),
						'monto' 		=> $this->input->post('monto'),
						'fecha_deposito'=> formato_fecha_ddmmaaaa($this->input->post('fecha')),
						'folio_cliente'	=> $this->input->post('folio_cliente'));

		$db->insert_query('ad_formato_retorno_deposito', $data);

		$response['success'] = 'true';

		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function deposito($id_deposito = null, $id_empresa = null , $id_banco = null)
	{	
		$this->load->model('tool/formato_retorno_model');	
		$this->load->model('users/clientes_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');
		$this->load->helper('utilerias');

		$db = $this->formato_retorno_model;


		$data['menu'] 			= 'menu/menu_admin';
		$data['body'] 			= 'admin/cuentas/formatoRetorno/formato_retorno_pagos';

		$deposito 				= $db->info_depto($id_deposito);
		$seek_folio 			= $db->get_like_query('ad_folio_cliente', array('folio_cliente'=> $deposito->clave_folio), array("id_cliente" => $deposito->id_cliente, "id_deposito" => $id_deposito));
		
		$data['empresa'] 		= $db->row_quey('ad_catalogo_empresa', array('id_empresa'=> $id_empresa));
		$data['banco'] 			= $db->row_quey('ad_catalogo_bancos', array('id_banco'=> $id_banco));
		
		$data['info_deposito'] 	= $deposito;
		$data['comision_cliente']= genera_comision($this->clientes_model, $deposito->id_cliente, $deposito->monto_deposito);
		

		if(count($seek_folio) == 0):
			$data['folio_cliente']  = generar_folio($deposito->clave_folio, (count($seek_folio) + 1));	
			$db->insert_query('ad_folio_cliente', array('id_cliente'=>$deposito->id_cliente, 'id_deposito' =>$id_deposito, 'folio_cliente' => $data['folio_cliente']));
			$data['lista_retornos']=array();
			$data['monto_retornar'] =	$deposito->monto_deposito - $data['comision_cliente'];
		else:
			$data['folio_cliente']  = $seek_folio[0]->folio_cliente;

			$data['lista_retornos']=$db->get_query('ad_formato_retorno', array('folio_cliente'=>$seek_folio[0]->folio_cliente ));	
			$data['monto_retornar'] =	$deposito->monto_deposito - $data['comision_cliente'];
		endif;
		
		
		
		//$data['list_deopsito'] 	= $db->lista_depositos_asignados($id_cliente);

		
		$this->load->view('layer/layerout', $data);
	
	}

	public function keepDataForma()
	{	
		$this->load->model('tool/formato_retorno_model');	
		$this->load->model('users/clientes_model');
		$db = $this->formato_retorno_model;

		$total_retornado 	= $this->input->post('total_retornado');
		$monto_retornar 	= $this->input->post('monto_retornar');
		$monto 				= $this->input->post('monto');

		$valida_monto = ($total_retornado + $monto);

		if($valida_monto > $monto_retornar)
		{
			$data['success'] = 'false';
			$data['txtAlert']= 'El monto ingresado es mayor al monto a retornar verifique el monto por favor';

		}else{
			$data = array('id_cliente' 	=> $this->input->post('id_cliente'),
					'folio_cliente' => $this->input->post('folio_cliente'),
					'id_deposito' 	=> $this->input->post('id_deposito'),
					'tipo_retorno' 	=> $this->input->post('tipo_retorno'),
					'nombre' 		=> $this->input->post('nombre'), 
					'monto'			=> $this->input->post('monto'),
					'parametro' 	=> $this->input->post('parametro'));

			$reg_id = $db->insert_query('ad_formato_retorno', $data);

			$suma_montos = $db->sum_montos_retorno($this->input->post('folio_cliente'));
			
			$suma_movimientos = $db->get_query('ad_formato_retorno' ,array('folio_cliente'=>$this->input->post('folio_cliente')));
					
			$data['success'] = 'true';
			$data['forma_id'] = $reg_id;
			$data['total_monto_format'] = number_format($suma_montos[0]->monto,2);
			$data['total_monto'] 		= $suma_montos[0]->monto;
			$data['total_movimientos'] 	= count($suma_movimientos);
			
		}
		echo json_encode($data);
	}
}
