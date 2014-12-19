<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Comisiones</li>
    <li>Detalle de comision</li>
</ol>
<h4 class="page-title">Detalle de comision del cliente <?=$cliente->nombre_cliente?> </h4>

<div class="block-area" id="responsiveTable">
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>

    <div class="table-responsive overflow">
    	
        <table class="table tile">
            <thead>
                <tr>
                    <th>Fecha depósito</th>
                    <th>Monto del depósito</th>
                    <th>Comisión</th>
                    <th>Folio</th>
                    <th>Empresa</th>
                    <th>Banco</th>
                </tr>
            </thead>
            <tbody>
            	<?php foreach($depositos as $deposito): 
                    $comision = (($deposito->monto_deposito / 1.16 ) * $cliente->comision)   ?>
                <tr>
                    <td><?=formato_fecha_ddmmaaaa($deposito->fecha_deposito)?></td>
                    <td>$<?=convierte_moneda($deposito->monto_deposito)?></td>
                    <td>$<?=convierte_moneda($comision)?></td>
                    <td><?=($deposito->folio_depto)?></td>
                    <td><?=$deposito->nombre_empresa?></td>
                    <td><?=$deposito->nombre_banco?></td>
                    
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<div class="text-center">
    <a href="<?=base_url('cuentas/comisiones')?>" class="btn "> <i class="fa fa-undo"></i> Regresar</a>
</div>

