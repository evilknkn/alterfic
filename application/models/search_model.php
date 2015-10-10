<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Search_model extends CI_Model
{	
	// public function buscar_folio_detalle($table, $array)
	// {
	// 	print_r($array);exit;
	// 	$query = $this->db->get_where($table, $array);	
	// 	$query= return $query->row();
	// }

	public function get_folio($table, $array)
	{
		$query = $this->db->get_where($table, $array);	
		return $query->row();
	}

	
	
}