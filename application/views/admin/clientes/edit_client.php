<!-- barra direccion-->
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="<?=base_url('/admin/dashboard')?>">Inicio</a>
        </li>
        <li><a href="<?=base_url('users/clientes')?>">Lista de clientes</a></li>
        <li>Editar de cliente</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        	<!-- PAGE CONTENT BEGINS -->
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
			        <button class="btn btn-primary"><i class="fa fa-save "></i> Guardar </button>
			  		<a href="<?=base_url('users/clientes')?>" class="btn btn-grey" style="margin-left:15px"><i class="fa fa-undo"></i>Regresar</a> 
			    </div>
			    <?=form_close()?>

			<!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<script type="text/javascript">
$('#tipo_cliente').change(function (){
        var tipo = $('#tipo_cliente').val();

        if(tipo == 'B' || tipo == 'A')
        {
            $('#campo_comision').show();
        }else{
            $('#campo_comision').hide();
            $('#comision').removeAttr("required");
        }
    });
    
$(document).ready(function (){
	 
	 var tipo = $('#tipo_cliente').val();

        if(tipo == 'B' || tipo == 'A')
        {
            $('#campo_comision').show();
        }else{
            $('#campo_comision').hide();
            $('#comision').removeAttr("required");
        }
   
});
   
</script>