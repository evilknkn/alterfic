<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Admin_users extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
    }

	public function list_admin($perfil)
	{	
		$this->load->model('users/users_model');

		$data['menu'] 	= 'menu/menu_admin';
		$data['body'] 	= 'admin/users/list_users' ;

		$data['list_users'] = $this->users_model->list_users(array('id_perfil' => $perfil));

		$this->load->view('layer/layerout', $data);
	}

	public function create_user($perfil)
	{
		$this->load->model('users/users_model');

		$this->form_validation->set_rules('username', 'nombre de usuario', 'required');
		$this->form_validation->set_rules('password', 'contraseña', 'required');
		$this->form_validation->set_rules('privilegios', 'activar privilegios', 'required');

		$this->form_validation->set_message('required', 'El campo %s es obligatorio');

		if($this->form_validation->run()):
			$array = array('username' 	=>	$this->input->post('username'),
							'password'	=>	sha1($this->input->post('password')),
							'id_perfil' =>	$perfil,
							'estatus'	=> 	1,
							'privilegios'=> $this->input->post('privilegios'));

			$id_reg = $this->users_model->new_user($array);
			
			$log  = array(	'id_user'   =>  $id_reg ,
	                        'accion'    =>  'Se creó el usuario '.$this->input->post('username'),
	                        'lugar'     =>  'Admin / crear usuario admin',
	                        'usuario'   =>  $this->input->post('username') );

        	$this->bitacora_model->insert_log($log);

			$this->session->set_flashdata('success', 'El usuario <b>'.$this->input->post('username').'</b> fue creado correctamente.');
			redirect(base_url('users/admin_users/list_admin/'.$perfil));
		else:
			$data['menu'] 	= 'menu/menu_admin';
			$data['body'] 	= 'admin/users/form_create_user';


			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function password_ramdom()
	{	
		$this->load->helper('utilerias_helper');	
		$clave = texto_aleatorio(10, TRUE, TRUE, TRUE);
		echo $clave;
	}
	
}