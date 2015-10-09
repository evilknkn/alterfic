<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Movimientos_internos extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }
    
	public function lista($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
		$this->load->model('catalogo/empresas_model');
		$this->load->helper('funciones_externas');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/movimientos/lista_movimientos');

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;
		# creamos la session con la fecha de detalle para generar el archivo excel 
		$array_session = array('fecha_ini_mov_int' => $fecha_ini, 'fecha_fin_mov_int' => $fecha_fin);
		$this->session->set_userdata($array_session);


		$empresa_data = $this->empresas_model->empresa(array('id_empresa'=>$id_empresa));

		$data['id_empresa'] = $id_empresa;
		$data['id_banco']	= $id_banco;
		$data['nombre_empresa'] = $empresa_data->nombre_empresa;
		$data['db']	= $this->empresas_model;

		$filtro = array('id_empresa'=> $id_empresa, 'id_banco' => $id_banco, 'fecha_mov >=' => $fecha_ini, 'fecha_mov <= ' => $fecha_fin ) ;
		$data['movimientos'] = $this->movimientos_model->lista_movimientos($filtro);
		$this->load->view('layer/layerout', $data);
	}

	public function add_mov_interno($id_empresa, $id_banco)
	{	
		$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
		$this->load->model('catalogo/empresas_model');

		$this->form_validation->set_rules('empresa', 'empresa', 'required');
		$this->form_validation->set_rules('id_banco', 'banco', 'required');
		$this->form_validation->set_rules('monto', 'fecha', 'required');
		$this->form_validation->set_rules('fecha', 'empresa', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('folio_entrada', 'folio de entrada', 'required|callback_unique_folio');
		$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|callback_unique_folio');

		if($this->form_validation->run()):

			$datos = array('id_empresa' 		=> $id_empresa,	
							'id_banco' 			=> $id_banco,
							'empresa_destino' 	=> $this->input->post('empresa'),
							'banco_destino'		=> $this->input->post('id_banco'),
							'monto' 			=> $this->input->post('monto'),
							'fecha_mov' 		=> formato_fecha_ddmmaaaa($this->input->post('fecha')),
							'folio_entrada' 	=> $this->input->post('folio_entrada'),
							'folio_salida' 		=> $this->input->post('folio_salida'));

			$this->movimientos_model->insert_movimiento($datos);

			$array= array(	'fecha_salida' 	=>	formato_fecha_ddmmaaaa($this->input->post('fecha')), 
							'monto_salida'	=>	$this->input->post('monto'),
							'folio_salida' 	=>	$this->input->post('folio_salida'),
							'detalle_salida'=>	'movimiento interno');

			$reg = $this->movimientos_model->insert_salida($array);

			$datos = array(	'id_empresa'		=>	$id_empresa,
							'id_banco'			=>	$id_banco,
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha')),
							'folio_mov'			=>	$this->input->post('folio_salida'),
							'tipo_movimiento'	=>	'mov_int');

			$this->movimientos_model->insert_movimiento_detalle($datos);

			$array = array('fecha_deposito' => formato_fecha_ddmmaaaa($this->input->post('fecha')),
							'monto_deposito' => $this->input->post('monto'),
							'folio_depto'	=> 	$this->input->post('folio_entrada'));

			$reg = $this->movimientos_model->registra_depto($array);

			$datos_depto = array(	'id_empresa'=>	$this->input->post('empresa'),
							'id_banco'			=>	$this->input->post('id_banco'),
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha')),
							'folio_mov'			=>	$this->input->post('folio_entrada'),
							'tipo_movimiento'	=>	'deposito_interno');

			$this->movimientos_model->insert_movimiento_detalle($datos_depto);


			$this->session->set_flashdata('success', 'Movimiento agregado correctamente');
			redirect(base_url('cuentas/movimientos_internos/lista/'.$id_empresa.'/'.$id_banco));
		else:
			$empresa_data = $this->empresas_model->empresa(array('id_empresa'=>$id_empresa));
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/movimientos/form_mov_interno');
			
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']	= $id_banco;
			$data['nombre_empresa'] = $empresa_data->nombre_empresa;
			$data['empresas']	= $this->empresas_model->lista_empresas_mov_interno();


			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function detalle_pago($id_pago)
	{
		$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
		$this->load->model('catalogo/empresas_model');

		$data['empresas']	= $this->empresas_model->lista_empresas();
		$data['pago'] 		= $this->movimientos_model->detalle_pago($id_pago);
		$this->load->view('admin/cuentas/deposito/detalle_pago', $data);

	}

	public function editar_movimiento($id_empresa, $id_banco, $id_movimiento)
	{
		$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
		$this->load->model('catalogo/empresas_model');

		$detalle = $this->movimientos_model->detalle_movimiento($id_movimiento);

		// Salida de movimiento interno
		$salida_int = $this->movimientos_model->detalle_salida($detalle->folio_salida);
		// Deposito internos
		$depo_int = $this->movimientos_model->detalle_deposito($detalle->folio_entrada);
		
		$this->form_validation->set_rules('empresa', 'empresa', 'required');
		$this->form_validation->set_rules('id_banco', 'banco', 'required');
		$this->form_validation->set_rules('monto', 'fecha', 'required');
		$this->form_validation->set_rules('fecha', 'empresa', 'required|callback_fecha_limite');
		# validación de folios 
		//$this->form_validation->set_rules('folio_entrada', 'folio de entrada', 'required|callback_unique_folio_other['.$depo_int->id_detalle.']');
		$this->form_validation->set_rules('folio_salida', 'folio de salida', 'required|callback_unique_folio_other['.$salida_int->id_detalle.']');

		if($this->form_validation->run()):
			
			$filtro_int = array('id_movimiento' => $id_movimiento);

			$datos = array(	'empresa_destino' 	=> $this->input->post('empresa'),
			 				'banco_destino'		=> $this->input->post('id_banco'),
			 				'monto' 			=> $this->input->post('monto'),
			 				'fecha_mov' 		=> formato_fecha_ddmmaaaa($this->input->post('fecha')),
			 				'folio_entrada' 	=> $this->input->post('folio_entrada'),
			 				'folio_salida' 		=> $this->input->post('folio_salida'));

			$this->movimientos_model->update_movimiento_int($datos, $filtro_int);
			
			$filtro_salida = array('id_salida' => $salida_int->id_movimiento);
			
			$array= array(	'fecha_salida' 	=>	formato_fecha_ddmmaaaa($this->input->post('fecha')), 
			 				'monto_salida'	=>	$this->input->post('monto'),
			 				'folio_salida' 	=>	$this->input->post('folio_salida'));

			$this->movimientos_model->update_salida($array, $filtro_salida);

			$filtro_mov_int = array('id_detalle' => $salida_int->id_detalle);

			$datos = array('fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha')),
			 				'folio_mov'			=>	$this->input->post('folio_salida'));

			$this->movimientos_model->update_movimiento_detalle($datos, $filtro_mov_int);

			$filtro_depto = array('id_deposito' => $depo_int->id_deposito);	
			
			$array = array('fecha_deposito' => formato_fecha_ddmmaaaa($this->input->post('fecha')),
							'monto_deposito' => $this->input->post('monto'),
			 				'folio_depto'	=> 	$this->input->post('folio_entrada'));

			$this->movimientos_model->update_depto($array, $filtro_depto);

			$filtro_dt_depto = array('id_detalle' => $depo_int->id_detalle);
			$datos_depto = array(	'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha')),
					 				'folio_mov'			=>	$this->input->post('folio_entrada'),
					 				'id_empresa'		=> 	$this->input->post('empresa'),
					 				'id_banco' 			=> 	$this->input->post('id_banco'));

			$this->movimientos_model->update_movimiento_detalle($datos_depto, $filtro_dt_depto);


			$this->session->set_flashdata('success', 'Movimiento actualizado correctamente');
			redirect(base_url('cuentas/movimientos_internos/editar_movimiento/'.$id_empresa.'/'.$id_banco.'/'.$id_movimiento));
		else:
			$empresa_data = $this->empresas_model->empresa(array('id_empresa'=>$id_empresa));
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/movimientos/editar_mov_interno');
			
			$data['no_empresa'] = $id_empresa;
			$data['no_banco']	= $id_banco;

			$data['nombre_empresa'] = $empresa_data->nombre_empresa;
			$data['empresas']	= $this->empresas_model->lista_empresas_mov_interno();
			$data['detalle']	= $detalle;


			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function bancos_empresa()
	{
		$this->load->model('catalogo/catalogo_banco_model', 'banco_model');
		$id_empresa = $this->input->post('id_empresa');
		$id_banco 	= $this->input->post('id_banco');

		$bancos = $this->banco_model->bancos_empresa($id_empresa);

		echo '<option value = "">Seleccione un banco</option>';
		foreach($bancos as $banco):
			$selected = ($banco->id_banco == $id_banco) ? 'selected = selected' : '';
			echo '<option value="'.$banco->id_banco.'" '.$selected.'>'.$banco->nombre_banco.'</option>';
		endforeach;
	}

	#### callbacks de validaciones

	function unique_folio($folio)
	{	
		$this->load->model('validate_model');

		$search_folio = $this->validate_model->unique_folio(trim($folio));

		if(count($search_folio) > 0 ):
			$this->form_validation->set_message('unique_folio', 'Este folio ya  esta registrado.');
            return FALSE;
		else:
			return true;
		endif;
	}

	function unique_folio_other($folio, $id_detalle)
	{
		$this->load->model('validate_model');

		$search_folio = $this->validate_model->unique_folio_other(trim($folio), $id_detalle);
		if(count($search_folio) > 0 ):
			$this->form_validation->set_message('unique_folio_other', 'Este folio ya  esta registrado.');
            return FALSE;
		else:
			return true;
		endif;
	}

	function fecha_limite($fecha)
	{	
		$fecha_insert = formato_fecha_ddmmaaaa($fecha);
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
	

}