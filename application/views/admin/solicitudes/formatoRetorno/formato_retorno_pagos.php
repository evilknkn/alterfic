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
								<span class="editable" >$<label id="comision-empresa"><?=$comision_empresa?></label> </span>
							</div>
						</div>

						<div class="profile-info-row">
							<div class="profile-info-name"> Sobrante agente</div> 
							<div class="profile-info-value">
								<span class="editable" >$<label id="sobrante-agente"><?=$sobrante?></label></span>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="row text-center">
				<a href="<?=base_url()?>cuentas/formato_retorno/getClientes" class=" btn btn-primary"> Guardar</a>
			</div>
			<!--  Inicio de captura de  depósitos-->
			<div class="row">
				<div class="col-sm-12 widget-container-span">
					<div class="widget-box">
						<div class="widget-header widget-hea1der-small header-color-dark">
							<h6>Captura de depósitos</h6>

							<div class="widget-toolbar">
								<a  id="createDeposito" data-action="settings" style="cursor:pointer">
									<i class="icon-plus"></i>
								</a>

								<a style="cursor:pointer" data-action="reload" id="reload-depositos">
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
													<th class="text-center">Editar</th>
													<th class="text-center">Borrar</th>
												</tr>
											</thead>
											<tbody id="lista-depositos"></tbody>
											<tfoot>
												<th colspan="2" class="text-right">Total</th>
												<th >$<label id="th-total-depositos">0.00</label></th>
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
								<a href="#" data-action="settings" id="validate_viewForm">
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
													<th>Editar</th>
													<th>Borrar</th>
												</tr>
											</thead>
											<tbody id="lista-retornos"></tbody>
											<tfoot>
												<th class="text-right">Total</th>
												<th>$<label id="total-formato-retorno">0.00</label></th>
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
<?=$this->load->view('admin/solicitudes/formatoRetorno/modal_efectivo');?>


<script type="text/javascript">
	$("#createDeposito").click(function(){
		console.log('si se va a crear');
		$("#edited_depto").val('');
		$('#modalDeposito').modal('show');
	});

	$("#validate_viewForm").click(function(){
		var tipo_retorno = $("#tipo-retorno").val();
		
		if(tipo_retorno.length >0){
			$("#message-error-retorno").hide();	
			if(tipo_retorno == 'cheque'){
				$('#modalCheque').modal('show');
			}
			if(tipo_retorno == 'spei'){
				$('#modalSpei').modal('show');
			}
			if(tipo_retorno == 'efectivo'){
				$('#modalEfectivo').modal('show');
			}
		}else{
			
			$("#message-error-retorno").show();
		}
	});

	function edit_retorno(id_forma, type_forma)
	{
		if(type_forma == 1 ){
			detail_cheque(id_forma);
		}
		if(type_forma == 2){
			detail_spei(id_forma);
		}
		if(type_forma == 3){
			detail_efectivo(id_forma);
		}
	}

	function delete_retorno(forma_id){
		var folio_cliente   	= $('#folio_cliente').val();
		var comision_cliente    = $("#comision_cliente").val();

		$.ajax({
                type: "POST",
                datatype: 'json',
                url: '<?php echo base_url("cuentas/formato_retorno/delete_forma")?>',
                data: "forma_id=" + forma_id +'&folio_cliente='+folio_cliente +'&comision_cliente='+comision_cliente ,
                success: function(data)
                {
                    $("#forma_id_"+forma_id).remove();

                    $('#sobrante-agente').html(data.total_depositos_sobrante);
                    $("#total-formato-retorno").html(data.total_formato);
                }
              });//fin accion ajax
	}

	$("#reload-depositos").click(function(){
		var folio_cliente   	= $('#folio_cliente').val();

		$.ajax({
                type: "POST",
                datatype: 'json',
                url: '<?php echo base_url("cuentas/formato_retorno/getDepositos")?>',
                data: 'folio_cliente='+folio_cliente ,
                success: function(data)
                {
                     var html = '';
                     	for(var i =0; i<data.list_deptos.length; i++ )
                     	{
                     		html += "<tr id='deposito_"+data.list_deptos[i].id_reg+"'>";
	                        html += "<td>"+data.list_deptos[i].nombre_empresa;
	                        html += "<input value='"+data.list_deptos[i].id_reg+"' id='no-deposito-"+data.list_deptos[i].id_reg+"' type='hidden' > ";
	                        html += "</td>";
	                        html += "<td>"+data.list_deptos[i].nombre_banco+"</td>";
	                        html += "<td>"+data.list_deptos[i].monto+"</td>";
	                        html += "<td>"+data.list_deptos[i].fecha_deposito+"</td>";
	                        html += "<td class='text-center'><a onclick='edit_deposito("+data.list_deptos[i].id_reg+")' style='cursor:pointer'><i class='icon-edit bigger-160'></i></a></td>";
	                        html += "<td class='text-center'><a onclick='delete_deposito("+data.list_deptos[i].id_reg+")' style='cursor:pointer'><i class='icon-trash bigger-160'></i></a></td>";
	                        html += "</tr>";
                     	}
                       

                        //console.log(data.total_monto[0].monto );
                    $('#lista-depositos').html(html);
                }
              });//fin accion ajax
	});
</script>




