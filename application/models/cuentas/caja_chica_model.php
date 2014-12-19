<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Caja_chica_model extends CI_Model
{
	
	public function empresa($filtro)
	{	
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'ace.id_empresa = abe.id_empresa', 'inner');
		//$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->row();
	}
}