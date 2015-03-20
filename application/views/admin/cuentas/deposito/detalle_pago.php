<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">

        <meta name="description" content="Violate Responsive Admin Template">
        <meta name="keywords" content="Super Admin, Admin, Template, Bootstrap">

        <title>ALTERFISC</title>
            
        <?=$this->load->view('includes/head')?>
    </head>
    <body id="skin-tectile">

        
        
        <div class="clearfix"></div>
        
        <section id="main" class="p-relative" role="main">
            
           
        
            <!-- Contentenido pagina media -->
            <section id="content" class="container">
            <?php //$this->load->view($body)?>
            <?php if($this->session->flashdata('success')):?>
            <div class="row">
                <div class="text-center col-sm-12 col-xs-12">
                    <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                </div>
            </div>
            <?php endif;?>
            <div class="col-xs-12 col-sm-12" style ="margin:10px">
            <?=form_open('', array('class' => 'form-horizontal'))?> 
                <div class="form-group">
                    <label class="control-label col-sm-4 col-xs-4"> Folio</label>
                    <div class="col-sm-8 col-xs-8">
                        <div class="col-sm-5 col-xs-5">
                           <input type="text" class="form-control" name="folio_pago" value="<?=$pago->folio_pago?>"  >
                           <input type="hidden"   name="id_detalle" value="<?=$pago->id_detalle?>">
                        </div>
                        <div class="col-sm12 col-xs-12">&nbsp;</div>
                        <div class="col-sm5 col-xs-5"><?=form_error('folio_pago')?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 col-xs-4"> Monto</label>
                    <div class="col-sm-8 col-xs-8">
                        <div class="col-sm-5 col-xs-5">
                            <input type="text" name="monto" class="form-control" value="<?=$pago->monto_pago?>"  >
                        </div>
                        <div class="col-sm12 col-xs-12">&nbsp;</div>
                        <div class="col-sm5 col-xs-5"><?=form_error('monto')?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 col-xs-4"> Empresa retorno</label>
                    <div class="col-sm-8 col-xs-8">
                        <div class="col-sm-5 col-xs-5">
                            <select class="form-control" name="empresa_retorno" id="empresa_retorno"  >
                                <option value=""> Seleccione un cliente</option>
                                <?php foreach($empresas as $empresa):?>
                                    <option value="<?=$empresa->id_empresa?>" <?=($empresa->id_empresa == $pago->empresa_retorno)? 'selected=selected':'';?> ><?=$empresa->nombre_empresa;?> </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="col-sm12 col-xs-12">&nbsp;</div>
                        <div class="col-sm5 col-xs-5"><?=form_error('empresa_retorno')?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 col-xs-4"> Banco</label>
                    <div class="col-sm-8 col-xs-8">
                        <div class="col-sm-5 col-xs-5">
                            <select class="form-control" name="id_banco" id="id_banco"  > 
                                <option value = "">Seleccione un banco</option>
                            </select>
                        </div>
                        <div class="col-sm12 col-xs-12">&nbsp;</div>
                        <div class="col-sm5 col-xs-5"><?=form_error('id_banco')?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 col-xs-4"> Fecha pago</label>
                    <div class="col-sm-8 col-xs-8">
                        <div class="col-sm-5 col-xs-5">
                            <div class="input-icon datetime-pick date-only">
                                <div class="input-group">
                                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_pago" required type="text" data-date-format="dd-mm-yyyy" value="<?=formato_fecha_ddmmaaaa($pago->fecha_pago)?>"  placeholder="dd/mm/aaaa"/>
                                    <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm12 col-xs-12">&nbsp;</div>
                        <div class="col-sm5 col-xs-5"><?=form_error('fecha_pago')?></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4 col-xs-4"> Archivo de comprobante</label>
                        <div class="fileupload fileupload-new col-sm-8 col-xs-8" data-provides="fileupload">
                            <div class="col-sm-6 col-xs-6 col-lg-6">
                                <div class="alert text-success">
                                    <p>Para ver la imagen adjunta haga clic <a href="<?=base_url($pago->ruta_comprobante)?>" style="color:blue" target="_blank">aquí</a>.</p>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="text-center">
                    <button class="btn btn-primary  "><i class="fa fa-save"></i> Guardar</button>
                </div>
            <?=form_close()?>
            </section>
            </div>

            <SCRIPT TYPE="text/javascript">
            $(document).ready(function(){
                var empresa = $('#empresa_retorno').val();
                $.ajax({
                        type: "POST",
                        datatype: 'html',
                        url: '<?php echo base_url("cuentas/movimientos_internos/bancos_empresa")?>',
                        data: "id_empresa=" + empresa + "&id_banco=" + <?=$pago->id_banco;?> , 
                        success: function(data)
                        {
                             $("#id_banco").html(data);
                        }
                      });//fin accion ajax
            });

            // $('#empresa_retorno').change(function(){
            //     var empresa = $('#empresa_retorno').val();
            //     $.ajax({
            //             type: "POST",
            //             datatype: 'html',
            //             url: '<?php echo base_url("cuentas/depositos/bancos_empresa")?>',
            //             data: "id_empresa=" + empresa , 
            //             success: function(data)
            //             {
            //                  $("#id_banco").html(data);
            //             }
            //           });//fin accion ajax
            // });
            $('#empresa_retorno').change(function(){
                var empresa = $('#empresa_retorno').val();
                var id_banco = $('#banco_hidden').val();
                $.ajax({
                        type: "POST",
                        datatype: 'html',
                        url: '<?php echo base_url("cuentas/depositos/bancos_empresa")?>',
                        data: "id_empresa=" + empresa + "&id_banco=" + <?=$pago->id_banco;?>  , 
                        success: function(data)
                        {
                             $("#id_banco").html(data);
                        }
                      });//fin accion ajax
            }); 
            </SCRIPT>
            
        </section>
        <?=$this->load->view('includes/scripts')?>
    </body>
</html>
