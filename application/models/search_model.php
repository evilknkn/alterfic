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

	public function detailMovimientoInterno($folio)
	{	
		//print_r($folio);exit;
		$this->db->select('mov_int.id_empresa, cat_empresa.nombre_empresa, mov_int.id_banco, cat_banco.nombre_banco, mov_int.monto');
		$this->db->from('ad_movimientos_internos mov_int ');
		$this->db->join('ad_catalogo_bancos cat_banco','mov_int.id_banco = cat_banco.id_banco','inner');
		$this->db->join('ad_catalogo_empresa cat_empresa ','mov_int.id_empresa = cat_empresa.id_empresa','inner');
		$this->db->where('mov_int.folio_entrada',$folio);
		$query = $this->db->get();
		return $query->row();
	}

	
	
}