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

    function validate_unique_folio()
    {
        var empresa  = $('#empresa_retorno').val();
        var banco    = $('#id_banco_option').val();
        var folio    =  $("#folio_pago_retorno").val();
       console.log(empresa.length+' --- '+ banco.length);
       if(empresa.length ==0){
            $('#fail_folio_pago_existe').show();
            $('#message_fail').html('*Debe seleccionar la empresa de retorno');
        return false;
       }

       if(banco.length ==0){
            $('#fail_folio_pago_existe').show();
            $('#message_fail').html('*Debe seleccionar el banco de retorno');
        return false;
       }

       if(folio.length ==0){
            $('#fail_folio_pago_existe').show();
            $('#message_fail').html('*Debe ingresar un folio');
        return false;
       }
       $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: '<?php echo base_url("cuentas/pagos/unique_folio_ajax")?>',
                                data: "folio_pago=" + folio+ '&empresa_retorno='+empresa+'&banco_retorno='+banco,
                                success: function(data)
                                {       
                                    if(data.success  == false )    {
                                         var fail_txt = data.fail_txt;
                                        //console.log("este folio existe");
                                        $('#fail_folio_pago_existe').show();
                                        $('#fail_folio_pago_success').hide();
                                        $('#message_fail').html(fail_txt);
                                        $('#success_folio_pago').hide();
                                        
                                    }else{
                                        $('#success_folio_pago').show();
                                        
                                        $('#fail_folio_pago_existe').hide();
                                    }
                                    
                                    
                                }
                              });//fin accion ajax
    }

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

/* Suma o resta */

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
        if(empresa !=15 ){
            if(empresa != 47){
                //alert('es diferente de 15 y 47')
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
            }
            else{
                $('#list_banks').hide();
                $('#folio_pago').hide();
            }
        }else{
            $('#list_banks').hide();
            $('#folio_pago').hide();
        }
    });

    $("#pay-bill").click(function(){
        console.log($("#empresa_retorno").val());
        if( $("#monto").val() == '' || $("#monto").val() == undefined ){
            
            $('#fail_monto').show();
            
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
                if( $("#empresa_retorno").val() != 47 ){
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
                }  // fin de if diferente a 47
            }//final de if diferente a 15

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

        // if( $("#ruta_comprobante").val() == '' || $("#ruta_comprobante").val() == undefined  ){
        //     $('#fail_monto').hide();
        //     $('#fail_fecha').hide();
        //     $('#fail_archivo').hide();
        //     $('#fail_empresa_retorno').hide();
        //     $('#fail_banco_retorno').hide();
        //     $('#fail_folio_pago').hide();
        //     $('#fail_archivo').show();

        //     console.log('tercero ',$("#ruta_comprobante").val());
        //     console.log('falta comprobante');
        //     return false;
        // }

        var type = [];
        $("input[name=id_deposito_json]:checked").each(function() {type.push(this.value)});

        //console.log(type.length);
        if(type.length == 0){
            $('#fail_depositos_array').show();
            return false;
        }
        if($("#empresa_retorno").val() != 15  && type.length > 1 ){
            if($("#empresa_retorno").val() != 47  && type.length > 1)
            {
                $('#fail_depositos_array_folio').show();
                return false;
            }
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

    
</script>
