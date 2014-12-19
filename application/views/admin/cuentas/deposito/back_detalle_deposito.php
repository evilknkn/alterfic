<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li><a href="<?=base_url('cuentas/depositos')?>">Lista de depósitos</a></li>
   	<li>Detalle de depósito</li>
</ol>


<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Lista de depósitos</h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>
    <div class="clearfix"></div>
    <a href="<?=base_url('cuentas/depositos/insert_deposito/'.$id_empresa.'/'.$empresa->id_banco)?>" class="btn"> <i class="fa fa-plus"></i> Agregar depósito</a>
    <a href="<?=base_url('cuentas/salida/insertar_salida/'.$id_empresa.'/'.$empresa->id_banco)?>" class="btn"> <i class="fa fa-plus"></i> Agregar Salida</a>
    <br><br>

    <div class="table-responsive overflow">
    	
        <table class="table tile">
            <thead>
            	<tr>
            		<th colspan="7" class="text-center" ><h3> <?=$empresa->nombre_empresa?>/ <?=$empresa->nombre_banco?></h3></th>
            	</tr>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Deposito</th>
                    <th class="text-center">Salida</th>
                    <th class="text-center">Folio</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Retorno</th>
                    <th class="text-center">Detalle</th>
                </tr>
            </thead>
            <!-- <tbody>
            	<?php $total_depto=0;?>
            	<?php if(count($depositos)>0){?>
                   <?php foreach($depositos as $deposito):
                        $total_depto = $total_depto +$deposito->monto_deposito; ?>
                        <tr>
                            <td><?=formato_fecha_ddmmaaaa($deposito->fecha_deposito)?></td>
                            <td class="text-center"><?=$deposito->monto_deposito?></td>
                            <td class="text-center"></td>
                            <td class="text-center"><?=$deposito->folio?></td>
                            <td class="text-center">
                                <select class="form-control" name="cliente_deposito">
                                    <option value=""> Seleccione un cliente</option>
                                    <?php foreach($clientes as $cliente):?>
                                        <option value="<?=$cliente->id_cliente?>"><?=$cliente->nombre_cliente;?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td class="text-center">
                                <a data-toggle="modal" href="#modalPagos" class="btn btn-sm" onclick="pagos(<?=$id_empresa?>,<?=$empresa->id_banco?>, <?=$deposito->id_deposito?>)">Ver Pagos</a>
                            </td>
                            

                            <td></td>
                        </tr>
                    <?php endforeach;?> 

                <?php }else{ ?>
                    <tr>
                        <td colspan="7" class="text-center">-- No hay depositos --</td>
                    </tr>
                <?php }?>
            </tbody> -->
            <tr>
            	<th class="text-right">Total</th>
            	<th class="text-center">$<?=round($total_depto, 2)?></th>
            </tr>
        </table>
    </div>
</div>


<div class="clearfix text-center">
        <a href="<?=base_url('cuentas/depositos')?>" style="margin-left:15px" class="btn"> <i class="fa fa-undo"></i> Regresar</a>
</div>

<script type="text/javascript">
function pagos(id_empresa, id_banco, id_deposito)
{
    var url_pago = 'cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito;
    $('#agregar_pago').attr({'href': '<?=base_url()?>cuentas/depositos/add_pagos/'+id_empresa+'/'+id_banco+'/'+id_deposito});



    $.ajax({
            type: "POST",
            datatype: 'html',
            url: '<?php echo base_url("cuentas/depositos/pagos")?>',
            data: "id_empresa=" + id_empresa + "&id_banco="+ id_banco + "&id_deposito=" + id_deposito, 
            success: function(data)
            {
                 $("#res_pagos").html(data);
            }
          });//fin accion ajax
};
</script>
<div class="modal fade" id="modalPagos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Pagos</h4>
            </div>
            <div class="modal-body">
                
                <table class="table tile">
                    <thead>
                        <tr>
                            <th>Pago</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="res_pagos">
                    </tbody>
                    
                </table>
            </div>
            <div class="modal-footer">
                <a id="agregar_pago" class="btn btn-sm" >Agregar pago</a>
                <button type="button" class="btn btn-sm" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
