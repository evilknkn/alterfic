<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de empresas</li>
   	<li>Editar empresa</li>
</ol>

<div class="block-area col-xs-12 col-sm-12 text" id="responsiveTable">
    <h3 class="block-title">Lista de clientes</h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>
    <div class="clearfix"></div>

	<div class="block-area cols-sm-8 col-xs-8" id="responsiveTable">
	   
	    <div class="clearfix"></div>
	    
	    <?=form_open('', array('class' => 'form-horizontal'))?> 
	    <div class="form-group">
	        <label class="control-label col-sm-4 col-xs-4"> Nombre de empresa</label>
	        <div class="col-sm-4 col-xs-4">
	            <input type="text" name="nombre_empresa" class="form-control" required value="<?=$empresa->nombre_empresa?>">
	        </div>
	    </div>

	    <div class="form-group">
	        <label class="control-label col-sm-4 col-xs-4"> No de cuenta</label>
	        <div class="col-sm-4 col-xs-4">
	            <input type="text" name="no_cuenta"  class="form-control"  value="<?=$empresa->no_cuenta?>">
	        </div>
	    </div>

	    <div class="form-group">
	        <label class="control-label col-sm-4 col-xs-4"> Clabe bancaria</label>
	        <div class="col-sm-4 col-xs-4">
	            <input type="text" name="clabe"  class="form-control"  value="<?=$empresa->clabe_bancaria?>">
	        </div>
	    </div>
	    
	    <div class="clearfix text-center">
	        <button class="btn"><i class="fa fa-save "></i> Guardar </button>
	  		<a href="<?=base_url('catalogos/corps')?>" class="btn" style="margin-left:15px"><i class="fa fa-undo"></i>Regresar</a> 
	    </div>
	    <?=form_close()?>
	</div>
</div>