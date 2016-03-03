
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

<div class="page-content" ng-controller="apartadoGeneralCtrl" >
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
                <div class="form-horizontal">
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2 col-xs-2 no-padding-rigth">Fecha incio</label>
                        <div class="col-sm-2 col-xs-2">
                            <div class="input-icon datetime-pick date-only">
                                <div class="input-group">
                                    <input class="form-control date-picker input-xxlarge data2" id="id-date-picker-1"  ng-model="fecha_ini" name="fecha_ini" required type="text" data-date-format="dd-mm-yyyy"   placeholder="dd/mm/aaaa"/>
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
                                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" ng-model="fecha_fin" name="fecha_fin" required type="text" data-date-format="dd-mm-yyyy" placeholder="dd/mm/aaaa"/>
                                    <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-2 col-xs-2">
                            <button class="btn btn-info"  ng-click="listaGeneralFiltro()"> Ver resultado</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <div class="row " style="margin-bottom:20px;">
                    <a href="<?=base_url()?>excel/apartados/info/general" id="exportar-general"  class="btn btn-success" > Exportar a Excel </a>
                </div>

                <div class="row" ng-init="listaGeneral('<?=base_url()?>')"  >
                  
                    <table datatable="ng" dt-options="dtOptions" class="row-border hover">
                        <thead>
                            <tr>   
                                <th>Nombre empresa</th>
                                <th>Banco</th>
                                <th>Fecha de depósito</th>
                                <th>Folio</th>
                                <th>Nombre cliente</th>
                                <?php if($this->session->userdata('ID_PERFIL') !=4):?>
                                    <th>Cliente</th> 
                                <?php endif;?>
                                <th>Depósito</th>
                                <th>Comisión </th>
                                <th>Pagar</th>
                         </tr>
                        </thead>
                        <tbody>                            
                            <tr ng-repeat="deposito in list_depositos" id="deposito_{{deposito.id_deposito}}"  ng-style="class_tr(deposito.id_deposito, deposito.nombre_cliente, deposito.status_pago)">
                                <td>{{ deposito.nombre_empresa }}</td>
                                <td>{{ deposito.nombre_banco }}</td>
                                <td>{{ deposito.fecha_deposito }}</td>
                                <td>{{ deposito.folio }}</td>
                                <td>{{ deposito.nombre_cliente }}</td>
                                <td> 
                                    <a class="btn btn-info" ng-click="asignaCliente(deposito.id_deposito, deposito.folio )"  >Asignar cliente</a>
                                </td>
                                <td>${{ deposito.monto_deposito }}</td>
                                <td>${{ deposito.comision }}</td>
                                <td><a id="pay_depto_{{deposito_.id_deposito}}" class="btn btn-primary" ng-click="pagarDeposito(deposito.id_deposito, deposito.folio )">Pagar</a></td>
                            </tr>
                       
                        </tbody>
                    </table>
                </div>


                <?=$this->load->view('admin/apartado/modal/modal_cliente');?>
                <?=$this->load->view('admin/apartado/modal/modal_pago');?>
              
            </div>   
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
