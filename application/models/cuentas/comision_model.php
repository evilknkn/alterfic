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

	public function lista_depositos_asignados($id_cliente= null)
	{	
		//echo $id_cliente;exit;
		$this->db->select('deposito.id_deposito, deposito.monto_deposito, deposito.folio_depto,cuenta.id_empresa, cuenta.id_banco, cuenta.folio_mov,banco.nombre_banco, empresa.nombre_empresa');
		$this->db->from('ad_depositos as deposito');
		$this->db->join('ad_detalle_cuenta as cuenta','deposito.id_deposito = cuenta.id_movimiento','inner');
		$this->db->join('ad_catalogo_bancos as banco ','cuenta.id_banco = banco.id_banco','inner');
		$this->db->join('ad_catalogo_empresa as empresa','cuenta.id_empresa = empresa.id_empresa ','innner');
		$this->db->where('cuenta.tipo_movimiento','deposito');
		$this->db->where('deposito.id_cliente ', $id_cliente);
		$query = $this->db->get();
		return $query->result();

	}
	/*select 
pago.monto_pago, pago.empresa_retorno, pago.banco_retorno, pago.fecha_pago, pago.folio_pago,
banco.nombre_banco, empresa.nombre_empresa
from ad_deposito_pago as pago
inner join ad_catalogo_bancos as banco on pago.banco_retorno = banco.id_banco
inner join ad_catalogo_empresa as empresa on pago.empresa_retorno = empresa.id_empresa 
where id_deposito =872*/
}