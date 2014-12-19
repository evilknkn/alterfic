<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Comisiones</li>
    <li>Lista de salida de comisiones</li>
</ol>
<h4 class="page-title">Lista de salida de comisiones </h4>

<?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>
    
<div class="block-area" id="responsiveTable">
    <div class="table-responsive overflow">
    	
        <a href="<?=base_url('cuentas/comisiones/retiro_comision')?>" class="btn">Agregar retiro</a>

        <br><br>
        <table class="table tile">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nombre Empresa</th>
                    <th>Banco</th>
                    <th>Folio</th>
                    <th>Monto</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($retiros)>0): 
                $total_retiro = 0;?>
                <?php foreach($retiros as $retiro):?>
                    <tr>
                        <td><?=formato_fecha_ddmmaaaa($retiro->fecha_movimiento)?></td>
                        <td><?=$retiro->nombre_empresa?></td>
                        <td><?=$retiro->nombre_banco?></td>
                        <td><?=$retiro->folio_mov?></td>
                        <td>$<?=convierte_moneda($retiro->monto_salida)?></td>
                        <td>
                            <a href="<?=base_url('comisiones/editar_retiro/'.$retiro->id_detalle)?>">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                $total_retiro = $total_retiro +$retiro->monto_salida;
                endforeach;?>
                <?php else:?>
                    <tr>
                        <td colspan="6" class="text-center">-- No hay retiros registrados --</td>
                    </tr>
                <?php endif;?>
                <tr>
                    <td colspan="3">&nbsp;</td>
                    <td class="text-right">Total</td>
                    <td class="text-left" colspan="2">$<?=convierte_moneda($total_retiro)?></td>
                </tr>
            </tbody> 
        </table>
        <div class="text-center">
            <a href="<?=base_url('cuentas/comisiones')?>" class="btn"><i class="fa fa-undo"></i> Regresar</a>
        </div>
    </div>
</div>


