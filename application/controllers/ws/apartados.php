<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Apartados extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }

	public function detalle_pagos($id_cliente = null)
	{
		$this->load->model('users/clientes_model');	
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');
		$this->load->helper('utilerias');

		$db = $this->comision_model;
		$array_pagos = array();
		$lista_pagos=$db->lista_pagos_deposito($id_cliente);
		
		foreach($lista_pagos as $pago)
		{
			$array_pagos[] = array(	'monto_pago' 		=> '$'.number_format($pago->monto_pago, 2),
									'empresa_retorno' 	=> $pago->empresa_retorno,
									'banco_retorno' 	=> $pago->banco_retorno,
									'fecha_pago' 		=> formato_fecha_ddmmaaaa($pago->fecha_pago),
									'folio_pago' 		=> $pago->folio_pago,
									'nombre_banco' 		=> $pago->nombre_banco,
									'nombre_empresa' 	=> $pago->nombre_empresa );
		}
		
		$response['pagos'] = $array_pagos; 
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function depositos_general()
	{
		$this->load->model('tool/eloquent_model');
		$this->load->helper('utilerias');
		$this->load->helper('funciones_externas');

		$db = $this->eloquent_model;

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;

		$select_param 	= 'deptos.status_retorno, deptos.id_deposito, deptos.fecha_deposito, deptos.monto_deposito, deptos.id_cliente, deptos.folio_depto, detail.id_empresa, detail.id_banco, cliente.nombre_cliente, cliente.comision, empresa.nombre_empresa, banco.nombre_banco';
		$table_from 	= "ad_depositos deptos";
		$inner[0]		= array('table'=> 'ad_detalle_cuenta detail', 'on_table' => 'deptos.id_deposito = detail.id_movimiento', 'type_join' => 'inner' );
		$inner[1]		= array('table'=> 'ad_catalogo_bancos banco', 'on_table' => 'banco.id_banco=detail.id_banco', 'type_join' => 'inner' );
		$inner[2]		= array('table'=> 'ad_catalogo_empresa empresa', 'on_table' => 'empresa.id_empresa = detail.id_empresa', 'type_join' => 'inner' );
		$inner[3]		= array('table'=> 'ad_catalogo_cliente cliente', 'on_table' => 'cliente.id_cliente = deptos.id_cliente', 'type_join' => 'left' );
		$whereIn_array	= array('detail.tipo_movimiento', array('deposito_interno', 'deposito') );
		$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin);

		$params_join = array('select_active'=> 'true', 'select_fields' => $select_param,
							'from' => $table_from, 'number_joins' => count($inner), 'inner_connect' => $inner, 
							'whereIn_active' => 'true', 'whereIn_param' => $whereIn_array,
							'where_active' => 'true', 'where_param' => $where_array );
		
		$lista_deptos = $db->join_dynamic($params_join);

		$response = array();

		foreach ($lista_deptos as $depto) 
		{
			$comision_empresa= round(($depto->monto_deposito / 1.16) * $depto->comision, 2);

			$response[] = array("id_empresa" 	=> $depto->id_empresa,
								"id_banco" 		=> $depto->id_banco,
								"id_deposito"	=> $depto->id_deposito,
								"id_cliente" 	=> $depto->id_cliente,
								"nombre_empresa"=> $depto->nombre_empresa,
								"nombre_banco"	=> $depto->nombre_banco,
								"fecha_deposito"=> formato_fecha_ddmmaaaa($depto->fecha_deposito),
								"folio"			=> $depto->folio_depto,
								"nombre_cliente"=> $depto->nombre_cliente,
								"monto_deposito"=> number_format($depto->monto_deposito,2),
								"comision" 		=> number_format($comision_empresa,2) );
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function depositos_asignados()
	{
		$this->load->model('tool/eloquent_model');
		$this->load->helper('utilerias');
		$this->load->helper('funciones_externas');

		$db = $this->eloquent_model;

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;

		$select_param 	= 'deptos.status_retorno, deptos.id_deposito, deptos.fecha_deposito, deptos.monto_deposito, deptos.id_cliente, deptos.folio_depto, detail.id_empresa, detail.id_banco, cliente.nombre_cliente, cliente.comision, empresa.nombre_empresa, banco.nombre_banco';
		$table_from 	= "ad_depositos deptos";
		$inner[0]		= array('table'=> 'ad_detalle_cuenta detail', 'on_table' => 'deptos.id_deposito = detail.id_movimiento', 'type_join' => 'inner' );
		$inner[1]		= array('table'=> 'ad_catalogo_bancos banco', 'on_table' => 'banco.id_banco=detail.id_banco', 'type_join' => 'inner' );
		$inner[2]		= array('table'=> 'ad_catalogo_empresa empresa', 'on_table' => 'empresa.id_empresa = detail.id_empresa', 'type_join' => 'inner' );
		$inner[3]		= array('table'=> 'ad_catalogo_cliente cliente', 'on_table' => 'cliente.id_cliente = deptos.id_cliente', 'type_join' => 'left' );
		$whereIn_array	= array('detail.tipo_movimiento', array('deposito_interno', 'deposito') );
		$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin,'deptos.id_cliente !=' => 0 );

		$params_join = array('select_active'=> 'true', 'select_fields' => $select_param,
							'from' => $table_from, 'number_joins' => count($inner), 'inner_connect' => $inner, 
							'whereIn_active' => 'true', 'whereIn_param' => $whereIn_array,
							'where_active' => 'true', 'where_param' => $where_array );
		
		$lista_deptos = $db->join_dynamic($params_join);

		$response = array();

		foreach ($lista_deptos as $depto) 
		{
			$comision_empresa= round(($depto->monto_deposito / 1.16) * $depto->comision, 2);

			$response[] = array("id_empresa" 	=> $depto->id_empresa,
								"id_banco" 		=> $depto->id_banco,
								"id_deposito"	=> $depto->id_deposito,
								"id_cliente" 	=> $depto->id_cliente,
								"nombre_empresa"=> $depto->nombre_empresa,
								"nombre_banco"	=> $depto->nombre_banco,
								"fecha_deposito"=> formato_fecha_ddmmaaaa($depto->fecha_deposito),
								"folio"			=> $depto->folio_depto,
								"nombre_cliente"=> $depto->nombre_cliente,
								"monto_deposito"=> number_format($depto->monto_deposito,2),
								"comision" 		=> number_format($comision_empresa,2) );
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function depositos_pendientes_asignar()
	{
		$this->load->model('tool/eloquent_model');
		$this->load->helper('utilerias');
		$this->load->helper('funciones_externas');

		$db = $this->eloquent_model;

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;

		$select_param 	= 'deptos.status_retorno, deptos.id_deposito, deptos.fecha_deposito, deptos.monto_deposito, deptos.id_cliente, deptos.folio_depto, detail.id_empresa, detail.id_banco, cliente.nombre_cliente, cliente.comision, empresa.nombre_empresa, banco.nombre_banco';
		$table_from 	= "ad_depositos deptos";
		$inner[0]		= array('table'=> 'ad_detalle_cuenta detail', 'on_table' => 'deptos.id_deposito = detail.id_movimiento', 'type_join' => 'inner' );
		$inner[1]		= array('table'=> 'ad_catalogo_bancos banco', 'on_table' => 'banco.id_banco=detail.id_banco', 'type_join' => 'inner' );
		$inner[2]		= array('table'=> 'ad_catalogo_empresa empresa', 'on_table' => 'empresa.id_empresa = detail.id_empresa', 'type_join' => 'inner' );
		$inner[3]		= array('table'=> 'ad_catalogo_cliente cliente', 'on_table' => 'cliente.id_cliente = deptos.id_cliente', 'type_join' => 'left' );
		$whereIn_array	= array('detail.tipo_movimiento', array('deposito_interno', 'deposito') );
		$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin,'deptos.id_cliente ' => 0 );

		$params_join = array('select_active'=> 'true', 'select_fields' => $select_param,
							'from' => $table_from, 'number_joins' => count($inner), 'inner_connect' => $inner, 
							'whereIn_active' => 'true', 'whereIn_param' => $whereIn_array,
							'where_active' => 'true', 'where_param' => $where_array );
		
		$lista_deptos = $db->join_dynamic($params_join);

		$response = array();

		foreach ($lista_deptos as $depto) 
		{
			$comision_empresa= round(($depto->monto_deposito / 1.16) * $depto->comision, 2);

			$response[] = array("id_empresa" 	=> $depto->id_empresa,
								"id_banco" 		=> $depto->id_banco,
								"id_deposito"	=> $depto->id_deposito,
								"id_cliente" 	=> $depto->id_cliente,
								"nombre_empresa"=> $depto->nombre_empresa,
								"nombre_banco"	=> $depto->nombre_banco,
								"fecha_deposito"=> formato_fecha_ddmmaaaa($depto->fecha_deposito),
								"folio"			=> $depto->folio_depto,
								"nombre_cliente"=> $depto->nombre_cliente,
								"monto_deposito"=> number_format($depto->monto_deposito,2),
								"comision" 		=> number_format($comision_empresa,2) );
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	
	}

	public function depositos_pagados()
	{
		$this->load->model('tool/eloquent_model');
		$this->load->helper('utilerias');
		$this->load->helper('funciones_externas');

		$db = $this->eloquent_model;

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;

		$select_param 	= 'deptos.status_retorno, deptos.id_deposito, deptos.fecha_deposito, deptos.monto_deposito, deptos.id_cliente, deptos.folio_depto, detail.id_empresa, detail.id_banco, cliente.nombre_cliente, cliente.comision, empresa.nombre_empresa, banco.nombre_banco';
		$table_from 	= "ad_depositos deptos";
		$inner[0]		= array('table'=> 'ad_detalle_cuenta detail', 'on_table' => 'deptos.id_deposito = detail.id_movimiento', 'type_join' => 'inner' );
		$inner[1]		= array('table'=> 'ad_catalogo_bancos banco', 'on_table' => 'banco.id_banco=detail.id_banco', 'type_join' => 'inner' );
		$inner[2]		= array('table'=> 'ad_catalogo_empresa empresa', 'on_table' => 'empresa.id_empresa = detail.id_empresa', 'type_join' => 'inner' );
		$inner[3]		= array('table'=> 'ad_catalogo_cliente cliente', 'on_table' => 'cliente.id_cliente = deptos.id_cliente', 'type_join' => 'left' );
		$whereIn_array	= array('detail.tipo_movimiento', array('deposito_interno', 'deposito') );
		$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin,'deptos.status_retorno' => 'pagado' );

		$params_join = array('select_active'=> 'true', 'select_fields' => $select_param,
							'from' => $table_from, 'number_joins' => count($inner), 'inner_connect' => $inner, 
							'whereIn_active' => 'true', 'whereIn_param' => $whereIn_array,
							'where_active' => 'true', 'where_param' => $where_array );
		
		$lista_deptos = $db->join_dynamic($params_join);

		$response = array();

		foreach ($lista_deptos as $depto) 
		{
			$comision_empresa= round(($depto->monto_deposito / 1.16) * $depto->comision, 2);

			$response[] = array("id_empresa" 	=> $depto->id_empresa,
								"id_banco" 		=> $depto->id_banco,
								"id_deposito"	=> $depto->id_deposito,
								"id_cliente" 	=> $depto->id_cliente,
								"nombre_empresa"=> $depto->nombre_empresa,
								"nombre_banco"	=> $depto->nombre_banco,
								"fecha_deposito"=> formato_fecha_ddmmaaaa($depto->fecha_deposito),
								"folio"			=> $depto->folio_depto,
								"nombre_cliente"=> $depto->nombre_cliente,
								"monto_deposito"=> number_format($depto->monto_deposito,2),
								"comision" 		=> number_format($comision_empresa,2) );
		}
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}