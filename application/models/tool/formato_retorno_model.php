<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Formato_retorno_model extends CI_Model
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

	public function get_all_query($table)
	{
		$query = $this->db->get($table);
		return $query->result();
	}

	public function update_where_query($table,  $data_up, $array_where )
	{
		$this->db->where($array_where);
		$this->db->update($table, $data_up);
		
	}

	public function info_depto($id_deposito = null)
	{	
		$this->db->from('ad_depositos dep');
		$this->db->join('ad_catalogo_cliente cli', 'dep.id_cliente = cli.id_cliente', 'inner');
		$this->db->where('dep.id_deposito', $id_deposito);
		
		$query = $this->db->get();
		return $query->row();
	}
}
/*
CREATE TABLE `ad_formato_retorno` (
  `id_formato` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `folio_cliente` varchar(50) DEFAULT NULL,
  `id_deposito` int(11) DEFAULT NULL,
  `tipo_retorno` varchar(10) DEFAULT NULL,
  `nombe` varchar(250) DEFAULT NULL,
  `monto` float(10,2) DEFAULT NULL,
  `parametro` varchar(100) DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_formato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/