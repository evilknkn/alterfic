<?php 
date_default_timezone_set('America/Mexico_City');
class Fondos extends CI_Controller
{
	public function index()
	{
		$data['menu'] 	= 'menu/menu_admin';
		$data['body']	= 'admin/cuentas/fondo/inicio_fondo';
		$this->load->view('layer/layerout', $data);
	}
}