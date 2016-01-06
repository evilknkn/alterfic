<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li><a href="<?=base_url('cuentas/depositos')?>">Lista de depósitos</a></li>
   	<li><a href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$empresa->id_empresa)?>">Detalle de depósito</a></li>
   	<li>Registrar depósito</li>
</ol>

<div class="col-sm-12 col-xs-12">
<p>Por favor llene los campos se piden acontinuación para registrar un depósito para la empresa <b><?=$empresa->nombre_empresa?></b>.</p>

	<?=form_open('',array('class'=>'form-horizontal'))?>
	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Fecha del depósito</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
	            <div class="input-group">
                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_depto" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_depto')?>"  placeholder="dd/mm/aaaa"/>
                    <span class="input-group-addon">
                    <i class="icon-calendar bigger-110"></i>
                    </span>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-sm-4 col-xs-4"><?=form_error('fecha_depto')?></div>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Monto del depósito</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
				<input type="text" class="form-control" name="monto_depto" value=" <?=set_value('monto_depto')?>" >
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
	        <div class="col-sm-4 col-xs-4"><?=form_error('monto_depto')?></div>
	   	</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Folio</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
				
				<input type="text" class="form-control" name="folio_depto" value="<?=set_value('folio_depto')?>" placeholder="<?= $empresa->clave_cta.$empresa->clave_banco.'-' ?>" >
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
	        <div class="col-sm-4 col-xs-4"><?=form_error('folio_depto')?></div>
		</div>
	</div>

	<div class="clearfix text-center">
		<button class="btn btn-primary"> <i class="fa fa-save "></i> Guardar</button>
		<a href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$empresa->id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn btn-grey"> <i class="fa fa-undo"></i> Regresar</a>
	</div>

	<?=form_close()?>
</div>

