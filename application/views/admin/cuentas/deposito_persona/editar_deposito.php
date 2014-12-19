<?php //print_r($deposito);
$fecha_depto = (!empty($deposito->fecha_movimiento))? formato_fecha_ddmmaaaa($deposito->fecha_movimiento): set_value('fecha_depto') ;
$monto_depto = (!empty($deposito->monto_deposito))? $deposito->monto_deposito : set_value('monto_depto') ;
$folio_depto = (!empty($deposito->folio_mov))? $deposito->folio_mov : set_value('folio_depto') ;
$id_detalle  = (!empty($deposito->id_detalle))? $deposito->id_detalle : set_value('id_detalle') ;
$id_deposito  = (!empty($deposito->id_deposito))? $deposito->id_deposito : set_value('id_deposito') ;
?>
<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li><a href="<?=base_url('cuentas/depositos')?>">Lista de depósitos</a></li>
   	<li>Editar depósito</li>
</ol>

<div class="col-sm-12 col-xs-12">
<p>Por favor modifique  la información necesaria y haga clic en <b>Guardar</b> para que se que se refleje el cambio para la cuenta de  <b><?=$empresa->nombre_empresa?></b>.</p>
	
	<?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>

	<?=form_open('',array('class'=>'form-horizontal'))?>
	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Fecha del depósito</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
				<div class="input-icon datetime-pick date-only">
	                <input data-format="dd/MM/yyyy" type="text" name="fecha_depto" class="form-control input-sm" placeholder="dd/mm/aaaa" value="<?=$fecha_depto?>" />
	                <span class="add-on">
	                    <i class="sa-plus"></i>
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
				<input type="text" class="form-control" name="monto_depto" value=" <?=$monto_depto?>" >
				<input type="hidden" name="id_detalle" value="<?=$id_detalle?>" class="form-control">
				<input type="hidden" name="id_deposito" value="<?=$id_deposito?>" class="form-control">
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
	        <div class="col-sm-4 col-xs-4"><?=form_error('monto_depto')?></div>
	   	</div>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-4 col-xs-4">Folio</label>
		<div class="col-sm-8 col-xs-8">
			<div class="col-sm-4 col-xs-4">
				<input type="text" class="form-control" name="folio_depto" value=" <?=$folio_depto?>" >
			</div>
			<div class="col-sm-12 col-xs-12">&nbsp;</div>
	        <div class="col-sm-4 col-xs-4"><?=form_error('folio_depto')?></div>
		</div>
	</div>

	<div class="clearfix text-center">
		<button class="btn"> <i class="fa fa-save "></i> Guardar</button>
		<a href="<?=base_url('cuentas/deposito_persona/detalle_cuenta/'.$empresa->id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn"> <i class="fa fa-undo"></i> Regresar</a>
	</div>

	<?=form_close()?>
</div>

