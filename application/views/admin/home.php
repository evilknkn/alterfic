<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="<?=base_url('/admin/dashboard')?>">Inicio</a>
        </li>
</div>
<?php $valor = json_decode($cosas);  ?>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="col-sm-12 col-xs-12">
                
                <div class="page-header">
                    <h1>Resumen financiero Empresas</h1>
                </div><!-- /.page-header -->
                <div class="col-sm-5 col-xs-5">
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>Total saldos</th>
                            <td>$<?=$valor->saldos?></td>
                        </tr>

                        <tr>
                            <th>Pendientes de retorno</th>
                            <td>$<?=$valor->retorno?></td>
                        </tr>

                        <tr>
                            <th>Comisiones</th>
                            <td>$<?=$valor->comision?></td>
                        </tr>

                        <tr>
                            <th>Gastos</th>
                            <td>$<?=$valor->gastos?></td>
                        </tr>

                        <tr>
                            <th>Retiro de comisiones</th>
                            <td>$<?=$valor->retiros?></td>
                        </tr>
                        
                        <tr>
                            <th>Total resumen</th>
                            <td>$<?=$valor->resumen?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="page-header">
                    <h1>Resumen financiero Personas</h1>
                </div><!-- /.page-header -->
                <div class="col-sm-5 col-xs-12">
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <tr>
                            <th>Total depòsitos</th>
                            <td>$<?=$valor->depositos?></td>
                        </tr>
                        <tr>
                            <th>Total salidas</th>
                            <td>$<?=$valor->salidas?></td>
                        </tr>
                        <tr>
                            <th>Total resumen</th>
                            <td>$<?=$valor->saldo_persona?></td>
                        </tr>
                    </table>
                </div>

                <div class="col-sm-12 col-xs-12">
                    
                    <div class="page-header">
                    <h1>Resumen financiero comisiones</h1>  
                    </div>
                    <div class="col-sm-5 col-xs-12">
                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                <?php    ?>
                                <tr>
                                    <th>Total comisiones</th>
                                    <td style="margin-left:15px">$<?=($valor->comision);?></td>
                                </tr>
                                <tr>
                                    <th>Total retiros</th>
                                    <td style="margin-left:15px">$<?=($valor->ret_com)?></td>
                                </tr>
                                <tr>
                                    <th>Total gastos</th>
                                    <td style="margin-left:15px">$<?=($valor->gastos)?></td>
                                </tr>
                                <tr>
                                    <th>Total comisión</th>
                                    <td style="margin-left:15px">$<?=($valor->total_ret);?></td>
                                </tr>
                            </table> 
                    </div>
                </div>
            </div>
            
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content