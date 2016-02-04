<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Apartados extends CI_Controller
{
	public function detalle_pagos($id_cliente = null)
	{
		$this->load->model('users/clientes_model');	
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');

		$db = $this->comision_model;

		$response['pagos']=$db->lista_pagos_deposito($id_cliente);
		
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}