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
    <a href="<?=base_url('cuentas/depositos/insert_deposito/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn"> <i class="fa fa-plus"></i> Agregar depósito</a>
    <a href="<?=base_url('cuentas/salida/insertar_salida/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn"> <i class="fa fa-plus"></i> Agregar Salida</a>
    <a href="<?=base_url('cuentas/movimientos_internos/lista/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn"> <i class="fa fa-plus"></i> Movimientos internos</a>
    <a href="<?=base_url('cuentas/depositos')?>" style="margin-left:15px" class="btn"> <i class="fa fa-undo"></i> Regresar</a>
    <br><br>

    <div class="row">

        <?=form_open('',array('class'=> 'form-horizontal'))?>
            <div class="form-group">
                <label class="control-label col-sm-2 col-xs-2 no-padding-rigth">Fecha incio</label>
                <div class="col-sm-2 col-xs-2">
                    <div class="input-icon datetime-pick date-only">
                        <input data-format="dd-MM-yyyy" type="text" name="fecha_inicio" class="form-control input-sm" placeholder="dd/mm/aaaa" value="<?=set_value('fecha_inicio')?>" required />
                        <span class="add-on">
                            <i class="sa-plus"></i>
                        </span>
                    </div>
                </div>

                <label class="control-label col-sm-2 col-xs-2">Fecha final</label>
                <div class="col-sm-2 col-xs-2">
                    <div class="input-icon datetime-pick date-only">
                        <input data-format="dd-MM-yyyy" type="text" name="fecha_final" class="form-control input-sm" placeholder="dd/mm/aaaa" value="<?=set_value('fecha_final')?>" required />
                        <span class="add-on">
                            <i class="sa-plus"></i>
                        </span>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-2">
                    <button class="btn"> Ver resultado</button>
                </div>
            </div>
        <?=form_close()?>
    </div>
    <br><br>
    <div class="table-responsive overflow">
        <table class="table tile">
            <thead>
            	<tr>
            		<th colspan="13" class="text-center" ><h3> <?=$empresa->nombre_empresa?>/ <?=$empresa->nombre_banco?></h3></th>
            	</tr>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Deposito</th>
                    <th class="text-center">Salida</th>
                    <th class="text-center">Folio</th>
                    <th class="text-center">Comisión</th>
                    <th class="text-center">Monto a retornar</th>
                    <th class="text-center">Pendiente de retorno</th>
                    <th class="text-center">Total retornado</th>
                    <th class="text-center" colspan="2">Cliente</th>
                    <th class="text-center">Detalle</th>
                    <th class="text-center">Editar</th>
                    <th class="text-center">Borrar</th>
                </tr>
            </thead>
            <tbody>
            
            <?php 
			$total_depto    = 0 ;
            $total_sal      = 0 ;
            if(count($movimientos)>0)
            {
            
            $comisio_cliente=0;
            $catidad_retornar=0;
            $pendiente=0;
            $pagos=0;
            foreach($movimientos as $movimiento): 
                $type_mov = $movimiento->tipo_movimiento;
                ?>
            <?php if($type_mov == 'deposito')
                    {
					
                    $deposito = lista_depositos($db_mov, $movimiento->folio_mov ); //print_r($deposito );exit;
                    //print_r($deposito);
                    $cantidad_deposito = $deposito->monto_deposito; 
                    $cliente_asig = cliente_asignado($db_mov, $deposito->id_deposito);
                    $total_depto = $total_depto + $deposito->monto_deposito;
                    $comisio_cliente = genera_comision($db_cliente, $cliente_asig, $deposito->monto_deposito);
                    $catidad_retornar = ($cantidad_deposito) - ($comisio_cliente) ;
                    $pagos = total_pagos($db_mov, $id_empresa, $id_banco, $deposito->id_deposito);
                    $pendiente=$catidad_retornar - $pagos;?>
                       <tr>
                            <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?></td>
                            <td>$<?=convierte_moneda($cantidad_deposito)?></td>
                            <td></td>
                            <td class="text-center"><?=$movimiento->folio_mov?></td>
                            <td class="text-center">$<?=convierte_moneda($comisio_cliente)?></td>
                            <td class="text-center">$<?=convierte_moneda($catidad_retornar)?></td>
                            <td class="text-center">$<?=convierte_moneda($pendiente)?></td>
                            <td class="text-center">$<?=$pagos?></td>
                            <td>
                                 <input type="hidden" id="id_deposito" value="<?=$deposito->id_deposito?>">

                                <select class="form-control" name="cliente_deposito" id="cliente_deposito_<?=$deposito->id_deposito?>" onchange="actualiza_cliente_deposito(<?=$deposito->id_deposito?>, this.value)" <?=($cliente_asig!=0)? 'disabled=disabled' : '';?> style="width:250px">
                                    <option value=""> Seleccione un cliente</option>
                                    <?php foreach($clientes as $cliente):?>
                                        <option value="<?=$cliente->id_cliente?>" <?=($cliente_asig==$cliente->id_cliente)? 'selected=selected' : '';?>><?=$cliente->nombre_cliente?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td><a style="cursor:pointer;width:60px" onclick="editar_cliente(<?=$deposito->id_deposito?>)" class="btn" >Editar</a></td>
                            <td>
                                <a data-toggle="modal" href="#modalPagos" class="btn btn-sm" onclick="pagos(<?=$id_empresa?>,<?=$id_banco?>, <?=$deposito->id_deposito?>)">Ver Pagos</a>
                            </td>
                            <td class="text-center">
                                <a href="<?=base_url('cuentas/depositos/editar_deposito/'.$id_empresa.'/'.$id_banco.'/'.$deposito->id_deposito)?>" >
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?=base_url('cuentas/mov_delete/deposito/'.$id_empresa.'/'.$id_banco.'/'.$deposito->id_deposito)?>" onclick="return confirm('¿Esta seguro que quiere eliminar el depósito?');" data-toggle-title="Haga clic aquí para borrar depósito">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>
                       </tr>
                <?php }else if( $type_mov == 'deposito_interno' ) 
                        { 
                        $deposito = lista_depositos($db_mov, $movimiento->folio_mov ); 
                        //print_r($movimiento->folio_mov);exit;
						$cantidad_deposito = $deposito->monto_deposito;
						$total_depto = $total_depto + $cantidad_deposito;
                        ?>
                        <tr>
                            <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?></td>
							
                            <td>$<?=convierte_moneda($cantidad_deposito)?></td>
							<td></td>
                            <td class="text-center"><?=$movimiento->folio_mov?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2"></td>
                            <td>Movimiento interno</td>
                            <td></td>
                       </tr>
                  <?php } else
                            {
                                $salida = lista_salidas($db_mov, $movimiento->folio_mov);
								$total_sal = $total_sal + $salida->monto_salida;
                                ?>
                            <tr>
                                <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?></td>
								<td></td>
                                <td>$<?=convierte_moneda($salida->monto_salida)?></td>
                                
                                <td class="text-center"><?=$movimiento->folio_mov?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td colspan="2"></td>
                                <td class="text-center">
                                    <?php if($type_mov == 'salida'){?>
                                    <a href="<?=base_url('cuentas/salida/editar_salida/'.$id_empresa.'/'.$id_banco.'/'.$salida->id_salida)?>"  data-toggle-title="Haga clic aquí para borrar depósito">
                                        <i class="fa fa-edit fa-lg"></i>
                                    </a>
                                   <?php }?> 
                                </td>
                                <td class="text-center">
                                    <?php if($type_mov == 'salida'){?>
                                    <a href="<?=base_url('cuentas/mov_delete/salida/'.$id_empresa.'/'.$id_banco.'/'.$salida->id_salida)?>" onclick="return confirm('¿Esta seguro que quiere eliminar esta salida?');" data-toggle-title="Haga clic aquí para borrar depósito">
                                        <i class="fa fa-trash fa-lg"></i>
                                    </a>
                                   <?php }?>
                                </td>
                           </tr>
                            <?php } ?>
            <?php endforeach;?>
            <?php }else{?>
                <tr>
                    <td colspan="11" class="text-center">-- No hay datos disponibles --</td>
                </tr>
            <?php }?>  
			<tr>
                <td class="text-center">Total</td>
                <td class="text-center">$<?=convierte_moneda($total_depto);?></td>
                <td class="text-center">$<?=convierte_moneda($total_sal)?></td>
            </tr> 
            </tbody>    
           
        </table>
    </div>
</div>


<div class="clearfix text-center">
        <a href="<?=base_url('cuentas/depositos')?>" style="margin-left:15px" class="btn"> <i class="fa fa-undo"></i> Regresar</a>
</div>

<?=$this->load->view('admin/cuentas/deposito/modales_depositos')?>
<script type="text/javascript">
function actualiza_cliente_deposito(id_deposito, id_cliente){
    //$('#cliente_deposito').change(function(){
    $.ajax({
            type: "POST",
            datatype: 'html',
            url: '<?php echo base_url("cuentas/depositos/asigna_cliente")?>',
            data: "id_cliente=" + id_cliente +"&id_deposito=" + id_deposito, 
            success: function(data)
            {
                 $("#res_pagos").html(data);
            }
          });//fin accion ajax
    //});
}

function editar_cliente(id_cliente)
{
    $('#cliente_deposito_'+id_cliente).removeAttr('disabled');
}

</script>