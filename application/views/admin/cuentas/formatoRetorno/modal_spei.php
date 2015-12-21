<div class="modal fade" id="modalSpei" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Datos de Spei</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    
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
                            <input class="form-control" type="text" id="folio_spei" placeholder="12345678900001">
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
        var id_deposito     = $('#id_deposito').val();
        var id_cliente      = $('#id_cliente').val();
        var name_spei       = $('#name_spei').val();
        var monto_spei      = $('#monto_spei').val();
        var folio_spei      = $('#folio_spei').val();

        console.log(folio_spei);
        $('#forma-retorno').val('');
        if(name_spei == '' || monto_spei ==  '' || folio_spei == '')
        {
            console.log('falta el campo');
        }
    
        var dataPost ='id_cliente='+id_cliente+'&folio_cliente='+folio_cliente+'&id_deposito='+id_deposito+'&tipo_retorno=spei&nombre='+name_spei+'&monto='+monto_spei+'&parametro='+folio_spei;

        $.ajax({
              type:'POST',
              dataType:'json',
              url:"<?=base_url('/cuentas/formato_retorno/keepDataForma')?>",
              data: dataPost,
              success: function(data){
                console.log(data);
                var html = '';
                    html+= "<tr id='forma_id_'>";
                    html += "<td>Cheque a nombre de "+name_spei+"</td>"
                    html += "<td>"+monto_spei+"</td>";
                    html += "<td></td>";
                    html += "<td></td>";
                    html += "<td></td>";
                    html+= "</tr>";
                $('#lista-retornos').append(html);
                $('#name_cheque').val('');
                $('#monto_cheque').val('');
                $('#folio_cheque').val('');
                $('#modalSpei').modal('hide');
              }
            })

// $('#').val('');
//         name_cheque
//         monto_cheque
//         folio_cheque
    }
</script>