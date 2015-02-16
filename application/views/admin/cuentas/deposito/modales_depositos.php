
<script type="text/javascript">
function pagos(id_empresa, id_banco, id_deposito)
{
    var url_pago = 'cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito;
    $('#agregar_pago').attr({'href': '<?=base_url()?>cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito});

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
            <div class="modal-body">
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
            <div class="modal-footer">
                <a id="agregar_pago" class="btn btn-info" >Agregar pago</a>
                <button type="button" class="btn btn-grey" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function pagos_detalle(id_empresa, id_banco, id_deposito)
{
    var url_pago = 'cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito;
    $('#agregar_pago').attr({'href': '<?=base_url()?>cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito});

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

<div class="modal fade" id="modalPagosDetalle" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Detalle salida</h4>
            </div>
            <div class="modal-body">
                <div id="error" class="alert alert-danger" style="display:none">
                    No se ha asignado cliente a este depósito
                </div>

                <table>
                    <tr>
                        <td width="150">Déposito</td>
                        <td>$<span id="deposito_detalle"></span></td>
                    </tr>
                    <tr>
                        <td width="150">Comisión</td>
                        <td>$<span id="comision_detalle"></span></td>
                    </tr>
                    <tr>
                        <td width="150">Monto a retornar</td>
                        <td>$<span id="retornar_detalle"></span></td>
                    </tr>
                    <tr>
                        <td width="150">Total retornado</td>
                        <td>$<span id="retornado_detalle"></span></td>
                    </tr>
                    <tr>
                        <td width="150">Pendiente de retorno</td>
                        <td>$<span id="pendiente_detalle"></span></td>
                    </tr>
                </table>
                <br><br>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
function abre_ventana(id_pago){
window.open("<?=base_url()?>cuentas/pagos/detalle_pago/"+ id_pago,"","width=600,height=450,toolbar=no,scrollbars=yes");
    
}
</script>