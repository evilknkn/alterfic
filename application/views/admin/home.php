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
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="col-sm-5 col-xs-5">
                <div class="page-header">
                    <h1>Resumen financiero Empresas</h1>
                </div><!-- /.page-header -->
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Total saldos</th>
                        <td>$<?=$saldos?></td>
                    </tr>

                    <tr>
                        <th>Pendientes de retorno</th>
                        <td>$<?=$retorno?></td>
                    </tr>

                    <tr>
                        <th>Comisiones</th>
                        <td>$<?=$comision?></td>
                    </tr>

                    <tr>
                        <th>Gastos</th>
                        <td>$<?=$gastos?></td>
                    </tr>

                    <tr>
                        <th>Retiro de comisiones</th>
                        <td>$<?=$retiros?></td>
                    </tr>
                    
                    <tr>
                        <th>Total resumen</th>
                        <td>$<?=$resumen?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-5 col-xs-5">
                <div class="page-header">
                    <h1>Resumen financiero Personas</h1>
                </div><!-- /.page-header -->
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Total depòsitos</th>
                        <td>$<?=$depositos?></td>
                    </tr>

                    <tr>
                        <th>Total salidas</th>
                        <td>$<?=$salidas?></td>
                    </tr>

                   
                    
                    <tr>
                        <th>Total resumen</th>
                        <td>$<?=$saldo_persona?></td>
                    </tr>
                </table>
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->