<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Movimientos_internos_express extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }

    public function lista($empresa = null, $banco = null)
    {
    	$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
		$this->load->model('catalogo/empresas_model');
		$this->load->helper('funciones_externas');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/movimientos/lista_movimientos_express');

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;
		# creamos la session con la fecha de detalle para generar el archivo excel 
		$array_session = array('fecha_ini_mov_int' => $fecha_ini, 'fecha_fin_mov_int' => $fecha_fin);
		$this->session->set_userdata($array_session);


		$empresa_data = $this->empresas_model->empresa(array('id_empresa'=>$empresa));

		$data['id_empresa'] = $empresa;
		$data['id_banco']	= $banco;
		$data['nombre_empresa'] = $empresa_data->nombre_empresa;
		$data['db']	= $this->empresas_model;

		$filtro = array('id_empresa'=> $empresa, 'id_banco' => $banco, 'fecha_mov >=' => $fecha_ini, 'fecha_mov <= ' => $fecha_fin ) ;
		$data['movimientos'] = $this->movimientos_model->lista_movimientos($filtro);
		$this->load->view('layer/layerout', $data);
    }

    public function add_mov_interno($id_empresa = null, $id_banco = null)
    {	
    	$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
    	$this->load->model('catalogo/empresas_model');
    	$this->load->model('cuentas/pendiente_retorno_model');

		$db = $this->pendiente_retorno_model;

    	$empresa_data = $this->empresas_model->empresa(array('id_empresa'=>$id_empresa));
    	
    	$this->form_validation->set_rules('monto', 'fecha', 'required');
		$this->form_validation->set_rules('folio_entrada', 'folio de entrada', 'required|callback_unique_folio');
		$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|callback_unique_folio');
    	
    	if($this->form_validation->run()):
    		print_r($_POST);exit;
    	else:
	    	$data['menu'] = 'menu/menu_admin';
	    	$data['body'] = 'admin/cuentas/movimientos/form_movimiento_express';
	    	$data['nombre_empresa'] = $empresa_data->nombre_empresa;
	    	$data['id_empresa'] = $id_empresa;
	    	$data['id_banco'] 	= $id_banco;

	    	$where_empresa = array('estatus' => 1, 'tipo_usuario' => 1 );
			$data['cat_empresas'] = $db->get_query('ad_catalogo_empresa', $where_empresa);
			$data['cat_bancos'] = $db->get_all_query('ad_catalogo_bancos');

	    	$this->load->view('layer/layerout', $data);
    	endif;
    }

    public function catalogo_claves()
	{
		$this->load->model('cuentas/pendiente_retorno_model');

		$db = $this->pendiente_retorno_model;

		$where_empresa = array('estatus' => 1, 'tipo_usuario' => 1 );
		$data['cat_empresas'] = $db->get_query('ad_catalogo_empresa', $where_empresa);


		$data['cat_bancos'] = $db->get_all_query('ad_catalogo_bancos');

		print_r($data['cat_bancos']);

	}  

    #### callbacks de validaciones

	function unique_folio($folio)
	{	
		$this->load->model('validate_model');

		$explode_folio = explode('-', $folio);
		
		if( count($explode_folio) < 2)
		{
			$this->form_validation->set_message('unique_folio', 'Este folio es incorrecto, verifique su formato.');
            return FALSE;
		}
		
		$valida_clave = $this->validate_model->valid_clave($explode_folio[0]);

		if( count($valida_clave) == 0)
		{
			$this->form_validation->set_message('unique_folio', 'Este folio es incorrecto, verifique que el banco corresponda a la empresa.');
            return FALSE;
		}
		
		$search_folio = $this->validate_model->unique_folio(trim($folio));

		if(count($search_folio) > 0 ):
			$this->form_validation->set_message('unique_folio', 'Este folio ya  esta registrado.');
            return FALSE;
		else:
			return true;
		endif;
	}
}
