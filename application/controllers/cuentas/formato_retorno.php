<?php 
date_default_timezone_set('America/Mexico_City');
class Formato_retorno extends CI_Controller
{
	public function deposito($id_deposito = null, $id_empresa = null , $id_banco = null)
	{	
		//echo $id_deposito;exit;
		$this->load->model('tool/formato_retorno_model');	
		$this->load->model('users/clientes_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');

		$db = $this->formato_retorno_model;

		$data['menu'] 			= 'menu/menu_admin';
		$data['body'] 			= 'admin/cuentas/formatoRetorno/Formato_retorno_pagos';
		$data['empresa'] 		= $db->row_quey('ad_catalogo_empresa', array('id_empresa'=> $id_empresa));
		$data['banco'] 			= $db->row_quey('ad_catalogo_bancos', array('id_banco'=> $id_banco));
		$deposito 				= $db->info_depto($id_deposito);
		$data['info_deposito'] 	= $deposito;

		$data['comision_cliente']= genera_comision($this->clientes_model, $deposito->id_cliente, $deposito->monto_deposito);
		$data['monto_retornar'] =	$deposito->monto_deposito - $data['comision_cliente'];
		
		//$data['list_deopsito'] 	= $db->lista_depositos_asignados($id_cliente);
		
		$this->load->view('layer/layerout', $data);
	
	}
}
