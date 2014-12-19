<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li><a href="<?=base_url('users/admin_users/list_admin/1')?>">Usuarios</a></li>
   	<li>Crear usuario</li>
</ol>
<div class="block-area" id="horizontal">
	<h3 class="block-title">Datos de ususario</h3>
	<?=form_open('',array('class'	=> 'form-horizontal'))?>
		<div class="form-group">
			<label class="control-label col-sm-4 col-xs-4 no-padding-rigth">Nombre de usuario</label>
			<div class="col-xs-8 col-sm-8">
				<div class="ol-sm-12 col-xs-12">
					<input type="text" class="form-control" value="<?=set_value('username')?>" name="username">
				</div>
				<div class="col-sm-12 col-xs-12"> &nbsp;</div>
				<div class="col-xs-6 col-sm-6"><?=form_error('username')?></div>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-4 col-xs-4 no-padding-rigth">Contraseña</label>
			<div class="col-xs-8 col-sm-8">
				<div class="col-sm-6 col-xs-6">
					<input type="text" class="form-control" value="<?=set_value('password')?>" name="password" id="password">
				</div>
				<div class="col-sm-6 col-xs-6">
					<a id="clave_ramdom" class="btn m-r-5"> <i class="fa fa-lock"></i> Generar contraseña </a>
			</div>

			<div class="col-sm-12 col-xs-12"> &nbsp;</div>
			<div class="col-xs-6 col-sm-6"><?=form_error('password')?></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-4 col-xs-4"> Activar privilegios </label>
			<div class="col-sm-8 col-xs-8"> 
				<div class="col-sm-5 col-xs-5">
					<select name="privilegios" class="form-control input-lg m-b-10">
						<option value="">Seleccione una opción</option>
						<option value="0" <?=$select=(set_value('privilegios') == 0)?'selected=selected':'';?>>No</option>
						<option value="1" <?=$select=(set_value('privilegios') == 1)?'selected=selected':'';?>>Si</option>
					</select>
				</div>
				<div class="col-sm-12 col-xs-12"> &nbsp;</div>
				<div class="col-xs-6 col-sm-6"><?=form_error('password')?></div>																																																																																																																																																																																																																																																			<div class="col-xs-6 col-sm-6"><?=form_error('password')?></div>
            </div>
		</div>

		<div class="text-center">
			<button class="btn m-r-5"> <i class="glyphicon glyphicon-ok"></i> Registrar</button>
		</div>
	<?=form_close()?>
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
           	}
    });//fin accion ajax
});
</script>