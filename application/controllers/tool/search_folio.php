<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Search_folio extends  CI_Controller
{	
	public function lookFor()
	{	
		$this->load->model('search_model');
		$this->load->helper('search_helper');

		$db			= $this->search_model;

		$folio = $this->input->post('buscar_folio');
		$row = $db->get_folio('ad_detalle_cuenta',  array('folio_mov' => $folio) );

		//print_r($row);exit;
		if(count($row) > 0 ):
			$type_mov 			= indefity_mov($row->tipo_movimiento);
			$data['empresa']	= indetify_factory($db, $row->id_empresa);
			$data['banco'] 		= indetify_bank($db, $row->id_banco);
			$data['message'] 	= 'El folio '.$folio.' es un movimiento '.$type_mov.' en la empresa '.$data['empresa'].' en el banco '.$data['banco'].' con fecha '. $row->fecha_movimiento ;
			$data['success'] 	= 'success';
			$data['info'] 		= $row->tipo_movimiento;
		else:
			$data['success'] 	= 'fail';
		endif;
		echo json_encode($data);
	}

}