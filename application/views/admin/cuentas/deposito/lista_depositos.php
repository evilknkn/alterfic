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
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="col-sm-12 col-xs-12">
                <div class="page-header">
                    <h1>Lista de depósitos</h1>
                </div><!-- /.page-header -->
                <div class="col-xs-12 col-sm-12">
                    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nombre de empresa</th>
                                <th>Banco</th>
                                <th>Total depósito</th>
                                <th>Total salida</th>
                                <th>Saldo</th>
                                <th>Saldo al mes</th>
                                <th class="tex-center">Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_depto =0 ;
                            $total_salida =0 ;
                            $total_saldo = 0;
                            foreach($empresas as $empresa): 
                            $depto = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito');
                            $depto_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito_interno');
                            
                            $salida = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida');
                            $salida_pago = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_pago');
                            $salida_mov_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'mov_int');
                            $salida_comision = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_comision');
                            
                            $total_depto =   $depto + $depto_int;
                            $total_salida = $salida + $salida_mov_int + $salida_pago + $salida_comision;

                            $saldo = $total_depto - $total_salida; 
                            $total_saldo = $total_saldo + $saldo; ?>
                            <tr>
                                <td><?=$empresa->nombre_empresa?></td>
                                <td><?=$empresa->nombre_banco?></td>
                                <td>$<?=convierte_moneda($total_depto)?></td>
                                <td>$<?=convierte_moneda($total_salida)?></td>

                                <td>$<?=convierte_moneda($saldo)?></td>
                                <td class="text-center"><a data-toggle="modal" href="#modalSaldosPorMes" onclick="saldoPorMes(<?php echo $empresa->id_empresa?>, <?php echo $empresa->id_banco?>)" class="btn btn-info">Consultar</a></td>
                              
                                <td class="tex-center">
                                    <a href="<?=base_url('cuentas/depositos/detalle_cuenta/'.$empresa->id_empresa.'/'.$empresa->id_banco)?>">
                                        <i class="fa fa-search fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

                </div>
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
<?=$this->load->view('admin/cuentas/deposito/modal_saldos_mes')?>