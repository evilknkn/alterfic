<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
	   	<li><a href="<?=base_url('users/admin_users/list_admin/1')?>">Usuarios</a></li>
	   	<li>Crear usuario</li>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        		<?php if($this->session->flashdata('success')):?>
                <div class="text-center col-sm-12 col-xs-12">
                    <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                </div>
                <?php endif;?>

				<h3 class="block-title">Datos de ususario</h3>
				<?=form_open('',array('class'	=> 'form-horizontal'))?>
					<div class="form-group">
						<label class="control-label col-sm-4 col-xs-4 no-padding-rigth">Nombre de usuario</label>
						<div class="col-xs-8 col-sm-8">
							<div class="ol-sm-12 col-xs-12">
								<input type="hidden" value="general_data" name="type_change">
								<input type="text" class="form-control" value="<?=$getUser->username?>" name="username">
							</div>
							<div class="col-sm-12 col-xs-12"> &nbsp;</div>
							<div class="col-xs-6 col-sm-6"><?=form_error('username')?></div>
						</div>
					</div>

					
					<div class="form-group">
						<label class="control-label col-sm-4 col-xs-4"> Tipo admin </label>
						<div class="col-sm-8 col-xs-8"> 
							<div class="col-sm-8 col-xs-8">
								<select name="privilegios" class="form-control input-lg m-b-10" required>
									<option value="">Seleccione una opción</option>
									<?php foreach ($list_admin as $key):?>
										<option value="<?=$key->id_perfil?>" <?=($getUser->id_perfil == $key->id_perfil )?'selected=selected':'';?>><?=$key->nombre_perfil?></option>
									<?endforeach;?>
								</select>
							</div>
							<div class="col-sm-12 col-xs-12"> &nbsp;</div>
							<div class="col-xs-6 col-sm-6"><?=form_error('privilegios')?></div>																																																																																																																																																																																																																																																			<div class="col-xs-6 col-sm-6"><?=form_error('password')?></div>
			            </div>
					</div>

					<div class="text-center">
						<button class="btn btn-info"> <i class="icon-ok"></i> Guardar</button>
					</div>
				<?=form_close()?>

				<h3 class="block-title">Cambiar contraseña</h3>

				<?=form_open('',array('class'	=> 'form-horizontal'))?>
					<div class="form-group">
						<label class="control-label col-sm-4 col-xs-4 no-padding-rigth">Contraseña</label>
						<div class="col-xs-8 col-sm-8">
							<div class="col-sm-6 col-xs-6">
								<input type="hidden" value="password" name="type_change">
								<input type="password" class="form-control" value="<?=set_value('password')?>" name="password" id="password">

								<label id="generate-Key"></label>
							</div>
							<div class="col-sm-6 col-xs-6">
								<a id="clave_ramdom" class="btn m-r-5"> <i class="fa fa-lock"></i> Generar contraseña </a>
							</div>
						</div>

						<div class="col-sm-12 col-xs-12"> &nbsp;</div>
						<div class="col-xs-6 col-sm-6"><?=form_error('password')?></div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-4 col-xs-4 no-padding-rigth">Confirmar contraseña</label>
						<div class="col-xs-8 col-sm-8">
							<div class="col-sm-6 col-xs-6">
								<input type="password" class="form-control" value="<?=set_value('password')?>" name="confirm_password" id="confirm_password">
								
							</div>
							
						</div>

						<div class="col-sm-12 col-xs-12"> &nbsp;</div>
						<div class="col-xs-6 col-sm-6"><?=form_error('password')?></div>
					</div>

					<div class="text-center">
						<button class="btn btn-info"> <i class="icon-ok"></i> Guardar</button>
					</div>
				<?=form_close()?>
		</div>
	</div>
</div>

<script src="<?=base_url('assets')?>/js/toggler.min.js"></script> <!-- Toggler -->
<script type="text/javascript">
$("#clave_ramdom").click(function(){
	$.ajax({
           	type: "POST",
           	url: "<?php echo base_url('users/admin_users/password_ramdom');?> ",
           	data: "activo=1",
           	success: function(data)
           	{
           		
           		$('#password').val(data);
           		$('#generate-Key').html('<b>'+data+'</b><br> Copiar y pegar para confirmar contraseña.');
           	}
    });//fin accion ajax
});
</script>