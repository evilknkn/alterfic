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
        <li>Lista de gastos</li>
        <li>Detalle de gastos</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="page-header">
                    <h1>Pendiente de retorno</h1>
                </div><!-- /.page-header -->

                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Monto</th>
                            <th>Descripción salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($movimientos)!=0):?>
                        <?php foreach ($movimientos as $movimiento) {?>
                            <tr>
                                <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?> </td>
                                <td><?=$movimiento->folio_mov?></td>
                                <td>$<?=convierte_moneda($movimiento->monto_salida)?></td>
                                <td><?=$movimiento->detalle_salida?></td>
                            </tr>
                        <?php } ?>
                  
                        <?php endif;?>
                    </tbody>
                </table>
                <div class="text-center" style="margin-top:20px">
                    <a href="<?=base_url('cuentas/gastos')?>" class="btn"><i class="fa fa-undo"></i>Regresar</a>
                </div>
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
        null, null, 
      { "bSortable": false }
    ] } );
        
});
</script>