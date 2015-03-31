<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Detalle_cuenta_model extends CI_Model
{
	public function insert_movimiento($array)
	{
		$this->db->insert('ad_detalle_cuenta', $array);
	}
	public function lista_movimientos($filtro, $fecha_ini, $fecha_fin)
	{
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->where($filtro);
		$this->db->where('fecha_movimiento >=', $fecha_ini);
		$this->db->where('fecha_movimiento <=', $fecha_fin);
		
		//$this->db->order_by('adc.folio_mov', 'desc');

		//$this->db->order_by('adc.fecha_movimiento','asc');
		$this->db->order_by('adc.tipo_movimiento');
		$this->db->order_by('adc.id_detalle', 'asc');

		//$query = $this->db->get();
		return $this->db->count_all_results();;
		//return $query->result();
	}

	public function lista_movimientos_page($filtro, $fecha_ini, $fecha_fin, $filter_page = null, $order = null)
	{	
		//print_r($filter_page); exit;
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->where($filtro);
		$this->db->where('fecha_movimiento >=', $fecha_ini);
		$this->db->where('fecha_movimiento <=', $fecha_fin);
		if($filter_page != null):
			$this->db->where($filter_page);
		endif;
		$this->db->order_by('adc.folio_mov', $order);

		$this->db->order_by('adc.fecha_movimiento','asc');
		$this->db->order_by('adc.tipo_movimiento');
		$this->db->order_by('adc.id_detalle', 'asc');
		$this->db->limit(100);

		$query = $this->db->get();
		return $query->result();
	}

	public function monto_retorno($filtro_dpto)
	{	
		$this->db->select('id_cliente, monto_deposito');
		$this->db->from('ad_depositos');
		$this->db->where($filtro_dpto);
		$query = $this->db->get();
		return $query->row();
	}

	public function comision($id_cliente)
	{
		$query =$this->db->get_where('ad_catalogo_cliente', array('id_cliente' => $id_cliente));
		return $query->row();
	}

	public function pagos_depto($filtro)
	{
		$query = $this->db->get_where('ad_deposito_pago', $filtro);
		return $query->result();
	}

	public function cliente_asignado_deposito($filtro)
	{
		$query = $this->db->get_where('ad_depositos', $filtro);
		return $query->row();
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
	
	public function tracking_salida_pago ($folio)
	{
		$this->db->from('ad_deposito_pago adp');
		$this->db->join('ad_depositos ad', 'ad.id_deposito = adp.id_deposito', 'inner');
		$this->db->join('ad_catalogo_cliente acc', 'acc.id_cliente = ad.id_cliente', 'inner');
		$this->db->where('adp.folio_pago', $folio);
		$query = $this->db->get();
		return $query->row();
	}

	public function detalle_deposito($folio)
	{
		$this->db->from('ad_deposito_pago adp');
		$this->db->join('ad_catalogo_bancos adb', 'adp.id_banco = adb.id_banco', 'inner');
		$this->db->join('ad_catalogo_empresa ace', 'ace.id_empresa= adp.id_empresa', 'inner');
		$this->db->where('adp.folio_pago', $folio);
		$query = $this->db->get();
		return $query->row();
	}

	public function info_deposito($filtro)
	{ 
		$query = $this->db->get_where('ad_depositos', $filtro);
		return $query->row();
	}

	public function info_salidas($filtro)
	{
		$query = $this->db->get_where('ad_salidas', $filtro);
		return $query->row();
	}

	public function salidas_cuenta($filtro)
	{	
		//$movimientos = array('salida', 'salida_pago', 'mov_int');
		$movimientos = array('salida');
		$this->db->from('ad_detalle_cuenta');
		$this->db->where($filtro);
		$this->db->where_in('tipo_movimiento', $movimientos);
		$query = $this->db->get();
		return $query->result();
	}

	public function salida_cuenta($folio, $tipo_movimiento)
	{
		if($tipo_movimiento == 'salida')
		{	
			$this->db->select('monto_salida monto');
			$this->db->from('ad_salidas sal');
			$this->db->where('sal.folio_salida', $folio);

		}
		elseif($tipo_movimiento == 'salida_pago')
		{	
			$this->db->select('monto_pago monto');
			$this->db->from('ad_deposito_pago adp');
			$this->db->where('adp.folio_pago', $folio);

		}
		//elseif($tipo_movimiento == 'mov_int');
		else
		{	
			$this->db->select('monto');
			$this->db->from('ad_movimientos_internos adi');
			$this->db->where('adi.folio_salida', $folio);
		}
		$query = $this->db->get();
		return $query->row();
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