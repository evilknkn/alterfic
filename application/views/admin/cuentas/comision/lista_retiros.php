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
        <li>Lista de salida de comisiones</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="page-header">
                    <h1>Lista de salida de comisiones</h1>
                </div><!-- /.page-header -->

                <?php if($this->session->flashdata('success')):?>
                    <div class="text-center col-sm-12 col-xs-12">
                        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                    </div>
                <?php endif;?>

                <div class="row">
                    <a href="<?=base_url('cuentas/comisiones/retiro_comision')?>" class="btn btn-info">Agregar retiro</a>
                    <br><br>
                    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Nombre Empresa</th>
                                <th>Banco</th>
                                <th>Folio</th>
                                <th>Monto</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($retiros)>0): 
                            $total_retiro = 0;?>
                            <?php foreach($retiros as $retiro):?>
                                <tr>
                                    <td><?=formato_fecha_ddmmaaaa($retiro->fecha_movimiento)?></td>
                                    <td><?=$retiro->nombre_empresa?></td>
                                    <td><?=$retiro->nombre_banco?></td>
                                    <td><?=$retiro->folio_mov?></td>
                                    <td>$<?=convierte_moneda($retiro->monto_salida)?></td>
                                    <td class="text-center">
                                        <a href="<?=base_url('comisiones/editar_retiro/'.$retiro->id_detalle)?>">
                                            <i class="fa fa-edit fa-2x"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php 
                            $total_retiro = $total_retiro +$retiro->monto_salida;
                            endforeach;?>
                            <?php else:?>
                                <tr>
                                    <td colspan="6" class="text-center">-- No hay retiros registrados --</td>
                                </tr>
                            <?php endif;?>
                            <tfoot>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                                <td class="text-right">Total</td>
                                <td class="text-left" colspan="2">$<?=convierte_moneda($total_retiro)?></td>
                            </tr>
                            </tfoot>
                        </tbody> 
                    </table>
                    <div class="text-center" style="margin-top:20px">
                        <a href="<?=base_url('cuentas/comisiones')?>" class="btn"><i class="fa fa-undo"></i> Regresar</a>
                    </div>
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