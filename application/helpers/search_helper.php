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
				$text = 'salida de movimiento de pago';
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

function clave_factory($dataArray)
{
	
	$db = $dataArray['db'];
	
	$detail_folio = explode('-', $dataArray['folio']);
		if(count($detail_folio) ==2)
		{	
			if(strlen($detail_folio[1]) != 5 ){
				$data['success'] = 'false';
				$data['fail_txt'] = '*El folio debe contener 5 dígitos';
				return $data;
			}else{
				
				$where_array = array('id_empresa' => $dataArray['id_empresa'], 'id_banco' => $dataArray['id_banco'], 'clave' => $detail_folio[0] );
				$clave_cta = $db->row_quey('ad_bancos_empresa', $where_array );
				//print_r($clave_cta);
				if(count($clave_cta) == 0)
				{
					$data['success'] = 'false';
					$data['fail_txt'] = '*La clave de empresa es incorrecta';
					return $data; 
				}else{
					$folio= $db->row_quey('ad_detalle_cuenta', array('folio_mov'=>$dataArray['folio'] ));
					if(count($folio) > 0){
						$data['success'] = 'false';
						$data['fail_txt'] = '*Este folio ya fue registrado';
						return $data;
					}else{
						$data['success'] = 'true';
						return $data;
					}
				}
				// print_r($clave_cta)
			}
			
		}else{
			$data['success'] = 'false';
			$data['fail_txt'] = '*Este folio no es valido, verifique el formato';
			return $data;
		}
}