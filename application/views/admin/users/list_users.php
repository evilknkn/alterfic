<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="<?=base_url('/admin/dashboard')?>">Inicio</a>
        </li>
        <li>Lista de usuarios</li>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">

            <div class="block-area" id="responsiveTable">
                <h3 class="block-title">Usuarios administradores</h3>
                <?php if($this->session->flashdata('success')):?>
                <div class="text-center col-sm-12 col-xs-12">
                    <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                </div>
                <?php endif;?>

                <div class="clearfix"></div>
                <a href="<?=base_url('users/admin_users/create_user/1')?>" class="btn btn-info">Crear usuario</a>
                <br><br>

                <div class="table-responsive overflow">
                	
                    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre de usuario</th>
                                <th>Ultimó acceso</th>
                                <th>Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php foreach($list_users as $user):
                        	$acceso_fecha = formato_fecha_texto(substr($user->ultimo_acceso,0,10));
            				$acceso_time  = substr($user->ultimo_acceso,11,19);
            				$acceso = $acceso_fecha. " a las ". $acceso_time; ?>
                            <tr>
                                <td><?=$user->username?></td>
                                <td><?=$acceso?> </td>
                                <td >
                                	<a href="<?=base_url()?>" class="tooltips tile-menu" data-original-title="Haga clic aquí para ver detalle del usuario">
                                	<i class="glyphicon glyphicon-search fa-2x"></i> 
                                	</a>
                                </td>
                            </tr>
                           <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
            <script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
            <script type="text/javascript">
            jQuery(function($) {
                var oTable1 = $('#sample-table-2').dataTable( {
                "aoColumns": [
                  { "bSortable": false },
                    null, 
                  { "bSortable": false }
                ] } );
                    
            });
            </script>