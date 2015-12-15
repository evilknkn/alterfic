<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Formato_retorno_model extends CI_Model
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

	public function info_depto($id_deposito = null)
	{	
		$this->db->from('ad_depositos dep');
		$this->db->join('ad_catalogo_cliente cli', 'dep.id_cliente = cli.id_cliente', 'inner');
		$this->db->where('dep.id_deposito', $id_deposito);
		
		$query = $this->db->get();
		return $query->row();
	}
}
