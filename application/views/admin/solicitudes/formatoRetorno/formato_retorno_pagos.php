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
						<div class="profile-info-name"> Comisión empresa</div>
						<div class="profile-info-value">
							<span class="editable" id="comision-empresa">$<?=$comision_empresa?></span>
						</div>
					</div>

					<div class="profile-info-row">
						<div class="profile-info-name"> Sobrante agente</div> open close
						<div class="profile-info-value">
							<span class="editable" id="sobrante-agente">$<?=$sobrante?></span>
						</div>
					</div>

				</div>
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


