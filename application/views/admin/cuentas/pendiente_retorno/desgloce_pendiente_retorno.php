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
        <li>Lista empresas pendiente de retorno </li>
        <li>Detalle de pendiente de retorno </li>
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
                            <th>Folio</th>
                            <th>Monto del depósito</th>
                            <th>Cliente</th>
                            <th>Comisión</th>
                            <th>Pagos</th>
                            <th>Pendiente retorno </th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php foreach($depositos as $deposito):
                        $comision = genera_comision($db, $deposito->id_cliente, $deposito->monto_deposito); 
                        $pagos = total_pagos($db, $id_empresa, $id_banco, $deposito->id_deposito);
                        $pendiente_retorno = $deposito->monto_deposito - ($comision + $pagos);
                        $cliente = cliente_asignado_deposito($db, $deposito->id_cliente);
                        ?>
                      <tr>
                        <td><?=formato_fecha_ddmmaaaa($deposito->fecha_deposito)?></td>
                        <td><?=$deposito->folio_depto?></td>
                        <td>$<?=convierte_moneda($deposito->monto_deposito)?></td>
                        <td><?=$cliente?></td>
                        <td>$<?=convierte_moneda($comision)?></td>
                        <td>$<?=convierte_moneda($pagos)?></td>
                        <td><?=convierte_moneda($pendiente_retorno)?></td>
                      </tr>
                      <?php endforeach;?>
                    </tbody>
                </table>
                <div class="text-center" style="margin-top:20px"> 
                  <a href="<?=base_url('cuentas/pendiente_retorno')?>" class="btn"><i class="fa fa-undo "></i> Regresar</a>
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
        null, null, null, null, null,
      { "bSortable": false }
    ] } );
        
});
</script>