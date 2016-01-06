<div class="modal fade" id="modalCheque" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Datos del cheque</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                   <div class="alert alert-danger text-center" id="error-cheque" style="display:none">                        
                   </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Nombre</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="name_cheque" placeholder="Nombre a quien se le entrega el cheque">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Monto</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="monto_cheque" placeholder="$1000">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Folio cheque</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="folio_cheque" placeholder="ABC-00001">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveInfoCheque()">Save changes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"> 
    saveInfoCheque = function()
    {  
        var folio_cliente   = $('#folio_cliente').val();
        var id_cliente      = $('#id_cliente').val();

        var nombre_cheque   = $('#name_cheque').val();
        var monto_cheque    = $('#monto_cheque').val();
        var folio_cheque    = $('#folio_cheque').val();

        var comision_cliente    = $("#comision_cliente").val();

        var tipo_retorno    = "cheque";

        if( monto_cheque.length == 0 || nombre_cheque.length == 0)
        {
            $('#error-cheque').show();
            $('#error-cheque').html('Todos los campos son requeridos');
            return false;
        }else{
            $('#error-cheque').hide();
        }
    /* Fin de validaciones*/    
        var dataPost ='id_cliente='+id_cliente+'&folio_cliente='+folio_cliente+'&tipo_retorno='+tipo_retorno+'&nombre='+nombre_cheque+'&monto='+monto_cheque+'&parametro='+folio_cheque+'&comision_cliente='+comision_cliente;

        $.ajax({
              type:'POST',
              dataType:'json',
              url:"<?=base_url('/cuentas/formato_retorno/keepDataForma')?>",
              data: dataPost,
              success: function(data){
                
                if(data.success == 'true')
                {   
                    var html = '';
                        html+= "<tr id='forma_id_'>";
                        html += "<td>Cheque a nombre de "+nombre_cheque+"</td>"
                        html += "<td>"+monto_cheque+"</td>";
                        html += "<td class='text-center'><a onclick='edit_retorno("+data.forma_id+")' style='cursor:pointer'><i class='icon-edit bigger-160'></i></a></td>";
                        html += "<td class='text-center'><a onclick='delete_retorno("+data.forma_id+")' style='cursor:pointer'><i class='icon-trash bigger-160'></i></a></td>";
                        html += "<td></td>";
                        html+= "</tr>";

                        //console.log(data.total_monto[0].monto );
                    $('#lista-retornos').append(html);
                    $('#sobrante-agente').html(data.total_depositos_sobrante);

                    $("#total-formato-retorno").html(data.total_formato);

                    $('#name_cheque').val('');
                    $('#monto_cheque').val('');
                    $('#folio_cheque').val('');
                    
                    $('#error-cheque').hide();
                    $('#modalCheque').modal('hide');
                }else{
                    $('#error-cheque').show();
                    $('#error-cheque').html(data.txtAlert);
                }
                    
              }
            })

    }


</script>
