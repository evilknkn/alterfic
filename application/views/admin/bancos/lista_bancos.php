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
        <li>Lista de bancos</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        	<!-- PAGE CONTENT BEGINS -->
			<div class="col-sm-12 col-xs-12">
			    	<p>Aquí usted puede ver la lista de bancos donde se reflejan los pagos de los clientes,
						asimismo puede registrar nuevos bancos ingresando el nombre en el campo "nombre banco" y haciendo clic en "guarda". </p>
			</div>

			<div class=" col-sm-12 col-xs-12 text-center col-sm-offset-3">
				<?php if($this->session->flashdata('success')):?>
				    <div class="text-center col-sm-9 col-xs-9">
				        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
				    </div>
			    <?php endif;?>
			    <?php if($this->session->flashdata('fail')):?>
				    <div class="text-center col-sm-12 col-xs-12">
				        <div class="alert alert-danger text-danger text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
				    </div>
			    <?php endif;?>

				<div class=" col-sm-4 col-xs-4">
					
					<table id="sample-table-2" class="table table-striped table-bordered table-hover">
					    <thead>
					        <tr>
					            <th>Nombre del banco</th>
					            <th class="text-center">Borrar</th>
					        </tr>
					    </thead>
					    <?php if(count($lista_bancos)!=0):?>
					    <tbody>
						    <?php foreach($lista_bancos as $banco):?>
						    	<tr>
						    		<td><?=$banco->nombre_banco?></td>
						    		<td class="text-center">
						    			<a href="<?=base_url('catalogos/banks/delete_bank/'.$banco->id_banco)?>" data-original-title="Haga clic aquí para borrar el banco">
						    				<i class="fa fa-trash fa-lg"></i>
						    			</a>
						    		</td>
						    	</tr>
							<?php endforeach;?>
						</tbody>	
						<?php else:?>
						<tbody>
							<tr>
								<td class="text-center" colspan="2">-- No hay bancos registrados -- </td>
							</tr>
						</tbody>
						<?php endif;?>
					</table>
					<br>
					<div class="col-sm-12 col-xs-12">
						<?=form_open('',array('class' => 'form-horizontal'))?>
							<label class="col-sm-4 col-xs-4 control-label no-padding-rigth">Nombre del banco </label>
							<div class="col-sm-8 col-xs-8">
								<div class="col-sm-8 col-xs-8">
									<input type="text" class="input-xlarge" required name="nombre_banco"> 
								</div>
								<div class="col-sm-4 col-xs-4"><button class="btn btn-primary"><i class="icon-plus"></i>Agregar</button></div>
							</div>
						<?=form_close();?>
					</div>
				</div>
			</div>
			<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
			<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
			<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			     
				  { "bSortable": false }
				] } );
					
			});
			</script>
<!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
