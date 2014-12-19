<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de gastos</li>
</ol>
<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Lista de gastos</h3>
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
                    <th>Total salida</th>
                    <th class="tex-center">Detalle</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
				$total_salida =0 ;
				foreach($empresas as $empresa): 
                $salida = gastos_cuenta($db_mov, $empresa->id_empresa, $empresa->id_banco);
                ?>
            	<tr>
            		<td><?=$empresa->nombre_empresa?></td>
            		<td><?=$empresa->nombre_banco?></td>
                    <td>$<?=convierte_moneda($salida);?></td>

            		<td class="tex-center">
            			<a href="<?=base_url('cuentas/gastos/detalle_salida/'.$empresa->id_empresa.'/'.$empresa->id_banco)?>">
            				<i class="fa fa-search fa-lg"></i>
            			</a>
            		</td>
            	</tr>
            	<?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>