<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Apartados extends CI_Controller
{
	public function detalle_pagos($id_cliente = null)
	{
		$this->load->model('users/clientes_model');	
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');
		$this->load->helper('utilerias');

		$db = $this->comision_model;
		$array_pagos = array();
		$lista_pagos=$db->lista_pagos_deposito($id_cliente);
		print_r($lista_pagos);
		foreach($lista_pagos as $pago)
		{
			$array_pagos[] = array(	'monto_pago' 		=> '$'.number_format($pago->monto_pago, 2),
									'empresa_retorno' 	=> $pago->empresa_retorno,
									'banco_retorno' 	=> $pago->banco_retorno,
									'fecha_pago' 		=> formato_fecha_ddmmaaaa($pago->fecha_pago),
									'folio_pago' 		=> $pago->folio_pago,
									'nombre_banco' 		=> $pago->nombre_banco,
									'nombre_empresa' 	=> $pago->nombre_empresa );
		}
		
		$response['pagos'] = $array_pagos; 
		return $this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}