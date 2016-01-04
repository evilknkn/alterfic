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
        <li>Formato de retorno retorno </li>
</div>

<div class="page-content">
    <div class="row">
        <div class='col-xs-12'>
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="page-header">
                    <h1>Formato de retorno</h1>
                </div><!-- /.page-header -->
            </div>
           
           	<div class="row col-xs-12" style="margin-bottom:20px">
           		<div class="col-xs-6">
		            <div class="profile-user-info profile-user-info-striped ">
						<div class="profile-info-row">
							<div class="profile-info-name"> Cliente </div>
							<div class="profile-info-value">
								<span class="editable" id="about"><?=$nombre_cliente?></span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Folio cliente </div>
							<div class="profile-info-value">
								<span class="editable" id="about"><?=$folio_cliente?></span>
								<input type="hidden" value="<?=$folio_cliente?>" id="folio_cliente">
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Comisión  </div>
							<div class="profile-info-value">
								<span class="editable" id="comision-empresa"><?=$comision_empresa?></span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Sobrante agente</div> 
							<div class="profile-info-value">
								<span class="editable" id="sobrante-agente">$<?=$sobrante?></span>
							</div>
						</div>

					</div>
				</div>
			</div>
			<!--  Inicio de captura de  depósitos-->
			<div class="row">
				<div class="col-sm-12 widget-container-span">
					<div class="widget-box">
						<div class="widget-header widget-hea1der-small header-color-dark">
							<h6>Captura de depósitos</h6>

							<div class="widget-toolbar">
								<a data-toggle="modal" data-toggle="modal" data-target="#modalDeposito" style="cursor:pointer">
									<i class="icon-plus"></i>
								</a>

								<a href="#" data-action="reload">
									<i class="icon-refresh"></i>
								</a>

								<a href="#empresas-depositos" data-action="collapse">
									<i class="icon-chevron-up"></i>
								</a>
							</div>
						</div>

						<div class="widget-body" id="empresas-depositos">
							<div class="widget-main padding-4">
								<div class="slim-scroll" data-height="125">
									<div class="content">
										<table class="table table-striped table-bordered table-hover">
											<thead class="thin-border-bottom">
												<tr>
													<th>Empresa</th>
													<th>Banco</th>
													<th>Monto</th>
													<th class="hidden-480">Fecha</th>
												</tr>
											</thead>
											<tbody id="lista-depositos"></tbody>
											<tfoot>
												<th colspan="2" class="text-right">Total</th>
												<th>$0.00</th>
											</tfoot>
										</table> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 widget-container-span">
					<div class="widget-box">
						<div class="widget-header widget-hea1der-small header-color-dark">
							<h6>Formas de retorno</h6>

							<div class="widget-toolbar">
								<a href="#" data-action="settings">
									<i class="icon-plus"></i>
								</a>

								<a href="#" data-action="reload">
									<i class="icon-refresh"></i>
								</a>

								<a href="#" data-action="collapse">
									<i class="icon-chevron-up"></i>
								</a>

								
							</div>
						</div>

						<div class="widget-body">
							<div class="widget-main padding-4">
								<div class="slim-scroll" data-height="125">
									<div class="content">
										<table class="table table-striped table-bordered table-hover">
											<thead class="thin-border-bottom">
												<tr>
													<th>Tipo de retorno</th>
													<th>Monto</th>
													<th class="hidden-480">Status</th>
												</tr>
											</thead>
											<tbody></tbody>
											<tfoot>
												<th class="text-right">Total</th>
												<th>$0.00</th>
											</tfoot>
										</table> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			
			</div>
			<!-- Fin  de captura de  depósitos -->
		</div>
    </div>
</div>
<?=$this->load->view('admin/solicitudes/formatoRetorno/modal_deposito');?>
<?=$this->load->view('admin/solicitudes/formatoRetorno/modal_cheque');?>
<?=$this->load->view('admin/solicitudes/formatoRetorno/modal_spei');?>


<script type="text/javascript">
$(document).ready(function(){

	$('#empresas-depositos').collapse({
	  hide: true
	})	
});

	agrega_forma_retorno = function(tipo_forma, folio_cliente, id_deposito)
	{
		if(tipo_forma == 'cheque')
		{
			$('#modalCheque').modal('show');
		}else if(tipo_forma == 'spei'){
			$('#modalSpei').modal('show');
			
		}
		console.log('agregaste el tipo '+ tipo_forma);
	}
	
</script>




