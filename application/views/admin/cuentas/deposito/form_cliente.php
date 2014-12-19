<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li><a href="<?=base_url('cuentas/depositos')?>">Lista de depósitos</a></li>
   	<li>Detalle de depósito</li>
    <li>Agregar Cliente</li>
</ol>


<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Agregar Cliente</h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>
    <div class="clearfix"></div>
    
    <?=form_open('', array('class' => 'form-horizontal'))?> 
    <div class="form-group">
        <label class="control-label col-sm-4 col-xs-4"> Cliente</label>
        <div class="col-sm-8 col-xs-8">
            <input type="text" name="nombre_cliente" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-4 col-xs-4"> Email</label>
        <div class="col-sm-8 col-xs-8">
            <input type="email" name="email"  class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-4 col-xs-4"> Comisión</label>
        <div class="col-sm-3 col-xs-3">
            <input type="text" name="comision" class="form-control" required>
        </div>
    </div>

    <div class="clearfix text-center">
        <button class="btn"><i class="fa fa-save "></i> Guardar </button>
        <a href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco)?>" class="btn" style="margin-left:15px"><i class="fa fa-undo"></i>Regresar</a>
    </div>
    <?=form_close()?>
</div>

