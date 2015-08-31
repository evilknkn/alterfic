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
}
