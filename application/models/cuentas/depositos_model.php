<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class  Depositos_model extends CI_Model
{	
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

	public function banco ($filtro)
	{	
		$this->db->select('acb.nombre_banco');
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'abe.id_empresa = ace.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->result();
	}

	public function empresa($filtro)
	{
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'ace.id_empresa = abe.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->row();
	}


	public function registra_depto($array)
	{
		$this->db->insert('ad_depositos', $array);
		return $this->db->insert_id();
	}

	public function insert_cliente($array)
	{
		$this->db->insert('ad_cliente_empresa', $array);
	}

	public function insert_pago($array)
	{
		$this->db->insert('ad_deposito_pago', $array);
	}

	public function pagos_deposito($array)
	{
		$query = $this->db->get_where('ad_deposito_pago', $array);
		return $query->result();
	}
	public function insert_movimiento($array)
	{
		$this->db->insert('ad_detalle_cuenta', $array);
	}

	public function actualiza_cliente($filtro, $data)
	{
		$this->db->where($filtro);
		$this->db->update('ad_depositos', $data);
	}

	public function insert_salida($array)
	{
		$this->db->insert('ad_salidas', $array);
		return $this->db->insert_id();
	}

	public function detalle_deposito($filtro)
	{	
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->join('ad_depositos ad', 'ad.id_deposito = adc.id_movimiento', 'inner');
		$this->db->join('ad_catalogo_empresa ace', 'ace.id_empresa = adc.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = adc.id_banco', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->row();
	}

	public function detalle_salida($filtro)
	{	
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->join('ad_salidas sal', 'sal.id_salida = adc.id_movimiento', 'inner');
		$this->db->join('ad_catalogo_empresa ace', 'ace.id_empresa = adc.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = adc.id_banco', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->row();
	}

	public function detalle_pago($id_pago)
	{
		$this->db->from('ad_deposito_pago adp');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = adp.id_banco', 'inner');
		$this->db->join('ad_catalogo_empresa ace', 'ace.id_empresa = adp.id_empresa', 'inner');
		$this->db->join('ad_depositos ad', 'ad.id_deposito = adp.id_deposito', 'inner');
		$this->db->join('ad_detalle_cuenta adc', 'adc.folio_mov = adp.folio_pago', 'inner');
		$this->db->join('ad_salidas salida', 'salida.folio_salida = adp.folio_pago', 'inner');
		$this->db->where('adp.id_pago', $id_pago);
		$query = $this->db->get();
		return $query->row();
	}

	public function actualiza_detalle_cuenta($dt_deposito, $id_detalle)
	{
		$this->db->where('id_detalle', $id_detalle);
		$this->db->update('ad_detalle_cuenta', $dt_deposito);
	}

	public function actualiza_deposito($deposito, $id_deposito)
	{
		$this->db->where('id_deposito', $id_deposito);
		$this->db->update('ad_depositos', $deposito);
	}

	public function update_deposito_pago($array, $id_pago)
	{
		$this->db->where('id_pago', $id_pago);
		$this->db->update('ad_deposito_pago', $array);
	}

	public function update_salidas($array_salida, $id_salida)
	{
		$this->db->where('id_salida', $id_salida);
		$this->db->update('ad_salidas', $array_salida);
	}

	public function update_detalle_cuenta($array_detalle, $id_detalle)
	{
		$this->db->where('id_detalle', $id_detalle);
		$this->db->update('ad_detalle_cuenta', $array_detalle);
	}

	public function numero_folio($clave)
	{
		$this->db->from('ad_detalle_cuenta');
		//$this->db->where('id_empresa', $id_empresa);
		$this->db->like('folio_mov', $clave);
		
		return $this->db->count_all_results();
	}
}