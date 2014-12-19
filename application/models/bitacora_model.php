<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bitacora_model extends CI_Model
{	
	public function insert_log($array)
	{
		$this->db->insert('ad_bitacora', $array);	
	}


	
}