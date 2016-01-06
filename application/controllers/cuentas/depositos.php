<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Depositos extends CI_controller
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
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas_helper');

		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/deposito/lista_depositos');

		$fecha = fechas_rango_inicio(date('m'));

		//$data['fecha_ini'] = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		//$data['fecha_fin'] = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;
		
		$data['fecha_ini'] = '2015-03-01';#($this->input->post('fecha_inicio')) ? '2015-03-01' : $fecha['fecha_inicio'] ;
		$data['fecha_fin'] = '2015-03-31';#($this->input->post('fecha_final')) ? '2015-03-31' : $fecha['fecha_fin'] ;
		

		$data['empresas'] 	= $this->depositos_model->lista_empresas(array('ace.tipo_usuario' => 1));
		$data['db']			= $this->depositos_model;
		$data['db_mov']		= $this->movimiento_model;

		$this->load->view('layer/layerout', $data);
	}

	public function detalle_cuenta($id_empresa, $id_banco)
	{	
		$this->load->model('cuentas/depositos_model');
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');


		$data = array(	'menu' 	=>  'menu/menu_admin',
						'body'	=>	'admin/cuentas/deposito/detalle_deposito');

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;
		# creamos la session con la fecha de detalle para generar el archivo excel 
		$array_session = array('fecha_ini_depositos' => $fecha_ini, 'fecha_fin_depositos' => $fecha_fin);
		$this->session->set_userdata($array_session);

		$datos_empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'acb.id_banco' => $id_banco));
		$data['empresa'] = $datos_empresa;

		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco);

		$data['movimientos'] 	= $this->movimiento_model->lista_movimientos($filtro, $fecha_ini, $fecha_fin );
		$data['clientes']	= $this->clientes_model->lista_clientes();

		$data['id_empresa'] = $id_empresa;
		$data['id_banco']	= $id_banco;
		$data['db'] = $this->depositos_model;
		$data['db_mov'] = $this->movimiento_model;
		$data['db_cliente'] = $this->clientes_model;

		$this->load->view('layer/layerout', $data);
	}

	public function insert_deposito($id_empresa, $banco)
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model');
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'abe.id_banco' => $banco ));

		$this->form_validation->set_rules('fecha_depto' ,'fecha del depoósito', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_depto' ,'monto del depoósito', 'required');
		$this->form_validation->set_rules('folio_depto' ,'folio', 'required|trim|callback_unique_folio');

		if($this->form_validation->run()):
			$array = array('fecha_deposito' => formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
							'monto_deposito' => $this->input->post('monto_depto'),
							'folio_depto'	=> 	trim($this->input->post('folio_depto')));

			$reg = $this->depositos_model->registra_depto($array);

			$datos = array(	'id_empresa'		=>	$id_empresa,
							'id_banco'			=>	$banco,
							'id_movimiento'		=> 	$reg,
							'folio_mov'			=> 	trim($this->input->post('folio_depto')),
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
							'tipo_movimiento'	=>	'deposito');

			$this->detalle_cuenta_model->insert_movimiento($datos);

			#Se inserta en la tabla de pendiente de retorno 
			$data_pendiente	= array('id_empresa' 		=> $id_empresa,
									'id_banco'	 		=> $banco,
									'id_deposito' 		=> $reg, 
									'folio_deposito'	=> trim($this->input->post('folio_depto')),
									'fecha_movimiento'	=> formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
									'monto_deposito'	=> $this->input->post('monto_depto'), 
									'pendiente_retornar' => $this->input->post('monto_depto') );

			$this->retorno_model->insert_deposito($data_pendiente);
			//print_r($data_pendiente);exit;

			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' registró  un deposito por '.$this->input->post('monto_depto').' a la empresa '. $empresa->nombre_empresa.' en banco '. $empresa->nombre_banco.' con folio '.trim($this->input->post('folio_depto')).'.' ,
                            'lugar'     =>  'Deposito',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

			$this->session->set_flashdata('success', 'El depósito se guardo correctamente');
			redirect(base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$banco));
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/deposito/form_depto');

			$data['empresa'] 	= $empresa;
			$data['id_banco'] 	= $banco; 
		
			$this->load->view('layer/layerout', $data);
		endif;	
	}

	public function editar_deposito($id_empresa, $id_banco, $id_detalle, $id_deposito)
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model');
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa));
		$dt_deposito = $this->depositos_model->detalle_deposito(array('adc.id_empresa'=>$id_empresa, 'adc.id_banco' => $id_banco, 'ad.id_deposito' => $id_deposito));
		
		$this->form_validation->set_rules('fecha_depto' ,'fecha del depoósito', 'required|callback_fecha_limite');
		$this->form_validation->set_rules('monto_depto' ,'monto del depoósito', 'required');
		$this->form_validation->set_rules('folio_depto' ,'folio', 'required|trim|callback_unique_folio_other');

		if($this->form_validation->run()):
			
			$dt_depositos = array(	'fecha_movimiento' 	=>  formato_fecha_ddmmaaaa($this->input->post('fecha_depto')), 'folio_mov' => $this->input->post('folio_depto'));
			$dt_pendiente = $this->retorno_model->select_pendiente_retorno_empresa(array('id_deposito' => $id_deposito));

			$pendiente = $this->input->post('monto_depto') - ($dt_pendiente->comision + $dt_pendiente->total_pagos) ;

			//print_r($pendiente);exit;

			$this->depositos_model->actualiza_detalle_cuenta($dt_depositos, $id_detalle);

			$deposito 	= array('fecha_deposito' 	=> formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
								'monto_deposito' 	=> $this->input->post('monto_depto'),
								'folio_depto'  		=> $this->input->post('folio_depto'));

			$this->depositos_model->actualiza_deposito($deposito, $id_deposito);

			$data_pendiente = array('monto_deposito' 	=> 	$this->input->post('monto_depto') ,
									'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_depto')),
									'folio_deposito'	=> 	$this->input->post('folio_depto'),
									'pendiente_retornar'=> 	$pendiente);

			$this->retorno_model->update_pendiente_retorno($data_pendiente, array('id_deposito' => $id_deposito));

			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' modificó el deposito con folio '.$this->input->post('folio_depto').' los datos anteriores eran: no. folio '.$dt_deposito->folio_depto.', monto '.$dt_deposito->monto_deposito.', fecha deldepto '.$dt_deposito->folio_depto.' de la empresa '. $dt_deposito->nombre_empresa.' en banco '. $dt_deposito->nombre_banco.'.' ,
                            'lugar'     =>  'Deposito edición',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

            $this->session->set_flashdata('success', 'Deposito actualizado correctamente.');
            redirect(base_url('cuentas/depositos/editar_deposito/'.$id_empresa.'/'.$id_banco.'/'.$id_detalle.'/'.$id_deposito));
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/deposito/editar_deposito');
			
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']	= $id_banco;
			$data['empresa'] 	= $empresa;
			$data['deposito'] 	= $dt_deposito;

			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function add_clientes($id_empresa, $id_banco)
	{	
		$this->load->model('cuentas/depositos_model');

		$this->form_validation->set_rules('fecha_depto' ,'fecha del depoósito', 'required');

		if($this->form_validation->run()):

			$array = array('id_empresa' 		=> $id_empresa,
							'id_banco' 			=> $id_banco,
							'nombre_cliente'	=> $this->input->post('nombre_cliente'),
							'email'				=> $this->input->post('email'),
							'comision'			=> $this->input->post('comision'));

			$this->depositos_model->insert_cliente($array);
			
			$this->session->set_flashdata('success', 'Se agregó correctamente un nuevo cliente');
			redirect(base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco));
		
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/deposito/form_cliente');
			
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']= $id_banco;
		
			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function add_pagos($id_empresa, $id_banco, $id_deposito, $url_gral = null)
	{ 
		//date('Y-m-d');
		$this->load->model('cuentas/depositos_model');
		$this->load->model('catalogo/empresas_model');
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'acb.id_banco' => $id_banco));

		$this->form_validation->set_rules('folio_pago' ,'folio de pago', 'required|trim|callback_unique_folio');
		$this->form_validation->set_rules('monto' ,'monto', 'required');
		$this->form_validation->set_rules('empresa_retorno' ,'empresa de retorno', 'required');
		$this->form_validation->set_rules('id_banco' ,'banco', 'required');
		$this->form_validation->set_rules('fecha_pago' ,'fecha de pago', 'required|callback_fecha_pago');
		//$this->form_validation->set_rules('ruta_comprobante' ,'comprobante', 'required');

		$this->form_validation->set_message('required', 'El campo %s es requerido');

		if($this->form_validation->run()):
			$info_depto = $this->retorno_model->select_pendiente_retorno_empresa(array('id_deposito' => $id_deposito,'id_empresa' => $id_empresa, 'id_banco' => $id_banco));

			# Inserta deposito a la tabla ad_deposito_pago
			$array = array('id_empresa' 			=> 	$id_empresa,
							'id_banco' 				=> 	$id_banco,
							'id_deposito'			=> 	$id_deposito,
							'monto_pago'			=> 	$this->input->post('monto'),
							'empresa_retorno'		=> 	$this->input->post('empresa_retorno'),
							'banco_retorno'			=> 	$this->input->post('id_banco'),
							'folio_pago'			=>	trim($this->input->post('folio_pago')),
							'ruta_comprobante'		=>	$this->input->post('ruta_comprobante'),
							'fecha_pago'			=>  formato_fecha_ddmmaaaa($this->input->post('fecha_pago')));

			$this->depositos_model->insert_pago($array);

			# Agregamos la salida con los id de empresa de retorno  a la tabla ad_salidas
			$array = array('fecha_salida' => formato_fecha_ddmmaaaa($this->input->post('fecha_pago')),
							'monto_salida' => $this->input->post('monto'),
							'folio_salida'	=> 	trim($this->input->post('folio_pago')),
							'detalle_salida' => 'Se realizó un pago a la empresa '.$empresa->nombre_empresa.' en el banco '.$empresa->nombre_banco.' por la cantidad de '.$this->input->post('monto'). ' al depósito con folio '.$info_depto->folio_deposito );

			$reg = $this->depositos_model->insert_salida($array);

			$datos = array(	'id_empresa'		=>	$this->input->post('empresa_retorno'),
							'id_banco'			=>	$this->input->post('id_banco'),
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_pago')),
							'folio_mov'			=>  trim($this->input->post('folio_pago')),
							'tipo_movimiento'	=>	'salida_pago');

			$this->depositos_model->insert_movimiento($datos);

			#Se inserta en la tabla de pendiente de retorno 
			#treaemos todos los pagos hechos
			$pago = total_pagos($this->retorno_model, $id_empresa, $id_banco, $id_deposito);
			$pendiente = $info_depto->monto_deposito - ($info_depto->comision + $pago) ;

			$data_pendiente	= array('total_pagos'			=> $pago, 	
									'pendiente_retornar' 	=> $pendiente );

			$this->retorno_model->update_pendiente_retorno($data_pendiente,array('id_deposito' => $id_deposito,'id_empresa' => $id_empresa, 'id_banco' => $id_banco));


			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' registró  un pago en el depósito con folio '.trim($this->input->post('folio_pago')).' con un monto de '.$this->input->post('monto_depto').' en la empresa '. $empresa->nombre_empresa.' del banco '. $empresa->nombre_banco.'.' ,
                            'lugar'     =>  'Pago',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);

			
			$this->session->set_flashdata('success', 'Pago agregado correctamente.');
			if($url_gral ==1):
				redirect(base_url('cuentas/pendiente_retorno/pendiente_retorno_general'));
			else:
				redirect(base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco));
			endif;
		
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/deposito/form_pagos');

			//$data['empresa'] = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'acb.id_banco' => $id_banco));
			$data['empresa'] = $empresa;
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']	= $id_banco;
			$data['empresas']	= $this->empresas_model->lista_empresas();
			$data['url_gral']   = $url_gral;
		
			$this->load->view('layer/layerout', $data);
		endif;
	}

	public function pagos()
	{
		$this->load->model('cuentas/depositos_model');

		$array = array('id_empresa'		=>	$this->input->post('id_empresa'),
						'id_banco'		=>	$this->input->post('id_banco'),
						'id_deposito'	=>	$this->input->post('id_deposito'));

		$pagos = $this->depositos_model->pagos_deposito($array);
		
		$total = 0;
		$cont = 1 ;
		for($i=0; $i<sizeof($pagos); $i++):
			//$cont = $cont + $i;
			$pago = convierte_moneda($pagos[$i]->monto_pago);
			$fecha = formato_fecha_ddmmaaaa($pagos[$i]->fecha_pago);

			$total = $total + $pagos[$i]->monto_pago;
			/**********************************************************/
			/* Valida si es perfil uno no puede borrar el movimiento */
			/********************************************************/
			
			$link_delete = "<a href='".base_url('cuentas/mov_delete/pago/'.$this->input->post('id_empresa').'/'.$this->input->post('id_banco').'/'.$pagos[$i]->id_pago)."'><i class='fa fa-trash fa-lg'></i></a>";
			$validate_perfil = ($this->session->userdata('ID_PERFIL') == 1 or $this->session->userdata('ID_PERFIL') == 5  )? '' : $link_delete; 
			
			echo "<tr>
				<td class='text-center'> Pago ".($i+1)."</td>
				<td class='text-center'>".$pago."</td>
				<td class='text-center'>".$fecha."</td>
				<td class='text-center'><a href='".base_url($pagos[$i]->ruta_comprobante)."' target='_blank' class='btn btn-yellow'>Ver comprobante</a></td>
				<td class='text-center'>
				<a onclick='abre_ventana(".$pagos[$i]->id_pago.")' style ='cursor:pointer' >
					<i class='fa fa-search' ></i>
				</a>
				</td>
				<td class='text-center'>
					".$validate_perfil."
				</td>
				
			</tr>";
		endfor;

		echo '<tr>
		<td class="text-center">Total</td>
		<td class="text-center">'.convierte_moneda($total).'</td>
		</tr>';
	}

	public function movimiento_pagos()
	{
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');

		$id_empresa		= $this->input->post('id_empresa');
		$id_banco		= $this->input->post('id_banco');
		$id_deposito	= $this->input->post('id_deposito');

		$filtro_dpto = array('id_deposito'=>$id_deposito);
		$monto_retorno = $this->movimiento_model->monto_retorno($filtro_dpto);

		$filtro_pago = array('id_empresa'=>$id_empresa, 'id_banco'=>$id_banco, 'id_deposito'=>$id_deposito);
		$pagos=$this->movimiento_model->pagos_depto($filtro_pago);

		$total_pagos = 0;

		foreach($pagos as $pago):
			$total_pagos = $total_pagos + $pago->monto_pago;
		endforeach;

		if(!empty($monto_retorno->id_cliente)):
			$cliente = $this->movimiento_model->comision($monto_retorno->id_cliente);
			$comision= $cliente->comision;
			$data_cliente = 'asignado';
		else:
			$data_cliente ="no asignado";
			$comision = 0;
		endif;
		
		$depto  = ($monto_retorno->monto_deposito);
		$comis = (($depto / 1.16 ) * $comision);
		$monto_retornar = $depto - (($depto / 1.16 ) * $comision);
		$total_pagos = $total_pagos;
		$pendiente=$monto_retornar -$total_pagos;

		$data['deposito'] = $depto;
		$data['comision'] = convierte_moneda($comis);
		$data['retorno'] = convierte_moneda($monto_retornar);
		$data['total_pagos'] = convierte_moneda($total_pagos);
		$data['pendiente'] = convierte_moneda($pendiente);
		$data['cliente'] = $comision;
		$data['estatus'] = $data_cliente;
		
		echo json_encode($data);
	}

	public function asigna_cliente()
	{	
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$data = array('id_cliente' => $this->input->post('id_cliente'));
		$filtro= array('id_deposito'=> $this->input->post('id_deposito'));

		$this->depositos_model->actualiza_cliente($filtro, $data);
		$depto = $this->depositos_model->info_deposito($this->input->post('id_deposito'));
		$pagos = $this->retorno_model->select_pendiente_retorno_empresa(array('id_deposito' => $this->input->post('id_deposito')));
		//print_r($depto);exit();

		$comision = genera_comision($this->retorno_model, $this->input->post('id_cliente'), $depto->monto_deposito);
		$pendiente_retorno = $pagos->monto_deposito - ($pagos->total_pagos + $comision);

		$this->retorno_model->update_pendiente_retorno(array('comision' => round($comision,2), 'pendiente_retornar' => $pendiente_retorno ) , array('id_deposito' => $this->input->post('id_deposito') ));
		//print_r($comision);exit;
		$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' asigno al cliente con el id '.trim($this->input->post('id_cliente')).' en el deposito con id '.$this->input->post('id_deposito'),
                            'lugar'     =>  'Deatalle_deposito/Deposito/asigna_cliente',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

        $this->bitacora_model->insert_log($array);

		echo "exito";
	}

	public function bancos_empresa()
	{
		$this->load->model('catalogo/catalogo_banco_model', 'banco_model');
		$id_empresa = $this->input->post('id_empresa');

		$bancos = $this->banco_model->bancos_empresa($id_empresa);

		echo '<option value = "">Seleccione un banco</option>';
		foreach($bancos as $banco):
			echo '<option value="'.$banco->id_banco.'">'.$banco->nombre_banco.'</option>';
		endforeach;
	}

	public function bancos_empresa_detalle()
	{
		$this->load->model('catalogo/catalogo_banco_model', 'banco_model');
		$id_empresa = $this->input->post('id_empresa');
		$id_banco = $this->input->post('id_banco');

		$bancos = $this->banco_model->bancos_empresa($id_empresa);

		echo '<option value = "">Seleccione un banco</option>';
		foreach($bancos as $banco):
			$selected = ($id_banco == $banco->id_banco)? 'selected = selected' : '';
			echo '<option value="'.$banco->id_banco.'"'.$selected.'>'.$banco->nombre_banco.'</option>';
		endforeach;
	}



	#### callbacks de validaciones

	function unique_folio($folio)
	{	
		$this->load->helper('search');
		$this->load->model('tool/eloquent_model','search_db');
		$db = $this->search_db;

		$id_empresa = $this->uri->segment(4);
		$id_banco = $this->uri->segment(5);

		$array_search = array('db' => $db, 'folio' => trim($folio),'id_empresa' => $id_empresa, 'id_banco'=> $id_banco );
		//return false;
		$search_folio = clave_factory($array_search);

		if($search_folio['success'] == 'false' ):
			$this->form_validation->set_message('unique_folio', $search_folio['fail_txt']);
            return FALSE;
		else:
			return true;
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

	function fecha_limite()
	{	
		$fecha_insert = formato_fecha_ddmmaaaa($this->input->post('fecha_depto'));
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

	function fecha_pago($fecha_pago)
	{	
		$fecha_insert = formato_fecha_ddmmaaaa($fecha_pago);
		$date_now = date('Y/m/d');
		$date_msg = date('d/m/Y');
		//print_r($fecha_insert);exit;
		if($fecha_insert > $date_now):
			$this->form_validation->set_message('fecha_pago', 'La fecha no puede ser mayor a el día de hoy ('.$date_msg.').');
            return FALSE;
		else:
			return TRUE;
		endif;
	}
}
