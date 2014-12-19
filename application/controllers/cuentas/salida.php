<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Salida extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }

	public function insertar_salida($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/salida_model');
		$this->load->model('cuentas/detalle_cuenta_model');
		$this->load->model('cuentas/depositos_model');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));

		$this->form_validation->set_rules('fecha_salida', 'fecha de salida', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_salida', 'monto de salida', 'required');
		$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|trim|callback_valida_folio');
		$this->form_validation->set_rules('detalle_salida', 'detalle de salida', 'required');

		if($this->form_validation->run()):

			$array= array(	'fecha_salida' 	=>	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')), 
							'monto_salida'	=>	$this->input->post('monto_salida'),
							'folio_salida' 	=>	trim($this->input->post('folio_salida')),
							'detalle_salida'=>	$this->input->post('detalle_salida'));

			$reg = $this->salida_model->insert_salida($array);

			$datos = array(	'id_empresa'		=>	$id_empresa,
							'id_banco'			=>	$id_banco,
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')),
							'folio_mov'			=> 	trim($this->input->post('folio_salida')),
							'tipo_movimiento'	=>	'salida');

			$this->detalle_cuenta_model->insert_movimiento($datos);

			$this->session->set_flashdata('success', 'Salida registrada correctamente');
			redirect(base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/salida/form_salida');

			$data['id_banco']	= $id_banco;
			$data['empresa']	= $empresa;

			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function editar_salida($id_empresa, $id_banco, $id_salida)
	{
		$this->load->model('cuentas/salida_model');
		$this->load->model('cuentas/detalle_cuenta_model');
		$this->load->model('cuentas/depositos_model');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));

		$filtro = array('ddc.id_banco' => $id_banco, 'ddc.id_empresa' => $id_empresa ,'ddc.id_movimiento' => $id_salida); 

		$this->form_validation->set_rules('fecha_salida', 'fecha de salida', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_salida', 'monto de salida', 'required');
		$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|trim|callback_unique_folio_other');
		$this->form_validation->set_rules('detalle_salida', 'detalle de salida', 'required');

		if($this->form_validation->run()):

			 $array= array(	'fecha_salida' 	=>	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')), 
							'monto_salida'	=>	$this->input->post('monto_salida'),
							'folio_salida' 	=>	trim($this->input->post('folio_salida')),
							'detalle_salida'=>	$this->input->post('detalle_salida'));

			$this->salida_model->update_salida($array, $id_salida);

			$datos = array(	'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')),
							'folio_mov'			=> 	trim($this->input->post('folio_salida')) );

			$this->salida_model->update_movimiento($datos, $this->input->post('id_detalle'));

			$this->session->set_flashdata('success', 'Salida actualizada correctamente');
			redirect(base_url('cuentas/salida/editar_salida/'.$id_empresa.'/'.$id_banco.'/'.$id_salida));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/salida/edicion_salida');

			$data['detalle'] 	= $this->salida_model->detalle_salida($filtro);
			$data['id_banco']	= $id_banco;
			$data['empresa']	= $empresa;

			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function insertar_salida_persona($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/salida_model');
		$this->load->model('cuentas/detalle_cuenta_model');
		$this->load->model('cuentas/depositos_model');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));

		$this->form_validation->set_rules('fecha_salida', 'fecha de salida', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_salida', 'monto de salida', 'required');
		//$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|trim|callback_valida_folio');
		$this->form_validation->set_rules('detalle_salida', 'detalle de salida', 'required');

		if($this->form_validation->run()):
			$folio_ant = $this->depositos_model->numero_folio($empresa->clave_cta, $id_empresa);
			
			$folio_mov = generar_folio($empresa->clave_cta, ($folio_ant+1) );

			$array= array(	'fecha_salida' 	=>	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')), 
							'monto_salida'	=>	$this->input->post('monto_salida'),
							'folio_salida' 	=>	$folio_mov,
							'detalle_salida'=>	$this->input->post('detalle_salida'));

			$reg = $this->salida_model->insert_salida($array);

			$datos = array(	'id_empresa'		=>	$id_empresa,
							'id_banco'			=>	$id_banco,
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')),
							'folio_mov'			=> 	$folio_mov,
							'tipo_movimiento'	=>	'salida');

			$this->detalle_cuenta_model->insert_movimiento($datos);

			$this->session->set_flashdata('success', 'Salida registrada correctamente');
			redirect(base_url('cuentas/deposito_persona/detalle_cuenta/'.$id_empresa.'/'.$id_banco));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/salida/form_salida_persona');

			$data['id_banco']	= $id_banco;
			$data['empresa']	= $empresa;

			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function editar_salida_persona($id_empresa, $id_banco, $id_salida)
	{
		$this->load->model('cuentas/salida_model');
		$this->load->model('cuentas/detalle_cuenta_model');
		$this->load->model('cuentas/depositos_model');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));

		$filtro = array('ddc.id_banco' => $id_banco, 'ddc.id_empresa' => $id_empresa ,'ddc.id_movimiento' => $id_salida); 

		$this->form_validation->set_rules('fecha_salida', 'fecha de salida', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_salida', 'monto de salida', 'required');
		//$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|trim|callback_unique_folio_other');
		$this->form_validation->set_rules('detalle_salida', 'detalle de salida', 'required');

		if($this->form_validation->run()):

			 $array= array(	'fecha_salida' 	=>	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')), 
							'monto_salida'	=>	$this->input->post('monto_salida'),
							'folio_salida' 	=>	trim($this->input->post('folio_salida')),
							'detalle_salida'=>	$this->input->post('detalle_salida'));

			$this->salida_model->update_salida($array, $id_salida);

			$datos = array(	'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')),
							'folio_mov'			=> 	trim($this->input->post('folio_salida')) );

			$this->salida_model->update_movimiento($datos, $this->input->post('id_detalle'));

			$this->session->set_flashdata('success', 'Salida actualizada correctamente');
			redirect(base_url('cuentas/salida/editar_salida_persona/'.$id_empresa.'/'.$id_banco.'/'.$id_salida));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/salida/edicion_salida_persona');

			$data['detalle'] 	= $this->salida_model->detalle_salida($filtro);
			$data['id_banco']	= $id_banco;
			$data['empresa']	= $empresa;

			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function insertar_salida_caja($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/salida_model');
		$this->load->model('cuentas/detalle_cuenta_model');
		$this->load->model('cuentas/depositos_model');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));

		$this->form_validation->set_rules('fecha_salida', 'fecha de salida', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_salida', 'monto de salida', 'required');
		//$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|trim|callback_valida_folio');
		$this->form_validation->set_rules('detalle_salida', 'detalle de salida', 'required');

		if($this->form_validation->run()):
			$folio_ant = $this->depositos_model->numero_folio('CAJA', $id_empresa);
			
			$folio_mov = generar_folio('CAJA', ($folio_ant+1) );

			$array= array(	'fecha_salida' 	=>	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')), 
							'monto_salida'	=>	$this->input->post('monto_salida'),
							'folio_salida' 	=>	$folio_mov,
							'detalle_salida'=>	$this->input->post('detalle_salida'));

			$reg = $this->salida_model->insert_salida($array);

			$datos = array(	'id_empresa'		=>	$id_empresa,
							'id_banco'			=>	$id_banco,
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_salida')),
							'folio_mov'			=> 	$folio_mov,
							'tipo_movimiento'	=>	'salida');

			$this->detalle_cuenta_model->insert_movimiento($datos);

			$this->session->set_flashdata('success', 'Salida registrada correctamente');
			redirect(base_url('cuentas/caja_chica/'.$id_empresa.'/'.$id_banco));

		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/salida/form_salida_persona');

			$data['id_banco']	= $id_banco;
			$data['empresa']	= $empresa;

			$this->load->view('layer/layerout', $data);
		endif;
	}
	/// Callback
	function valida_folio($folio)
	{	
		$this->load->model('validate_model');
		$res = $this->validate_model->unique_folio($folio);
		
		if(count($res)!=0)
		{
			$this->form_validation->set_message('valida_folio', 'Este folio ya se encuentra registrado');
			return FALSE;
		}else
		{
			return TRUE;
		}
	}

	function fecha_limite()
	{	
		$fecha_insert = formato_fecha_ddmmaaaa($this->input->post('fecha_salida'));
		$date_now = date('Y/m/d');
		$date_msg = date('d/m/Y');
		//print_r($fecha_insert);exit;
		if($fecha_insert > $date_now):
			$this->form_validation->set_message('fecha_limite', 'La fecha no puede ser mayor a el día de hoy ('.$date_msg.').');
            return FALSE;
		else:
			return TRUE;
		endif;
	}

	function unique_folio_other($folio)
	{
		$this->load->model('validate_model');

		$search_folio = $this->validate_model->unique_folio_other(trim($folio), $this->input->post('id_detalle'));

		if(count($search_folio) > 0 ):
			$this->form_validation->set_message('unique_folio_other', 'Este folio ya  esta registrado.');
            return FALSE;
		else:
			return true;
		endif;
	}
}