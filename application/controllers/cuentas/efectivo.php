<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class efectivo extends CI_Controller
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
		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/efectivo/lista_efectivo');

		$this->load->view('layer/layerout', $data);
	}
}