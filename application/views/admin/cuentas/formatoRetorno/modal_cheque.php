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
                        <label class="label-control col-xs-4">Folio</label>
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
        var id_deposito     = $('#id_deposito').val();
        var id_cliente      = $('#id_cliente').val();
        var nombre_cheque   = $('#name_cheque').val();
        var monto_cheque    = $('#monto_cheque').val();
        var folio_cheque     = $('#folio_cheque').val();

        var monto_retornar  = $('#monto_a_retornar').val();
        //console.log('el monto a retornar es '+ (monto_retornar)+' el monto del cheque es: '+monto_cheque );
        var total_retornado_all = $('#inputTotal_retornado').val();
        console.log(total_retornado_all);

        // if(monto_cheque > monto_retornar)
        // {
        //     //console.log('el monto es superior');
        //     $('#error-cheque').show();
        //     $('#error-cheque').html('El monto es mayor al de retornar');
        //     return false;
        // }else{
        //     $('#error-cheque').hide();
        // }
        
        
        $('#forma-retorno').val('');
        if(folio_cheque == '' || monto_cheque ==  '' || nombre_cheque == '')
        {
            $('#error-cheque').show();
            $('#error-cheque').html('Todos loscampos son requeridos');
            return false;
        }else{
            $('#error-cheque').hide();
        }
    /* Fin de validaciones*/    
        var dataPost ='id_cliente='+id_cliente+'&folio_cliente='+folio_cliente+'&id_deposito='+id_deposito+'&tipo_retorno=cheque&nombre='+nombre_cheque+'&monto='+monto_cheque+'&parametro='+folio_cheque+'&total_retornado='+total_retornado_all+'&monto_retornar='+monto_retornar;

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
                        html += "<td></td>";
                        html += "<td></td>";
                        html += "<td></td>";
                        html+= "</tr>";

                        //console.log(data.total_monto[0].monto );
                    if(data.total_monto == monto_retornar  || data.total_movimientos == 10)
                    {
                         $('#option-retorno').css('display','none');
                    }
                    
                    $('#lista-retornos').append(html);
                    $('#name_cheque').val('');
                    $('#monto_cheque').val('');
                    $('#folio_cheque').val('');

                    $('#total_retornado').html(data.total_monto);
                    $('#inputTotal_retornado').val(data.total_monto);
                    var resta_retornado = parseFloat(monto_retornar) - parseFloat(data.total_monto);
                    console.log('resultado de la resta ' +resta_retornado);
                    $('#monto_a_retornar').val(resta_retornado);
                    
                    $('#error-cheque').hide();
                    $('#modalCheque').modal('hide');
                }else{
                    console.log(data.txtAlert);
                }
                    
              }
            })

    }


</script>
