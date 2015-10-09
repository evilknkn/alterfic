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

/* Suma o resta */
function suma_resta(deposito_id, monto){
    var monto_hiden = Number($('#monto_pagar').val());
    var field = 'id_deposito_json'+deposito_id;
    if($('#'+field).is(':checked') ){
        var total = monto_hiden+ monto;
    }else{
       var total = monto_hiden - monto;
    }
    $('#monto_pagar').val(total.toFixed(2));
    $("#monto_pagar_bottom").val(total.toFixed(2));
}
/* Suma o resta */
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
                                <input type="text" name="monto" id="monto">
                                <label class="text-danger" id="fail_monto" style="display:none">*Este campo es requerido</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 col-xs-4"> Empresa retorno</label>
                            <div class="col-sm-8 col-xs-8">
                                    <select class="form-control" name="empresa_retorno" id="empresa_retorno"  >
                                        <option value=""> Seleccione un cliente</option>
                                        
                                    </select>
                               <label class="text-danger" id="fail_empresa_retorno" style="display:none">*Este campo es requerido</label>
                            </div>
                        </div>


                        <div class="form-group" id="list_banks">
                            <label class="control-label col-sm-4 col-xs-4"> Banco</label>
                            <div class="col-sm-8 col-xs-8">
                                <select class="form-control" name="id_banco_option" id="id_banco_option" > 
                                    <option value = "">Seleccione un banco</option>
                                </select>
                                <label class="text-danger" id="fail_banco_retorno" style="display:none">*Este campo es requerido</label>

                            </div>
                        </div>

                        <div class="form-group" id="folio_pago">
                            <label class="control-label col-sm-4 col-xs-4"> Folio</label>
                            <div class="col-sm-8 col-xs-8">
                                <div class="col-sm-5 col-xs-5">
                                   <input type="text" class="form-control" name="folio_pago"  id="folio_pago_retorno" >
                                   <a onclick="validate_unique_folio()" class="btn btn-primary"> Validar folio</a>
                                </div>
                                <label class="text-danger" id="fail_folio_pago" style="display:none">*Este campo es requerido</label>
                                <label class="text-danger" id="fail_folio_pago_existe" style="display:none">*Este folio ya fue registrado</label> 
                                <label class="text-success" id="fail_folio_pago_success" style="display:none">*Este folio es valido</label> 
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
                            <label class="control-label col-sm-4 col-xs-4">&nbsp;</label>
                            <label class="text-danger" id="fail_fecha" style="display:none">*Este campo es requerido</label>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-4 col-xs-4"> Adjuntar comprobante</label>
                          <div class="col-sm-8 col-xs-8">
                              <div class="col-sm-12 col-xs-12">
                                  <input type="hidden" name="ruta_comprobante" id="ruta_comprobante" value="<?=set_value('ruta_comprobante')?>" >
                                  <div id="upload_comprobante" >Clic para cargar</div>
                                  El formato de la imagen debe ser PDF, PNG o JPG con un tamaño maximo de 4 MB.
                                  <br>
                                  <label class="text-danger" id="fail_archivo" style="display:none">*Este campo es requerido</label>
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
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('<li><div class="alert alert-success" id="success_file">Archivo cargado exitosamente.<a href="<?php print base_url();?>'+responseJSON.directory+
                            '" target="_blank"> Ver archivo cargado </div></a></li>');
                            } else {
                            $("#ruta_comprobante").val('');
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('<li><div class="alert alert-danger" id="fail_file">'+responseJSON.error+'</div></li>');
                            }
                            },
                            onCancel: function(id, fileName){

                            },
                              debug: false
                            });
                        </script>
                        
                        <div class="row text-center text-danger" style="display:none" id="fail_depositos_array">
                            *Debe seleccionar al menos un depósito
                        </div>

                        <div class="row text-center text-danger" style="display:none" id="fail_depositos_array_folio">
                            *No puedes ingresar más de un pago en este tipo de movimiento
                        </div>

                        <div class="row text-center " style = "margin-bottom:15px" >
                            Total a pagar $ <input type="text" id="monto_pagar" value="0" disabled>
                        </div>

                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
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

                        <div class="row text-center " style = "margin-top:15px" >
                            Total a pagar $ <input type="text" id="monto_pagar_bottom" value="0" disabled>
                        </div>
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
        

       // console.log('id_empresa:'+empresa+ ' - id_banco:'+banco+' -empresa:'+deposito);

        $.ajax({
                type: "POST",
                dataType: "json",
                url:    "<?=base_url('cuentas/pagos/pending_pay_client')?>",
                data:   "id_deposito=" +deposito,
                success: function(data){
                    
                    var html_pendiente = '';
                    var value_paid = 0;

                    for(var i=0; i<data.length; i++){
                        html_pendiente += "<tr>";
                        if(data[i].checked == true){
                            html_pendiente += "<td><input type='checkbox' name='id_deposito_json' id='id_deposito_json"+data[i].id_deposito+"' value='"+data[i].id_deposito+"' checked=checked onclick='suma_resta("+data[i].id_deposito+","+data[i].monto_pendiente_retorno+")'></td>";
                            value_paid = value_paid + data[i].monto_pendiente_retorno;
                        }else{
                            html_pendiente += "<td><input type='checkbox' name='id_deposito_json' id='id_deposito_json"+data[i].id_deposito+"' value='"+data[i].id_deposito+"' onclick='suma_resta("+data[i].id_deposito+","+data[i].monto_pendiente_retorno+")' ></td>";
                        }

                        html_pendiente += "<td>"+data[i].folio_deposito+"</td>";
                        html_pendiente += "<td>$"+data[i].monto_deposito+"</td>";
                        html_pendiente += "<td>$"+data[i].comision+"</td>";
                        html_pendiente += "<td>$"+data[i].pendiente_retornar+"</td>";
                        html_pendiente += "</tr>";             
                    }


                    $("#pendientes_retornar").html(html_pendiente);
                    $("#monto_pagar").val(value_paid);
                    $("#monto_pagar_bottom").val(value_paid);
                }
        });



        $.ajax({
                type: "POST",
                dataType: "json",
                url:    "<?=base_url('cuentas/pagos/empresas')?>",
                data:   "id_deposito=" +deposito,
                success: function(data){
                    
                    var html_option = '';

                          html_option += '<option value="">Seleccione una empresa</option>';
                    for(var i=0; i<data.length; i++){
                        html_option += '<option value="'+data[i].id_empresa+'">'+data[i].name_empresa+'</option>';
                    }
                    $('#empresa_retorno').html(html_option);

                }
        });
    /////
    });

    $('#empresa_retorno').change(function(){
        var empresa = $('#empresa_retorno').val();
        if(empresa !=15){
            $('#list_banks').show();
            $('#folio_pago').show();
            $.ajax({
                    type: "POST",
                    datatype: 'html',
                    url: '<?php echo base_url("cuentas/depositos/bancos_empresa")?>',
                    data: "id_empresa=" + empresa , 
                    success: function(data)
                    {
                         $("#id_banco_option").html(data);
                    }
                  });//fin accion ajax
        }else{
            $('#list_banks').hide();
            $('#folio_pago').hide();
        }
    });

   

    function validate_unique_folio()
    {
       $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '<?php echo base_url("cuentas/pagos/unique_folio_ajax")?>',
                                data: "folio_pago=" + $("#folio_pago_retorno").val(),
                                success: function(data)
                                {       
                                   console.log(data.success);
                                    if(data.success  == false )    {
                                        //console.log("este folio existe");
                                        $('#fail_folio_pago_existe').show();
                                        $('#fail_folio_pago_success').hide();
                                        
                                    }else{
                                        $('#fail_folio_pago_success').show();
                                        $('#fail_folio_pago_existe').hide();
                                    }
                                    
                                    
                                }
                              });//fin accion ajax
    }
    
    

    $("#pay-bill").click(function(){

        if( $("#monto").val() == '' || $("#monto").val() == undefined ){
            console.log('primero ',$("#monto").val());
            $('#fail_monto').show();
            console.log('falta monto');
            return false;
        }

        if( $("#empresa_retorno").val() == '' || $("#empresa_retorno").val() == undefined  ){
            $('#fail_monto').hide();
            $('#fail_fecha').hide();
            $('#fail_archivo').hide();
            $('#fail_empresa_retorno').show();

            console.log('tercero ',$("#empresa_retorno").val());
            console.log('falta empresa retorno');
            return false;
        }else{
            if($("#empresa_retorno").val() != 15)
            {
                if( $("#id_banco_option").val() == '' || $("#id_banco_option").val() == undefined  ){
                    $('#fail_monto').hide();
                    $('#fail_fecha').hide();
                    $('#fail_archivo').hide();
                    $('#fail_empresa_retorno').hide();
                    $('#fail_banco_retorno').show();

                    

                    console.log('id banco option ',$("#id_banco_option").val());
                    console.log('falta banco retorno');
                    return false;
                }

                if( $("#folio_pago_retorno").val() == '' || $("#folio_pago_retorno").val() == undefined  ){
                    
                    $('#fail_monto').hide();
                    $('#fail_fecha').hide();
                    $('#fail_archivo').hide();
                    $('#fail_empresa_retorno').hide();
                    $('#fail_banco_retorno').hide();

                    $('#fail_folio_pago').show();

                    

                    console.log('folio pago ',$("#folio_pago_retorno").val());
                    console.log('falta folio pago');
                    return false;
                }
            }

        }





        if( $("input:text[name=fecha_pago]").val() == '' ||  $("input:text[name=fecha_pago]").val()== undefined  ){
            $('#fail_monto').hide();
            $('#fail_fecha').hide();
            $('#fail_archivo').hide();
            $('#fail_empresa_retorno').hide();
            $('#fail_banco_retorno').hide();
            $('#fail_folio_pago').hide();
            $('#fail_fecha').show();
            $('#fail_folio_pago_existe').hide();

            console.log('segundo ',$("input:text[name=fecha_pago]").val());
            console.log('falta fecha');
            return false;
        }

        if( $("#ruta_comprobante").val() == '' || $("#ruta_comprobante").val() == undefined  ){
            $('#fail_monto').hide();
            $('#fail_fecha').hide();
            $('#fail_archivo').hide();
            $('#fail_empresa_retorno').hide();
            $('#fail_banco_retorno').hide();
            $('#fail_folio_pago').hide();
            $('#fail_archivo').show();

            console.log('tercero ',$("#ruta_comprobante").val());
            console.log('falta comprobante');
            return false;
        }

        


        var type = [];
        $("input[name=id_deposito_json]:checked").each(function() {type.push(this.value)});

        console.log(type.length);
        if(type.length == 0){
            $('#fail_depositos_array').show();
            return false;
        }
        if($("#empresa_retorno").val() != 15 && type.length > 1 ){
            $('#fail_depositos_array_folio').show();
            return false;
        }

        $('#fail_monto').hide();
        $('#fail_fecha').hide();
        $('#fail_archivo').hide();
        $('#fail_depositos').show();
        $('#success_file').hide();
        $('#fail_file').hide();
        $('#fail_depositos_array').hide();
        $('#fail_banco_retorno').hide();
        $('#fail_empresa_retorno').hide();
        $('#fail_folio_pago').hide();
        $('#fail_folio_pago_existe').hide();
        $('#fail_depositos_array_folio').hide();
        $('#fail_folio_pago_success').hide();

        var empresa = $('#id_empresa').val();
        var banco   = $('#id_banco').val();
        var deposito = $('#deposito_id').val();

        //console.log('--id_empresa:'+empresa+ ' - id_banco:'+banco+' -empresa:'+deposito);

        $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo base_url("cuentas/pagos/pay_bills")?>',
                data: "fecha_pago=" + $("input:text[name=fecha_pago]").val() + "&comprobante="+ $("#ruta_comprobante").val()  + "&id_depositos=" + type+"&monto_pago="+$("#monto").val() + "&empresa_retorno="+$("#empresa_retorno").val()+"&banco_retorno="+$("#id_banco_option").val()+"&folio_pago="+$("#folio_pago_retorno").val(), 
                success: function(data)
                {   
                    pagos(empresa, banco, deposito);

                    $('#monto').val('');
                    $("input:text[name=fecha_pago]").val('');
                    $('#ruta_comprobante').val('');
                    $("#folio_pago_retorno").val('');


                    $("#add-pay").hide();
                    $("#button-add-pay").hide();
                    
                    $("#table-pays").show();
                    $("#button-list-pays").show();


                }
              });//fin accion ajax
        

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
