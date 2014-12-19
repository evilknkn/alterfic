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

function montos($db, $id_empresa, $id_banco, $tipo_mov)
{	

	$total_monto =0;
	
	$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco,'adc.tipo_movimiento' => $tipo_mov);
	
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
		$comision = (($deposito / 1.16 ) * $res->comision);
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

function genera_comision_total($db, $id_cliente, $comision)
{	
	$depositos = $db->lista_depositos(array('id_cliente' => $id_cliente));
	
	$total_comision = 0;
	foreach($depositos as $deposito):
		$comision_depto = (($deposito->monto_deposito / 1.16 ) * $comision);
		$total_comision = $total_comision + $comision_depto;
	endforeach;

	return $total_comision;
}

function genera_total_depositos($db, $id_empresa, $id_banco)
{	
	$filtro=array('adc.id_empresa'=>$id_empresa, 'adc.id_banco' =>$id_banco, 'adc.tipo_movimiento' => 'deposito');
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
	if($month == '01' or $month == '03' or $month =='04' or $month == '07' or $month == '08' or $month == '10' or $month == '12')
	{
		$fecha['fecha_inicio'] = date('Y-m-').'01';
		$fecha['fecha_fin'] = date('Y-m-').'31';
	}elseif($month == '04' or $month == '06' or $month == '09' or $month == '11'){
		$fecha['fecha_inicio'] = date('Y-m-').'01';
		$fecha['fecha_fin'] = date('Y-m-').'30';
	}else{
		$fecha['fecha_inicio'] = date('Y-m-').'01';
		$fecha['fecha_fin'] = date('Y-m-').'28';
	}

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

function depositos_pendiente_retorno_gral($db, $id_empresa, $id_banco)
{	
	$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco, 'adc.tipo_movimiento' => 'deposito');
	$depositos = $db->detalle_retorno($filtro);
	return $depositos;
}
