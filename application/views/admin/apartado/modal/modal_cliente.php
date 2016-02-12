<div class="modal fade" id="modalAsignaCliente" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="apartadoGeneralCtrl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="title-modal"> </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                   <div class="alert alert-danger text-center" id="error-cheque" style="display:none">                        
                   </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Clientes</label>
                        <div class="col-xs-8">
                            <input  id="id_depto" type="hidden">
                            <select id="id_cliente">
                                <option value="">- Seleccione un cliente -</option>
                                <?php foreach($lista_clientes as $cliente):?>
                                    <option value="<?=$cliente->id_cliente?>"> <?=$cliente->nombre_cliente?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveAsignaCliente()">Asignar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    function saveAsignaCliente(){
        var path = "<?= $this->uri->segment(3);?>"
        var _url = "/ws/apartados/asignar_deposito";
        var _idDeposito = $("#id_depto").val();
        var _idCliente  = $("#id_cliente").val();
        var dataPost = { id_deposito: _idDeposito, id_cliente: _idCliente };
      
        $.ajax({
                  type:'POST',
                  dataType:'json',
                  url:_url,
                  data: dataPost,
                  success: function(data){
                    if(data.success == 'true' && path =='pendiente_asignar'){
                        $("#deposito_"+_idDeposito).remove();
                        $('#id_cliente').val('');
                        $('#modalAsignaCliente').modal('hide');
                    }
                  }
              });
    }


     
</script>