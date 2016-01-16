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
								<input type="hidden" value="<?=$id_cliente?>" id="id_cliente">
								<input type="hidden" value="<?=$comision_porcentaje?>" id="comision_cliente">    
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
								<span class="editable" >$<label id="comision-empresa"><?=$comision?></label> </span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Sobrante agente</div> 
							<div class="profile-info-value">
								<span class="editable" >$<label id="sobrante-agente"><?=$total_depositos_sobrante?></label></span>
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
								<!-- <a data-toggle="modal" data-toggle="modal" data-target="#modalDeposito" style="cursor:pointer">
									<i class="icon-plus"></i>
								</a>

								<a href="#" data-action="reload">
									<i class="icon-refresh"></i>
								</a> -->

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
												</tr>
											</thead>
											<tbody id="lista-depositos">
												<?php 
													$total_deposito = 0;
													foreach($depositos as $deposito):
														$total_deposito = $total_deposito+$deposito->monto;
													?>
													<tr>
														<td><?=$deposito->nombre_empresa?></td>
														<td><?=$deposito->nombre_banco?></td>
														<td>$<?=number_format($deposito->monto,2)?></td>
													</tr>
												<?php endforeach;?>
											</tbody>
											<tfoot>
												<th colspan="2" class="text-right">Total</th>
												<th >$<label id="th-total-depositos"><?=number_format($total_deposito,2)?></label></th>
											</tfoot>
										</table> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				

				<div class="col-sm-12 widget-container-span">
					<div class="alert alert-danger text-center" id="message-error-retorno" style="display:none"> 
						Debe seleccionar un tipo de retorno
						<button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
					</div>
					<div class="widget-box">
						<div class="widget-header widget-hea1der-small header-color-dark">
							<h6>Formas de retorno</h6> 

							<div class="widget-toolbar">
								<!-- <a href="#" data-action="settings" id="validate_viewForm">
									<i class="icon-plus"></i>
								</a>
								<select id="tipo-retorno"> 
									<option value = "">-seleciona retorno-</option>
									<option value="cheque">Cheque</option>
									<option value="spei">Spei</option>
									<option value="efectivo">Efectivo</option>
								</select>

								<a href="#" data-action="reload">
									<i class="icon-refresh"></i>
								</a> -->

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
													
												</tr>
											</thead>
											<tbody id="lista-retornos">
												<?php  $total_retorno = 0;
												foreach($retornos as $retorno):
													$total_retorno = $total_retorno + $retorno->monto;
												?>
													<tr>
														<td><?=$retorno->tipo_retorno?></td>
														<td>$<?=number_format($retorno->monto,2)?></td>
														
													</tr>
												<?php endforeach;?>
											</tbody>
											<tfoot>
												<th class="text-right">Total</th>
												<th>$<label id="total-formato-retorno"><?=number_format($total_retorno,2)?></label></th>
											</tfoot>
										</table> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row text-center">
					<a href="<?=base_url()?>cuentas/formato_retorno/getFormatos/<?=$id_cliente?>" class=" btn"> Regresar</a>
				</div>
			
			</div>
			<!-- Fin  de captura de  depósitos -->
		</div>
    </div>
</div>