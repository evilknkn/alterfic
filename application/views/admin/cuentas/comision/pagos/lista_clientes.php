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
                    foreach($list_clientes as $cliente): 

                    $total_comisiones= genera_comision_total($db_com, $cliente->id_cliente, $cliente->comision, $cliente->tipo_cliente );
                    $total_salida = $total_salida + $total_comisiones;
                    ?>
                    <tr>
                        <td><?=$cliente->nombre_cliente?></td>
                        <td>$<?php echo convierte_moneda($total_comisiones);?></td>
                        <td class="text-center">
                            <a href="<?=base_url('cuentas/comisiones/detalle_pagos/'.$cliente->id_cliente)?>">
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
           
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(function($) {
    var oTable1 = $('#sample-table-2').dataTable( {
     aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: 100,
    "aoColumns": [
      { "bSortable": true },
        null, 
      { "bSortable": false }
    ] } );
        
});
</script>

