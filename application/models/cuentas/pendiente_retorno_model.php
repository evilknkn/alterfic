<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pendiente_retorno_model extends CI_Model
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
}
