<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Validate_model extends CI_Model
{	
	public function unique_folio($folio)
	{
		$query = $this->db->get_where('ad_detalle_cuenta', array('folio_mov'=> $folio));
		return $query->row();
	}

	public function unique_folio_other($folio, $id_detalle)
	{	
		$this->db->from('ad_detalle_cuenta adc');
		$this->db->where('folio_mov', $folio);
		$this->db->where('id_detalle !=', $id_detalle);
		//SELECT * FROM ad_detalle_cuenta WHERE folio_mov = 'AB0001' AND id_detalle !=  99
		$query = $this->db->get();
		return $query->row();
	}
	
}