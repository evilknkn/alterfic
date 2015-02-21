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
        <li>Comisiones</li>
        <li>Lista de salida de comisiones</li>
        <li>Agregar retiro</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="page-header">
                    <h1>Agregar retiro</h1>
                </div><!-- /.page-header -->

                <p>Aquí puede agregar un retiro de comisión, solo llene los campos que acontinuación se muestran.</p>

                <?=form_open('', array('class'=>'form-horizontal'))?>
                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Folio</label>
                        <div class="col-xs-8 col-sm-8">
                            <div class="col-sm-4 col-xs-4 ">
                                <input type="text" class="form-control" name="folio_retiro" value="<?=set_value('folio_retiro')?>">
                            </div>
                            <div class="col-xs-12 col-sm-12">&nbsp;</div>
                            <div class="col-sm-5 col-xs-5"><?=form_error('folio_retiro')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Monto</label>
                        <div class="col-xs-8 col-sm-8">
                            <div class="col-sm-4 col-xs-4 ">
                                <input type="text" class="form-control" name="monto_retiro" value="<?=set_value('monto_retiro')?>">
                            </div>
                            <div class="col-xs-12 col-sm-12">&nbsp;</div>
                            <div class="col-sm-5 col-xs-5"><?=form_error('monto_retiro')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4">Fecha de retiro</label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-sm-4 col-xs-4">
                                
                                <div class="input-group">
                                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_retiro" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_retiro')?>"  placeholder="dd/mm/aaaa"/>
                                    <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-4 col-xs-4"><?=form_error('fecha_retiro')?></div>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Empresa </label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-sm-5 col-xs-5">
                            <select class="form-control" name="empresa" id="empresa" >
                                <option value=""> Seleccione un cliente</option>
                                <?php foreach($empresas as $empresa):?>
                                    <option value="<?=$empresa->id_empresa?>" <?=($empresa->id_empresa == set_value('empresa'))?'selected=selected':'';?>><?=$empresa->nombre_empresa;?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-4 col-xs-4"><?=form_error('empresa')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Banco</label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-sm-5 col-xs-5">
                            <select class="form-control" name="id_banco" id="id_banco" > 
                                <option value = "">Seleccione un banco</option>
                            </select>
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-4 col-xs-4"><?=form_error('empresa')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4">Detalle de retiro</label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-sm-4 col-xs-4">
                                <textarea cols="20" rows="5" name="detalle_salida" class="form-control"> <?=set_value('detalle_salida')?></textarea>
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-4 col-xs-4"><?=form_error('detalle_salida')?></div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                        <a href="<?=base_url('cuentas/comisiones/salida_comision')?>" class="btn btn-grey" style="margin-left:15px"><i class="fa fa-undo"></i> Regresar</a>
                        
                    </div>
                <?=form_close()?>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<SCRIPT TYPE="text/javascript">
$('#empresa').change(function(){
    var empresa = $('#empresa').val();

    $.ajax({
            type: "POST",
            datatype: 'html',
            url: '<?php echo base_url("cuentas/comisiones/bancos_empresa")?>',
            data: "id_empresa=" + empresa , 
            success: function(data)
            {
                 $("#id_banco").html(data);
            }
          });//fin accion ajax
});
</SCRIPT>