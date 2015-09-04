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
                    <h1>Lista de depósitos</h1>
                </div><!-- /.page-header -->

                <?php if($this->session->flashdata('success')):?>
                <div class="text-center col-sm-12 col-xs-12">
                    <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                </div>
                <?php endif;?>
                <a href="<?=base_url('cuentas/caja_chica/insert_deposito/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn btn-primary"> <i class="fa fa-plus"></i> Agregar depósito</a>
                <a href="<?=base_url('cuentas/salida/insertar_salida_caja/'.$id_empresa.'/'.$id_banco)?>" style="margin-left:15px" class="btn btn-primary"> <i class="fa fa-plus"></i> Agregar Salida</a>
                <a data-toggle="modal" href="#modalSaldosPorMes" class="btn btn-info" style="margin-left:15px"><i class="fa fa-search"></i>Consultar saldo</a>
                <br><br>
                <div class="row">

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
            <br><br>

           
            <div class="page-header">
                <h1><?=$empresa->nombre_empresa?></h1>
            </div><!-- /.page-header -->
            <div class="row">
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Deposito</th>
                            <th class="text-center">Salida</th>
                            <th class="text-center">Folio</th>
                            
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
                        <?php if($type_mov == 'deposito' or $type_mov == 'deposito_interno' )
                                {
                                
                                $deposito = lista_depositos($db_mov, $movimiento->folio_mov ); //print_r($movimiento->folio_mov );exit;
                                //print_r($deposito);
                                $cantidad_deposito = $deposito->monto_deposito; 
                                // $cliente_asig = cliente_asignado($db_mov, $deposito->id_deposito);
                                 $total_depto = $total_depto + $deposito->monto_deposito;
                                // $comisio_cliente = genera_comision($db_cliente, $cliente_asig, $deposito->monto_deposito);
                                // $catidad_retornar = ($cantidad_deposito) - ($comisio_cliente) ;
                                // $pagos = total_pagos($db_mov, $id_empresa, $id_banco, $deposito->id_deposito);
                                // $pendiente=$catidad_retornar - $pagos;?>
                                   <tr>
                                        <td class="text-center"><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?></td>
                                        <td class="text-center">$<?=convierte_moneda($cantidad_deposito)?></td>
                                        <td></td>
                                        <td class="text-center"><?=$movimiento->folio_mov?></td>
                                        <td></td>
                                        <td class="text-center">
                                            <a href="<?=base_url('cuentas/deposito_persona/editar_deposito/'.$id_empresa.'/'.$id_banco.'/'.$deposito->id_deposito)?>" >
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?=base_url('cuentas/mov_delete/deposito_persona/'.$id_empresa.'/'.$id_banco.'/'.$deposito->id_deposito)?>" onclick="return confirm('¿Esta seguro que quiere eliminar el depósito?');" data-toggle-title="Haga clic aquí para borrar depósito">
                                                <i class="fa fa-trash fa-lg"></i>
                                            </a>
                                        </td>
                                   </tr>
                            <?php }else{
                                    $salida = lista_salidas($db_mov, $movimiento->folio_mov);
                                    $total_sal = $total_sal + $salida->monto_salida;?>
                                    <tr>
                                        <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?></td>
                                        <td></td>
                                        <td class="text-center">$<?=convierte_moneda($salida->monto_salida)?></td>
                                        
                                        <td class="text-center"><?=$movimiento->folio_mov?></td>
                                        <td><?=$salida->detalle_salida?></td>
                                        <td class="text-center">
                                            <a href="<?=base_url('cuentas/salida/editar_salida_persona/'.$id_empresa.'/'.$id_banco.'/'.$salida->id_salida)?>"  data-toggle-title="Haga clic aquí para borrar depósito">
                                                <i class="fa fa-edit fa-lg"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?=base_url('cuentas/mov_delete/salida_persona/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_detalle.'/'.$salida->id_salida)?>" onclick="return confirm('¿Esta seguro que quiere eliminar esta salida?');" data-toggle-title="Haga clic aquí para borrar depósito">
                                                <i class="fa fa-trash fa-lg"></i>
                                            </a>
                                        </td>                                
                                   </tr>
                            <?php }  ?>
                        <?php endforeach;?>
                    <?php }?>

                    </tbody>    
                    <tfoot> 
                    <tr>
                        <td class="text-center">Total</td>
                        <td class="text-center">$<?=convierte_moneda($total_depto);?></td>
                        <td class="text-center">$<?=convierte_moneda($total_sal)?></td>
                    </tr> 
                    </tfoot>
                </table>
            </div>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(function($) {
    var oTable1 = $('#sample-table-2').dataTable( {
    "aoColumns": [
      { "bSortable": true },
        null, null, null, null, null, 
      { "bSortable": false }
    ] } );
        
});
</script>
<?=$this->load->view('/admin/cuentas/caja_chica/consulta_saldo')?>