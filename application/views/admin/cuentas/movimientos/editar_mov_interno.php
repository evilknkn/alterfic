<!-- barra direccion-->
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
       <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
        <li>Lista de depósitos</li>
        <li>Movimientos internos</li>
        <li>Editar movimiento interno</li>
    </ul>
</div>
<?php  
$id_empresa        = (isset($detalle->empresa_destino)) ? $detalle->empresa_destino : set_value('empresa');
$id_banco       = (isset($detalle->banco_destino)) ? $detalle->banco_destino : set_value('id_banco');
$monto          = (isset($detalle->monto)) ? $detalle->monto : set_value('monto');
$fecha          = (isset($detalle->fecha_mov)) ? formato_fecha_ddmmaaaa($detalle->fecha_mov) : set_value('fecha');
$folio_salida   = (isset($detalle->folio_salida)) ? $detalle->folio_salida : set_value('folio_salida');
$folio_entrada  = (isset($detalle->folio_entrada)) ? $detalle->folio_entrada : set_value('folio_entrada');
?>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
                <div class="page-header">
                    <h1>Editar movimiento en <?=$nombre_empresa?></h1>
                </div><!-- /.page-header -->
                <?php if($this->session->flashdata('success')):?>
                    <div class="text-center col-sm-12 col-xs-12">
                        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                    </div>
                <?php endif;?>

                <?=form_open('', array('class' => 'form-horizontal'))?> 
                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Empresa </label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-sm-5 col-xs-5">
                            <select class="form-control" name="empresa" id="empresa" >
                                <option value=""> Seleccione un cliente</option>
                                <?php foreach($empresas as $empresa):?>
                                <?=$selected = ($empresa->id_empresa == $id_empresa) ? 'selected = selected ' : ' ';?>
                                    <option value="<?=$empresa->id_empresa?>" <?=$selected?> ><?=$empresa->nombre_empresa;?></option>
                                <?php endforeach;?>
                            </select>
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-5 col-xs-5"><?=form_error('empresa')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Banco</label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-xs-5 col-sm-5">
                            <select class="form-control" name="id_banco" id="id_banco" > 
                                <option value = "">Seleccione un banco</option>
                            </select>
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-5 col-xs-5"><?=form_error('id_banco')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Monto</label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-sm-3 col-xs-3">
                            <input type="text" name="monto"  class="form-control" value="<?=$monto?>">
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-5 col-xs-5"><?=form_error('monto')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4">Fecha</label>
                        <div class="col-sm-8 col-xs-8">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="input-icon datetime-pick date-only">
                                        <div class="input-group">
                                            <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha" required type="text" data-date-format="dd-mm-yyyy" value="<?=$fecha?>"  placeholder="dd/mm/aaaa"/>
                                            <span class="input-group-addon">
                                            <i class="icon-calendar bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">&nbsp;</div>
                                <div class="col-sm-5 col-xs-5"><?=form_error('fecha')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Folio salida</label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-xs-3 col-sm-3">
                            <input type="text" name="folio_salida" class="form-control" value="<?=$folio_salida?>">
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-5 col-xs-5"><?=form_error('folio_salida')?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4"> Folio entrada</label>
                        <div class="col-sm-8 col-xs-8">
                            <div class="col-sm-3 col-xs-3">
                            <input type="text" name="folio_entrada" class="form-control" value="<?=$folio_entrada?>">
                            </div>
                            <div class="col-sm-12 col-xs-12">&nbsp;</div>
                            <div class="col-sm-5 col-xs-5"><?=form_error('folio_entrada')?></div>
                        </div>
                    </div>

                    <div class="clearfix text-center">
                        <button class="btn btn-primary"><i class="fa fa-save "></i> Guardar </button>
                        <a href="<?=base_url('cuentas/movimientos_internos/lista/'.$no_empresa.'/'.$no_banco)?>" class="btn btn-grey" style="margin-left:15px"><i class="fa fa-undo"></i>Regresar</a>
                    </div>
                    <?=form_close()?>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<SCRIPT TYPE="text/javascript">
$('#empresa').change(function(){
    var empresa = $('#empresa').val();
    var id_banco = "<?=$id_banco?>";

    $.ajax({
            type: "POST",
            datatype: 'html',
            url: '<?php echo base_url("cuentas/movimientos_internos/bancos_empresa")?>',
            data: "id_empresa=" + empresa + "&id_banco=" + id_banco, 
            success: function(data)
            {
                 $("#id_banco").html(data);
            }
          });//fin accion ajax
});
$( document ).ready(function() {
     var empresa = $('#empresa').val();
     var id_banco = "<?=$id_banco?>";
    $.ajax({
            type: "POST",
            datatype: 'html',
            url: '<?php echo base_url("cuentas/movimientos_internos/bancos_empresa")?>',
            data: "id_empresa=" + empresa + "&id_banco=" + id_banco , 
            success: function(data)
            {
                 $("#id_banco").html(data);
            }
          });//fin accion ajax
});
</SCRIPT>
