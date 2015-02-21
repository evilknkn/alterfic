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
        <li>Lista general pendiente de retorno </li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-header">
                <h1>Lista de pendiente general </h1>
            </div><!-- /.page-header -->
                <div class="row">
                    <a href="<?=base_url('excel/pendiente_retorno/gral')?>" class="btn btn-success"><i class="icon-file"></i> Exportar a excel </a>
                    <br><br>
                    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>   
                                <th>Nombre empresa</th>
                                <th>Banco</th>
                                <th>Fecha de depósito</th>
                                <th>Folio</th>
                                <th>Monto depósito</th>
                                <th>Cliente</th>
                                <th>Comisión </th>
                                <th>Pagos</th>
                                <th>Pendiente retorno</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $id_empresa = 0;
                            $id_banco   = 0;

                            foreach($empresas as $empresa):
                                if($id_empresa != $empresa->id_empresa and $id_banco != $empresa->id_banco): 
                                    $depositos = depositos_pendiente_retorno_gral($db, $empresa->id_empresa, $empresa->id_banco);
                                ?>
                                <?php foreach($depositos as $deposito):

                                        $cliente = cliente_asignado_deposito($db, $deposito->id_cliente);
                                        $comision = genera_comision($db, $deposito->id_cliente, $deposito->monto_deposito); 
                                        $pagos = total_pagos($db, $empresa->id_empresa, $empresa->id_banco, $deposito->id_deposito);
                                        $pendiente_retorno = $deposito->monto_deposito - ($comision + $pagos);
                                        if($pendiente_retorno > 10):
                                        ?>
                                    <tr>
                                        <td><?=$empresa->nombre_empresa?></td>
                                        <td><?=$empresa->nombre_banco?></td>
                                        <td><?=formato_fecha_ddmmaaaa($deposito->fecha_deposito)?></td>
                                        <td><?=$deposito->folio_depto?></td>
                                        <td>$<?=convierte_moneda($deposito->monto_deposito)?></td>
                                        <td><?=$cliente?></td>
                                        <td>$<?=convierte_moneda($comision)?></td>
                                        <td>$<?=convierte_moneda($pagos)?></td>
                                        <td><?=convierte_moneda($pendiente_retorno)?></td>
                                    </tr>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center" style="margin-top:20px"> 
                    <a href="<?=base_url('cuentas/pendiente_retorno')?>" class="btn btn-grey"><i class="icon-undo"></i> Regresar</a>
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
        null, null, null, null, null, null,null,
      { "bSortable": true }
    ] } );
        
});
</script>