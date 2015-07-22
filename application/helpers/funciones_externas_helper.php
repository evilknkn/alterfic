<?php 
function bancos_empresa($db, $id_empresa)
{
	$bancos = $db->banco(array('ace.id_empresa' => $id_empresa));
	foreach($bancos as $banco):
	 	$nombre_banco[] = $banco->nombre_banco;
	endforeach;
	
	return $nombre_banco;
}

function nombre_empresa($db, $id_empresa)
{
	$res = $db->empresa(array('id_empresa'=>$id_empresa));
	return $res->nombre_empresa;
}

function cliente_asignado($db, $id_deposito)
{	
	$filtro = array('id_deposito'=>$id_deposito);
	$res = $db->cliente_asignado_deposito($filtro);
	return  $res->id_cliente;
}

function montos($db, $id_empresa, $id_banco, $tipo_mov, $fecha_ini = null, $fecha_fin = null)
{	

	$total_monto =0;
	if($fecha_ini != null):
		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco,'adc.tipo_movimiento' => $tipo_mov, 'fecha_movimiento >=' => $fecha_ini, 'fecha_movimiento <=' => $fecha_fin);
	else:
		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco,'adc.tipo_movimiento' => $tipo_mov);
	endif;
		$movimientos = $db->lista_movimiento($filtro, $tipo_mov);
		
	if(!empty($movimientos)):
		foreach($movimientos as $movimiento):
			$id_movimiento [] = $movimiento->id_movimiento;
		endforeach;
		
		if($tipo_mov == "deposito" or $tipo_mov == "deposito_interno"):
			$montos = $db->movimientos_deposito($id_movimiento);
			foreach($montos as $monto):
				$total_monto = $total_monto + $monto->monto_deposito;
			endforeach;
		else:
			$montos = $db->movimientos_salida($id_movimiento);
			foreach($montos as $monto):
				$total_monto = $total_monto + $monto->monto_salida;
			endforeach;
		endif;
		
		//print_r($id_movimiento);
	else:
		$total_monto = 0;
	endif;
	
	return ($total_monto);
}


function retorna_cliente($db, $folio)
{	
	$res = $db->tracking_salida_pago($folio);
	return $res;
}

function create_file($carpeta){

	$path = "files/".$carpeta."/";
		$targetPath =  PATH . "files/";

	if(!is_dir($targetPath)) {
	@mkdir($targetPath, 0755);
	}
	$targetPath.= $carpeta."/";
	if(!is_dir($targetPath)) {
	@mkdir($targetPath, 0755);
	}
}

function genera_comision($db, $id_cliente, $deposito)
{	

	if($id_cliente != 0 ):
		$res = $db->datos_cliente(array('id_cliente'=> $id_cliente));
		if($res->tipo_cliente == 'A'):
			$comision = ($deposito  * $res->comision);
		else:
			$comision = (($deposito / 1.16 ) * $res->comision);
		endif;
	else:
		$comision = 0;
	endif;
	return ($comision);
}

function total_pagos($db, $id_empresa, $id_banco, $id_deposito)
{
	$filtro_pago = array('id_empresa'=>$id_empresa, 'id_banco'=>$id_banco, 'id_deposito'=>$id_deposito);
	$pagos= $db->pagos_depto($filtro_pago);

	$total_pagos = 0;

	foreach($pagos as $pago):
		$total_pagos = $total_pagos + $pago->monto_pago;
	endforeach;

	return ($total_pagos);
}

function genera_comision_total($db, $id_cliente, $comision, $tipo_cliente = null)
{	
	$depositos = $db->lista_depositos(array('id_cliente' => $id_cliente));
	
	$total_comision = 0;
	foreach($depositos as $deposito):
		if( $tipo_cliente == 'A'):
			$comision_depto = (($deposito->monto_deposito  ) * $comision);
		else:
			$comision_depto = (($deposito->monto_deposito / 1.16 ) * $comision);
		endif;

		$total_comision = $total_comision + $comision_depto;
	endforeach;

	return $total_comision;
}

function genera_total_depositos($db, $id_empresa, $id_banco, $fecha_ini = null, $fecha_fin = null)
{	
	
	if($fecha_ini!=null):
		$filtro=array('adc.id_empresa'=>$id_empresa,
		 'adc.id_banco' =>$id_banco, 'adc.tipo_movimiento' => 'deposito',
		 'fecha_movimiento >= ' => $fecha_ini,
		 'fecha_movimiento <=' => $fecha_fin);
	else:
		$filtro=array('adc.id_empresa'=>$id_empresa, 'adc.id_banco' =>$id_banco, 'adc.tipo_movimiento' => 'deposito');
	endif;
	$depositos = $db->depositos_empresa($filtro);

	$total_depositos = 0 ;
	$id_cliente = "";
	$total_retornado =0;
	$monto_retornar= 0;
	foreach($depositos as $deposito):
		$total_depositos = $total_depositos + $deposito->monto_deposito;

		$comision 	= genera_comision($db, $deposito->id_cliente, $deposito->monto_deposito );
		$pagos  	= total_pagos($db, $id_empresa, $id_banco, $deposito->id_deposito);

		$pagados = $comision + $pagos;
		$total_retornado = $total_retornado + $pagados;		
	endforeach;
	
	$monto_retornar  =  $total_depositos - $total_retornado; 
	//echo ($monto_retornar. "<br>");
	$datos ['depositos'] = $total_depositos;
	$datos ['pendiente_retorno']	 = $monto_retornar;
	return $datos;
}


