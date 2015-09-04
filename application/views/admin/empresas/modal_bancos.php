<script type="text/javascript">
function bancos_empresa(id_empresa)
{
    $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url("catalogos/corps/bancos_empresa")?>',
            data: "id_empresa=" + id_empresa , 
            success: function(data)
            {   
               
               var html = '';
                for(var i = 0; i < data.length; i++){

                    html += "<tr>";
                    html += "<th>"+ data[i].nombre_banco+"</th>";
                    html += "<th><select class='form-control' onchange='change_status_bank("+data[i].id_empresa+","+data[i].id_banco+", this.value )'>"
                    if(data[i].status_banco == 1 ){
                        html += "<option value='1' selected=selected >Activo</option>";
                        html += "<option value='0'>Inactivo</option> </select></th>";
                    }else{
                        html += "<option value='1' >Activo</option>";
                        html +="<option value='0' selected=selected>Inactivo</option> </select></th>";
                    }                    
                    html += "</tr>";
                }
               
                $("#show-bancos").html(html);


            }
          });//fin accion ajax
}

function change_status_bank(id_empresa, id_banco, state){
    //console.log('cambio de id a '+ id_empresa+' '+ id_banco + ' '+ state);

     $.ajax({
            type: "POST",
            dataType: "json",
            url: '<?php echo base_url("catalogos/corps/disabled_bank")?>',
            data: "id_empresa=" + id_empresa + "&id_banco="+id_banco+"&state="+state, 
            success: function(data)
            {   
                $("#success_change").show();
            }
          });//fin accion ajax

}

function close_success(){
    $('#success_change').hide();
}
</script>

<div class="modal fade" id="bancos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Bancos</h4>
            </div>

            <div class="alert alert-block alert-success" id="success_change" style="display:none">
                <button type="button" class="close" onclick="close_success()">
                    <i class="icon-remove"></i>
                </button>

                <i class="icon-ok green"></i>
                Se actualizó correctamente
            </div>

            <div class="modal-body">
               <table border="0" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="70%">Banco</th>
                            <th width="30%">Estatus</th>
                            
                        </tr>
                    </thead>
                    <tbody id="show-bancos"></tbody>
                    
               </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>