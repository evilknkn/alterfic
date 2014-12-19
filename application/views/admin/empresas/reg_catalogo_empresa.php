<div class="col-sm-12 col-xs-12">
	<?=form_open('',array('class' => 'form-horizontal'))?>
	<div>
		<label class=" control-label col-sm-4 col-xs-4">Tipo de cuenta</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4"> 
				<select class="form-control" name="tipo_cuenta" id="tipo_cuenta" required>
					<option value="">Seleccione un tipo de cuenta</option> 
					<option value="1" <?=(set_value('tipo_cuenta') == 1)?"selected=selected":"";?>>Empresa</option>
					<option value="2"  <?=(set_value('tipo_cuenta') == 2)?"selected=selected":"";?>>Persona</option>
				</select>
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-xs-5 col-sm-5"><?=form_error('tipo_cuenta')?></div>
		</div>
	</div>


	<div class="form-group" id="clave_cta" style="display:none">
		<label class=" control-label col-sm-4 col-xs-4">Clave de cuenta para folio</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4"> 
				<input type="text" class="form-control" name="clave_cuenta" >
			</div>
			
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-xs-5  col-sm-5"><?=form_error('clave_cuenta')?></div>
		</div>
	</div>
	
	<div class="form-group">
		<label class=" control-label col-sm-4 col-xs-4">Nombre de empresa </label>
		<div class="col-xs-8 col-sm-8">
			<div class="col-sm-4 col-xs-4">
				<input type="text" name="nombre_empresa" class="form-control" required value="<?=set_value('nombre_empresa')?>">
			</div>		
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-xs-5  col-sm-5"><?=form_error('nombre_empresa')?></div>
		</div>
	</div>

	<div class="form-group">
		<label class=" control-label col-sm-4 col-xs-4">Banco de depósito </label>
		<div class="col-xs-8 col-sm-8">
			<div class="col-sm-4 col-xs-4">
				<select name="id_banco" class="form-control" required>
					<option value="">Seleccione un banco</option>
					<?php foreach($bancos as $banco):?>
						<option value="<?=$banco->id_banco?>" <?=(set_value('tipo_cuenta') == $banco->id_banco)?"selected=selected":"";?> ><?=$banco->nombre_banco?></option>
					<?php endforeach;?>
				</select>
				
			</div>
		</div>
		<div class="col-sm-12 col-xs-12">&nbsp;</div>
		<div class="col-xs-12  col-sm-12"><?=form_error('nombre_empresa')?></div>
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
		<a href="<?=base_url('catalogos/corps')?>" class="btn" style="margin-left:10px"><i class="fa fa-undo"></i> Regresar</a>
	</div>
	<?=form_close();?>
</div>



<script type="text/javascript">
$('#tipo_cuenta').change(function (){
	if($('#tipo_cuenta').val()==2)
	{
		$('#clave_cta').show();
	}else{
		$('#clave_cta').hide();
	}
});
$(document).ready(function (){
	if($('#tipo_cuenta').val()==2)
	{
		$('#clave_cta').show();
	}else{
		$('#clave_cta').hide();
	}
});
</script>