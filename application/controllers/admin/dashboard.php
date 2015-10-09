<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Dashboard extends CI_Controller
{	
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == ''){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
    }
	
	public function index()
	{	
		$this->load->model('cuentas/resumen_model');
		$this->load->model('cuentas/retorno_model');
		$this->load->model('cuentas/comision_model');
		$this->load->helper('funciones_externas');
		$this->load->helper('cuentas');

		if($this->session->userdata('consulta')=='active'):
			/*$depositos = $this->resumen_model->total_depositos();
			//lista de empresas
			$empresas = $this->retorno_model->lista_empresas(array('ace.tipo_usuario' => 1));
			
			$total_saldos 	= 0;
			$total_retorno 	= 0;
			$total_comision	= 0;
			$total_gastos	= 0;
			$retiro 		= 0;
			$resumen 		= 0;

			$total_depto 	= 0;
			$no_empresa 	= 0;
			$no_persona 	= 0;
			$gran_total_depto	= 0;
			$gran_total_salida	= 0;

			$gran_total_depto_persona	= 0;
			$gran_total_salida_persona	= 0;
			$saldo_persona = 0;

			foreach ($empresas as $empresa)
			{	
				if($no_empresa != $empresa->id_empresa):

					// calculo de depositos totales en el sistema //
					$depto = montos($this->resumen_model, $empresa->id_empresa, $empresa->id_banco, 'deposito');
					$depto_int = montos($this->resumen_model, $empresa->id_empresa, $empresa->id_banco, 'deposito_interno');

					$total_depto = $depto + $depto_int;

					// Suma total de salidas de las empresas//
					$salida = montos($this->resumen_model, $empresa->id_empresa, $empresa->id_banco, 'salida');
					$salida_pago = montos($this->resumen_model, $empresa->id_empresa, $empresa->id_banco, 'salida_pago');
		            $salida_mov_int = montos($this->resumen_model, $empresa->id_empresa, $empresa->id_banco, 'mov_int');
		            $salida_comision = montos($this->resumen_model, $empresa->id_empresa, $empresa->id_banco, 'salida_comision');
					
					$total_salida =  $salida + $salida_pago + $salida_mov_int + $salida_comision;
					
					// Pendientes de retorno //
					$res = genera_total_depositos($this->retorno_model, $empresa->id_empresa, $empresa->id_banco);	

					// Gastos
					$salida_gastos = gastos_cuenta($this->resumen_model, $empresa->id_empresa, $empresa->id_banco);
					$total_gastos = $total_gastos + $salida_gastos;
					
				endif;
					$gran_total_depto 	= $gran_total_depto + $total_depto;
					$gran_total_salida 	= $gran_total_salida +  $total_salida;
					$total_retorno = $total_retorno + $res['pendiente_retorno'];
			}

			$total_saldos = $gran_total_depto - $gran_total_salida;
			// Retiros
			$retiro = total_retiros($this->comision_model);

			$clientes =  $this->resumen_model->lista_clientes();
			$total_comision = 0;
			foreach($clientes as $cliente)
			{
				$total_comisiones= genera_comision_total($this->comision_model, $cliente->id_cliente, $cliente->comision);
				$total_comision = $total_comision + ($total_comisiones);
			}
			

			$resumen = $total_saldos - $total_retorno - $total_comision + $total_gastos + $retiro;

			$personas = $this->retorno_model->lista_empresas(array('ace.tipo_usuario' => 2));

			foreach ($personas as $persona)
			{	

				if($no_persona != $persona->id_empresa):
					$deposito = montos($this->resumen_model, $persona->id_empresa, $persona->id_banco, 'deposito');
					$salida_persona = montos($this->resumen_model, $persona->id_empresa, $persona->id_banco, 'salida');

				endif;

				$gran_total_depto_persona  = $gran_total_depto_persona +$deposito;
				$gran_total_salida_persona = $gran_total_salida_persona + $salida_persona;
			}

		
			$retiro = total_retiros($this->comision_model);  
	        $total_retiro  = $total_comision - $total_gastos - $retiro;

			$saldo_persona = $gran_total_depto_persona  - $gran_total_salida_persona;

			$data['saldos'] 	= convierte_moneda($total_saldos);
			$data['retorno'] 	= convierte_moneda($total_retorno);
			$data['comision'] 	= convierte_moneda($total_comision);
			$data['gastos'] 	= convierte_moneda($total_gastos);
			$data['retiros'] 	= convierte_moneda($retiro); 
			$data['resumen'] 	= convierte_moneda($resumen);
			$data['ret_com']	= convierte_moneda($retiro);
			$data['total_ret'] 	= convierte_moneda($total_retiro);

			$data['depositos'] 	= convierte_moneda($gran_total_depto_persona);
			$data['salidas'] 	= convierte_moneda($gran_total_salida_persona);
			$data['saldo_persona'] = convierte_moneda($saldo_persona);*/

			$all_data['body']	= 'admin/home';
		else:
			$all_data['body'] = 'admin/consulta/lista_empresas';
			$data['empresas'] 	= $this->retorno_model->lista_empresas(array('ace.tipo_usuario' => 1));
		endif;
			//$data['menu'] 	= 'menu/menu_admin';
			//$all_data['cosas'] = json_encode($data);
			//print_r($cuerpo);exit;
			
		$this->load->view('layer/layerout', $all_data);
	}
}