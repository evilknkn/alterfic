<?php 
class Salida_model extends CI_Model
{
	public function insert_salida($array)
	{
		$this->db->insert('ad_salidas', $array);
		return $this->db->insert_id();
	}

	public function detalle_salida($filtro)
	{	
		$this->db->from('ad_detalle_cuenta ddc');
		$this->db->join('ad_salidas sal', 'ddc.id_movimiento = sal.id_salida', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_salida($array, $id_salida)
	{
		$this->db->where('id_salida', $id_salida);
		$this->db->update('ad_salidas', $array);
	}

	public function update_movimiento($datos, $id_detalle)
	{
		$this->db->where('id_detalle', $id_detalle);
		$this->db->update('ad_detalle_cuenta', $datos);
	}
}