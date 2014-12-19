<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Repositorio_model extends CI_Model{

	function valida_imagen ($crypto){

		$query = $this->db->get_where('ad_repo_archivos', array('clave_repo' => $crypto));

		return $query->row();
	}

	function insert_repo($nombre_archivo, $clave, $ruta, $nombre_archivo, $mime, $bytes){

		$array = array('clave_repo' => $clave,
						'ruta_repo' => $ruta,

						'nombre_archivo' => $nombre_archivo,
						'mime' 		=> $mime,
						'bytes' 	=> $bytes);	

		$this->db->insert('ad_repo_archivos',$array);
	}

}