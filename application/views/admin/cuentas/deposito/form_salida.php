<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li><a href="<?=base_url('cuentas/depositos')?>">Lista de depósitos</a></li>
   	<li><a href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$empresa->id_empresa.'/'.$empresa->id_banco)?>">Detalle de depósito</a></li>
   	<li>Registrar salida</li>
</ol>

<div class="col-sm-12 col-xs-12">
<p>Por favor llene los campos se piden acontinuación para registrar una salida para la empresa <b><?=$empresa->nombre_empresa?></b>.</p>

	<?=form_open('',array('class'=>'form-horizontal'))?>
	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Fecha de salida</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
				<div class="input-icon datetime-pick date-only">
	                <input data-format="dd/MM/yyyy" type="text" name="fecha_salida" class="form-control input-sm" placeholder="dd/mm/aaaa" value="<?=set_value('fecha_salida')?>" />
	                <span class="add-on">
	                    <i class="sa-plus"></i>
	                </span>
	            </div>
            </div>
            <div class="col-sm-12 col-xs-12">&nbsp;</div>
	        <div class="col-sm-4 col-xs-4"><?=form_error('fecha_salida')?></div>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Monto de salida</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
				<input type="text" class="form-control" name="monto_salida" value=" <?=set_value('monto_salida')?>" >
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
	        <div class="col-sm-4 col-xs-4"><?=form_error('monto_salida')?></div>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Folio</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
				<input type="text" class="form-control" name="folio_salida" value=" <?=set_value('folio_salida')?>" >
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
	        <div class="col-sm-4 col-xs-4"><?=form_error('folio_salida')?></div>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Detalle de salida</label>
		<div class="col-xs-4 col-sm-4">
			<div>
				<textarea cols="60" rows="10" name="detalle_salida" class="form-control"><?=set_value('detalle_salida')?></textarea>
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
			<div class="col-sm-8 col-xs-8"><?=form_error('detalle_salida')?></div>
		</div>
	</div>

	<div class="clearfix text-center">
		<button class="btn"> <i class="fa fa-save "></i> Guardar</button>
		<a href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$empresa->id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn"> <i class="fa fa-undo"></i> Regresar</a>
	</div>

	<?=form_close()?>
</div>

