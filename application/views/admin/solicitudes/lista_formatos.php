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
        <li>Lista de formatos del cliente </li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="col-xs-12 col-sm-12" >
                    <div class="page-header">
                        <h1>Lista de formatos</h1>
                    </div><!-- /.page-header -->
                    
                    <div class="col-sm-12 col-xs-12">
                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Ver detalle</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_folios as $folio): ?>
                                    <tr>
                                        <td><?=$folio->folio_cliente?></td>
                                        
                                        <td class="text-center"><i class="icon-list bigger-160"></i> </td>
                                        
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
                <script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
                <script type="text/javascript">
                jQuery(function($) {

                    var oTable1 = $('#sample-table-2').dataTable( {
                                
                                aLengthMenu: [
                                [25, 50, 100, 200, -1],
                                [25, 50, 100, 200, "All"]
                            ],
                            iDisplayLength: 50,

                    "aoColumns": [
                      { "bSortable": true },
                      { "bSortable": false }
                    ] } );
                        
                });
                </script>
                

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
