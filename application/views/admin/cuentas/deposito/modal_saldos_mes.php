<div class="modal fade" id="modalSaldosPorMes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:1000px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Saldo al mes de <?=buscar_mes_txt(date('m'))?> en la empresa <span id="nombre-empresa"></span> / <span id="nombre-banco"></span></h4>
            </div>
            <div class="modal-body">
               <div class="row">
                        <div class="form-group">
                            <label class="control-label col-sm-2 col-xs-2 no-padding-rigth">Consultar</label>
                            <div class="col-sm-4 col-xs-4">
                                <?php $mes_txt = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');  ?>
                                <div class="input-icon datetime-pick date-only">
                                    <select class="form-control" id="buscar-mes">
                                        <option value="">Mes</option>
                                        <?php for($i = 1 ;  $i<=12 ;$i++){ ?>
                                            <option value="<?php echo $i; ?>" <?=(date('m')== $i)? 'selected=selected': '';?>><?php echo $mes_txt[$i -1];?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div> 
                            <div class="col-sm-4 col-xs-4">
                                <?php   $ini = date('Y'); 
                                        $fin = $ini - 5; ?>
                                <div class="input-icon datetime-pick date-only">
                                    <select class="form-control" id="buscar-year">
                                        <option value="">Año</option>
                                        <?php for($i = $fin ;  $i<=$ini ;$i++){ ?>
                                            <option value="<?php echo $i; ?>" <?=(date('Y')== $i)? 'selected=selected': '';?> ><?php echo $i; ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div> 
                            <input type="hidden" id="id-empresa" class="form-control" value="">
                            <input type="hidden" id="id-banco" class="form-control" value="">
                            <div class="col-sm-2 col-xs-2">
                                <button class="btn" id="ver-resultado"> Ver resultado</button>
                            </div>
                        </div>
                </div>
                <br><br>
                <table width="100%">
                        <tr>
                            <td width="20%">Total depósito</td>
                            <td width="80%" id="total-deposito"> </td>
                        </tr>
                        <tr>
                            <td>Total salida</td>
                            <td id="total-salida"> </td>
                        </tr>
                        <tr>
                            <td>Saldo</td>
                            <td id="total-saldo"> </td>
                        </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function saldoPorMes(id_empresa, id_banco)
{
    $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url("cuentas/saldo/saldoMes")?>',
            data: "id_empresa=" + id_empresa + "&id_banco="+ id_banco , 
            success: function(data)
            {   
               console.log(data);
               $('#nombre-empresa').html(data.empresa.nombre_empresa);
               $('#nombre-banco').html(data.empresa.nombre_banco);
               $('#id-empresa').val(data.empresa.id_empresa);
               $('#id-banco').val(data.empresa.id_banco);
               $('#total-deposito').html('$'+data.total_deposito);
               $('#total-salida').html('$'+data.total_salida);
               $('#total-saldo').html('$'+data.total_saldo);

            }
          });//fin accion ajax
}

$('#ver-resultado').click(function(){
    $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url("cuentas/saldo/saldoMes")?>',
            data: "id_empresa=" + $('#id-empresa').val() + "&id_banco="+ $('#id-banco').val() + '&ano_consulta='+ $('#buscar-year').val() +'&mes_consulta=' + $('#buscar-mes').val(), 
            success: function(data)
            {   
               console.log(data);
               $('#nombre-empresa').html(data.empresa.nombre_empresa);
               $('#nombre-banco').html(data.empresa.nombre_banco);
               $('#id-empresa').val(data.empresa.id_empresa);
               $('#id-banco').val(data.empresa.id_banco);
               $('#total-deposito').html('$'+data.total_deposito);
               $('#total-salida').html('$'+data.total_salida);
               $('#total-saldo').html('$'+data.total_saldo);

            }
          });//fin accion ajax
});
</script>


