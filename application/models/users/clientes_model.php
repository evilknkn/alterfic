<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clientes_model extends CI_Model
{
	public function lista_clientes()
	{	$this->db->from('ad_catalogo_cliente');
		$this->db->order_by('nombre_cliente', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	public function insert_cliente($array)
	{
		$this->db->insert('ad_catalogo_cliente', $array);
	}

	public function datos_cliente($filtro)
	{
		$query = $this->db->get_where('ad_catalogo_cliente', $filtro);
		return $query->row();
	}

	public function update_cliente($datos, $id_cliente)
	{
		$this->db->where('id_cliente', $id_cliente);
		$this->db->update('ad_catalogo_cliente', $datos);
	}
}