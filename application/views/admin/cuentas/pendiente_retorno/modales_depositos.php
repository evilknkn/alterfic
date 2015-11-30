<link rel="stylesheet" href="<?=base_url('assets/css/fileuploader.css');?>" />
<script src="<?=base_url('assets/js/fileuploader.js');?>"></script>


<div class="modal fade" id="modalPagos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Pagos</h4>
            </div>

            <input type="hidden" id="id_empresa"  value="">
            <input type="hidden" id="id_banco"    value="">
            <input type="hidden" id="deposito_id" value="">

            <div class="modal-body">
                <div id="table-pays">
                    <div id="error" class="alert alert-danger" style="display:none">
                        No se ha asignado cliente a este depósito
                    </div>

                    <table>
                        <tr>
                            <td width="150">Déposito</td>
                            <td>$<span id="deposito"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Comisión</td>
                            <td>$<span id="comision"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Monto a retornar</td>
                            <td>$<span id="retornar"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Total retornado</td>
                            <td>$<span id="retornado"></span></td>
                        </tr>
                        <tr>
                            <td width="150">Pendiente de retorno</td>
                            <td>$<span id="pendiente"></span></td>
                        </tr>
                    </table>
                    <br><br>
                    <table class="table tile">
                        <thead>
                            <tr>
                                <th class="text-center" >Pago</th>
                                <th class="text-center" >Monto</th>
                                <th class="text-center" >Fecha</th>
                                <th class="text-center" >Comprobante</th>
                                <th class="text-center" >Detalle</th>
                                <th class="text-center">Borrar</th>
                            </tr>
                        </thead>
                        <tbody id="res_pagos">
                        </tbody>
                        
                    </table>
                </div> 

                <div id="add-pay" style="display:none">
                    <form class="form-horizontal">

                        <div class="form-group">
                            <label class="control-label col-sm-4"> Monto </label>
                            <div class="col-sm-8">
                                <input type="text" name="monto" id="monto">
                                <label class="text-danger" id="fail_monto" style="display:none">*Este campo es requerido</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 col-xs-4"> Empresa retorno</label>
                            <div class="col-sm-8 col-xs-8">
                                    <select class="form-control" name="empresa_retorno" id="empresa_retorno"  >
                                        <option value=""> Seleccione un cliente</option>
                                        
                                    </select>
                               <label class="text-danger" id="fail_empresa_retorno" style="display:none">*Este campo es requerido</label>
                            </div>
                        </div>


                        <div class="form-group" id="list_banks">
                            <label class="control-label col-sm-4 col-xs-4"> Banco</label>
                            <div class="col-sm-8 col-xs-8">
                                <select class="form-control" name="id_banco_option" id="id_banco_option" > 
                                    <option value = "">Seleccione un banco</option>
                                </select>
                                <label class="text-danger" id="fail_banco_retorno" style="display:none">*Este campo es requerido</label>

                            </div>
                        </div>

                        <div class="form-group" id="folio_pago">
                            <label class="control-label col-sm-4 col-xs-4"> Folio</label>
                            <div class="col-sm-8 col-xs-8">
                                <div class="col-sm-5 col-xs-5">
                                   <input type="text" class="form-control" name="folio_pago"  id="folio_pago_retorno" >
                                   <a onclick="validate_unique_folio()" class="btn btn-primary"> Validar folio</a>
                                </div>
                                <label class="text-danger" id="fail_folio_pago" style="display:none">*Este campo es requerido</label>
                                <label class="text-danger" id="fail_folio_pago_existe" style="display:none"><div id="message_fail">*</div></label> 
                                <label class="text-success" id="success_folio_pago" style="display:none">*Este folio es válido</label> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 col-xs-4"> Fecha pago</label>
                            <div class="input-group col-sm-5 col-xs-5">
                                <input class="form-control date-picker input-large" id="id-date-picker-1" name="fecha_pago" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_pago')?>"  placeholder="dd/mm/aaaa"/>
                                <span class="input-group-addon">
                                <i class="icon-calendar bigger-110"></i>
                                </span>                                
                            </div>
                            <label class="control-label col-sm-4 col-xs-4">&nbsp;</label>
                            <label class="text-danger" id="fail_fecha" style="display:none">*Este campo es requerido</label>
                        </div>

                        <div class="form-group">
                          <label class="control-label col-sm-4 col-xs-4"> Adjuntar comprobante</label>
                          <div class="col-sm-8 col-xs-8">
                              <div class="col-sm-12 col-xs-12">
                                  <input type="hidden" name="ruta_comprobante" id="ruta_comprobante" value="<?=set_value('ruta_comprobante')?>" >
                                  <div id="upload_comprobante" >Clic para cargar</div>
                                  El formato de la imagen debe ser PDF, PNG o JPG con un tamaño maximo de 4 MB.
                                  <br>
                                  <label class="text-danger" id="fail_archivo" style="display:none">*Este campo es requerido</label>
                              </div>
                              <div class="col-sm-12 col-xs-12">&nbsp;</div>
                              <div class="col-sm-6 col-xs-6"><?=form_error('ruta_comprobante')?></div>
                          </div>
                          
                      </div>

                       <script type="text/javascript">
                           var uploader = new qq.FileUploader({
                            element: document.getElementById('upload_comprobante'),
                            action: '<?php print base_url("archivos/subir_archivo");?>',
                            multiple: false,
                            params: { carpeta : 'comprobantes_pago', extension : 'pdf|jpg|png' },
                            // events         
                            // you can return false to abort submit
                            onSubmit: function(id, fileName){
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('');
                            },
                            onProgress: function(id, fileName, loaded, total){

                              },
                            onComplete: function  (id, fileName, responseJSON){
                            if(responseJSON.error == null) {
                            $("#ruta_comprobante").val(responseJSON.directory);
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('<li><div class="alert alert-success" id="success_file">Archivo cargado exitosamente.<a href="<?php print base_url();?>'+responseJSON.directory+
                            '" target="_blank"> Ver archivo cargado </div></a></li>');
                            } else {
                            $("#ruta_comprobante").val('');
                            $("#upload_comprobante .qq-uploader .qq-upload-list").html('<li><div class="alert alert-danger" id="fail_file">'+responseJSON.error+'</div></li>');
                            }
                            },
                            onCancel: function(id, fileName){

                            },
                              debug: false
                            });
                        </script>
                        
                        <div class="row text-center text-danger" style="display:none" id="fail_depositos_array">
                            *Debe seleccionar al menos un depósito
                        </div>

                        <div class="row text-center text-danger" style="display:none" id="fail_depositos_array_folio">
                            *No puedes ingresar más de un pago en este tipo de movimiento
                        </div>

                        <div class="row text-center " style = "margin-bottom:15px" >
                            Total a pagar $ <input type="text" id="monto_pagar" value="0" disabled>
                        </div>

                        <table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Folio</th>
                                    <th>Depósito</th>
                                    <th>Comisión</th>
                                    <th>Pendiente</th>
                                </tr>
                            </thead>
                            <tbody id="pendientes_retornar"></tbody>
                        </table>

                        <div class="row text-center " style = "margin-top:15px" >
                            Total a pagar $ <input type="text" id="monto_pagar_bottom" value="0" disabled>
                        </div>
                    </form>
                </div>   

            </div>
            
            <div class="modal-footer">
                <?php if($this->session->userdata('ID_PERFIL') !=1  ): ?>
                    <?php if($this->session->userdata('ID_PERFIL') !=5  ): ?>
                        <div id="button-list-pays">
                            <a id="show-add-pay" class="btn btn-info" >Agregar pago</a>
                            <button type="button" class="btn btn-grey" data-dismiss="modal">Cerrar</button>
                        </div>
                    <?php endif;?>
                <?php endif;?>
                <div id="button-add-pay" style="display:none">
                    <a id="pay-bill" class="btn btn-info" >Guardar</a>
                    <button type="button" class="btn btn-grey" id="cancel-pay">Cancelar</button>
                </div>

            </div>
        </div>
    </div>
</div>
<?=$this->load->view('admin/cuentas/pendiente_retorno/javascript_pagos')?>
