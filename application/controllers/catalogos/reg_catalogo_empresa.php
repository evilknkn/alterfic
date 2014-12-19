
<div class="col-sm-12 col-xs-12">
			<?=form_open('',array('class' => 'form-horizontal'))?>
			<div class="form-group">
				<label class=" control-label col-sm-4 col-xs-4">Nombre de empresa </label>
				<div class="col-xs-8 col-sm-8">
					<div >
						<input type="text" name="nombre_empresa" class="form-control" required>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">&nbsp;</div>
				<div class="col-xs-12  col-sm-12"><?=form_error('nombre_empresa')?></div>
			</div>

			<div class="form-group">
				<label class=" control-label col-sm-4 col-xs-4">Banco de depósito </label>
				<div class="col-xs-8 col-sm-8">
					<div >
						<select name="id_banco" class="form-control" required>
							<option value="">Seleccione un banco</option>
							<?php foreach($bancos as $banco):?>
								<option value="<?=$banco->id_banco?>"><?=$banco->nombre_banco?></option>
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

	    	<div class="clearfix">
	    		<button class="btn "><i class=" fa fa-plus"></i> Agregar </button>
	    	</div>
			<?=form_close();?>
		</div>