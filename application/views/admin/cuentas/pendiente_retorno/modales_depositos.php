<link rel="stylesheet" href="<?=base_url('assets/css/fileuploader.css');?>" />
<script src="<?=base_url('assets/js/fileuploader.js');?>"></script>

<script type="text/javascript">
var empresa  = '';
var banco    = '';
var deposito = '';

function pagos(id_empresa, id_banco, id_deposito)
{
    var url_pago = 'cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito+'/1';
    $('#agregar_pago').attr({'href': '<?=base_url()?>cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito+'/1'});

    $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url("cuentas/depositos/movimiento_pagos")?>',
            data: "id_empresa=" + id_empresa + "&id_banco="+ id_banco + "&id_deposito=" + id_deposito, 
            success: function(data)
            {   
                if(data.estatus == "no asignado"  )
                {
                    $("#error").show();
                }else{
                    $("#error").hide();
                }
                $('#deposito').html(data.deposito);
                $('#comision').html(data.comision);
                $("#retornar").html(data.retorno);
                $("#retornado").html(data.total_pagos);
                $("#pendiente").html(data.pendiente);


                $("#id_empresa").val(id_empresa);
                $("#id_banco").val(id_banco);
                $("#deposito_id").val(id_deposito);
                
            }
          });//fin accion ajax

    $.ajax({
            type: "POST",
            datatype: 'html',
            url: '<?php echo base_url("cuentas/depositos/pagos")?>',
            data: "id_empresa=" + id_empresa + "&id_banco="+ id_banco + "&id_deposito=" + id_deposito, 
            success: function(data)
            {
                 $("#res_pagos").html(data);
            }
          });//fin accion ajax
};
</script>
<div class="modal fade" id="modalPagos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Pagos</h4>
            </div>

            <input type="hidden" id="id_empresa"  value="">
            <input type="hidden" id="id_banco"    value="">
            <input type="hidden" id="deposito_id" value="">

            <div class="modal-body">
                <div id="table-pays">
                    <div id="error" class="alert alert-danger" style="display:none">
                        No se ha asignado cliente a este depósito
                    </div>

                    <table>
                        <tr>
                            <td width="150">Déposito</td>
                            <td>$<span id="deposito"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Comisión</td>
                            <td>$<span id="comision"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Monto a retornar</td>
                            <td>$<span id="retornar"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Total retornado</td>
                            <td>$<span id="retornado"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Pendiente de retorno</td>
                            <td>$<span id="pendiente"></span></td>
                        </tr>
                    </table>
                    <br><br>
                    <table class="table tile">
                        <thead>
                            <tr>
                                <th class="text-center" >Pago</th>
                                <th class="text-center" >Monto</th>
                                <th class="text-center" >Fecha</th>
                                <th class="text-center" >Comprobante</th>
                                <th class="text-center" >Detalle</th>
                                <th class="text-center">Borrar</th>
                            </tr>
                        </thead>
                        <tbody id="res_pagos">
                        </tbody>
                        
                    </table>
                </div> 

                <div id="add-pay" style="display:none">
                    <form class="form-horizontal">

                        <div class="form-group">
                            <label class="control-label col-sm-4"> Monto </label>
                            <div class="col-sm-8">
                                <input type="text" name="monto">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 col-xs-4"> Fecha pago</label>
                            <div class="input-group col-sm-5 col-xs-5">
                                <input class="form-control date-picker input-large" id="id-date-picker-1" name="fecha_pago" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_pago')?>"  placeholder="dd/mm/aaaa"/>
                                <span class="input-group-addon">
                                <i class="icon-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-4 col-xs-4"> Adjuntar comprobante</label>
                          <div class="col-sm-8 col-xs-8">
                              <div class="col-sm-12 col-xs-12">
                                  <input type="hidden" name="ruta_comprobante" id="ruta_comprobante" value="<?=set_value('ruta_comprobante')?>" >
                                  <div id="upload_comprobante" >Clic para cargar</div>
                                  El formato de la imagen debe ser PDF, PNG o JPG con un tamaño maximo de 4 MB.
                              </div>
                              <div class="col-sm-12 col-xs-12">&nbsp;</div>
                              <div class="col-sm-6 col-xs-6"><?=form_error('ruta_comprobante')?></div>
                          </div>
                          
                      </div>

                       <script type="text/javascript">
                           var uploader = new qq.FileUploader({
                            element: document.getElementById('upload_comprobante'),
                            action: '<?php print base_url("archivos/subir_archivo");?>',
                            multiple: false,
                            params: { carpeta : 'comprobantes_pago', extension : 'pdf|jpg|png' },
                            // events         
                            // you can return false to abort submit
                            onSubmit: function(id, fileName){
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('');
                            },
                            onProgress: function(id, fileName, loaded, total){

                              },
                            onComplete: function  (id, fileName, responseJSON){
                            if(responseJSON.error == null) {
                            $("#ruta_comprobante").val(responseJSON.directory);
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('<li><div class="alert alert-success">Archivo cargado exitosamente.<a href="<?php print base_url();?>'+responseJSON.directory+
                            '" target="_blank"> Ver archivo cargado </div></a></li>');
                            } else {
                            $("#ruta_comprobante").val('');
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('<li><div class="alert alert-danger">'+responseJSON.error+'</div></li>');
                            }
                            },
                            onCancel: function(id, fileName){

                            },
                              debug: false
                            });
                        </script>

                        <table border="1">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Folio</th>
                                    <th>Depósito</th>
                                    <th>Comisión</th>
                                    <th>Pendiente</th>
                                </tr>
                            </thead>
                            <tbody id="pendientes_retornar"></tbody>
                        </table>

                        <input type="text" value="" id="prueba">
                    </form>
                </div>   

            </div>
            
            <div class="modal-footer">
                <div id="button-list-pays">
                    <a id="show-add-pay" class="btn btn-info" >Agregar pago</a>
                    <button type="button" class="btn btn-grey" data-dismiss="modal">Cerrar</button>
                </div>

                <div id="button-add-pay" style="display:none">
                    <a id="pay-bill" class="btn btn-info" >Guardar</a>
                    <button type="button" class="btn btn-grey" id="cancel-pay">Cancelar</button>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("#show-add-pay").click(function(){
        $("#add-pay").show();
        $("#button-add-pay").show();
        
        $("#table-pays").hide();
        $("#button-list-pays").hide();

        var empresa = $('#id_empresa').val();
        var banco   = $('#id_banco').val();
        var deposito = $('#deposito_id').val();
        

        console.log('id_empresa:'+empresa+ ' - id_banco:'+banco+' -empresa:'+deposito);

        $.ajax({
                type: "POST",
                dataType: "json",
                url:    "<?=base_url('cuentas/pagos/pending_pay_client')?>",
                data:   "id_deposito=" +deposito,
                success: function(data){
                    console.log(data.length);

                    var html_pendiente = '';

                    for(var i=0; i<data.length; i++){
                        html_pendiente += "<tr>";
                        html_pendiente += "<td>"+data[i].id_deposito+"</td>";
                        html_pendiente += "<td>"+data[i].folio_deposito+"</td>";
                        html_pendiente += "<td>"+data[i].monto_deposito+"</td>";
                        html_pendiente += "<td>"+data[i].comision+"</td>";
                        html_pendiente += "<td>"+data[i].pendiente_retornar+"</td>";
                        html_pendiente += "</tr>";             
                    }


                    $("#pendientes_retornar").html(html_pendiente);
                    $("#prueba").html('ksmf');
                }
        });

    });

    $("#pay-bill").click(function(){
        $("#add-pay").hide();
        $("#button-add-pay").hide();
        
        $("#table-pays").show();
        $("#button-list-pays").show();

        var empresa = $('#id_empresa').val();
        var banco   = $('#id_banco').val();
        var deposito = $('#deposito_id').val();

        console.log('--id_empresa:'+empresa+ ' - id_banco:'+banco+' -empresa:'+deposito);

    });

    $("#cancel-pay").click(function(){
        $("#add-pay").hide();
        $("#button-add-pay").hide();
        
        $("#table-pays").show();
        $("#button-list-pays").show();

    });

    function pagos_detalle(id_empresa, id_banco, id_deposito)
    {
        var url_pago = 'cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito+'/1';
        $('#agregar_pago').attr({'href': '<?=base_url()?>cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito+'/1'});

        $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo base_url("cuentas/pagos/detalle_salida")?>',
                data: "id_empresa=" + id_empresa + "&id_banco="+ id_banco + "&id_deposito=" + id_deposito, 
                success: function(data)
                {   
                    if(data.estatus == "no asignado"  )
                    {
                        $("#error").show();
                    }else{
                        $("#error").hide();
                    }
                    $('#deposito_detalle').html(data.deposito);
                    $('#comision_detalle').html(data.comision);
                    $("#retornar_detalle").html(data.retorno);
                    $("#retornado_detalle").html(data.total_pagos);
                    $("#pendiente_detalle").html(data.pendiente);
                }
              });//fin accion ajax

        
    };
</script>
