<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de depósitos</li>
</ol>
<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Lista de depósitos</h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>

    <div class="table-responsive overflow">
    	
        <table class="table tile">
            <thead>
                <tr>
                    <th>Nombre de empresa</th>
                    <th>Banco</th>
                    <th>Total depósito</th>
                    <th>Total salida</th>
                    <th>Saldo</th>
                    <th class="tex-center">Detalle</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
				$total_depto =0 ;
				$total_salida =0 ;
                $total_saldo = 0;
				foreach($empresas as $empresa): 
                $depto = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito');
				$depto_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito_interno');
				
                $salida = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida');
                $salida_pago = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_pago');
                $salida_mov_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'mov_int');
                $salida_comision = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_comision');
                
				$total_depto =   $depto + $depto_int;
                $total_salida = $salida + $salida_mov_int + $salida_pago + $salida_comision;

                $saldo = $total_depto - $total_salida; 
                $total_saldo = $total_saldo + $saldo; ?>
            	<tr>
            		<td><?=$empresa->nombre_empresa?></td>
            		<td><?=$empresa->nombre_banco?></td>
            		<td>$<?=convierte_moneda($total_depto)?></td>
                    <td>$<?=convierte_moneda($total_salida)?></td>

                    <td>$<?=convierte_moneda($saldo)?></td>
            		<td class="tex-center">
            			<a href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$empresa->id_empresa.'/'.$empresa->id_banco)?>">
            				<i class="fa fa-search fa-lg"></i>
            			</a>
            		</td>
            	</tr>
            	<?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>