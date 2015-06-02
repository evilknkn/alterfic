<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Caja_chica_model extends CI_Model
{
	
	public function empresa($filtro)
	{	
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'ace.id_empresa = abe.id_empresa', 'inner');
		//$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->row();
	}

	public function total_depositos($fecha )
	{
		$sql = "SELECT SUM(monto_deposito) total_deposito FROM ad_detalle_cuenta adc 
				INNER JOIN ad_depositos ad ON adc.`id_movimiento` = ad.id_deposito
				WHERE adc.id_empresa = 30 
				AND adc.tipo_movimiento =  'deposito'
				AND adc.fecha_movimiento LIKE '%".$fecha."%'";

		$query = $this->db->query($sql);
		return $query->row();
	}

	public function total_salida( $fecha)
	{
		$sql = "SELECT SUM(monto_salida) total_salida FROM ad_detalle_cuenta adc 
				INNER JOIN ad_salidas ads ON adc.id_movimiento = ads.id_salida
				WHERE adc.`id_empresa` = 30
				AND adc.tipo_movimiento =  'salida'
				AND adc.fecha_movimiento LIKE '%".$fecha."%'";

		$query = $this->db->query($sql);
		return $query->row();
	}	
	public function total_depositos_gral()
	{
		$sql = "SELECT SUM(monto_deposito) total_deposito FROM ad_detalle_cuenta adc 
				INNER JOIN ad_depositos ad ON adc.`id_movimiento` = ad.id_deposito
				WHERE adc.id_empresa = 30 
				AND adc.tipo_movimiento =  'deposito'
				AND adc.fecha_movimiento between '2015-04-01' and '".date('Y-m-d')."' ";
		$query = $this->db->query($sql);
		return $query->row();
	}
	public function total_salida_gral()
	{
		$sql = "SELECT SUM(monto_salida) total_salida FROM ad_detalle_cuenta adc 
				INNER JOIN ad_salidas ads ON adc.id_movimiento = ads.id_salida
				WHERE adc.`id_empresa` = 30
				AND adc.tipo_movimiento =  'salida'
				AND adc.fecha_movimiento between '2015-04-01' and '".date('Y-m-d')."'";

		$query = $this->db->query($sql);
		return $query->row();
	}
}