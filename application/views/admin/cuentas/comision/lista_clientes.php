<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Comisiones</li>
</ol>
<h4 class="page-title">Lista de clientes </h4>

<div class="block-area" id="responsiveTable">
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>

    <div class="table-responsive overflow">
    	
        <table class="table tile">
            <thead>
                <tr>
                    <th>Nombre Cliente</th>
                    <th>Total comisión</th>
                    <th class="text-center">Detalle</th>
                </tr>
            </thead>
            <tbody>
            	<?php $total_salida = 0 ;
                foreach($clientes as $cliente): 
                $total_comisiones= genera_comision_total($db_com, $cliente->id_cliente, $cliente->comision);
                $total_salida = $total_salida + $total_comisiones;
                ?>
                <tr>
                    <td><?=$cliente->nombre_cliente?></td>
                    <td>$<?=convierte_moneda($total_comisiones);?></td>
                    <td class="text-center">
                        <a href="<?=base_url('cuentas/comisiones/detalle_comision/'.$cliente->id_cliente)?>">
                            <i class="fa fa-search fa-lg"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
            <!--<tfoot> 
                <td class="text-right">Total</td>
                <td>$<?=convierte_moneda($total_salida);?></td>
            </tfoot>-->
        </table>

        <a href="<?=base_url('cuentas/comisiones/salida_comision')?>" class="btn">Ver lista de retiros</a>

        <br><br>
        <table class="table tile col-sm-5 col-xs-5">
            <?php   $retiro = total_retiros($db_com); 
                    $total_retiro  = $total_salida - $gastos - $retiro; ?>
            <tr>
                <th>Total comisiones</th>
                <td style="margin-left:15px">$<?=convierte_moneda($total_salida);?></td>
            </tr>
            <tr>
                <th>Total retiros</th>
                <td style="margin-left:15px">$<?=convierte_moneda($retiro)?></td>
            </tr>
            <tr>
                <th>Total gastos</th>
                <td style="margin-left:15px">$<?=convierte_moneda($gastos)?></td>
            </tr>
            <tr>
                <th>Total comisión</th>
                <td style="margin-left:15px">$<?=convierte_moneda($total_retiro);?></td>
            </tr>
        </table>
    </div>
</div>


