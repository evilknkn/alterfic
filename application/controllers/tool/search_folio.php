<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Search_folio extends  CI_Controller
{	
	public function lookFor()
	{	
		$this->load->model('search_model');
		$db			= $this->search_model;

		$folio = $this->input->post('buscar_folio');
		$row = $db->get_folio('ad_detalle_cuenta',  array('folio_mov' => $folio) );
		
		if(count($row) > 0 ):
			
			$data['success'] 	= 'success';
			$data['info'] 		= $row->tipo_movimiento;
		else:
			$data['success'] 	= 'fail';
		endif;
		echo json_encode($data);
	}

}