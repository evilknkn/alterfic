<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresas_model extends CI_Model
{
	public function lista_empresas()
	{
		$query = $this->db->get_where('ad_catalogo_empresa',array('estatus'=>1));
		return $query->result();
	}

	public function  insert_empresa($array)
	{
		$this->db->insert('ad_catalogo_empresa', $array);
		return $this->db->insert_id();
	}

	public function catalogo_bancos()
	{
		$query = $this->db->get('ad_catalogo_bancos');
		return $query->result();
	}

	public function catalogo_empresas()
	{
		$query = $this->db->get_where('ad_catalogo_empresa', array('estatus' => 1));
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
		$query = $this->db->get_where('ad_catalogo_empresa', $filtro);
		return $query->row();
	}

	public function create_vinculo($datos)
	{
		$this->db->insert('ad_bancos_empresa', $datos);
	}

	public function empresa_destino($id_empresa)
	{	
		$this->db->from('ad_catalogo_empresa');
		$this->db->where('id_empresa !=', $id_empresa);
		$query = $this->db->get();
		return $query->result();
	}

	public function datos_empresa($filtro)
	{
		$query = $this->db->get_where('ad_catalogo_empresa', $filtro);
		return $query->row();
	}

	public function actualiza_datos_empresa($data, $id_empresa)
	{
		$this->db->where('id_empresa', $id_empresa);
		$this->db->update('ad_catalogo_empresa', $data);
	}

	public function delete_empresa($filtro)
	{
		$this->db->where($filtro);
		$this->db->update('ad_catalogo_empresa', array('estatus'=>0));
	}

	public function catalogo_empresas_lista($limit, $start)
	{	
		//_where('ad_catalogo_empresa', array('estatus' => 1));
		$this->db->from('ad_catalogo_empresa');
		$this->db->where('estatus', 1);
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
	}
}
