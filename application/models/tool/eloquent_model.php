<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Eloquent_model extends CI_Model
{
	public function row_quey($table, $array)
	{
		$this->db->from($table);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_query($table, $array)
	{
		$this->db->from($table);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_in_query($table, $array, $camp)
	{
		$this->db->from($table);
		$this->db->where_in($camp, $array);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_query($table)
	{
		$query = $this->db->get($table);
		return $query->result();
	}

	public function update_where_query($table,  $data_up, $array_where )
	{
		$this->db->where($array_where);
		$this->db->update($table, $data_up);
		
	}

	public function lista_empresas()
	{	
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'ace.id_empresa = abe.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where('ace.tipo_usuario',1);
		$this->db->where('ace.estatus',1);
		$this->db->where('abe.status_cta',1);
		$this->db->order_by('ace.nombre_empresa', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
}
