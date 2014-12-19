<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Clientes extends CI_Controller
{	
	public function index()
	{
		$this->load->model('users/clientes_model');
		$this->form_validation->set_rules('nombre_cliente', 'nombre_cliente', 'required');
		if($this->form_validation->run()):
			$array = array('nombre_cliente'	=>	$this->input->post('nombre_cliente'),
							'email' 		=> 	$this->input->post('email'),
							'comision'		=> 	($this->input->post('comision') /100),
							'tipo_cliente'	=> 	$this->input->post('tipo_cliente'));

			$this->clientes_model->insert_cliente($array);

			$this->session->set_flashdata('success', 'Cliente creado correctamente.');
			redirect(base_url('users/clientes'));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/clientes/lista_clientes');

			$data['clientes'] = $this->clientes_model->lista_clientes();

			$this->load->view('layer/layerout', $data);
		endif;

	}


	public function editar_cliente($id_cliente)
	{	
		$this->load->model('users/clientes_model');


		$this->form_validation->set_rules('nombre_cliente', 'nombre_cliente', 'required');
		if($this->form_validation->run()):
			$array = array('nombre_cliente'	=>	$this->input->post('nombre_cliente'),
							'email' 		=> 	$this->input->post('email'),
							'comision'		=> 	($this->input->post('comision') /100),
							'tipo_cliente'	=> 	$this->input->post('tipo_cliente'));

			$this->clientes_model->update_cliente($array, $id_cliente);

			$this->session->set_flashdata('success', 'Cliente actualizado correctamente.');
			redirect(base_url('users/clientes/editar_cliente/'.$id_cliente));

		else:
		
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/clientes/edit_client');

				$data['cliente'] = $this->clientes_model->datos_cliente(array('id_cliente' => $id_cliente));

				$this->load->view('layer/layerout', $data);
		endif;
	}
}