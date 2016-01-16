<div class="modal fade" id="modalEfectivo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Datos de efectivo</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                   <div class="alert alert-danger text-center" id="error-efectivo" style="display:none">                        
                   </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Nombre</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="name_efectivo" placeholder="Nombre a quien se le entrega el efectivo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Monto</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="monto_efectivo" placeholder="$1000">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveInfoEfectivo()">Save changes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript"> 
    function saveInfoEfectivo(){

        var folio_cliente   = $('#folio_cliente').val();
        var id_cliente      = $('#id_cliente').val();

        var nombre_efectivo   = $('#name_efectivo').val();
        var monto_efectivo    = $('#monto_efectivo').val();

        var comision_cliente    = $("#comision_cliente").val();

        var tipo_retorno    = "efectivo";

        if( nombre_efectivo.length == 0 || monto_efectivo.length == 0)
        {
            $('#error-efectivo').show();
            $('#error-efectivo').html('Todos los campos son requeridos');
            return false;
        }else{
            $('#error-efectivo').hide();
        }

        var dataPost ='id_cliente='+id_cliente+'&folio_cliente='+folio_cliente+'&tipo_retorno='+tipo_retorno+'&nombre='+nombre_efectivo+'&monto='+monto_efectivo+'&comision_cliente='+comision_cliente;

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
                        html += "<td>Efectivo a nombre de "+nombre_efectivo+"</td>"
                        html += "<td>"+monto_efectivo+"</td>";
                        html += "<td class='text-center'><a onclick='edit_retorno("+data.forma_id+")' style='cursor:pointer'><i class='icon-edit bigger-160'></i></a></td>";
                        html += "<td class='text-center'><a onclick='delete_retorno("+data.forma_id+")' style='cursor:pointer'><i class='icon-trash bigger-160'></i></a></td>";
                        
                        html+= "</tr>";

                        //console.log(data.total_monto[0].monto );
                    $('#lista-retornos').append(html);
                    $('#sobrante-agente').html(data.total_depositos_sobrante);

                    $("#total-formato-retorno").html(data.total_formato);

                    $('#name_efectivo').val('');
                    $('#monto_efectivo').val('');
                    
                    $('#error-efectivo').hide();
                    $('#modalEfectivo').modal('hide');
                }else{
                    $('#error-efectivo').show();
                    $('#error-efectivo').html(data.txtAlert);
                }
                    
              }
            })
    }
</script>