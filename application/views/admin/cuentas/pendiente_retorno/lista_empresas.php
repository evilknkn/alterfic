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
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="page-header">
                    <h1>Pendiente de retorno</h1>
                </div><!-- /.page-header -->
            </div>
            <?php if($this->session->flashdata('success')):?>
            <div class="text-center col-sm-12 col-xs-12">
                <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
            </div>
            <?php endif;?>
            <div class="row" style="margin-bottom:15px;">
                <a href="<?=base_url('cuentas/pendiente_retorno/pendiente_retorno_general')?>" class="btn btn-primary">Pendiente de retorno general</a>
            </div>

            <div class="row">
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>   
                            <th>Nombre empresa</th>
                            <th>Banco</th>
                            <th>Total depósito</th>
                            <th>Pendiente a retornar</th>
                            <th class="text-center">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($empresas as $empresa):
                        $res = genera_total_depositos($db, $empresa->id_empresa, $empresa->id_banco);
                        
                        ?>
                        <tr>
                            <td><?=$empresa->nombre_empresa?></td>
                            <td><?=$empresa->nombre_banco?></td>
                            <td>$<?=convierte_moneda($res['depositos'])?></td>
                            <td>$<?=convierte_moneda($res['pendiente_retorno'])?></td>
                            <td class="text-center">
                                <a href="<?=base_url('cuentas/pendiente_retorno/detalle_retorno/'.$empresa->id_empresa.'/'.$empresa->id_banco)?>">
                                    <i class="fa fa-search fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
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
        null, null, null, 
      { "bSortable": false }
    ] } );
        
});
</script>
