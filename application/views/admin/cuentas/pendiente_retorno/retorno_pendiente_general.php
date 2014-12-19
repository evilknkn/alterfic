
<script type="text/javascript">
// $(function() {
//             $("table").tablesorter({debug: true});
//         });
$(document).ready(function (){
    $('table').tablesorter();
});
</script>

<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista general pendiente de retorno </li>
</ol>

<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Lista general pendiente de retorno </h3>
    <br>
    <a href="<?=base_url('cuentas/pendiente_retorno')?>" class="btn"> <i class="fa fa-undo"></i> Regresar</a>
    <br><br>
        <div class="row form-group">
            <label class="label-control col-sm-2 col-xs-2 text-right"> Filtro por empresa </label>
            <?=form_open('')?>
            <div class="col-sm-5 col-xs-5">
                <select class="form-control input-small" required name="id_empresa">
                    <option value="">Seleccione una empresa</option>
                    <option value="0">Todas las empresas</option>
                    <?php 
                    $id_empresa = 0;
                    $id_banco   = 0;
                    foreach($catalogo_empresas as $empresa): ?>
                        <option value="<?=$empresa->id_empresa?>"><?=$empresa->nombre_empresa?></option>
                    <?php endforeach?>
                </select>
            </div>
            <div class="col-sm-2 col-xs-2"> <button class="btn"> Filtrar</button></div>
            <?=form_close();?>
        </div>
         <br><br>
    <div class="table-responsive overflow">
    	
       <!--  <table class="tablesorter" id="pendientes_retorno">  -->
        <table id="rowspan" cellspacing="0" class="table tile tablesorter">
            <thead>
                <tr>   
                    <th>Nombre empresa</th>
                    <th>Banco</th>
                    <th>Fecha de depósito</th>
                    <th>Folio</th>
                    <th>Monto depósito</th>
                    <th>Cliente</th>
                    <th>Comisión </th>
                    <th>Pagos</th>
                    <th>Pendiente retorno</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $id_empresa = 0;
                $id_banco   = 0;

                foreach($empresas as $empresa):
                    if($id_empresa != $empresa->id_empresa and $id_banco != $empresa->id_banco): 
                        $depositos = depositos_pendiente_retorno_gral($db, $empresa->id_empresa, $empresa->id_banco);
                    ?>
                    <?php foreach($depositos as $deposito):

                            $cliente = cliente_asignado_deposito($db, $deposito->id_cliente);
                            $comision = genera_comision($db, $deposito->id_cliente, $deposito->monto_deposito); 
                            $pagos = total_pagos($db, $empresa->id_empresa, $empresa->id_banco, $deposito->id_deposito);
                            $pendiente_retorno = $deposito->monto_deposito - ($comision + $pagos);
                            if($pendiente_retorno > 10):
                            ?>
                        <tr>
                        	<td><?=$empresa->nombre_empresa?></td>
                        	<td><?=$empresa->nombre_banco?></td>
                        	<td><?=formato_fecha_ddmmaaaa($deposito->fecha_deposito)?></td>
                            <td><?=$deposito->folio_depto?></td>
                            <td>$<?=convierte_moneda($deposito->monto_deposito)?></td>
                            <td><?=$cliente?></td>
                            <td>$<?=convierte_moneda($comision)?></td>
                            <td>$<?=convierte_moneda($pagos)?></td>
                            <td><?=convierte_moneda($pendiente_retorno)?></td>
                        </tr>
                        <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

