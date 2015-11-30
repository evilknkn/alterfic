<?php
class Movimientos_internos_model extends CI_Model
{
	public function lista_movimientos($filtro)
	{
		$query = $this->db->get_where('ad_movimientos_internos', $filtro);
		return $query->result();
	}

	public function insert_movimiento($datos)
	{
		$this->db->insert('ad_movimientos_internos', $datos);
		return $this->db->insert_id();
	}

	public function detalle_pago($id_pago)
	{
		$query = $this->db->get_where('ad_deposito_pago', array('id_pago' => $id_pago));
		return $query->row();
	}
	public function insert_salida($array)
	{
		$this->db->insert('ad_salidas', $array);
		return $this->db->insert_id();
	}

	public function insert_movimiento_detalle($array)
	{
		$this->db->insert('ad_detalle_cuenta', $array);
	}

	public function registra_depto($array)
	{
		$this->db->insert('ad_depositos', $array);
		return $this->db->insert_id();
	}

	public function detalle_movimiento($id_movimiento)
	{
		$query = $this->db->get_where('ad_movimientos_internos', array('id_movimiento' => $id_movimiento));
		return $query->row();
	}

	public function detalle_salida($folio)
	{	
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->join('ad_salidas sal', 'sal.folio_salida = adc.folio_mov', 'inner');
		$this->db->where('adc.folio_mov', $folio);
		$query = $this->db->get();
		return $query->row();
	}

	public function detalle_deposito($folio)
	{
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->join('ad_depositos ad', 'ad.folio_depto = adc.folio_mov', 'inner');
		$this->db->where('adc.folio_mov', $folio);
		$query = $this->db->get();
		return $query->row();
	}

	public function update_movimiento_int($datos, $filtro_int)
	{
		$this->db->where($filtro_int);
		$this->db->update('ad_movimientos_internos', $datos);
	}

	public function update_salida($array, $filtro_salida)
	{
		$this->db->where($filtro_salida);
		$this->db->update('ad_salidas', $array);
	}

	public function update_movimiento_detalle($datos, $filtro_mov_int)
	{
		$this->db->where($filtro_mov_int);
		$this->db->update('ad_detalle_cuenta', $datos);
	}
	public function update_depto($array, $filtro_depto)
	{
		$this->db->where($filtro_depto);
		$this->db->update('ad_depositos', $array);
	}

	public function insertMovimiento($datos)
	{
		$this->db->insert('ad_log_movimiento_express', $datos);
	}
}