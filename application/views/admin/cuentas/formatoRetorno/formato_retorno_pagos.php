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
        <div class="col-xs-6">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="page-header">
                    <h1>Formato de retorno</h1>
                </div><!-- /.page-header -->
            </div>
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
					<div class="profile-info-name"> Monto a retornar </div>

					<div class="profile-info-value">
						<span class="editable" id="login">$<?=convierte_moneda($monto_retornar)?></span>
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
						<span class="editable" id="about"><?=$info_deposito->clave_folio?></span>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>