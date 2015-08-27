<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trash_model extends CI_Model
{
	public function eliminar_movimiento($table, $filtro)
	{
		$this->db->where($filtro);
		$this->db->delete($table);
	}	
}	