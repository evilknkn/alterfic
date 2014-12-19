<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login_model extends CI_Model
{
	public function datos_usuario($filtro)

	{
		$query = $this->db->get_where('ad_usuarios', $filtro);
		return $query->row();
	}

	public function actualiza_acceso($id_user)
	{	
		$execute = 'update ad_usuarios set ultimo_acceso = now() where id_user = '.$this->db->escape_str($id_user);
		$this->db->query($execute);
	}
}