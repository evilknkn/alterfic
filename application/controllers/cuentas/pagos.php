<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagos extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
       
    }
    
	public function add_pagos($id_empresa, $id_banco, $id_deposito)
	{ 
		//date('Y-m-d');
		$this->load->model('cuentas/depositos_model');
		$this->load->model('catalogo/empresas_model');

		$this->form_validation->set_rules('folio_pago' ,'folio de pago', 'required');
		$this->form_validation->set_rules('monto' ,'monto', 'required');
		$this->form_validation->set_rules('empresa_retorno' ,'empresa de retorno', 'required');
		$this->form_validation->set_rules('id_banco' ,'banco', 'required');
		$this->form_validation->set_rules('fecha_pago' ,'fecha de pago', 'required');
		$this->form_validation->set_rules('ruta_comprobante' ,'comprobante', 'required');

		$this->form_validation->set_message('required', 'El campo %s es requerido');

		if($this->form_validation->run()):

			$array = array('id_empresa' 			=> 	$id_empresa,
							'id_banco' 				=> 	$id_banco,
							'id_deposito'			=> 	$id_deposito,
							'monto_pago'			=> 	$this->input->post('monto'),
							'empresa_retorno'		=> 	$this->input->post('empresa_retorno'),
							'banco_retorno'			=> 	$this->input->post('id_banco'),
							'folio_pago'			=>	$this->input->post('folio_pago'),
							'ruta_comprobante'		=>	$this->input->post('ruta_comprobante'),
							'fecha_pago'			=> formato_fecha_ddmmaaaa($this->input->post('fecha_pago')));

			$this->depositos_model->insert_pago($array);

			$array = array('fecha_salida' 	=> formato_fecha_ddmmaaaa($this->input->post('fecha_pago')),
							'monto_salida' 	=> $this->input->post('monto'),
							'folio_salida'	=> 	$this->input->post('folio_pago'),
							'detalle_salida'=> 'Pago en el deposito con folio '.$this->input->post('folio_pago') );

			$reg = $this->depositos_model->insert_salida($array);

			$datos = array(	'id_empresa'		=>	$this->input->post('empresa_retorno'),
							'id_banco'			=>	$this->input->post('id_banco'),
							'id_movimiento'		=> 	$reg,
							'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_pago')),
							'tipo_movimiento'	=>	'salida_pago');

			$this->depositos_model->insert_movimiento($datos);

			
			$this->session->set_flashdata('success', 'Pago agregado correctamente.');
			redirect(base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco));
		
		else:
			$data = array(	'menu' 	=>  'menu/menu_admin',
							'body'	=>	'admin/cuentas/deposito/form_pagos');
			
			$data['id_empresa'] = $id_empresa;
			$data['id_banco']	= $id_banco;
			$data['empresas']	= $this->empresas_model->lista_empresas();
		
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
			$cont = $cont + $i;
			$pago = convierte_moneda($pagos[$i]->monto_pago);
			$fecha = formato_fecha_ddmmaaaa($pagos[$i]->fecha_pago);

			$total = $total + $pagos[$i]->monto_pago;
			echo "<tr>
				<td class='text-center'> Pago ".$cont."</td>
				<td class='text-center'>".$pago."</td>
				<td class='text-center'>".$fecha."</td>
				<td class='text-center'><a href='".base_url($pagos[$i]->ruta_comprobante)."' class='btn'>Ver comprobante</a></td>
				<td class='text-center'>
				<a onclick='abre_ventana(".$pagos[$i]->id_pago.")' style ='cursor:pointer' >
					<i class='fa fa-search' ></i>
				</a>
				</td>
				<td class='text-center'>
					<a href='".base_url('cuentas/mov_delete/pago/'.$pagos[$i]->id_pago)."'>
						<i class='fa fa-trash fa-lg'></i>
					</a>
				</td>
				
			</tr>";
		endfor;

		echo '<tr>
		<td class="text-center">Total</td>
		<td class="text-center">'.convierte_moneda($total).'</td>
		</tr>';
	}

	public function pagos_detalle()
	{
		$this->load->model('cuentas/depositos_model');

		$array = array('id_empresa'		=>	$this->input->post('id_empresa'),
						'id_banco'		=>	$this->input->post('id_banco'),
						'id_deposito'	=>	$this->input->post('id_deposito'));

		$pagos = $this->depositos_model->pagos_deposito($array);
		
		$total = 0;
		$cont = 1 ;
		for($i=0; $i<sizeof($pagos); $i++):
			$cont = $cont + $i;
			$pago = convierte_moneda($pagos[$i]->monto_pago);
			$fecha = formato_fecha_ddmmaaaa($pagos[$i]->fecha_pago);

			$total = $total + $pagos[$i]->monto_pago;
			echo "<tr>
				<td class='text-center'> Pago ".($i+1)."</td>
				<td class='text-center'>".$pago."</td>
				<td class='text-center'>".$fecha."</td>
				<td class='text-center'><a href='".base_url($pagos[$i]->ruta_comprobante)."' class='btn'>Ver comprobante</a></td>
				<td class='text-center'>
				<a onclick='abre_ventana(".$pagos[$i]->id_pago.")' style ='cursor:pointer' >
					<i class='fa fa-search' ></i>
				</a>
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

	public function detalle_salida()
	{
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');

		$id_empresa		= $this->input->post('id_empresa');
		$id_banco		= $this->input->post('id_banco');
		$id_deposito	= $this->input->post('id_deposito');

		$filtro_dpto = array('id_deposito'=>$id_deposito);
		$monto_retorno = $this->movimiento_model->monto_retorno($filtro_dpto);

		$filtro_pago = array('id_empresa'=>$id_empresa, 'id_banco'=>$id_banco, 'id_deposito'=>$id_deposito);
		$pagos=$this->movimiento_model->pagos_depto($filtro_pago);

		$datos_pago = $this->movimiento_model->detalle_deposito($pagos[0]->folio_pago);
		//print_r($datos_pago_traking);
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

		$data['deposito'] = $depto.' de la cuenta '.$datos_pago->nombre_empresa.' del banco '.$datos_pago->nombre_banco;
		$data['comision'] = convierte_moneda($comis);
		$data['retorno'] = convierte_moneda($monto_retornar);
		$data['total_pagos'] = convierte_moneda($total_pagos);
		$data['pendiente'] = convierte_moneda($pendiente);
		$data['cliente'] = $comision;
		$data['estatus'] = $data_cliente;
		
		echo json_encode($data);
	}

	public function detalle_pago($id_pago)
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('catalogo/empresas_model');

		$dt_pago = $this->depositos_model->detalle_pago($id_pago);

		$this->form_validation->set_rules('folio_pago' ,'folio de pago', 'required|callback_unique_folio_other['.$this->input->post('id_detalle').']');
		$this->form_validation->set_rules('monto' ,'monto', 'required');
		$this->form_validation->set_rules('empresa_retorno' ,'empresa de retorno', 'required');
		$this->form_validation->set_rules('id_banco' ,'banco', 'required');
		$this->form_validation->set_rules('fecha_pago' ,'fecha de pago', 'required|callback_fecha_limite');
		//$this->form_validation->set_rules('ruta_comprobante' ,'comprobante', 'required');

		$this->form_validation->set_message('required', 'El campo %s es requerido');
		if($this->form_validation->run()):
			$info_depto = $this->depositos_model->info_deposito($dt_pago->id_deposito);
			$empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $dt_pago->id_empresa, 'acb.id_banco' => $dt_pago->id_banco));

			$array = array(	'monto_pago'			=> 	$this->input->post('monto'),
							'empresa_retorno'		=> 	$this->input->post('empresa_retorno'),
							'banco_retorno'			=> 	$this->input->post('id_banco'),
							'folio_pago'			=>	$this->input->post('folio_pago'),
							'fecha_pago'			=>  formato_fecha_ddmmaaaa($this->input->post('fecha_pago')));

			$this->depositos_model->update_deposito_pago($array, $id_pago);

			$array_salida = array('fecha_salida' 	=> formato_fecha_ddmmaaaa($this->input->post('fecha_pago')),
							'monto_salida' 	=> $this->input->post('monto'),
							'folio_salida'	=> 	$this->input->post('folio_pago'),
							'detalle_salida' => 'Se actualizo un pago a la empresa '.$empresa->nombre_empresa.' en el banco '.$empresa->nombre_banco.' por la cantidad de '.$this->input->post('monto'). ' al depósito con folio '.$info_depto->folio_depto );

			$this->depositos_model->update_salidas($array_salida, $dt_pago->id_salida);

		

			$array_detalle = array(	'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($this->input->post('fecha_pago')),
									'id_empresa'		=> 	$this->input->post('empresa_retorno'),
									'id_banco'			=> 	$this->input->post('id_banco'),
									'folio_mov'			=>  trim($this->input->post('folio_pago')));

			$this->depositos_model->update_detalle_cuenta($array_detalle, $dt_pago->id_detalle);


			$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
                            'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' edito un pago en el depósito con folio '.trim($this->input->post('folio_pago')).' con un monto de '.$this->input->post('monto').' en la empresa '. $empresa->nombre_empresa.' del banco '. $empresa->nombre_banco.'.' ,
                            'lugar'     =>  'Pago',
                            'usuario'   =>  $this->session->userdata('USERNAME'));

            $this->bitacora_model->insert_log($array);
			
			$this->session->set_flashdata('success', 'Pago actualizado correctamente');
			redirect(base_url('cuentas/pagos/detalle_pago/'.$id_pago));
		else:
			$data['empresas']	= $this->empresas_model->lista_empresas();
			$data['pago'] 		= $dt_pago;
			$this->load->view('admin/cuentas/deposito/detalle_pago', $data);
		endif;
	}

	public function pending_pay_client()
	{	
		$this->load->model('cuentas/Pendiente_retorno_model', 'db_retorno');
		$db = $this->db_retorno;

		$det_depto = $db->row_quey('ad_pendiente_retorno', array('id_deposito' => $this->input->post('id_deposito') ) );
		//print_r($det_depto->id_cliente);exit;
		$ctas_pendiente = $db->get_query('ad_pendiente_retorno', array('id_cliente'=> $det_depto->id_cliente, 'pendiente_retornar >'=>10));
		$data = array();
		foreach($ctas_pendiente as $ctas )
		{
			$data[] = array('id_deposito' 		=> $ctas->id_pendiente,
							'folio_deposito' 	=> $ctas->folio_deposito,
							'monto_deposito' 	=> number_format($ctas->monto_deposito,2),
							'comision'			=> number_format($ctas->comision, 2),
							'pendiente_retornar'=> number_format($ctas->pendiente_retornar, 2),
							'checked' 			=> ($ctas->id_deposito == $det_depto->id_deposito)? true:false );
		}
		//print_r(($data));exit;

		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data)); 
	}
	public function pay_bills()
	{	
		$this->load->model('cuentas/depositos_model');
		$this->load->model('catalogo/empresas_model');
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$this->load->model('cuentas/Pendiente_retorno_model', 'db_retorno');
		$db = $this->db_retorno;

		//print_r($_POST);exit;

		$empresa_retorno = $this->input->post('empresa_retorno');
		$banco_retorno 	= $this->input->post('banco_retorno');
		$id_depositos 	= $this->input->post('id_depositos');
		$fecha_pago 	= $this->input->post('fecha_pago');
     	$comprobante 	= $this->input->post('comprobante');
     	$id_depositos   = $this->input->post('id_depositos');
     	$monto_pago 	= $this->input->post('monto_pago');
     	$folio_form 	= $this->input->post("folio_pago");

     	//echo "este es el folo enviado en post ".$folio_form;exit;

     	if($empresa_retorno == 15 )
     	{
     		$empresa_retorno 	= 15;
     		$banco_retorno 		= 6;
     	}else{
     		$empresa_retorno 	= $empresa_retorno;
     		$banco_retorno 		= $banco_retorno;
     	}
	   	

     	$deposito = explode(',', $id_depositos);

		$array = $db->get_in_query('ad_pendiente_retorno', $deposito, 'id_pendiente');
		$i=0;
		foreach($array as $depto )
		{	
			if($empresa_retorno == 15){
				$folio_ant = $this->depositos_model->numero_folio('EFE');
				$folio_mov = generar_folio('EFE', ($folio_ant+1) );
			}else{
				$folio_mov = $folio_form;
			}
			

			$pago_add = $monto_pago ;
			//echo $pago_add.'---'.$i++.'--- pendente--'.$depto->pendiente_retornar."<br>";
			if($pago_add > 0)
			{	
				if($pago_add > $depto->pendiente_retornar)
				{
					$pago_add = $depto->pendiente_retornar;
				}	else{
					$pago_add = $monto_pago;
				}

				//echo $depto->id_empresa.'-----'. $depto->id_banco.'---'.$depto->id_deposito;
				//echo 'se pagara '. $pago_add."<br>";
				# Inserta deposito a la tabla ad_deposito_pago, estos deben ir en la funcion de pendiente de retorno 
				$array_first = array('id_empresa' 			=> 	$depto->id_empresa,
								'id_banco' 				=> 	$depto->id_banco,
								'id_deposito'			=> 	$depto->id_deposito,
								'monto_pago'			=> 	$pago_add,
								'empresa_retorno'		=> 	$empresa_retorno,
								'banco_retorno'			=> 	$banco_retorno,
								'folio_pago'			=>	$folio_mov,
								'ruta_comprobante'		=>	$comprobante,
								'fecha_pago'			=>  formato_fecha_ddmmaaaa($fecha_pago));

				$this->depositos_model->insert_pago($array_first);

				# Agregamos la salida con los id de empresa de retorno  a la tabla ad_salidas
				$array_second = array('fecha_salida' => formato_fecha_ddmmaaaa($fecha_pago),
								'monto_salida' => $pago_add,
								'folio_salida'	=> 	$folio_mov,
								'detalle_salida' => 'Se realizó un pago a la empresa con id '.$depto->id_empresa.' en el banco con id '.$depto->id_banco.' por la cantidad de '.$pago_add. ' al depósito con folio '.$depto->folio_deposito );

				$reg = $this->depositos_model->insert_salida($array_second);

				// Se inserta el movimiento en detalle de movimiento 
				$datos = array(	'id_empresa'		=>	$empresa_retorno,
								'id_banco'			=>	$banco_retorno,
								'id_movimiento'		=> 	$reg,
								'fecha_movimiento'	=> 	formato_fecha_ddmmaaaa($fecha_pago),
								'folio_mov'			=>  $folio_mov,
								'tipo_movimiento'	=>	'salida_pago');

				$this->depositos_model->insert_movimiento($datos);
			

				#Se inserta en la tabla de pendiente de retorno 
				#treaemos todos los pagos hechos
				$pago = total_pagos($this->retorno_model, $depto->id_empresa, $depto->id_banco, $depto->id_deposito);
				$pendiente = $depto->monto_deposito - ($depto->comision + $pago) ;

				$data_pendiente	= array('total_pagos'			=> $pago, 	
										'pendiente_retornar' 	=> $pendiente );

				$this->retorno_model->update_pendiente_retorno($data_pendiente,array('id_deposito' => $depto->id_deposito,'id_empresa' => $depto->id_empresa, 'id_banco' => $depto->id_banco));


				$array  = array('id_user'   =>  $this->session->userdata('ID_USER') ,
		                        'accion'    =>  'El usuario '.$this->session->userdata('USERNAME'). ' registró  un pago en el depósito con folio '.$folio_mov.' con un monto de '.$pago_add.' en la empresa '. $depto->id_empresa.' del banco '. $depto->id_banco.'.' ,
		                        'lugar'     =>  'Pago',
		                        'usuario'   =>  $this->session->userdata('USERNAME'));

		        $this->bitacora_model->insert_log($array);
		   }

		    $monto_pago = $monto_pago - $depto->pendiente_retornar;
		}

		$data['message'] = 'success';

		echo json_encode($data); 
	}

	public function unique_folio_ajax()
	{
		$this->load->model('cuentas/Pendiente_retorno_model', 'db_retorno');
		$db = $this->db_retorno;

		$folio= $db->row_quey('ad_detalle_cuenta', array('folio_mov'=>$this->input->post('folio_pago') ));

		if(count($folio) > 0){
			$data['success'] = false;
		}else{
			$data['success'] = true;
		}


		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data)); 
	}

	public function empresas()
	{
		$this->load->model('cuentas/Pendiente_retorno_model', 'db_retorno');
		$db = $this->db_retorno;

		$list_empresas =  $db->get_query('ad_catalogo_empresa', array('tipo_usuario'=>1, 'estatus' => 1));

		$data = array();
		
		foreach($list_empresas as $empresa)
		{
			$data[] = array('id_empresa' =>  $empresa->id_empresa, 'name_empresa' => $empresa->nombre_empresa );
		}

		//return json_encode($data);
		return $this->output->set_content_type('application/json')->set_status_header(200)->set_output(json_encode($data)); 
	}
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