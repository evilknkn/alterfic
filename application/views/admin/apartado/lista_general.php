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

<div class="page-content">
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
                <?=form_open('',array('class'=> 'form-horizontal'))?>
                    <div class="form-group">
                        <label class="control-label col-sm-2 col-xs-2 no-padding-rigth">Fecha incio</label>
                        <div class="col-sm-2 col-xs-2">
                            <div class="input-icon datetime-pick date-only">
                                <div class="input-group">
                                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_inicio" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_inicio')?>"  placeholder="dd/mm/aaaa"/>
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
                                    <input class="form-control date-picker input-xxlarge" id="id-date-picker-1" name="fecha_final" required type="text" data-date-format="dd-mm-yyyy" value="<?=set_value('fecha_final')?>"  placeholder="dd/mm/aaaa"/>
                                    <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 col-xs-2">
                            <button class="btn btn-info"> Ver resultado</button>
                        </div>
                    </div>
                <?=form_close()?>
            </div>

            <div class="table-responsive">
                <div class="row" ng-controller="apartadoGeneralCtrl" ng-init="listaGeneral('<?=base_url()?>')">
                    
                    <table id="sample-table-2" class="table table-striped table-bordered table-hover">
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
                                <th>Ver pagos</th>
                         </tr>
                        </thead>
                         <tbody  ng-repeat="deposito in list_depositos">
                   
                        <tr>
                            <td>{{ deposito.nombre_empresa }}</td>
                            <td>{{ deposito.nombre_banco }}</td>
                            <td>{{ deposito.fecha_deposito }}</td>
                            <td>{{ deposito.folio }}</td>
                            <td>{{ deposito.nombre_cliente }}</td>
                            <td> 
                                <select>
                                <option value="">-Asigne un cliente -</option>
                                <?php foreach($lista_clientes as $cliente): ?>

                                    <option value="<?=$cliente->id_cliente ?>" ng-if=" deposito.id_cliente == <?=$cliente->id_cliente ?>" selected disabled><?=$cliente->nombre_cliente ?> </option>

                                    <option value="<?=$cliente->id_cliente ?>" ><?=$cliente->nombre_cliente ?> </option>
                                <?php endforeach;?>
                                </select>
                            </td>
                            <td>${{ deposito.monto_deposito }}</td>
                            <td>${{ deposito.comision }}</td>
                            <td>
                                <select disabled>
                                <option value="">-Asigne un cliente -</option>
                                </select>
                            </td>
                        </tr>
                   
                    </tbody>
                    </table>
                </div>
                <div ng-controller="TodoController">
                    <div data-pagination="" data-num-pages="numPages()" 
                            data-current-page="currentPage" data-max-size="maxSize"  
                            data-boundary-links="true"></div>
                </div>
            </div>   
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
