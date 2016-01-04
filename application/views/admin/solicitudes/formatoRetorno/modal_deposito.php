<div class="modal fade" id="modalDeposito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" >Depósitos</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger text-center" style="display:none" id="errorDeposito"> Todos los datos son requeridos </div>
        <div class="form-horizontal">            
            <div class="form-group">
                <label class="label-control col-xs-2">Empresa</label>
                <select id="empresa" onchange="BancosEmpresa(this.value)">
                    <option value="">- Selecciona una empresa -</option>
                    <?php foreach($empresas as $empresa):?>
                        <option value="<?=$empresa->id_empresa?>"> <?=$empresa->nombre_empresa?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="form-group">
                <label class="label-control col-xs-2">Banco</label>
                <select id="bancos">
                    <option value="">- Selecciona un banco -</option>
                </select>
            </div>

            <div class="form-group">
                <label class="label-control col-xs-2">Monto</label>
                <input type="text" id="monto" >
            </div>

            <div class="form-group">
                <label class="label-control col-xs-2">Fecha</label>
                <div class="input-group">
                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_depto" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_pago')?>"  placeholder="dd/mm/aaaa"/>
                    <span class="input-group-addon">
                    <i class="icon-calendar bigger-110"></i>
                    </span>
                </div>
            </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submit_deposito">Save</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function BancosEmpresa(id_empresa){
        $.ajax({
                type: "POST",
                datatype: 'json',
                url: '<?php echo base_url("cuentas/formato_retorno/banco_empresa")?>',
                data: "id_empresa=" + id_empresa ,
                success: function(data)
                {
                    console.log(data.bancos.length);
                    var html = "";
                        html += "<option value=''>- Seleccione un banco -</option>";
                    for(var i=0; i< data.bancos.length ;i++){
                        html += "<option value='"+data.bancos[i].id_banco+"'>"+data.bancos[i].nombre_banco+"</option>";
                    }
                    $("#bancos").html(html);
                }
              });//fin accion ajax
   } 

   $("#submit_deposito").click(function(){
        var id_empresa  = $("#empresa").val();
        var nombre_empresa = $("#empresa option:selected").html();
        var id_banco    = $("#bancos").val();
        var nombre_banco = $("#bancos option:selected").html();
        var monto       = $("#monto").val();
        var fecha       = $("#id-date-picker-1").val();

        var folio_cliente= 'ANG-00001';
        
        
        if(id_empresa.length ==0 || id_banco.length == 0 || monto.length ==0 || fecha.length==0){
            $("#errorDeposito").show();
            return false;
        }
        else{
            $("#errorDeposito").hide();

            var sentData = 'id_empresa='+id_empresa+'&id_banco='+id_banco+'&monto='+monto+'&fecha='+fecha+'&folio_cliente='+folio_cliente;

            $.ajax({
                type: "POST",
                datatype: 'json',
                url: '<?php echo base_url("cuentas/formato_retorno/guardar_deposito")?>',
                data: sentData ,
                success: function(data)
                {
                    console.log(data);
                    var html = "";
                        html += "<tr>";
                    
                        html += "<td>"+nombre_empresa+"</td>";
                        html += "<td>"+nombre_banco+"</td>";
                        html += "<td>"+monto+"</td>";
                        html += "<td>"+fecha+"</td>";
                    
                        html += "</tr>";

                    $('#lista-depositos').append(html);
                    
                }
              });//fin accion ajax

        }
   });
</script>
