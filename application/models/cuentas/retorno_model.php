<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Retorno_model extends  CI_Model
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

	public function all_empresas()
	{	$this->db->from('ad_catalogo_empresa');
		$this->db->where(array('estatus' => 1, 'tipo_usuario' => 1));
		$this->db->order_by('nombre_empresa');
		$query = $this->db->get();
		return $query->result();
	}

	public function detalle_retorno($filtro)
	{
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->join('ad_depositos ad', 'ad.id_deposito = adc.id_movimiento', 'inner');
		$this->db->where($filtro);
		$this->db->order_by('ad.folio_depto','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function depositos_empresa($filtro)
	{
		$this->db->from('ad_depositos ad');
		$this->db->join('ad_detalle_cuenta adc', 'adc.id_movimiento = ad.id_deposito', 'inner');
		$this->db->where($filtro);
		$query = $this->db->get();
		return $query->result();
	}

	public function datos_cliente($filtro)
	{
		$query = $this->db->get_where('ad_catalogo_cliente', $filtro);
		return $query->row();
	}

	public function pagos_depto($filtro)
	{
		$query = $this->db->get_where('ad_deposito_pago', $filtro);
		return $query->result();
	}

	public function cliente_asignado_depto($where)
	{
		$query = $this->db->get_where('ad_catalogo_cliente', $where);
		return $query->row();
	}

	public function empresas_general()
	{
		$this->db->select('ace.id_empresa, ace.nombre_empresa, acb.id_banco, acb.nombre_banco');
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'abe.id_empresa = ace.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where(array('ace.estatus' => 1,'ace.tipo_usuario' => 1));
		$this->db->order_by('ace.nombre_empresa');
		$query = $this->db->get();
		return $query->result();
	}

	public function empresa_general_filtro($id_empresa)
	{
		$this->db->select('ace.id_empresa, ace.nombre_empresa, acb.id_banco, acb.nombre_banco');
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'abe.id_empresa = ace.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where(array('ace.estatus' => 1,'ace.tipo_usuario' => 1, 'ace.id_empresa'=>$id_empresa));
		
		
		$this->db->order_by('ace.nombre_empresa');
		$query = $this->db->get();
		return $query->result();
	}

	public function insert_deposito($array_insert)
	{
		$this->db->insert('ad_pendiente_retorno', $array_insert);
	}

	public function select_pendiente_retorno($array_filtro)
	{
		$query = $this->db->get_where('ad_pendiente_retorno', $array_filtro);
		return $query->result();
	}

	public function select_pendiente_retorno_empresa($array_filtro)
	{
		$query = $this->db->get_where('ad_pendiente_retorno', $array_filtro);
		return $query->row();
	}

	public function update_pendiente_retorno($array_up, $array_where)
	{
		$this->db->where($array_where);
		$this->db->update('ad_pendiente_retorno', $array_up);
	}

}