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
                                    <th>Cliente</th>
                                    <th>Email</th>
                                    <th>Comisión</th>
                                    <th>Tipo cliente</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($clientes as $cliente): ?>
                                    <tr>
                                        <td><?=$cliente->nombre_cliente?></td>
                                        <td><?=$cliente->email?></td>
                                        <td><?=($cliente->comision * 100)?> %</td>
                                        <td><?=$cliente->tipo_cliente?> </td>
                                        <td class="tex-center">
                                            <?php if($this->session->userdata('ID_PERFIL') == 6): ?>
                                                <a href="<?=base_url('users/clientes/editar_cliente/'.$cliente->id_cliente)?>">
                                                    <i class="fa fa-edit fa-2x"></i>
                                                </a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if($this->session->userdata('ID_PERFIL') == 6): ?>
                    <div class="block-area cols-sm-8 col-xs-8" >
                        <div class="page-header">
                            <h1>Agregar Cliente</h1>
                        </div><!-- /.page-header -->
                       
                        <div class="clearfix"></div>
                        
                        <?=form_open('', array('class' => 'form-horizontal'))?> 
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-xs-4 no-padding-rigth"> Cliente</label>
                            <div class="col-sm-4 col-xs-4">
                                <input type="text" name="nombre_cliente" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 col-xs-4"> Email</label>
                            <div class="col-sm-4 col-xs-4">
                                <input type="email" name="email"  class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 col-xs-4"> Tipo de cliente</label>
                            <div class="col-sm-3 col-sm-3">
                                <select class="form-control" name="tipo_cliente" id="tipo_cliente" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="A">Tipo A</option>
                                    <option value="B">Tipo B</option>
                                </select> 
                            </div>
                        </div>

                        <div class="form-group" id="campo_comision">
                            <label class="control-label col-sm-4 col-xs-4"> Comisión</label>
                            <div class="col-sm-3 col-xs-3">
                                <input type="text" name="comision" id='comision' class="form-control" required>
                            </div>
                        </div>

                        <div class="clearfix text-center">
                            <button class="btn btn-primary"><i class="fa fa-save "></i> Guardar </button>
                        </div>
                        <?=form_close()?>
                    </div>
                <?php endif;?>

                <script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
                <script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
                <script type="text/javascript">
                jQuery(function($) {
                    var oTable1 = $('#sample-table-2').dataTable( {
                    "aoColumns": [
                      { "bSortable": false },
                        null, null, null,
                      { "bSortable": false }
                    ] } );
                        
                });
                </script>
                <script type="text/javascript">
    $('#tipo_cliente').change(function (){
        var tipo = $('#tipo_cliente').val();

        if(tipo == 'B'  || tipo == 'A' )
        {
            $('#campo_comision').show();
        }else{
            $('#campo_comision').hide();
            $('#comision').removeAttr("required");
        }
    });
</script>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
