<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de gastos</li>
    <li>Detalle de gastos</li>
</ol>
<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Detalle de gastos de la empresa <b><?=$empresa->nombre_empresa?></b> del banco <b><?=$empresa->nombre_banco?></b></h3>

    <div class="table-responsive overflow">
        <table class="table tile">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Folio</th>
                    <th>Monto</th>
                    <th>Descripción salida</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($movimientos)!=0):?>
            	<?php foreach ($movimientos as $movimiento) {?>
                    <tr>
                        <td><?=formato_fecha_ddmmaaaa($movimiento->fecha_movimiento)?> </td>
                        <td><?=$movimiento->folio_mov?></td>
                        <td>$<?=convierte_moneda($movimiento->monto_salida)?></td>
                        <td><?=$movimiento->detalle_salida?></td>
                    </tr>
                <?php } ?>
            <?php else:?>
                <tr>
                <td colspan="3" class="text-center">-- No hay salidas registradas en la cuenta -- </td>
                </tr>
                
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>

<div class="text-center">
<a href="<?=base_url('cuentas/gastos')?>" class="btn"><i class="fa fa-undo"></i>Regresar</a></div>