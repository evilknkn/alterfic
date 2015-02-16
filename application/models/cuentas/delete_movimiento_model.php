<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delete_movimiento_model extends CI_Model
{
	public function delete_registro($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}
}