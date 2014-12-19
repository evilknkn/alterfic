<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class catalogo_banco_model extends CI_Model
{
	public function catalogo_bancos()
	{
		$query = $this->db->get('ad_catalogo_bancos');
		return $query->result();
	}

	public function insert_banco($array)
	{
		$this->db->insert('ad_catalogo_bancos', $array);
	}

	public function empresas_asignadas($filtro)
	{
		$this->db->from('ad_catalogo_bancos acb');
		$this->db->join('ad_catalogo_empresa ace', 'acb.id_banco = ace.id_banco', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->result();
	}

	public function borrar_banco($filtro)
	{
		$this->db->where($filtro);
		$this->db->delete('ad_catalogo_bancos');
	}
	public function datos_banco($filtro)
	{
		$query = $this->db->get_where('ad_catalogo_bancos', $filtro);
		return $query->row();
	}

	public function bancos_empresa($id_empresa)
	{
		$this->db->from('ad_bancos_empresa abe');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where('abe.id_empresa', $id_empresa);
		$query =  $this->db->get();
		return $query->result();
	}
	
}
