<!-- barra direccion-->
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="<?=base_url('/admin/dashboard')?>">Inicio</a>
        </li>
        <li>Comisiones</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-header">
                <h1>Lista de clientes</h1>
            </div><!-- /.page-header -->

            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
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

                    $total_comisiones= genera_comision_total($db_com, $cliente->id_cliente, $cliente->comision, $cliente->tipo_cliente );
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
            <br>
            <a href="<?=base_url('cuentas/comisiones/salida_comision')?>" class="btn btn-info">Ver lista de retiros</a>
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
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(function($) {
    var oTable1 = $('#sample-table-2').dataTable( {
    "aoColumns": [
      { "bSortable": true },
        null, 
      { "bSortable": false }
    ] } );
        
});
</script>