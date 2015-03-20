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
        <li>Lista de depósitos</li>
        <li>Movimientos internos</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-header">
                <h1>Movimientos internos <?=$nombre_empresa?></h1>
            </div><!-- /.page-header -->

            <?php if($this->session->flashdata('success')):?>
                <div class="text-center col-sm-12 col-xs-12">
                    <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
                </div>
            <?php endif;?>


            <div class="row">
                <?php if($this->session->userdata('consulta') == 'active'): ?>
                    <a href="<?=base_url('cuentas/movimientos_internos/add_mov_interno/'.$id_empresa.'/'.$id_banco)?>" class="btn btn-primary">Agregar movimiento</a>
                    <br><br>
                <?php endif; ?>
                
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

            <a href="<?=base_url('excel/exportaExcel/movimientos_internos/'.$id_empresa.'/'.$id_banco)?>" class="btn btn-success"><i class="icon-file"></i> Exportar a excel </a>
            <br><br>
                <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nombre de empresa</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Folio entrada</th>
                            <th>Folio salida</th>
                            <th class="text-center">Editar</th>
                            <th class="text-center">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($movimientos as $movimiento):?>
                           <tr>
                                <td><?=nombre_empresa($db, $movimiento->empresa_destino)?></td>
                                <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_mov)?></td>
                                <td>$<?=convierte_moneda($movimiento->monto)?></td>
                                <td><?=$movimiento->folio_entrada?></td>
                                <td><?=$movimiento->folio_salida?></td>
                                <td class="text-center">
                                    <a href="<?=base_url('cuentas/movimientos_internos/editar_movimiento/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_movimiento)?>"> 
                                        <i class="fa fa-edit fa-2x"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="<?=base_url('cuentas/mov_delete/movimiento_interno/'.$id_empresa.'/'.$id_banco.'/'.$movimiento->id_movimiento)?>" onclick="return confirm('¿Esta seguro que quiere eliminar el movimiento interno?');"> 
                                        <i class="fa fa-trash fa-2x"></i>
                                    </a>
                                </td>
                           </tr>
                        <?php endforeach; ?>
                     
                    </tbody>
                </table>
            </div>
            <?php if($this->session->userdata('consulta') == 'active'): ?>
            <div class="text-center" style="margin-top:20px">
                <a class="btn btn-grey " href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$id_empresa.'/'.$id_banco)?>"> <i class="fa fa-undo"></i> Regresar</a>
            </div>
            <?php else:?>
                <div class="text-center" style="margin-top:20px">
                <a class="btn btn-grey " href="<?=base_url('admin/dashboard')?>"> <i class="fa fa-undo"></i> Regresar</a>
            </div>
            <?php endif;?>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(function($) {
    var oTable1 = $('#sample-table-2').dataTable( {
    'aaSorting' : [[4, 'desc']],
    aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: 100,
    "aoColumns": [
      { "bSortable": true },
        null, null, null, null, null,
      { "bSortable": false }
    ] } );
        
});
</script>