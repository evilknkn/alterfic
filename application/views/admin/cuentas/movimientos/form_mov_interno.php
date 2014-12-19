<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
    <li>Lista de depósitos</li>
    <li>Movimientos internos</li>
    <li>Agregar movimiento interno</li>
</ol>


<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Nuevo movimiento en <?=$nombre_empresa?></h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>
    <div class="clearfix"></div>
    
    <?=form_open('', array('class' => 'form-horizontal'))?> 
    <div class="form-group">
        <label class="control-label col-sm-4 col-xs-4"> Empresa </label>
        <div class="col-sm-8 col-xs-8">
            <div class="col-sm-5 col-xs-5">
            <select class="form-control" name="empresa" id="empresa" >
                <option value=""> Seleccione un cliente</option>
                <?php foreach($empresas as $empresa):?>
                    <option value="<?=$empresa->id_empresa?>" <?=($empresa->id_empresa == set_value('empresa'))? 'selected = selected' : '';?>><?=$empresa->nombre_empresa;?></option>
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
            <input type="text" name="monto"  class="form-control" value="<?=set_value('monto')?>">
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
                    <input data-format="dd/MM/yyyy" type="text" name="fecha" class="form-control " placeholder="dd/mm/aaaa" value="<?=set_value('fecha')?>" />
                    <span class="add-on">
                        <i class="sa-plus"></i>
                    </span>
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
            <input type="text" name="folio_salida" class="form-control" value="<?=set_value('folio_salida')?>">
            </div>
            <div class="col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-sm-5 col-xs-5"><?=form_error('folio_salida')?></div>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-4 col-xs-4"> Folio entrada</label>
        <div class="col-sm-8 col-xs-8">
            <div class="col-sm-3 col-xs-3">
            <input type="text" name="folio_entrada" class="form-control" value="<?=set_value('folio_entrada')?>">
            </div>
            <div class="col-sm-12 col-xs-12">&nbsp;</div>
            <div class="col-sm-5 col-xs-5"><?=form_error('folio_entrada')?></div>
        </div>
    </div>

    <div class="clearfix text-center">
        <button class="btn"><i class="fa fa-save "></i> Guardar </button>
        <a href="<?=base_url('cuentas/movimientos_internos/lista/'.$id_empresa.'/'.$id_banco)?>" class="btn" style="margin-left:15px"><i class="fa fa-undo"></i>Regresar</a>
    </div>
    <?=form_close()?>
</div>

<SCRIPT TYPE="text/javascript">
// $('#empresa').change(function(){
//     var empresa = $('#empresa').val();

//     $.ajax({
//             type: "POST",
//             datatype: 'html',
//             url: '<?php echo base_url("cuentas/depositos/bancos_empresa")?>',
//             data: "id_empresa=" + empresa , 
//             success: function(data)
//             {
//                  $("#id_banco").html(data);
//             }
//           });//fin accion ajax
// });
</SCRIPT>
<SCRIPT TYPE="text/javascript">
$('#empresa').change(function(){
    var empresa = $('#empresa').val();
    var id_banco = "<?=set_value('id_banco')?>";

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
     var id_banco = "<?=set_value('id_banco')?>";
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