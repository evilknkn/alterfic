<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Formato_retorno_model extends CI_Model
{	

	public function insert_query($table, $data)
	{	
		$this->db->insert($table, $data); 
		return $this->db->insert_id();
	}
	public function row_quey($table, $array)
	{
		$this->db->from($table);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_query($table, $array, $order)
	{
		$this->db->from($table);
		$this->db->where($array);

		if($order == true):
			$this->db->order_by('nombre_empresa','asc');
		endif;
		$query = $this->db->get();

		return $query->result();
	}

	public function get_data($table= null)
	{
		$this->db->from($table);
		
		$query = $this->db->get();

		return $query->result();
	}

	public function get_in_query($table, $array, $camp)
	{
		$this->db->from($table);
		$this->db->where_in($camp, $array);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_all_query($table)
	{
		$query = $this->db->get($table);
		return $query->result();
	}

	public function detele_query($table = null, $array=null)
	{
		$this->db->where($array);
		$this->db->delete($table);
	}

	public function sum_montos_retorno($folio = null)
	{
		$this->db->select_sum('monto');
		$this->db->from('ad_formato_retorno_deposito');
		$this->db->where('folio_cliente', $folio);
		$query = $this->db->get();
		return $query->result();
	}

	public function sum_montos_formato($folio = null)
	{
		$this->db->select_sum('monto');
		$this->db->from('ad_formato_retorno');
		$this->db->where('folio_cliente', $folio);
		$query = $this->db->get();
		return $query->result();
	}

	public function update_where_query($table,  $data_up, $array_where )
	{
		$this->db->where($array_where);
		$this->db->update($table, $data_up);
		
	}

	public function get_like_query($table = null, $where_like = null, $array_where= null)
	{
		$this->db->from($table);
		$this->db->like($where_like);
		///$this->db->where($array_where);
		//return $this->db->count_all_results();
		$query = $this->db->get();
		return $query->result();
	}

	public function info_depto($id_deposito = null)
	{	
		$this->db->from('ad_depositos dep');
		$this->db->join('ad_catalogo_cliente cli', 'dep.id_cliente = cli.id_cliente', 'inner');
		$this->db->where('dep.id_deposito', $id_deposito);
		
		$query = $this->db->get();
		return $query->row();
	}

	public function folio_cliente($array=null)
	{	
		$this->db->from('ad_folio_cliente fol_cli');
		$this->db->join('ad_formato_retorno forma_r', 'fol_cli.id_cliente = forma_r.id_cliente', 'inner');
		$this->db->where($array);
		
		$query = $this->db->get();
		return $query->row();
	}

	public function bancos_empresa($id_empresa = null)
	{
		$this->db->from('ad_bancos_empresa abe');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where('abe.id_empresa', $id_empresa);
		$this->db->where('abe.status_cta', 1);
		$query =  $this->db->get();
		return $query->result();
	}

	public function info_deposito($id = null)
	{
		$this->db->from('ad_formato_retorno_deposito as depto');
		$this->db->join('ad_catalogo_empresa as empresa', 'empresa.id_empresa = depto.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos as banco', 'depto.id_banco = banco.id_banco', 'inner');
		$this->db->where('depto.id_reg', $id);
		$query =  $this->db->get();
		return $query->row();
	}

	public function list_deptos($folio = null)
	{	
		$this->db->select('retDep.id_reg, retDep.id_empresa, retDep.id_banco, retDep.monto, catEmp.nombre_empresa, catBan.nombre_banco, retDep.fecha_deposito');
		$this->db->from('ad_formato_retorno_deposito as retDep');
		$this->db->join('ad_catalogo_empresa as catEmp', 'catEmp.id_empresa = retDep.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos as catBan', 'retDep.id_banco = catBan.id_banco', 'inner');
		$this->db->where('retDep.folio_cliente', $folio);
		$query =  $this->db->get();
		return $query->result();
	}



}
/*
select * from ad_formato_retorno_deposito as retDep
inner join `ad_catalogo_empresa` as catEmp on retDep.id_empresa = catEmp.id_empresa 
inner join ad_catalogo_bancos as catBan on retDep.id_banco = catBan.id_banco
where retDep.folio_cliente = 'ANG-000001'
*/