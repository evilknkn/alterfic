<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tool_master_controller extends  CI_Controller
{	public function index()
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas_helper');
		$db			= $this->depositos_model;
		$db_mov		= $this->movimiento_model;


		$empresas = $this->depositos_model->lista_empresas(array('ace.tipo_usuario' => 1));
		foreach($empresas as $empresa)
		{
			echo $empresa->nombre_empresa.'--->'.$empresa->id_empresa.' // //'.$empresa->nombre_banco.'---> '.$empresa->id_banco.'<br>';
		}

        echo '<br>
                <form method="post" >
                id_empresa <input type="text" name="empresa" value=""><br>
                banco <input type="text" name="banco" value="" ><br>
                mes <input type="text" name="month" value="03" ><br>
                año <input type="text" name="year" value="2015" ><br>
                <button type="submit">Enviar</button>
                </form>';

        $empresa    = $this->input->post('empresa'); 
        $banco      = $this->input->post('banco'); 
        $month      = $this->input->post('month'); 
        $year       = $this->input->post('year'); 
        //print_r($month);exit;
        
        if($month == '01'):
            echo $month_ant  = '12';  
        else:
            echo $month_ant  = '0'.($month-1);  
        endif;

        if(!empty($empresa)):  

    		$lista_empresas = $this->depositos_model->lista_empresas(array('ace.tipo_usuario' => 1, 'ace.id_empresa' => $empresa, 'acb.id_banco' => $banco));
           
    		echo '<br>';
    		$total_depto =0 ;
            $total_salida =0 ;
            $total_saldo = 0;
            $total_gastos = 0;
            $total_comision = 0;
            $pendiente_retorno=0;
            $saldo = 0;
            echo '<table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Total depósito</th>
                                    <th>Total salida</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>';
            //$fecha = fechas_rango_inicio(date('m'));
                         
            $fecha = fechas_rango_mes($month);
            $fecha_inicio = $year.'-'.$month.'-'.$fecha['fecha_inicio'];
            $fecha_fin = $year.'-'.$month.'-'.$fecha['fecha_fin'];

            $corte = $this->depositos_model->select_corte(array('fecha_ini'=>$fecha_inicio, 'fecha_fin' => $fecha_fin, 'id_banco'=> $this->input->post('banco'), 'id_empresa' => $this->input->post('empresa') ));
            //print_r($corte);exit(); 
            if(count($corte) == 0 ):
        		foreach($lista_empresas as $empresa)
        		{	
                    $fecha_ant = fechas_rango_mes($month_ant);
                    if($month_ant == '12'): $year =  $year - 1 ; endif;
                    $fecha_begin = $year.'-'.($month_ant).'-'.$fecha_ant['fecha_inicio'];
                    $fecha_end = $year.'-'.($month_ant).'-'.$fecha_ant['fecha_fin'];
                //print_r($fecha_end);exit;
                    
        			echo "<h1>".$empresa->nombre_empresa.'-->'.$empresa->nombre_banco."</h1>";
                    $depto = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito', $fecha_inicio, $fecha_fin );
                    $depto_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito_interno', $fecha_inicio, $fecha_fin);
                    
                    $salida = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida',$fecha_inicio, $fecha_fin);
                    $salida_pago = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_pago', $fecha_inicio, $fecha_fin);
                    $salida_mov_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'mov_int', $fecha_inicio, $fecha_fin);
                    $salida_comision = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_comision', $fecha_inicio, $fecha_fin);
                    
                    $corte_ant = $this->depositos_model->select_corte(array( 'id_banco'=> $this->input->post('banco'), 'id_empresa' => $this->input->post('empresa') ,'fecha_ini'=>$fecha_begin, 'fecha_fin' => $fecha_end,));
                    #total depositos
                    $total_depto =   $depto + $depto_int;
                    #total_salida
                    $total_salida = $salida + $salida_mov_int + $salida_pago + $salida_comision;
                    
                    
                    if (count($corte_ant) > 0):
                        $saldo = $total_depto - $total_salida + $corte_ant->total_saldo ;
                        $total_saldo = $total_saldo + $saldo ;
                        
                    else:
                        $saldo = $total_depto - $total_salida ;
                        $total_saldo = $total_saldo + $saldo;
                        
                    endif;

                    $data = array(  'id_empresa'        =>  $empresa->id_empresa, 
                                    'id_banco'          =>  $empresa->id_banco,
                                    'fecha_ini'         =>  $fecha_inicio,       
                                    'fecha_fin'         =>  $fecha_fin,          
                                    'total_depto'       =>  $total_depto,        
                                    'total_salida'      =>  $total_salida,  
                                    'total_saldo'       =>  $total_saldo,     
                                    'total_gastos'      =>  $total_gastos,       
                                    'total_comision'    =>  $total_comision,     
                                    'pendiente_retorno' =>  $pendiente_retorno);

                    $this->depositos_model->insert_corte($data);

        		}
                 echo '<tr>
                            <td>$'.convierte_moneda($total_depto).'</td>
                            <td>$'.convierte_moneda($total_salida).'</td>
            
                            <td>$'.convierte_moneda($saldo).'</td>
                          </tr>';

        		echo '</tbody></table>';
            endif;
        endif;
	}
	

}