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
        <li>Lista de depósitos</li>
        <li>Movimientos internos</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-header">
                <h1>Movimientos internos <?=$nombre_empresa?></h1>
            </div><!-- /.page-header -->

            <?php if($this->session->flashdata('success')):?>
                <div class="text-center col-sm-12 col-xs-12">
                    <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                </div>
            <?php endif;?>


            <div class="row">
                <a href="<?=base_url('cuentas/movimientos_internos/add_mov_interno/'.$id_empresa.'/'.$id_banco)?>" class="btn btn-primary">Agregar movimiento</a>
                <br><br>
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nombre de empresa</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Folio entrada</th>
                            <th>Folio salida</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($movimientos)>0):?>
                        <?php foreach($movimientos as $movimiento):?>
                           <tr>
                                <td><?=nombre_empresa($db, $movimiento->empresa_destino)?></td>
                                <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_mov)?></td>
                                <td>$<?=convierte_moneda($movimiento->monto)?></td>
                                <td><?=$movimiento->folio_entrada?></td>
                                <td><?=$movimiento->folio_salida?></td>
                                <td class="text-center">
                                    <a href="<?=base_url('cuentas/movimientos_internos/editar_movimiento/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_movimiento)?>"> 
                                        <i class="fa fa-edit fa-2x"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="<?=base_url('cuentas/mov_delete/movimiento_interno/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_movimiento)?>">
                                        <i class="fa fa-trash fa-2x"></i>
                                    </a>
                                </td>
                           </tr>
                        <?php endforeach; ?>
                        <?php else:?>
                            <tr>
                                <td colspan="7" class="text-center"> -- No hay datos disponibles -- </td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            <div class="text-center" style="margin-top:20px">
                <a class="btn btn-grey " href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco)?>"> <i class="fa fa-undo"></i> Regresar</a>
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