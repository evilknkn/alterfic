<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista empresas pendiente de retorno </li>
</ol>

<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Lista empresas pendiente de retorno </h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>
    <div class="row">
        <a href="<?=base_url('cuentas/pendiente_retorno/pendiente_retorno_general')?>" class="btn">Pendiente de retorno general</a>
    </div>
    <br><br>
    <div class="table-responsive overflow">
    	
        <table class="table tile">
            <thead>
                <tr>   
                    <th>Nombre empresa</th>
                    <th>Banco</th>
                    <th>Total depósito</th>
                    <th>Pendiente a retornar</th>
                    <th class="text-center">Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($empresas as $empresa):
                $res = genera_total_depositos($db, $empresa->id_empresa, $empresa->id_banco);
                
                ?>
                <tr>
                    <td><?=$empresa->nombre_empresa?></td>
                    <td><?=$empresa->nombre_banco?></td>
                    <td>$<?=convierte_moneda($res['depositos'])?></td>
                    <td>$<?=convierte_moneda($res['pendiente_retorno'])?></td>
                    <td class="text-center">
                        <a href="<?=base_url('cuentas/pendiente_retorno/detalle_retorno/'.$empresa->id_empresa.'/'.$empresa->id_banco)?>">
                            <i class="fa fa-search fa-lg"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
