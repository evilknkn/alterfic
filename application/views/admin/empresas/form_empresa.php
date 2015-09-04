<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de empresas</li>
   	<li>Nueva empresa</li>
</ol>
<div class="col-sm-12 col-xs-12">
	<p>Aquí puede registrar nuevas empresas ingresando el nombre en el campo "nombre de empresa" y haciendo clic en "guarda". </p>
</div>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>

<div class="row">
	<div class="col-sm-8 col-xs-8">
		<?=form_open('',array('class' => 'form-horizontal'))?>

		<div class="form-group">
			<label class="control-label col-sm-4 col-xs-4"> Tipo de cuenta</label>
			<div class="control-sm-8 col-xs-8">
				<div class="col-xs-5 col-sm-5">
					<select class="form-control" name="tipo_cuenta" id="tipo_cuenta">
						<option value="">Seleccione un tipo</option>
						<option value="1">Empresa</option>
						<option value="2">Persona</option>
					</select>
				</div>
				<div class="col-xs-12 col-sm-12">&nbsp;</div>
				<div class="col-xs-12 col-sm-12"><?=form_error('tipo_cuenta')?></div>
			</div>
		</div>
	
		<div class="form-group" id="clave_cta" style="display:none">
			<label class="control-label col-sm-4 col-xs-4"> Clave de folio</label>
			<div class="control-sm-8 col-xs-8">
				<div class="col-xs-5 col-sm-5">
					<input type="text" class="form-control" name="clave_folio">
				</div>
				<div class="col-xs-12 col-sm-12">&nbsp;</div>
				<div class="col-xs-12 col-sm-12"><?=form_error('clave_cta')?></div>
			</div>
		</div>

		<div class="form-group">
			<label class=" control-label col-sm-4 col-xs-4">Nombre de empresa </label>
			<div class="col-xs-8 col-sm-8">
				<div >
					<input type="text" name="nombre_empresa" class="form-control" >
				</div>
				<div class="col-sm-12 col-xs-12">&nbsp;</div>
				<div class="col-xs-12  col-sm-12"><?=form_error('nombre_empresa')?></div>
			</div>
			
		</div>

		<div class="form-group">
			<label class=" control-label col-sm-4 col-xs-4">Banco de depósito </label>
			<div class="col-xs-8 col-sm-8">
				<div class=" col-sm-12 col-xs-12">
					<select name="id_banco" class="form-control">
						<option value="">Seleccione un banco</option>
						<?php foreach($bancos as $banco):?>
							<option value="<?=$banco->id_banco?>"><?=$banco->nombre_banco?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class=" col-sm-12 col-xs-12">&nbsp;</div>
				<div class=" col-sm-12 col-xs-12"><?=form_error('id_banco')?></div>
			</div>
			
		</div>

		<div class="form-group">
	        <label class="control-label col-sm-4 col-xs-4"> No de cuenta</label>
	        <div class="col-sm-4 col-xs-4">
	            <input type="text" name="no_cuenta"  class="form-control"  value="">
	        </div>
	    </div>

		<div class="form-group">
	        <label class="control-label col-sm-4 col-xs-4"> Clabe bancaria</label>
	        <div class="col-sm-4 col-xs-4">
	            <input type="text" name="clabe"  class="form-control"  value="">
	        </div>
	    </div>

		<div class="text-center">
			<button class="btn "><i class=" fa fa-plus"></i> Agregar </button>
			<a href="<?=base_url('catalogos/corps')?>"></a>
		</div>
		<?=form_close();?>
	</div>
</div>
	<script type="text/javascript">
	$("#tipo_cuenta").change(function()
	{
		var tipo_cuenta = $("#tipo_cuenta").val();

		if(tipo_cuenta == 2)
		{
			$("#clave_cta").show();
		}else{
			$("#clave_cta").hide();
		}
	});
</script>
