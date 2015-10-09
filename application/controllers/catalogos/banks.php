<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Banks extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
    }

	public function index()
	{
		$this->load->model('catalogo/catalogo_banco_model' , 'db_catalogo');

		$this->form_validation->set_rules('nombre_banco', 'nombre banco', 'required');
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		if($this->form_validation->run()):
			$array = array('nombre_banco' => $this->input->post('nombre_banco'));
			$this->db_catalogo->insert_banco($array);

			$this->session->set_flashdata('success', 'Banco guardado correctamente');
			redirect(base_url('catalogos/banks'));
		else:
		$data['body'] = 'admin/bancos/lista_bancos';
		$data['menu'] = 'menu/menu_admin';
		$data['lista_bancos']  = $this->db_catalogo->catalogo_bancos();

		$this->load->view('layer/layerout', $data);
		endif;
	}

	public function delete_bank($id_banco)
	{	
		$this->load->model('catalogo/catalogo_banco_model' , 'db_catalogo');

		$banco = $this->db_catalogo->datos_banco(array('id_banco'=>$id_banco));
		$datos = $this->db_catalogo->empresas_asignadas(array('acb.id_banco'=>$id_banco));

		if(count($datos)!=0):
			$this->session->set_flashdata('fail', 'El banco '.$banco->nombre.' no puede ser borrado, debido a que tiene vinculadas algunas empresas.');
		else:
			$this->db_catalogo->borrar_banco(array('id_banco'=>$id_banco));
			$this->session->set_flashdata('success', 'El banco '.$bancos->nombre.' fue borrado correctamente');
		endif;	
		redirect(base_url('catalogos/banks'));
	}
}