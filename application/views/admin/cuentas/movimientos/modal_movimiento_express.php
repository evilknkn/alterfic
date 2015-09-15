<div class="modal fade" id="modalMovimientoExpress" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nuevo movimiento interno</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4" > Folio salida</label>
                        <div class="col-sm-8 col-xs-8">
                            <input type="text" id="folio_salida" name="folio_salida" >
                        </div>
                        <div class="col-sm-5 col-xs-5"><?=form_error('folio_salida')?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4" > Folio entrada</label>
                        <div class="col-sm-8 col-xs-8">
                            <input type="text" id="folio_entrada" name="folio_entrada" >
                        </div>
                        <div class="col-sm-5 col-xs-5"><?=form_error('folio_entrada')?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4 col-xs-4" > Monto</label>
                        <div class="col-sm-8 col-xs-8">
                            <input type="text" id="monto" name="monto" >
                        </div>
                        <div class="col-sm-5 col-xs-5"><?=form_error('monto')?></div>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <a id="show-add-pay" class="btn btn-info" >Guardar</a>
                <button type="button" class="btn btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>