function gastos_cuenta($db, $id_empresa, $id_banco)
{
	$movimientos = $db->detalle_gastos($id_empresa, $id_banco);

	$total_gasto = 0;
	foreach($movimientos as $movimiento)
	{
		$total_gasto = $total_gasto + $movimiento->monto_salida;
	}

	return $total_gasto;

}

function fechas_rango_inicio($month)
{	
	$fecha_anterior = '';

	if($month == '01' or $month == '03' or $month =='04' or $month == '07' or $month == '08' or $month == '10' or $month == '12')
	{	
		// if($month < 10){
		// 	$fecha_anterior = ($month == '01') ? (date('Y') -1).'-12-15':  date('Y').'-0'.($month - 1).'-15'; 
		// }else{
		// 	$fecha_anterior = ($month == '01') ? (date('Y') -1).'-12-15':  date('Y').($month - 1).'-15'; 
		// }

		$fecha['fecha_inicio'] = date('Y-m-').'01';
		$fecha['fecha_fin'] = date('Y-m-').'31';

	}elseif($month == '04' or $month == '06' or $month == '09' or $month == '11'){
		// if($month < 10){
		// 	$fecha_anterior = ($month == '01') ? (date('Y') -1).'-12-15':  date('Y').'-0'.($month - 1).'-15'; 
		// }else{
		// 	$fecha_anterior = ($month == '01') ? (date('Y') -1).'-12-15':  date('Y').($month - 1).'-15'; 
		// }

		$fecha['fecha_inicio'] = date('Y-m-').'01';
		$fecha['fecha_fin'] = date('Y-m-').'30';
	}else{
		// if($month < 10){
		// 	$fecha_anterior = ($month == '01') ? (date('Y') -1).'-12-15':  date('Y').'-0'.($month - 1).'-15'; 
		// }else{
		// 	$fecha_anterior = ($month == '01') ? (date('Y') -1).'-12-15':  date('Y').($month - 1).'-15'; 
		// }
		$fecha['fecha_inicio'] = date('Y-m-').'01';
		$fecha['fecha_fin'] = date('Y-m-').'28';
	}

	return $fecha;
}



function fechas_rango_mes($month)
{

	if($month == '01' or $month == '03' or $month =='04' or $month == '07' or $month == '08' or $month == '10' or $month == '12')
	{
		$fecha['fecha_inicio'] = '01';
		$fecha['fecha_fin'] = '31';
	}elseif($month == '04' or $month == '06' or $month == '09' or $month == '11'){
		$fecha['fecha_inicio'] = '01';
		$fecha['fecha_fin'] = '30';
	}else{
		$fecha['fecha_inicio'] = '01';
		$fecha['fecha_fin'] = '28';
	}
///	print_r($fecha);
	return $fecha;
}

function cliente_asignado_deposito($db, $id_cliente)
{
	$res = $db->cliente_asignado_depto(array('id_cliente'=>$id_cliente));
	if(isset($res->nombre_cliente)): 
		$nombre_cliente = $res->nombre_cliente; 
	else: 
		$nombre_cliente=''; 
	endif;
	return $nombre_cliente;
}

function depositos_pendiente_retorno_gral($db, $id_empresa, $id_banco, $fecha_ini = null, $fecha_fin = null)
{	
	if($fecha_ini == null):
	$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco, 'adc.tipo_movimiento' => 'deposito');
	else:
	$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco, 'adc.tipo_movimiento' => 'deposito', 'adc.fecha_movimiento >=' => $fecha_ini, 'adc.fecha_movimiento <=' => $fecha_fin);
	endif;
	$depositos = $db->detalle_retorno($filtro);
	return $depositos;
}

function consulta_saldo_anterior($db, $month, $id_empresa, $id_banco)
{	
	$total_saldo = 0;
	$fecha_ant = fechas_rango_mes($month);
	$year = date('Y');
    if($month == '12'): $year =  $year - 1 ; endif;
    $fecha_begin = $year.'-'.($month).'-'.$fecha_ant['fecha_inicio'];
    $fecha_end = $year.'-'.($month).'-'.$fecha_ant['fecha_fin'];

	$key = $db->select_corte(array('id_empresa'=>$id_empresa,
	 'id_banco'=>$id_banco,'fecha_ini'=>$fecha_begin, 'fecha_fin'=>$fecha_end));
	//echo $key->id_empresa.'--'.$key->id_banco.'---'. ($key->total_saldo) .'<br>';
	if(isset($key->total_saldo)):
		$total_saldo = $key->total_saldo; 
	endif;
	return $total_saldo;
}


function pendiente_retorno($db, $id_empresa, $id_banco, $fecha_ini = null, $fecha_fin = null)
{
		$key = $db->select_pendiente_retorno(array('id_empresa' => $id_empresa, 'id_banco' => $id_banco));
	return $key;
}
function pendiente_retorno_empresa($db, $filtro)
{
	$key = $db->select_pendiente_retorno($filtro);
	return $key;
}

function depositos_generales ($db, $id_empresa, $id_banco, $fecha_ini = null, $fecha_fin = null)
{	
	//print_r($id_empresa);exit();
	$key = $db->sum_depositos( $id_empresa, $id_banco, $fecha_ini , $fecha_fin);
	//print_r($key);exit();
	if(!empty($key->total_deposito) ):
		return $key->total_deposito;
	else:
		return '0';
	endif;
}

function salidas_generales ($db, $id_empresa, $id_banco, $fecha_ini = null, $fecha_fin = null)
{	
	//print_r($id_empresa);exit();
	$key = $db->sum_salidas( $id_empresa, $id_banco, $fecha_ini , $fecha_fin);
	//echo $key->total_salida;
	//exit();
	if(!empty($key->total_salida) ):
		return $key->total_salida;
	else:
		return '0';
	endif;
}
