<div class="modal fade" id="modalAsignaCliente" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="apartadoGeneralCtrl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Asignación de cliente al folio {{folioDeposito}} </h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                   <div class="alert alert-danger text-center" id="error-cheque" style="display:none">                        
                   </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Clientes</label>
                        <div class="col-xs-8">
                            <select ng-model="param.id_cliente">
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
                <button type="button" class="btn btn-primary" ng-click="asignaCliente(param)">Asignar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('#modalAsignaCliente').on('show.bs.modal', function (e) {
  // do something...
  console.log('abrimos la modal');
})
    
</script>