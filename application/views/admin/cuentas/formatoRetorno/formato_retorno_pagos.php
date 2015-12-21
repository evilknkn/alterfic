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
           	<div class="col-xs-6">
	            <div class="profile-user-info profile-user-info-striped ">
					<div class="profile-info-row">
						<div class="profile-info-name"> Empresa </div>

						<div class="profile-info-value">
							<span class="editable" id="username"><?=$empresa->nombre_empresa?></span>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Banco </div>

						<div class="profile-info-value">
							<span class="editable" id="city"><?=$banco->nombre_banco?></span>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Cliente </div>

						<div class="profile-info-value">
							<span class="editable" id="about"><?=$info_deposito->nombre_cliente?></span>

						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Folio cliente </div>

						<div class="profile-info-value">
							<span class="editable" id="about"><?=$folio_cliente?></span>
							<input type="hidden" value="<?=$folio_cliente?>" id="folio_cliente">
							<input type="hidden" value="<?=$info_deposito->id_deposito?>" id="id_deposito">
							<input type="hidden" value="<?=$info_deposito->id_cliente?>" id="id_cliente">
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-6">
	            <div class="profile-user-info profile-user-info-striped ">
					
					<div class="profile-info-row">
						<div class="profile-info-name"> Monto </div>

						<div class="profile-info-value">
							<span class="editable" id="age">$<?=convierte_moneda($info_deposito->monto_deposito)?></span>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Comisión </div>

						<div class="profile-info-value">
							<span class="editable" id="signup">$<?=convierte_moneda($comision_cliente)?></span>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Retornar </div>

						<div class="profile-info-value">
							<span class="editable" id="login">$<?=convierte_moneda($monto_retornar)?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="form-horizontal col-xs-12" style='margin-top:20px'>
        		<div class="form-group">
        			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Selecciona una forma </label>
					<div class="col-sm-3">
						<select id="forma-retorno" onchange="agrega_forma_retorno(this.value, '<?=$folio_cliente?>', <?=$info_deposito->id_deposito?>)" class="form-control">
							<option value =""> selecciona una forma</option>
							<option value="cheque">Cheque</option>
							<option value="spei">Spei</option>
							<option value="efectivo">Efectivo</option>
						</select>
					</div>
	        	</div>
	        </div>

	        <div class="table-responsive">
	        	<table class="table table-striped table-bordered table-hover" >
	        		<thead>
		        		<tr>
		        			<th>Forma de retorno</th>
		        			<th>Monto</th>
		        			<th>Edit</th>
		        			<th>View</th>
		        			<th>Delete</th>
		        		</tr>
	        		</thead>
	        		<tbody id="lista-retornos">
	        		</tbody>
	        	</table>
	        </div>

        </div>

        
    </div>
</div>
<script type="text/javascript">
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

<?php $this->load->view('admin/cuentas/formatoRetorno/modal_spei');?>
<?php $this->load->view('admin/cuentas/formatoRetorno/modal_cheque');?>


