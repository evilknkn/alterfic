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
        <li>Lista de clientes</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="col-xs-12 col-sm-12" >
                    <div class="page-header">
                        <h1>Lista de clientes</h1>
                    </div><!-- /.page-header -->

                    <?php if($this->session->flashdata('success')):?>
                    <div class="text-center col-sm-12 col-xs-12">
                        <div class="alert alert-success text-success text-center"> <?php echo $this->session->flashdata('success');?></div>
                    </div>
                    <?php endif;?>
                    
                    <div class="col-sm-12 col-xs-12">
                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre cliente</th>
                                    <th>Comisión</th>
                                    <th>Clave folio</th>
                                    <th>Ver formatos</th>
                                    <th>Agregar formato</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($lista_clientes as $cliente): ?>
                                    <tr>
                                        <td><?=$cliente->nombre_cliente?></td>
                                        
                                        <td><?=($cliente->comision * 100)?> %</td>
                                        <td><?=$cliente->clave_folio?></td>
                                        <td class="text-center"> <i class="icon-list bigger-160"></i> </td>
                                        <td class="text-center">
                                            <a href="<?=base_url()?>cuentas/formato_retorno/create/<?=$cliente->id_cliente?>"><i class="icon-file bigger-160"></i>
                                            </a>
                                        </td>
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
                        null, null, null, 
                      { "bSortable": false }
                    ] } );
                        
                });
                </script>
                

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
