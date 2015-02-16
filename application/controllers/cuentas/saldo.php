<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Saldo extends CI_Controller 
{
	public function saldoMes()
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');

		
		
		if($this->input->post('mes_consulta')):
			$fecha = fechas_rango_mes($this->input->post('mes_consulta'));
			$inicia = $this->input->post('ano_consulta').'-'.$this->input->post('mes_consulta').'-'.$fecha['fecha_inicio'] ;
			$finaliza = $this->input->post('ano_consulta').'-'.$this->input->post('mes_consulta').'-'.$fecha['fecha_fin'] ;
		else:
			$fecha = fechas_rango_inicio(date('m'));
		endif;
		$db_mov = $this->movimiento_model;

		$fecha_ini = ($this->input->post('mes_consulta')) ? $inicia : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('mes_consulta')) ? $finaliza : $fecha['fecha_fin'] ;

		$filtro = array('adc.id_empresa' => $this->input->post('id_empresa'), 'adc.id_banco' => $this->input->post('id_banco'));

		$movimientos = $this->movimiento_model->lista_movimientos($filtro, $fecha_ini, $fecha_fin );

		$total_depto    = 0 ;
        $total_sal      = 0 ;	
		$comisio_cliente=0;
        $catidad_retornar=0;
        $pendiente=0;
        $pagos=0;
        foreach ($movimientos as $movimiento):
        	$type_mov = $movimiento->tipo_movimiento;
        	if($type_mov == 'deposito')
            {
	        	$deposito = lista_depositos($db_mov, $movimiento->folio_mov );
	        	$cantidad_deposito = $deposito->monto_deposito; 
	            $cliente_asig = cliente_asignado($db_mov, $deposito->id_deposito);
	            $total_depto = $total_depto + $deposito->monto_deposito;

	            $comisio_cliente = genera_comision($this->clientes_model, $cliente_asig, $deposito->monto_deposito);
	            $catidad_retornar = ($cantidad_deposito) - ($comisio_cliente) ;
	            $pagos = total_pagos($db_mov, $this->input->post('id_empresa'), $this->input->post('id_banco'), $deposito->id_deposito);
	            $pendiente=$catidad_retornar - $pagos;
	        }else if( $type_mov == 'deposito_interno' ) {
	        	$deposito = lista_depositos($db_mov, $movimiento->folio_mov ); 
                        //print_r($movimiento->folio_mov);exit;
				$cantidad_deposito = $deposito->monto_deposito;
				$total_depto = $total_depto + $cantidad_deposito;

	        }else
            {
                $salida = lista_salidas($db_mov, $movimiento->folio_mov);
				$total_sal = $total_sal + $salida->monto_salida;
			}

        endforeach;
        $total_saldo_mes = $total_depto - $total_sal;

        $data['total_deposito'] = convierte_moneda($total_depto);
        $data['total_salida']	= convierte_moneda($total_sal);
        $data['total_saldo']	= convierte_moneda($total_saldo_mes);
		$data['empresa'] = $this->depositos_model->empresa(array('ace.id_empresa' => $this->input->post('id_empresa'), 'acb.id_banco' => $this->input->post('id_banco')));
		

		echo json_encode($data);
	}
}