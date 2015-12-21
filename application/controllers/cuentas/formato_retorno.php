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
		$this->load->helper('utilerias');

		$db = $this->formato_retorno_model;

		$data['menu'] 			= 'menu/menu_admin';
		$data['body'] 			= 'admin/cuentas/formatoRetorno/Formato_retorno_pagos';
		$deposito 				= $db->info_depto($id_deposito);
		$seek_folio 			= $db->get_like_query('ad_formato_retorno', array('folio_cliente'=> $deposito->clave_folio));
		//$existe_folio 			= $db->folio_cliente(array('forma_r.id_cl'=> $deposito->id_cliente, 'forma_r.id_deposito' => $id_deposito));

		$data['folio_cliente']  = generar_folio($deposito->clave_folio, ($seek_folio + 1));
			

		$data['empresa'] 		= $db->row_quey('ad_catalogo_empresa', array('id_empresa'=> $id_empresa));
		$data['banco'] 			= $db->row_quey('ad_catalogo_bancos', array('id_banco'=> $id_banco));
		
		$data['info_deposito'] 	= $deposito;
		$data['comision_cliente']= genera_comision($this->clientes_model, $deposito->id_cliente, $deposito->monto_deposito);
		$data['monto_retornar'] =	$deposito->monto_deposito - $data['comision_cliente'];
		
		//$data['list_deopsito'] 	= $db->lista_depositos_asignados($id_cliente);
		
		$this->load->view('layer/layerout', $data);
	
	}

	public function keepDataForma()
	{	
		$this->load->model('tool/formato_retorno_model');	
		$this->load->model('users/clientes_model');
		$db = $this->formato_retorno_model;

		$data = array('id_cliente' 	=> $this->input->post('id_cliente'),
					'folio_cliente' => $this->input->post('folio_cliente'),
					'id_deposito' 	=> $this->input->post('id_deposito'),
					'tipo_retorno' 	=> $this->input->post('tipo_retorno'),
					'nombre' 		=> $this->input->post('nombre'), 
					'monto'			=> $this->input->post('monto'),
					'parametro' 	=> $this->input->post('parametro'));

		$reg_id = $db->insert_query('ad_formato_retorno', $data);
		
		$data['success'] = 'true';
		$data['forma_id'] = $reg_id;
		echo json_encode($data);
	}
}
