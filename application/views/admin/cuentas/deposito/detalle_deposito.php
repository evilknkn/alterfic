<!-- barra direccion-->
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="<?=base_url('/admin/dashboard')?>">Inicio</a>
        </li>
        <li><a href="<?=base_url('cuentas/depositos')?>">Lista de depósitos</a></li>
        <li>Detalle de depósito</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-header">
                <h1>Detalle de depósito</h1>
            </div><!-- /.page-header -->
            <?php if($this->session->flashdata('success')):?>
            <div class="text-center col-sm-12 col-xs-12">
                <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
            </div>
            <?php endif;?>

            <div class="row">
                <a href="<?=base_url('cuentas/depositos/insert_deposito/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn btn-primary"> 
                    <i class="fa fa-plus"></i> Agregar depósito</a>
                <a href="<?=base_url('cuentas/salida/insertar_salida/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn btn-primary"> 
                    <i class="fa fa-plus"></i> Agregar Salida</a>
                <a href="<?=base_url('cuentas/movimientos_internos/lista/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn btn-primary"> 
                    <i class="fa fa-plus"></i> Movimientos internos</a>
                <a href="<?=base_url('cuentas/depositos')?>" style="margin-left:15px" class="btn btn-grey"> 
                    <i class="fa fa-undo"></i> Regresar</a>
            </div>

            <div class="row" style="margin-top:30px">
                <?=form_open('',array('class'=> 'form-horizontal'))?>
                    <div class="form-group">
                        <label class="control-label col-sm-2 col-xs-2 no-padding-rigth">Fecha incio</label>
                        <div class="col-sm-2 col-xs-2">
                            <div class="input-icon datetime-pick date-only">
                                <div class="input-group">
                                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_inicio" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_inicio')?>"  placeholder="dd/mm/aaaa"/>
                                    <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>

                           
                        </div>

                        <label class="control-label col-sm-2 col-xs-2">Fecha final</label>
                        <div class="col-sm-2 col-xs-2">
                            <div class="input-icon datetime-pick date-only">
                                <div class="input-group">
                                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_final" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_final')?>"  placeholder="dd/mm/aaaa"/>
                                    <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-2">
                            <button class="btn btn-info"> Ver resultado</button>
                        </div>
                    </div>
                <?=form_close()?>
            </div>

            <div class="row">
                <div class="page-header">
                    <h1><?=$empresa->nombre_empresa?>/ <?=$empresa->nombre_banco?></h1>
                </div><!-- /.page-header -->
                <a href="<?=base_url('excel/exportaExcel/detalle_depositos/'.$id_empresa.'/'.$id_banco)?>" class="btn btn-success"><i class="icon-file"></i> Exporar a excel</a>
                <br><br>
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Deposito</th>
                            <th class="text-center">Salida</th>
                            <th class="text-center">Folio</th>
                            <th class="text-center">Comisión</th>
                            <th class="text-center">Monto a retornar</th>
                            <th class="text-center">Pendiente de retorno</th>
                            <th class="text-center">Total retornado</th>
                            <th class="text-center" >Cliente</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
                   $total_depto    = 0 ;
                    $total_sal      = 0 ;
                   
                    $deposito =0;
                    $cantidad_deposito = 0;
                    $comisio_cliente=0;
                    $catidad_retornar=0;
                    $pendiente=0;
                    $pagos=0;
                    //foreach($movimientos as $movimiento): 
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
                            <td class="text-center">$<?=convierte_moneda($pagos)?></td>
                            <td>
                                 <input type="hidden" id="id_deposito" value="<?=$deposito->id_deposito?>">

                                <select class="input-large" name="cliente_deposito" id="cliente_deposito_<?=$deposito->id_deposito?>" onchange="actualiza_cliente_deposito(<?=$deposito->id_deposito?>, this.value)" <?=($cliente_asig!=0)? 'disabled=disabled' : '';?> >
                                    <option value=""> Seleccione un cliente</option>
                                    <?php foreach($clientes as $cliente):?>
                                        <option value="<?=$cliente->id_cliente?>" <?=($cliente_asig==$cliente->id_cliente)? 'selected=selected' : '';?>><?=$cliente->nombre_cliente?></option>
                                    <?php endforeach;?>
                                </select>
                                <a style="cursor:pointer;width:60px" onclick="editar_cliente(<?=$deposito->id_deposito?>)" class="btn btn-primary" >Editar</a>
                            </td>
                            <td class="text-center">
                                <a data-toggle="modal" href="#modalPagos" class="btn btn-info" onclick="pagos(<?=$id_empresa?>,<?=$id_banco?>, <?=$deposito->id_deposito?>)">Ver Pagos</a>
                            </td>
                            <td class="text-center">
                                <a href="<?=base_url('cuentas/depositos/editar_deposito/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_detalle.'/'.$movimiento->id_movimiento)?>" >
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="<?=base_url('cuentas/mov_delete/deposito/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_detalle.'/'.$movimiento->id_movimiento)?>" onclick="return confirm('¿Esta seguro que quiere eliminar el depósito?');" data-toggle-title="Haga clic aquí para borrar depósito">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>
                       </tr>
                <?php }else if( $type_mov == 'deposito_interno' )
                    {
                        $deposito = lista_depositos($db_mov, $movimiento->folio_mov ); 
                        //print_r($movimiento->folio_mov);exit;
                        $cantidad_deposito = $deposito->monto_deposito;
                        $total_depto = $total_depto + $cantidad_deposito;?>
                        <tr>
                            <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?></td>
                            
                            <td class="text-center">$<?=convierte_moneda($cantidad_deposito)?></td>
                            <td></td>
                            <td class="text-center"><?=$movimiento->folio_mov?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                            <td></td>
                            <td>Movimiento depósito interno</td>
                            <td></td>
                            <td></td>
                       </tr>

                <?php }else
                        {
                            $salida = lista_salidas($db_mov, $movimiento->folio_mov);
                            $total_sal = $total_sal + $salida->monto_salida;
                            ?>
                        <tr>
                            <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?></td>
                            <td></td>
                            <td class="text-center">$<?=convierte_moneda($salida->monto_salida)?></td>
                            
                            <td class="text-center"><?=$movimiento->folio_mov?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?=$salida->detalle_salida?></td>
                            <td class="text-center">
                                <?php if($type_mov == 'salida'){?>
                                <a href="<?=base_url('cuentas/salida/editar_salida/'.$id_empresa.'/'.$id_banco.'/'.$salida->id_salida)?>"  data-toggle-title="Haga clic aquí para borrar depósito">
                                    <i class="fa fa-edit fa-lg"></i>
                                </a>
                               <?php }?> 
                            </td>
                            <td class="text-center">
                                <?php if($type_mov == 'salida'){?>
                                <a href="<?=base_url('cuentas/mov_delete/salida/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_detalle.'/'.$salida->id_salida)?>" onclick="return confirm('¿Esta seguro que quiere eliminar esta salida?');" data-toggle-title="Haga clic aquí para borrar depósito">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                               <?php }?>
                            </td>
                       </tr>
                <?php } ?>
                    <?php endforeach;?>
                    </tbody>
                    <tfoot>
                        <td><b>Total</b></td>
                        <td class="text-center">$<?=convierte_moneda($total_depto);?></td>
                        <td class="text-center">$<?=convierte_moneda($total_sal)?></td>
                        
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tfoot>
                </table>
            </div>
            <div class="clearfix text-center" style="margin-top:20px;">
                    <a href="<?=base_url('cuentas/depositos')?>"  class="btn btn-grey"> <i class="fa fa-undo"></i> Regresar</a>
            </div>

            <?=$this->load->view('admin/cuentas/deposito/modales_depositos')?>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(function($) {
    var oTable1 = $('#sample-table-2').dataTable( {
        'aaSorting' : [[3, 'desc']],
        aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: 100,
    "aoColumns": [
      { "bSortable": true },
        null, null, null, null, null, null, null, null, null, null,
      { "bSortable": false }
    ] } );
        
});


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
    
