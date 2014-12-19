<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista empresas pendiente de retorno </li>
   	<li>Detalle de pendiente de retorno </li>
</ol>

<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Detalle de pendiente de retorno</h3>
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
                    <th>Folio</th>
                    <th>Monto del depósito</th>
                    <th>Cliente</th>
                    <th>Comisión</th>
                    <th>Pagos</th>
                    <th>Pendiente retorno </th>
                </tr>
            </thead>
            <tbody>
              <?php foreach($depositos as $deposito):
                $comision = genera_comision($db, $deposito->id_cliente, $deposito->monto_deposito); 
                $pagos = total_pagos($db, $id_empresa, $id_banco, $deposito->id_deposito);
                $pendiente_retorno = $deposito->monto_deposito - ($comision + $pagos);
                $cliente = cliente_asignado_deposito($db, $deposito->id_cliente);
                ?>
              <tr>
                <td><?=formato_fecha_ddmmaaaa($deposito->fecha_deposito)?></td>
                <td><?=$deposito->folio_depto?></td>
                <td>$<?=convierte_moneda($deposito->monto_deposito)?></td>
                <td><?=$cliente?></td>
                <td>$<?=convierte_moneda($comision)?></td>
                <td>$<?=convierte_moneda($pagos)?></td>
                <td><?=convierte_moneda($pendiente_retorno)?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<div class="text-center">
  <a href="<?=base_url('cuentas/pendiente_retorno')?>" class="btn"><i class="fa fa-undo "></i> Regresar</a>
</div>