<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Depositos extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == ''){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
    }

    public function general()
    {	
    	$this->load->model('tool/eloquent_model');
    	$db = $this->eloquent_model;
    	
    	$data['lista_clientes'] = $db->get_all_query('ad_catalogo_cliente', 'nombre_cliente');
    	
		$data['menu'] 		= 'menu/menu_admin';
		$data['body']		= 'admin/apartado/lista_general';

		$this->load->view('layer/layerout', $data);    	
    }

    public function pendiente_asignar()
    {
        $this->load->model('tool/eloquent_model');
        $db = $this->eloquent_model;
        
        $data['lista_clientes'] = $db->get_all_query('ad_catalogo_cliente', 'nombre_cliente');
        
        $data['menu']       = 'menu/menu_admin';
        $data['body']       = 'admin/apartado/lista_pendiente';

        $this->load->view('layer/layerout', $data);   

    }

	public function pendiente_retorno()
	{
        $this->load->model('tool/eloquent_model');
        $db = $this->eloquent_model;
        
        $data['lista_clientes'] = $db->get_all_query('ad_catalogo_cliente', 'nombre_cliente');
        
        $data['menu']       = 'menu/menu_admin';
        $data['body']       = 'admin/apartado/lista_asignados';

        $this->load->view('layer/layerout', $data);  
	}

	public function pagados()
	{
        $this->load->model('tool/eloquent_model');
        $db = $this->eloquent_model;
        
        $data['lista_clientes'] = $db->get_all_query('ad_catalogo_cliente', 'nombre_cliente');
        
        $data['menu']       = 'menu/menu_admin';
        $data['body']       = 'admin/apartado/lista_pagados';

        $this->load->view('layer/layerout', $data);  
	}
}