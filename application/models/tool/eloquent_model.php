<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Eloquent_model extends CI_Model
{
	public function row_quey($table, $array)
	{
		$this->db->from($table);
		$this->db->where($array);
		$query = $this->db->get();
		return $query->row();
	}

	public function get_query($table, $array)
	{
		$this->db->from($table);
		$this->db->where($array);
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

	public function get_all_query($table, $order=null ) 
	{
		$this->db->from($table);
		
		if($order != null){
			$this->db->order_by($order);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function update_where_query($table,  $data_up, $array_where )
	{
		$this->db->where($array_where);
		$this->db->update($table, $data_up);
		
	}

	public function join_dynamic($params)
	{	
		if($params['select_active'] == 'true')
		$this->db->select($params['select_fields']);
		
		$this->db->from($params['from']);
		
		$total = $params['number_joins'];
		$inner = $params['inner_connect'];
		
		for($i=0; $i<$total; $i++)
		{
			$this->db->join($inner[$i]['table'], $inner[$i]['on_table'], $inner[$i]['type_join']);
		}

		if($params['whereIn_active'] == 'true')
			$this->db->where_in($params['whereIn_param'][0], $params['whereIn_param'][1]);
		
		if($params['where_active'] == 'true')
			$this->db->where($params['where_param']);

		$query = $this->db->get();
		return $query->result();

	}

	public function lista_empresas()
	{	
		$this->db->from('ad_catalogo_empresa ace');
		$this->db->join('ad_bancos_empresa abe', 'ace.id_empresa = abe.id_empresa', 'inner');
		$this->db->join('ad_catalogo_bancos acb', 'acb.id_banco = abe.id_banco', 'inner');
		$this->db->where('ace.tipo_usuario',1);
		$this->db->where('ace.estatus',1);
		$this->db->where('abe.status_cta',1);
		$this->db->order_by('ace.nombre_empresa', 'asc');
		$query = $this->db->get();
		return $query->result();
	}
}

