<div class="modal fade" id="modalCheque" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Datos del cheque</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">

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

        console.log(folio_cheque);
        $('#forma-retorno').val('');
        if(folio_cheque == '' || monto_cheque ==  '' || nombre_cheque == '')
        {
            console.log('falta el campo');
        }
        return false;
        var dataPost ='id_cliente='+id_cliente+'&folio_cliente='+folio_cliente+'&id_deposito='+id_deposito+'&tipo_retorno=cheque&nombre='+nombre_cheque+'&monto='+monto_cheque+'&parametro='+folio_banco;

        $.ajax({
              type:'POST',
              dataType:'json',
              url:"<?=base_url('/cuentas/formato_retorno/keepDataForma')?>",
              data: dataPost,
              success: function(data){
                console.log(data);
                var html = '';
                    html+= "<tr id='forma_id_'>";
                    html += "<td>Cheque a nombre de "+nombre_cheque+"</td>"
                    html += "<td></td>"
                    html += "<td></td>"
                    html += "<td></td>"
                    html+= "</tr>";
                $('#lista-retornos').append(html);
                $('#name_cheque').val('');
                $('#monto_cheque').val('');
                $('#folio_cheque').val('');
              }
            })

// $('#').val('');
//         name_cheque
//         monto_cheque
//         folio_cheque
    }
</script>
