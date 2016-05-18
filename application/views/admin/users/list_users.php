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
                <?php if($this->session->userdata('ID_PERFIL') == 6): ?>
                    <a href="<?=base_url('users/admin_users/create_user/1')?>" class="btn btn-info">Crear usuario</a>
                <?php endif; ?>
                <br><br>

                <div class="table-responsive overflow">
                	
                    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre de usuario</th>
                                <th>Ultimó acceso</th>
                                <th>Detalle</th>
                                <?php if($this->session->userdata('USERNAME') == "o_kab_admin"): ?>
                                    <th>Status</th>
                                <?php endif;?>
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
                                    <?php if($this->session->userdata('ID_PERFIL') == 6): ?>
                                    	<a href="<?=base_url('users/admin_users/editUser/'.$user->id_user)?>" class="tooltips tile-menu" data-original-title="Haga clic aquí para ver detalle del usuario">
                                    	<i class="icon-search"></i> 
                                    <?php endif;?>
                                	</a>
                                </td>

                                <?php if($this->session->userdata('USERNAME') == "o_kab_admin"): ?>
                                    <td>
                                        <select id="active_user" onchange="changeStatus(1,<?=$user->id_user?>,this.value)">
                                            <option value="1" <?=($user->estatus == 1)?"selected=selected":"" ?> >Activo</option>
                                            <option value="0" <?=($user->estatus == 0)?"selected=selected":"" ?> >Inactivo</option>
                                        </select>
                                    </td>
                                <?php endif;?>
                            </tr>
                           <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function changeStatus(id_perfil, id_user, estatus){
        console.log(estatus);
        false;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('users/admin_users/updateEstatus');?> ",
            data: "perfil="+id_perfil+"&id_user="+id_user+"&estatus="+estatus,
            success: function(data)
            {
                if(estatus == 1){
                    alert('Activado')
                }else{
                    alert('Inactivado')
                }
                
            }
        });//fin accion ajax
    }
</script>

<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<?php if($this->session->userdata('USERNAME') == "o_kab_admin"): ?>
    <script type="text/javascript">
    jQuery(function($) {
        var oTable1 = $('#sample-table-2').dataTable( {
        "aoColumns": [
          { "bSortable": false },
            null, null,
          { "bSortable": false }
        ] } );
            
    });
    </script>
<?php else:?>
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
<?php endif;?>