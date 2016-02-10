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

            <div>

            </div>

            <div class="table-responsive col-sm-12" id="detalle-pagos"  ng-controller="detallePagosCtrl" ng-init="retornaPagos('<?=base_url()?>',<?=$id_cliente?>)"  >
                <a href="<?=base_url()?>excel/pagos_clientes/export_paids_client/<?=$id_cliente?>" class="btn btn-success" style ="margin-bottom:20px;">Exportar a excel</a>
                <a href="<?=base_url()?>cuentas/comisiones/clientes_pagos" class="btn"  style ="margin-bottom:20px;"> Regresar</a>
                <table id="" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Empresa de retorno</th>
                            <th>Banco de retorno</th>
                            <th class="text-center">Monto depósito</th>
                            <th class="text-center">Folio depósito</th>
                            <th class="text-center">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="movimientos-pagos-depositos" ng-repeat="paid in list_paids">
                   
                        <tr>
                            <td>{{ paid.nombre_empresa }}</td>
                            <td>{{ paid.nombre_banco }}</td>
                            <td class="text-center"> {{ paid.monto_pago }}</td>
                            <td>{{ paid.folio_pago }}</td>
                            <td>{{ paid.fecha_pago }}</td>
                        </tr>
                   
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
    var oTable1 = $('#sample-table-3').dataTable( {
     aLengthMenu: [
        [10, 50, 100, 200, -1],
        [10, 50, 100, 200, "All"]
    ],
    iDisplayLength: 10,
    "aoColumns": [
      { "bSortable": true },
        null, null, null,
      { "bSortable": false }
    ] } );
        
});
</script>

