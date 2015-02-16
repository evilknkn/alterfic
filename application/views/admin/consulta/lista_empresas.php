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
        <li>Lista de empresas</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="page-header">
                    <h1>Lista de depósitos</h1>
                </div><!-- /.page-header -->

                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nombre de empresa</th>
                            <th>Banco</th>
                           <!--  <th>Total depósito</th>
                            <th>Total salida</th>
                            <th>Saldo</th> -->
                            <th class="tex-center">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($empresas as $empresa): ?>
                        <tr>
                            <td><?=$empresa->nombre_empresa?></td>
                            <td><?=$empresa->nombre_banco?></td>
                            <td class="tex-center">
                                <a href="<?=base_url('cuentas/movimientos_internos/lista/'.$empresa->id_empresa.'/'.$empresa->id_banco)?>">
                                    <i class="fa fa-search fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
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