<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Delete_movimiento_model extends CI_Model
{
	public function elimina_dpto($id_deposito)
	{
		$this->db->where('id_deposito', $id_deposito);
		$this->db->delete('ad_depositos');

		$this->db->where('id_movimiento', $id_deposito);
		//$this->db->where('tipo_movimiento', 'deposito');
		$this->db->delete('ad_detalle_cuenta');

	}

	public function elimina_salida($id_salida)
	{
		$this->db->where('id_salida', $id_salida);
		$this->db->delete('ad_salidas');

		$this->db->where('id_movimiento', $id_salida);
		//$this->db->where('tipo_movimiento', 'salida');
		$this->db->delete('ad_detalle_cuenta');
	}

	public function datos_pago($filtro)
	{
		$query = $this->db->get_where('ad_deposito_pago', $filtro);
		return $query->row();
	}

	public function datos_salida($filtro)
	{
		$query = $this->db->get_where('ad_salidas', $filtro);
		return $query->row();
	}

	public function elimina_pago($folio_pago, $empresa_retorno, $banco_retorno, $id_pago, $id_salida)
	{
		$this->db->where('folio_salida', $folio_pago);
		$this->db->delete('ad_salidas');

		$this->db->where(array('id_empresa' => $empresa_retorno, 'id_banco' => $banco_retorno, 'id_movimiento' => $id_salida));
		$this->db->where('tipo_movimiento', 'salida_pago');
		$this->db->delete('ad_detalle_cuenta');

		$this->db->where('id_pago', $id_pago);
		$this->db->delete('ad_deposito_pago');
	}

	public function elimina_movimiento_interno($id_movimiento)
	{
		$this->db->where('id_movimiento', $id_movimiento);
		$this->db->delete('ad_movimientos_internos');
	}
}