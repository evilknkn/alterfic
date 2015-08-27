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
               console.log(data);
               
               var html = '';
               console.log(data.length);
                for(var i = 0; i < data.length; i++){
                    
                    html += "<tr>";
                    html += "<th></th><th>"+ data[i].nombre_banco+"</th>";
                    html += "</tr>";
                }
               
                $("#show-bancos").html('chile');


            }
          });//fin accion ajax
}
</script>

<div class="modal fade" id="bancos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Bancos</h4>
            </div>
            <div class="modal-body">
               <table border="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Banco</th>
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