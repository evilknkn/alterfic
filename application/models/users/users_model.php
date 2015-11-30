<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_model extends CI_Model
{
	public function list_users($filtro)
	{
		$query = $this->db->get_where('ad_usuarios', $filtro);
		return $query->result();
	}

	public function new_user($array)
	{
		$this->db->insert('ad_usuarios', $array);
		return $this->db->insert_id();
	}

	public function rowData($table, $array)
	{
		$query = $this->db->get_where($table, $array);
		return $query->row();
	}

	public function getData($table, $array)
	{
		$query = $this->db->get_where($table, $array);
		return $query->result();
	}

	public function update($table, $array, $where)
	{
		$this->db->where($where);
		$this->db->update($table, $array);
	}
}