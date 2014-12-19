<?php 
class Ejemplo_paginacion extends CI_Controller
{
	public function index()
	{
	   // $this->load->library('pagination');
	 	$this->load->model('catalogo/empresas_model');
		$this->load->helper('funciones_externas_helper');

		$empresas = $this->empresas_model->catalogo_empresas();

		$this->load->library('pagination');
		$url = base_url().'ejemplo_paginacion';
		$ini_pag = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		// $config['base_url'] 	= $url;
		// $config['total_rows'] 	= count($empresas);
		// $config['per_page']	 	= '20'; 

		// $this->pagination->initialize($config); 

		// $data['pages'] = $this->pagination->create_links();
		// $data['ej'] = "asfagfsf";


	    $opciones = array();
	    //$desde = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	 
	    $opciones['per_page'] = 5;
	    $opciones['base_url'] = $url;
	    $opciones['total_rows'] = count($empresas);
	    // $opciones['uri_segment'] = 3;
	 
	     $this->pagination->initialize($opciones);
	 
	    // $data['lista'] = $this->Frase_model->getTodasFrases($opciones['per_page'],$desde);
	     $data['paginacion'] = $this->pagination->create_links();
	 
	    // $this->load->view('principal',$data);
	     $this->load->view('ejemplo_paginas', $data);

	}
}