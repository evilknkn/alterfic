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
        <li>Lista general pendiente de retorno </li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-header">
                <h1>Lista de pendiente general </h1>
            </div><!-- /.page-header -->
            <?php if($this->session->flashdata('success')):?>
            <div class="text-center col-sm-12 col-xs-12">
                <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
            </div>
            <?php endif;?>

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
                    <a href="<?=base_url('excel/pendiente_retorno/gral')?>" class="btn btn-success"><i class="icon-file"></i> Exportar a excel </a>
                    <br><br>
                    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>   
                                <th>Nombre empresa</th>
                                <th>Banco</th>
                                <th>Fecha de depósito</th>
                                <th>Folio</th>
                                <th>Nombre cliente</th>
                                <th>Cliente</th> 
                                <th>Depósito</th>
                                <th>Pagos</th>
                                <th>Comisión </th>
                                <th>Pendiente retorno</th>
                                <th>Ver pagos</th>
                         </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $id_empresa = 0;
                            $id_banco   = 0;

                            foreach($empresas as $empresa):
                               	$pendientes = pendiente_retorno_empresa($db, array('id_empresa' => $empresa->id_empresa, 'id_banco' => $empresa->id_banco));
                               //print_r($pendientes);
                               		foreach($pendientes as $data):
                               			//print_r($data->id_cliente);exit;
                               			if(!empty($data->id_cliente) and $data->id_cliente != 0 ):
                                        	$nombre_cliente = cliente_asignado_deposito($db , $data->id_cliente);
                                        else:
                                        		$nombre_cliente = '';
                                    	endif;
                                        $cliente_asig = cliente_asignado($db_mov, $data->id_deposito);
                                       // $cliente_asig = 0;
                                    	if($data->pendiente_retornar > 10):
                                        ?>
                                    <tr>
                                        <td><?=$empresa->nombre_empresa?></td>
                                        <td><?=$empresa->nombre_banco?></td>
                                        <td><?=formato_fecha_ddmmaaaa($data->fecha_movimiento)?></td>
                                        <td><?=$data->folio_deposito?></td>
                                        <td><?=$nombre_cliente?></td>
                                        <td>
                                            <input type="hidden" id="id_deposito" value="<?=$data->id_deposito?>">
                                            
                                            <select class="input-large" name="cliente_deposito" id="cliente_deposito_<?=$data->id_deposito?>" onchange="actualiza_cliente_deposito(<?=$data->id_deposito?>, this.value)" <?=($cliente_asig!=0)? 'disabled=disabled' : '';?> >
                                                <option value=""> Seleccione un cliente</option>
                                                <?php foreach($clientes as $cliente):?>
                                                    <option value="<?=$cliente->id_cliente?>" <?=($cliente_asig==$cliente->id_cliente)? 'selected=selected' : '';?>><?=$cliente->nombre_cliente?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <a style="cursor:pointer;width:60px" onclick="editar_cliente(<?=$data->id_deposito?>)" class="btn btn-primary" >Editar</a>
                                        </td>  
                                        <td>$<?=convierte_moneda($data->monto_deposito)?></td>
                                     	<td>$<?=convierte_moneda($data->total_pagos)?></td>
                                     	<td>$<?=convierte_moneda($data->comision)?></td>
                                        <td><?=convierte_moneda($data->pendiente_retornar)?></td>
                                        <td>
                                            <a data-toggle="modal" href="#modalPagos" class="btn btn-info" onclick="pagos(<?=$empresa->id_empresa?>,<?=$empresa->id_banco?>, <?=$data->id_deposito?>)">Ver Pagos</a>
                                        </td>
                                        <!--  -->
                                       
                                    </tr>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center" style="margin-top:20px"> 
                    <a href="<?=base_url('cuentas/pendiente_retorno')?>" class="btn btn-grey"><i class="icon-undo"></i> Regresar</a>
                </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<?=$this->load->view('admin/cuentas/pendiente_retorno/modales_depositos')?>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
<script type="text/javascript">
jQuery(function($) {
    var oTable1 = $('#sample-table-2').dataTable( {
        aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: 100,
    "aoColumns": [
      { "bSortable": true },
        null, null, null, null, null, null, null,null,null,
      { "bSortable": true }
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