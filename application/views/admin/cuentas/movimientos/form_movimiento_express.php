<!-- barra direccion-->
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
       <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
        <li>Lista de depósitos</li>
        <li>Movimientos internos</li>
        <li>Agregar movimiento interno</li>
    </ul>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="page-header">
                    <h1>Nuevo movimiento en <?=$nombre_empresa?></h1>
                </div><!-- /.page-header -->
                <?php if($this->session->flashdata('success')):?>
                    <div class="text-center col-sm-12 col-xs-12">
                        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                    </div>
                <?php endif;?>

                <?=form_open('', array('class' => 'form-horizontal'))?> 
                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4" > Folio salida</label>
                        <div class="col-sm-8 col-xs-8">
                            <input type="text" id="folio_salida" name="folio_salida" value="<?=set_value('folio_salida')?>">
                        </div>
                        <div class="col-sm-5 col-xs-5"><?=form_error('folio_salida')?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4" > Folio entrada</label>
                        <div class="col-sm-8 col-xs-8">
                            <input type="text" id="folio_entrada" name="folio_entrada" value="<?=set_value('folio_entrada')?>">
                        </div>
                        <div class="col-sm-5 col-xs-5"><?=form_error('folio_entrada')?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4" > Monto</label>
                        <div class="col-sm-8 col-xs-8">
                            <input type="text" id="monto" name="monto" value="<?=set_value('monto')?>">
                        </div>
                        <div class="col-sm-5 col-xs-5"><?=form_error('monto')?></div>
                    </div>

                    <div class="clearfix text-center">
                        <button class="btn btn-primary" type="submit"> <i class="fa fa-save "></i> Guardar </button>
                        <a href="<?=base_url('cuentas/movimientos_internos_express/lista/'.$id_empresa.'/'.$id_banco)?>" class="btn btn-grey" style="margin-left:15px"><i class="fa fa-undo"></i>Regresar</a>
                    </div>

                <?=form_close() ?> 
                
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

