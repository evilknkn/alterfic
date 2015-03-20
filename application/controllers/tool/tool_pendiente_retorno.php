<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tool_pendiente_retorno extends  CI_Controller
{
	public function index()
	{
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');
		$this->load->model('users/clientes_model');
		$this->load->helper('cuentas_helper');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');

		$db = $this->retorno_model;
		$db_mov = $this->movimiento_model;

		$lista_empresas = $this->retorno_model->empresas_general();

		

		foreach($lista_empresas as $empresa)
		{
			echo '<h1>'.$empresa->id_empresa.' '.$empresa->nombre_empresa.' '. $empresa->id_banco.' '.$empresa->nombre_banco.' </h1>';

			$id_empresa = 0;
            $id_banco   = 0;

            $depositos = depositos_pendiente_retorno_gral($db, $empresa->id_empresa, $empresa->id_banco);
            //print_r($depositos);exit;
            foreach($depositos as $deposito)
            {
            	echo $deposito->folio_mov.' '.$deposito->id_movimiento.' '.$deposito->fecha_movimiento.' '.$deposito->monto_deposito.' '.$deposito->id_cliente."<br>";
            	$array_insert = array(	'id_empresa' 		=> $empresa->id_empresa, 
            							'id_banco' 			=> $empresa->id_banco, 
            							'id_deposito' 		=> $deposito->id_movimiento,
            							'folio_deposito'	=> $deposito->folio_mov,
            							'fecha_movimiento'	=> $deposito->fecha_movimiento,
            							'monto_deposito'	=> $deposito->monto_deposito,
            							'id_cliente'		=> $deposito->id_cliente,
            							'total_pagos' 		=> 0,
            							'pendiente_retornar'=> 0);
            	$this->retorno_model->insert_deposito($array_insert);
            }#fin depositos
            echo "<hr>";
		}#fin lista_empresas
	}

	public function depositos_pagos()
	{
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');
		$this->load->model('users/clientes_model');
		$this->load->helper('cuentas_helper');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');

		$db = $this->retorno_model;
		$db_mov = $this->movimiento_model;

		$lista_empresas = $this->retorno_model->empresas_general();

		foreach($lista_empresas as $empresa)
		{
			echo '<h1>'.$empresa->id_empresa.' '.$empresa->nombre_empresa.' '. $empresa->id_banco.' '.$empresa->nombre_banco.' </h1>';

			$pendientes = $this->retorno_model->select_pendiente_retorno(array('id_empresa' => $empresa->id_empresa, 'id_banco' => $empresa->id_banco));

			foreach($pendientes as $pendiente)
			{
				echo ' <h5>info de depto </h5>'.$pendiente->folio_deposito.' '.$pendiente->id_deposito.' '.$pendiente->fecha_movimiento.' '.$pendiente->monto_deposito.' '.$pendiente->id_cliente;

				$pago = total_pagos($db, $empresa->id_empresa, $empresa->id_banco, $pendiente->id_deposito);
				
				$comision = genera_comision($db, $pendiente->id_cliente, $pendiente->monto_deposito); 
				//print_r($comision);exit;
				$pendiente_return = ($pendiente->monto_deposito - ($comision + $pago) );
				//print_r($pago);exit;
				echo "<h4>total Pagos</h4>";
				echo " total_pagos:" . $pago."<br>";
				echo " comision: ".$comision."<br>";
				echo " pendiente_retornar:".$pendiente_return;
				echo "<br>";

				$update_data  	= array('total_pagos' => $pago, 'comision' => $comision,'pendiente_retornar' => $pendiente_return);
				$where_data 	= array('id_empresa' => $empresa->id_empresa, 'id_banco'=>$empresa->id_banco, 'folio_deposito' => $pendiente->folio_deposito, 'id_deposito' => $pendiente->id_deposito);
				$this->retorno_model->update_pendiente_retorno( $update_data, $where_data );

			}#fin pendiente
			echo "<hr>";
		}#fin lista_empresas

	}
}