<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Corps extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
    }

    public function listar_empresas()
    {	
    	$this->load->model('catalogo/empresas_model');
		$this->load->helper('funciones_externas_helper');
    	$start = $this->input->post('ini_start');
    	$empresas = $this->empresas_model->catalogo_empresas_lista(5, $start);

    	echo json_encode($empresas);
    }

	public function index()
	{	
		$this->load->model('catalogo/empresas_model');
		$this->load->helper('funciones_externas_helper');
		
		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/empresas/lista_empresas');

		$data['bancos'] = $this->empresas_model->catalogo_bancos();
		$data['empresas'] = $this->empresas_model->catalogo_empresas();
		$data['db']		= $this->empresas_model;

			$this->load->view('layer/layerout', $data);
	}

	public function add_empresa_persona()
	{

		$this->load->model('catalogo/empresas_model');
		$this->load->model('catalogo/catalogo_banco_model', 'db_banco');
		$this->load->helper('funciones_externas_helper');

		$this->form_validation->set_rules('nombre_empresa', 'nombre de empresa', 'required');
		$this->form_validation->set_rules('tipo_cuenta', 'tipo de cuenta', 'required');
		if($this->input->post('tipo_cuenta')==2):
			$this->form_validation->set_rules('clave_cuenta', 'clave de cuenta para folio', 'required');
		else:
			$this->form_validation->set_rules('clave_movimiento', 'clave de movimiento', 'required');
		endif;	
		$this->form_validation->set_message('required', 'El campo %s es requerido');
		
		
		if($this->form_validation->run()):
			$where_array = array('id_banco' => $this->input->post('id_banco') ) ;
			$banco_detail = $this->db_banco->datos_banco($where_array);
			//print_r($banco_detail);exit;

			$array = array('nombre_empresa' 	=> 	$this->input->post('nombre_empresa'),
							'tipo_usuario'		=> 	$this->input->post('tipo_cuenta'),
							'clave_cta'			=>	($this->input->post('tipo_cuenta')==2)? $this->input->post('clave_cuenta'): strtoupper($this->input->post('clave_movimiento')),
							'clabe_bancaria' 	=>	$this->input->post('clabe'),
								'no_cuenta'		=> 	$this->input->post('no_cuenta'),
								'estatus'		=>	1);

			$req = $this->empresas_model->insert_empresa($array);

			$datos = array('id_banco' 		=>	$this->input->post('id_banco'),
							'id_empresa'	=>	$req,
							'clave'			=> ($this->input->post('tipo_cuenta')==1)? strtoupper($this->input->post('clave_movimiento').$banco_detail->clave_banco) :'',
							'status_cta' 	=> 1);

			$this->empresas_model->create_vinculo($datos);

			$this->session->set_flashdata('success', 'La empresa se registro correctamente');
			redirect(base_url('catalogos/corps'));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/empresas/reg_catalogo_empresa');

			$data['bancos'] = $this->empresas_model->catalogo_bancos();
			$data['empresas'] = $this->empresas_model->catalogo_empresas();
			$data['db']		= $this->empresas_model;

			$this->load->view('layer/layerout', $data);
		endif;


	}
	public function add_banco()
	{
		$this->load->model('catalogo/empresas_model');
		$this->load->model('catalogo/catalogo_banco_model');

		$dataBank = $this->catalogo_banco_model->datos_banco(array('id_banco'=>$this->input->post('id_banco')));

		$filtro = array('id_empresa' => $this->input->post('id_empresa'));
		$detail_empresa = $this->empresas_model->empresa($filtro);

		

		$datos = array('id_banco' 		=>	$this->input->post('id_banco'),
						'id_empresa'	=>	$this->input->post('id_empresa'),
						'clave' 		=>  $detail_empresa->clave_cta.$dataBank->clave_banco,
						'status_cta' 	=> 1);

		$this->empresas_model->create_vinculo($datos);
		
		$this->session->set_flashdata('success', 'La empresa se guardó correctamente');
		redirect(base_url('catalogos/corps'));
	}

	public function edit_corp($id_empresa)
	{
		$this->load->model('catalogo/empresas_model');

		$this->form_validation->set_rules('nombre_empresa', 'nombre de empresa', 'required');

		if($this->form_validation->run()):
			$datos = array('nombre_empresa'  => $this->input->post('nombre_empresa'),
						  'clabe_bancaria' 	=>	$this->input->post('clabe'),
						  'no_cuenta'		=> 	$this->input->post('no_cuenta'));

			$this->empresas_model->actualiza_datos_empresa($datos, $id_empresa);

			$this->session->set_flashdata('success', 'Datos actualizados correctamente');
			redirect(base_url('catalogos/corps/edit_corp/'.$id_empresa));
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/empresas/edit_empresa');

			$data['empresa'] = $this->empresas_model->datos_empresa(array('id_empresa'=>$id_empresa));	
			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function delete_corp($id_empresa)
	{
		$this->load->model('catalogo/empresas_model');

		$empresa = $this->empresas_model->datos_empresa(array('id_empresa'=>$id_empresa));	

		$this->empresas_model->delete_empresa(array('id_empresa' => $id_empresa));

		$array  = array('id_user'   =>  $this->session->userdata('ID_USER')  ,
                        'accion'    =>  'El usuario '.$this->session->userdata('USERNAME').' eliminó la empresa '.$empresa->nombre_empresa ,
                        'lugar'     =>  'catálogo de empresas',
                        'usuario'   =>  $this->session->userdata('USERNAME') );

        $this->bitacora_model->insert_log($array);

        $this->session->set_flashdata('success', 'Empresa elimada correctamente');
        redirect(base_url('catalogos/corps'));
	}

	public function bancos_empresa()
	{
		$this->load->model('catalogo/empresas_model');
		$this->load->helper('funciones_externas_helper');
					
		$bancos = $this->empresas_model->catalogo_empresa_bancos(array('ace.id_empresa' => $this->input->post('id_empresa') ));
		//print_r($bancos);
		$data = array();
		foreach($bancos as $banco)
		{
			$data[] = array('id_empresa' => $banco->id_empresa, 'id_banco' => $banco->id_banco, 'nombre_banco' => $banco->nombre_banco, 'status_banco' => $banco->status_cta);
		}

		return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));

		//echo json_encode($data);
	}

	public function disabled_bank()
	{
		$this->load->model('catalogo/empresas_model');

		$id_empresa = $this->input->post('id_empresa'); 
		$id_banco	= $this->input->post('id_banco');
		$status_bank= $this->input->post('state');

		$array_set = array('status_cta' => $status_bank);
		$array_where = array('id_empresa' => $id_empresa, 'id_banco' => $id_banco );
		$this->empresas_model->change_status_bank($array_set, $array_where);

		$data['success'] = true;

		return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($data));
	}


}