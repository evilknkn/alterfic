<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Resumen_model extends CI_Model
{
	public function total_depositos()
	{
		$this->db->from('ad_depositos');
		$query = $this->db->get();
		return $query->result();
	}

	public function lista_clientes()
	{
		$query = $this->db->get('ad_catalogo_cliente');
		return $query->result();
	}

	public function lista_movimiento($filtro, $tipo_mov)
	{
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->result();

	}

	public function movimientos_deposito($id_movimiento)
	{		//if($id_movimiento[0]== 5 ){print_r($id_movimiento);}
		$this->db->from('ad_depositos ad');
		$this->db->where_in('id_deposito', $id_movimiento);
		$query = $this->db->get();
		return $query->result();
	}

	public function movimientos_salida($id_movimiento)
	{	
		$this->db->from('ad_salidas');
		$this->db->where_in('id_salida', $id_movimiento);
		$query = $this->db->get();
		return $query->result();
	}

	public function detalle_gastos($id_empresa, $id_banco)
	{
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->join('ad_salidas sal', 'adc.folio_mov = sal.folio_salida', 'inner');
		$this->db->where(array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco, 'adc.tipo_movimiento' => 'salida'));
		$query = $this->db->get();
		return $query->result();
 
	}

}