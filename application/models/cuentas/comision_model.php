<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comision_model extends CI_Model
{
	public function lista_depositos($filtro)
	{
		$query = $this->db->get_where('ad_depositos', $filtro);
		return $query->result();
	}

	public function detalle_depositos($filtro)
	{
		$this->db->from('ad_depositos ad');
		$this->db->join('ad_detalle_cuenta adc', 'adc.id_movimiento = ad.id_deposito', 'inner');
		$this->db->join('ad_catalogo_empresa ace', 'adc.id_empresa = ace.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'adc.id_banco= acb.id_banco', 'inner');
		$this->db->where($filtro);
		$this->db->where('adc.tipo_movimiento','deposito');
		$query = $this->db->get();
		return $query->result();
	}

	public function lista_retiros()
	{
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->join('ad_salidas sal', 'adc.folio_mov = sal.folio_salida', 'inner');
		$this->db->join('ad_catalogo_empresa ace', 'ace.id_empresa = adc.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = adc.id_banco', 'inner');
		$this->db->where('adc.tipo_movimiento', 'salida_comision');
		$query = $this->db->get();
		return $query->result();
	}

	public function lista_empresas($filtro)
	{	
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'ace.id_empresa = abe.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where($filtro);
		$this->db->where('ace.estatus',1);
		$this->db->order_by('ace.nombre_empresa', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
}