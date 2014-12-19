<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de clientes</li>
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
	        <label class="control-label col-sm-4 col-xs-4"> Cliente</label>
	        <div class="col-sm-4 col-xs-4">
	            <input type="text" name="nombre_cliente" class="form-control" required value="<?=$cliente->nombre_cliente?>">
	        </div>
	    </div>

	    <div class="form-group">
	        <label class="control-label col-sm-4 col-xs-4"> Email</label>
	        <div class="col-sm-4 col-xs-4">
	            <input type="email" name="email"  class="form-control" required value="<?=$cliente->email?>">
	        </div>
	    </div>

	    <div class="form-group">
	        <label class="control-label col-sm-4 col-xs-4"> Tipo de cliente</label>
	        <div class="col-sm-3 col-sm-3">
	            <select class="form-control" name="tipo_cliente" id="tipo_cliente" required >
	                <option value="">Seleccione un tipo</option>
	                <option value="A" <?=($cliente->tipo_cliente== 'A')? 'selected=selected':''; ?>>Tipo A</option>
	                <option value="B"<?=($cliente->tipo_cliente== 'B')? 'selected=selected':''; ?>>Tipo B</option>
	            </select> 
	        </div>
	    </div>

	    <div class="form-group" id="campo_comision">
	        <label class="control-label col-sm-4 col-xs-4"> Comisión</label>
	        <div class="col-sm-3 col-xs-3">
	            <input type="text" name="comision" id='comision' class="form-control" required value="<?=($cliente->comision * 100)?>">
	        </div>
	    </div>

	    <div class="clearfix text-center">
	        <button class="btn"><i class="fa fa-save "></i> Guardar </button>
	  		<a href="<?=base_url('users/clientes')?>" class="btn" style="margin-left:15px"><i class="fa fa-undo"></i>Regresar</a> 
	    </div>
	    <?=form_close()?>
	</div>
</div>

<script type="text/javascript">
$('#tipo_cliente').change(function (){
        var tipo = $('#tipo_cliente').val();

        if(tipo == 'B')
        {
            $('#campo_comision').show();
        }else{
            $('#campo_comision').hide();
            $('#comision').removeAttr("required");
        }
    });
    
$(document).ready(function (){
	 
	 var tipo = $('#tipo_cliente').val();

        if(tipo == 'B')
        {
            $('#campo_comision').show();
        }else{
            $('#campo_comision').hide();
            $('#comision').removeAttr("required");
        }
   
});
   
</script>