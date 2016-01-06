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

            <div class="table-responsive col-sm-6">
                <a href="<?=base_url('cuentas/comisiones/clientes_pagos')?>" class="btn btn-default" style="margin-bottom:15px;"> Lista de clientes</a> 
                
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Empresa </th>
                            <th>Banco </th>
                            <th class="text-center">Monto depósito</th>
                            <th class="text-center">Folio depósito</th>
                            <th>Lista depósitos</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($list_deopsito as $deposito): ?>
                        <tr>
                            <td><?=$deposito->nombre_empresa?></td>
                            <td><?=$deposito->nombre_banco?></td>
                            <td class="text-center"><?=convierte_moneda($deposito->monto_deposito)?></td>
                            <td><?=$deposito->folio_mov?></td>
                            <td class="text-center">
                                <a onclick="showPays(<?=$deposito->id_deposito?>)" style="cursor:pointer">
                                    <i class="icon-list bigger-160"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>                        
                    </tbody>
                </table>

                <script type="text/javascript">
                    function showPays(deposito_id){
                        
                    
                    $.ajax({
                          type:'POST',
                          dataType:'json',
                          url:"<?php echo base_url('cuentas/comisiones/pagos_deposito')?>",
                          data:'deposito_id='+deposito_id,
                          success: function(data){
                            console.log(data)
                            var html = '';
                            for(vari=0; i<data.length;i++)
                            {
                                html+= "<tr>";
                                html += "<td>"+data[i].nombre_empresa+"</td>";
                                html += "<td"+data[i].nombre_banco+"></td>";
                                html += "<td"+data[i].mongo_pago+"></td>";
                                html += "<td>"+data[i].folio_pago+"</td>";
                                html += "<td>"+data[i].fecah_pago+"</td>";                                
                                html+= "</tr>";
                            }
                            $('#detalle-pagos').show();
                            $('#movimientos-pagos-depositos').html(html);
                          }
                        })
                    }
                </script>

                 <a href="<?=base_url('cuentas/comisiones/clientes_pagos')?>" class="btn btn-default" style="margin-top:15px;"> Lista de clientes</a> 
            </div>

            <div class="table-responsive col-sm-6" id="detalle-pagos" style = "" >
                <div style="margin-bottom:15%;"></div>
                <table id="sample-table-3" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Empresa de retorno</th>
                            <th>Banco de retorno</th>
                            <th class="text-center">Monto depósito</th>
                            <th class="text-center">Folio depósito</th>
                            <th class="text-center">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="movimientos-pagos-depositos">
                   
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-center"></td>
                            <td></td>
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
    var oTable1 = $('#sample-table-2').dataTable( {
     aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: 100,
    "aoColumns": [
      { "bSortable": true },
        null, null, null,
      { "bSortable": false }
    ] } );
        
});
</script>

