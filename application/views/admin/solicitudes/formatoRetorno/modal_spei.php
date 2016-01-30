<div class="modal fade" id="modalSpei" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Datos de Spei</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="alert alert-danger text-center" id="error-spei" style="display:none">                        
                    </div>
                    <div class="form-group">
                        <label class="label-control col-xs-4">Nombre</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="name_spei" placeholder="Nombre a quien se tranfiere">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Monto</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="monto_spei" placeholder="$1000">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Clabe interbancaria</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="clabe" placeholder="12345678900001">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveInfoSpei()">Save changes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"> 
    saveInfoSpei = function()
    {  
        var folio_cliente   = $('#folio_cliente').val();
        var id_cliente      = $('#id_cliente').val();

        var nombre_spei     = $('#name_spei').val();
        var monto_spei      = $('#monto_spei').val();
        var clabe           = $('#clabe').val();

        var comision_cliente    = $("#comision_cliente").val();

        var tipo_retorno    = "spei";

        if(nombre_spei.length == 0 || monto_spei.length == 0 )
        {
            $('#error-spei').show();
            $('#error-spei').html('nombre y monto son requeridos');
            return false;
        }else{
            $('#error-spei').hide();
        }
    /* Fin de validaciones*/    
        var dataPost ='id_cliente='+id_cliente+'&folio_cliente='+folio_cliente+'&tipo_retorno='+tipo_retorno+'&nombre='+nombre_spei+'&monto='+monto_spei+'&parametro='+clabe+'&comision_cliente='+comision_cliente;

        $.ajax({
              type:'POST',
              dataType:'json',
              url:"<?=base_url('/cuentas/formato_retorno/keepDataForma')?>",
              data: dataPost,
              success: function(data){
                
                if(data.success == 'true')
                {   
                    var html = '';
                        html+= "<tr id='forma_id_"+data.forma_id+"'>";
                        html += "<td>Spei a nombre de "+nombre_spei+"</td>"
                        html += "<td>"+monto_spei+"</td>";
                        html += "<td class='text-center'><a onclick='edit_retorno("+data.forma_id+", spei)' style='cursor:pointer'><i class='icon-edit bigger-160'></i></a></td>";
                        html += "<td class='text-center'><a onclick='delete_retorno("+data.forma_id+")' style='cursor:pointer'><i class='icon-trash bigger-160'></i></a></td>";
                        
                        html+= "</tr>";

                        //console.log(data.total_monto[0].monto );
                    
                    $('#lista-retornos').append(html);
                   
                    $('#sobrante-agente').html(data.total_depositos_sobrante);
                    $("#total-formato-retorno").html(data.total_formato);

                    $('#name_cheque').val('');
                    $('#monto_cheque').val('');
                    $('#folio_cheque').val('');

                    $('#error-spei').hide();
                    $('#modalSpei').modal('hide');
                }else{
                    $('#error-spei').show();
                    $('#error-spei').html(data.txtAlert);
                }
                    
              }
            })

    }


</script>
