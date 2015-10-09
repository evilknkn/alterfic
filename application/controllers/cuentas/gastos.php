<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class gastos extends CI_Controller
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
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas_helper');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/gastos/lista_gastos');

		$data['empresas'] 	= $this->depositos_model->lista_empresas(array('ace.tipo_usuario' => 1));
		$data['db']			= $this->depositos_model;
		$data['db_mov']		= $this->movimiento_model;

		$this->load->view('layer/layerout', $data);
	}

	public function detalle_salida($id_empresa, $id_banco)
	{	
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->model('cuentas/depositos_model');
		$this->load->helper('cuentas_helper');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/gastos/detalle_gasto');

		$datos_empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'acb.id_banco' => $id_banco));
		$data['empresa'] = $datos_empresa;

		$data['movimientos'] = $this->movimiento_model->detalle_gastos($id_empresa, $id_banco);
		$data['db'] = $this->movimiento_model;

		$this->load->view('layer/layerout', $data);
	}
}