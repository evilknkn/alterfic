<?php 
function total_depositos($db, $id_empresa, $id_banco)
{

	$filtro = array('ace.id_empresa' => $id_empresa, 'ace.id_banco' => $id_banco);
	$depositos = $db->depositos_empresa($filtro);

	$total_depto=0;
	foreach($depositos as $deposito):
		$total_depto = $total_depto +$deposito->monto_deposito;
	endforeach;
	return round($total_depto, 2);
}

function lista_depositos($db, $folio_deposito)
{
	$res = $db->info_deposito(array('folio_depto' => $folio_deposito));
	
	return $res;
}
function lista_salidas($db, $folio_salida)
{
	$res = $db->info_salidas(array('folio_salida' => $folio_salida));
	return $res;
}

function retorna_salida($db, $folio_salida, $movimiento)
{
	$res = $db->salida_cuenta($folio_salida, $movimiento);
	//print_r($res);
	return $res;
}

function total_retiros($db)
{
	$retiros = $db->lista_retiros();

	$total_retiro = 0; 
	foreach($retiros as $retiro)
	{
		$total_retiro = $total_retiro + $retiro->monto_salida;
	}

	return $total_retiro;
}