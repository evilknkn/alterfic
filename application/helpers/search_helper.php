<?php 
function indefity_mov($mov_detail = null )
{
	//print_r($mov_detail);exit;
	switch ($mov_detail) {
		case 'deposito':
				$text = 'depósito';
			break;

		case 'mov_int':
				$text = 'interno';
			break;

		case 'deposito_interno':
				$text = 'depósito en movimiento interno';
			break;

		case 'salida_pago':
				$text = 'salida de monimiento de pago';
			break;

		case 'salida':
				$text = 'salida';
			break;

		case 'salida_comision':
				$text = 'salida pago de comisión';
			break;
	}

	return $text;
} 

function indetify_factory($db, $id_empresa)
{
	$row = $db->get_folio('ad_catalogo_empresa', array('id_empresa'=> $id_empresa));
	return $row->nombre_empresa;
}

function indetify_bank($db, $id_banco)
{
	$row = $db->get_folio('ad_catalogo_bancos', array('id_banco'=> $id_banco));
	return $row->nombre_banco;
}