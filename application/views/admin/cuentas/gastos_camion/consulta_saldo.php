<div class="modal fade" id="modalSaldosPorMes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Saldo de gastos de camión </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="form-group">
                             <?php $mes_txt = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');  ?>
                            <div class="col-md-5 text-center">
                                <label>Mes</label>
                            
                                <select id="mes">
                                    <option>-Seleccione un mes-</option>
                                    <?php for($i = 1 ;  $i<=12 ;$i++){ ?>
                                        <option value="<?php echo $i; ?>" <?=(date('m')== $i)? 'selected=selected': '';?>><?php echo $mes_txt[$i -1];?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="col-md-5 text-center">
                                <?php   $ini = date('Y'); 
                                        $fin = $ini - 5; ?>
                                <label>Año</label>
                                <select id="year">
                                    <option>-Seleccione un año-</option>
                                    <?php for($i = $fin ;  $i<=$ini ;$i++){ ?>
                                        <option value="<?php echo $i; ?>" <?=(date('Y')== $i)? 'selected=selected': '';?> ><?php echo $i; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="generar-resultado"><i class="fa fa-eye"></i> Ver</button>
                            </div>

                        </div>

                    </div>
                </div>
                <br/>
                <br/>
                <div class="row col-md-offset-1">
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
                            <tr>
                                <td width="40%">Saldo disponible </td>
                                <td width="60%" id="saldo-disponible"> </td>
                            </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#generar-resultado').click(function(){

         $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url("cuentas/gastos_camion/saldo_gasto_camion")?>',
            data: "mes=" + $('#mes').val() + "&ano="+ $('#year').val() , 
            success: function(data)
            {   
               $('#total-deposito').html('$'+data[0].deposito);
               $('#total-salida').html('$'+data[0].salida);
               $('#total-saldo').html('$'+data[0].saldo);
               $('#saldo-disponible').html('$'+data[0].saldo_disponible);

            }
          });//fin accion ajax
    });

    $(document).ready(function(){
         $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url("cuentas/gastos_camion/saldo_gasto_camion")?>',
            data: "mes=" + $('#mes').val() + "&ano="+ $('#year').val() , 
            success: function(data)
            {   
               $('#total-deposito').html('$'+data[0].deposito);
               $('#total-salida').html('$'+data[0].salida);
               $('#total-saldo').html('$'+data[0].saldo);
               $('#saldo-disponible').html('$'+data[0].saldo_disponible);
            }
          });//fin accion ajax
    })
</script>