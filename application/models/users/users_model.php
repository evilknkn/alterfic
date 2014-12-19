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
}