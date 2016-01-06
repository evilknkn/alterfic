<div class="modal fade" id="modalSpei" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Datos de Spei</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="alert alert-danger text-center" id="error-spei" style="display:none">                        
                    </div>
                    <div class="form-group">
                        <label class="label-control col-xs-4">Nombre</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="name_spei" placeholder="Nombre a quien se tranfiere">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Monto</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="monto_spei" placeholder="$1000">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="label-control col-xs-4">Clabe interbancaria</label>
                        <div class="col-xs-8">
                            <input class="form-control" type="text" id="folio_spei" placeholder="12345678900001">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveInfoSpei()">Save changes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

