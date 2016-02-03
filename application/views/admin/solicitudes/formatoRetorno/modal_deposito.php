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
                <input value="" id="edited_depto" type="hidden">
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
        var id_empresa          = $("#empresa").val();
        var nombre_empresa      = $("#empresa option:selected").html();
        var id_banco            = $("#bancos").val();
        var nombre_banco        = $("#bancos option:selected").html();
        var monto               = $("#monto").val();
        var fecha               = $("#id-date-picker-1").val();
        var comision_cliente    = $("#comision_cliente").val();
        
        var folio_cliente       = $("#folio_cliente").val();

        var active_edition      = $("#edited_depto").val(); 
       

        if(id_empresa.length ==0 || id_banco.length == 0 || monto.length ==0 || fecha.length==0){
            $("#errorDeposito").show();
            return false;
        }
        else{
            $("#errorDeposito").hide();

            if(active_edition != ''){
                var post_url = '<?php echo base_url("cuentas/formato_retorno/edicion_deposito")?>';
                var sentData = 'id_empresa='+id_empresa+'&id_banco='+id_banco+'&monto='+monto+'&fecha='+fecha+'&folio_cliente='+folio_cliente+'&comision_cliente='+comision_cliente+'&id_reg='+active_edition;
            }else{
                var post_url = '<?php echo base_url("cuentas/formato_retorno/guardar_deposito")?>';
                var sentData = 'id_empresa='+id_empresa+'&id_banco='+id_banco+'&monto='+monto+'&fecha='+fecha+'&folio_cliente='+folio_cliente+'&comision_cliente='+comision_cliente;
            }
            

            $.ajax({
                type: "POST",
                datatype: 'json',
                url: post_url,
                data: sentData ,
                success: function(data)
                {
                    var html = "";
                        html += "<tr id='deposito_"+data.deposito_id+"'>";
                    
                        html += "<td>"+nombre_empresa;
                        html += "<input value='"+data.deposito_id+"' id='no-deposito-"+data.deposito_id+"' type='hidden' > ";
                        html += "</td>";
                        html += "<td>"+nombre_banco+"</td>";
                        html += "<td>"+monto+"</td>";
                        html += "<td>"+fecha+"</td>";
                        html += "<td class='text-center'><a onclick='edit_deposito("+data.deposito_id+")' style='cursor:pointer'><i class='icon-edit bigger-160'></i></a></td>";
                        html += "<td class='text-center'><a onclick='delete_deposito("+data.deposito_id+")' style='cursor:pointer'><i class='icon-trash bigger-160'></i></a></td>";
                        html += "</tr>";

                    if(data.success == 'edited'){
                        $("#deposito_"+data.deposito_id).remove();
                        $('#lista-depositos').append(html);
                    }else{
                        $('#lista-depositos').append(html);
                    }
                    
                    
                    $('#th-total-depositos').html(data.total_depositos);
                    $('#comision-empresa').html(data.comision);
                    $('#sobrante-agente').html(data.total_depositos_sobrante);

                    $('#empresa').val('');
                    $('#bancos').val('');
                    $('#monto').val('');
                    $("#id-date-picker-1").val('');

                    $('#modalDeposito').modal('hide');
                    
                }
              });//fin accion ajax
        }
   });

    function delete_deposito(deposito_id){
        var id = deposito_id;
        var comision_cliente    = $("#comision_cliente").val();
        var folio_cliente       = $('#folio_cliente').val();
        

        $.ajax({
                type: "POST",
                datatype: 'json',
                url: '<?php echo base_url("cuentas/formato_retorno/delete_deposito")?>',
                data: "deposito_id=" + id +'&comision_cliente='+comision_cliente+'&folio_cliente='+folio_cliente,
                success: function(data)
                {   
                    $("#deposito_"+id).remove();

                    $('#th-total-depositos').html(data.total_depositos);
                    $('#comision-empresa').html(data.comision);
                    $('#sobrante-agente').html(data.total_depositos_sobrante);

                    $('#empresa').val('');
                    $('#bancos').val('');
                    $('#monto').val('');
                    $("#id-date-picker-1").val('');

                    $('#modalDeposito').modal('hide');

                }
              });//fin accion ajax
    }

    function edit_deposito(deposito_id){
        $('#modalDeposito').modal('show');
        $.ajax({
                type: "POST",
                datatype: 'json',
                url: '<?php echo base_url("cuentas/formato_retorno/data_deposito")?>',
                data: "deposito_id=" + deposito_id ,
                success: function(data)
                {   
                    console.log(data);
                    $("#empresa [value='"+data.empresa+"']").attr('selected','selected');
                    $("#bancos [value='"+data.banco+"']").attr('selected','selected');
                    //$( "#empresa option:selected" ).text(data.empresa).attr('selected', 'selected');
                    //$( "#bancos option:selected" ).text(data.banco).attr('selected', 'selected');
                    $("#monto").val(data.monto_depto);
                    $("#id-date-picker-1").val(data.fecha);

                    $("#edited_depto").val(data.id_reg);
                }
              });//fin accion ajax
    }

</script>
