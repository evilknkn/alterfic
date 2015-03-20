<?php 
class Pendiente_retorno extends CI_Controller
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
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/pendiente_retorno/lista_empresas');
		$fecha = fechas_rango_inicio(date('m'));

		$data['fecha_ini'] = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$data['fecha_fin'] = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;

		$data['empresas'] = $this->retorno_model->lista_empresas(array('ace.tipo_usuario' => 1));
		$data['db'] = $this->retorno_model;

		$this->load->view('layer/layerout',$data);
	}

	public function detalle_retorno($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/pendiente_retorno/desgloce_pendiente_retorno');

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;
		# creamos la session con la fecha de detalle para generar el archivo excel 
		$array_session = array('fecha_ini_retorno' => $fecha_ini, 'fecha_fin_retorno' => $fecha_fin);
		$this->session->set_userdata($array_session);


		$data['db'] = $this->retorno_model;
		$data['id_empresa']	= $id_empresa;
		$data['id_banco'] 	= $id_banco;
		
		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco, 'adc.tipo_movimiento' => 'deposito',  'adc.fecha_movimiento >=' => $fecha_ini, 'adc.fecha_movimiento <=' => $fecha_fin);
		$data['depositos'] = $this->retorno_model->detalle_retorno($filtro);
		$this->load->view('layer/layerout',$data);
	}

	public function pendiente_retorno_general()
	{
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');
		$this->load->model('users/clientes_model');
		$this->load->helper('cuentas_helper');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');


		if($this->input->post('id_empresa'))
		{
			$id_empresa = $this->input->post('id_empresa');
		}

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/pendiente_retorno/retorno_pendiente_general'); 

		$fecha = fechas_rango_inicio(date('m'));

		$data['fecha_ini'] = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$data['fecha_fin'] = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;


		$data['catalogo_empresas'] = $this->retorno_model->all_empresas();


		if(isset($id_empresa) and $id_empresa >0):
			$data['empresas'] = $this->retorno_model->empresa_general_filtro($id_empresa);
		else:
			$data['empresas'] = $this->retorno_model->empresas_general();
		endif;

		//$data['clientes']	= $this->clientes_model->lista_clientes();
		$data['db'] = $this->retorno_model;
		$data['db_mov'] = $this->movimiento_model;

		$this->load->view('layer/layerout', $data);
	}



}