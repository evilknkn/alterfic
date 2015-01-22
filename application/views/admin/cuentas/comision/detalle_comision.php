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
        <li>Detalle de comision</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-header">
                <h1>Detalle de pendiente de retorno</h1>
            </div><!-- /.page-header -->

            <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Fecha depósito</th>
                        <th>Monto del depósito</th>
                        <th>Comisión</th>
                        <th>Folio</th>
                        <th>Empresa</th>
                        <th>Banco</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($depositos as $deposito): 
                        $comision = (($deposito->monto_deposito / 1.16 ) * $cliente->comision)   ?>
                    <tr>
                        <td><?=formato_fecha_ddmmaaaa($deposito->fecha_deposito)?></td>
                        <td>$<?=convierte_moneda($deposito->monto_deposito)?></td>
                        <td>$<?=convierte_moneda($comision)?></td>
                        <td><?=($deposito->folio_depto)?></td>
                        <td><?=$deposito->nombre_empresa?></td>
                        <td><?=$deposito->nombre_banco?></td>
                        
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>

            <div class="text-center" style="margin-top:20px">
                <a href="<?=base_url('cuentas/comisiones')?>" class="btn "> <i class="fa fa-undo"></i> Regresar</a>
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
        null, null, null, null, 
      { "bSortable": false }
    ] } );
        
});
</script>