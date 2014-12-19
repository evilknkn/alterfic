<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Usuarios</li>
</ol>

<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Usuarios administradores</h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>

    <div class="clearfix"></div>
    <a href="<?=base_url('users/admin_users/create_user/1')?>" class="btn m-r-5">Crear usuario</a>
    <br><br>

    <div class="table-responsive overflow">
    	
        <table class="table tile">
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