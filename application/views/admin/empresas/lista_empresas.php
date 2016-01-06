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
        <li>Lista de empresas</li>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
        	<!-- PAGE CONTENT BEGINS -->
        	<div class=" col-sm-12 col-xs-12  ">
			<?php if($this->session->flashdata('success')):?>
			    <div class="text-center col-sm-9 col-xs-9">
			        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
			    </div>
		    <?php endif;?>

		  	<?php if($this->session->userdata('ID_PERFIL') == 6): ?>
		    <a href="<?=base_url('catalogos/corps/add_empresa_persona')?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Agregar empresa o persona</a>
		<?php endif; ?>
		    <br><br><br>
							
				<table id="sample-table-2" class="table table-striped table-bordered table-hover">
				    <thead>
				        <tr>
				            <th>Nombre empresa</th>
				            <th class="text-center">Banco</th>
				            <th>No. cuenta</th>
				            <th>Clabe</th>
				            <th>Tipo de cuenta</th>
				            <?php if($this->session->userdata('ID_PERFIL') == 6): ?>
				            	<th>Agregar banco</th>
				            
					            <th>Editar</th>
					            <th class="text-center">Borrar</th>
					        <?php endif;?>
				        </tr>
				    </thead>
				    <tbody>
				    	<?php foreach($empresas as $empresa):
				    	$nombre_banco = bancos_empresa($db, $empresa->id_empresa);
				    	$nombre_banco = join(',', $nombre_banco)?>
				    	<tr>
				    		<td><?=$empresa->nombre_empresa;?></td>
				    		<td><?=$nombre_banco?> <br>
				    		<!-- botón de activar o desactivar bancos  -->
				    		<?php if($this->session->userdata('ID_PERFIL') == 6): ?>
				    			<button class="btn btn-info" data-toggle="modal" href="#bancos" onclick="bancos_empresa(<?=$empresa->id_empresa?>)"> Bancos activos</button> 
				    		<?php endif;?>
				    		</td>
				    		<td><?=$empresa->no_cuenta?></td>
				    		<td><?=$empresa->clabe_bancaria?></td>
				    		<td><?=($empresa->tipo_usuario ==1 )?'Empresa':'Persona';?></td>
				    		<?php if($this->session->userdata('ID_PERFIL') == 6): ?>
				    		
					    		<td class="text-left" style="width:18%">
					    			
						    			<?=form_open('catalogos/corps/add_banco')?>
						    			<input type="hidden" name="id_empresa" value="<?=$empresa->id_empresa?>" >
						    			<select name="id_banco" class="input-large"required>
											<option value="">Seleccione un banco</option>
											<?php foreach($bancos as $banco):?>
												<option value="<?=$banco->id_banco?>"><?=$banco->nombre_banco?> </option>
											<?php endforeach;?>
										</select>
										<button class="btn btn-info"> Agregar</button>
										<?=form_close();?>
					    		</td>
				    		
					    		<td class="text-center"> 
					    			<a href="<?=base_url('catalogos/corps/edit_corp/'.$empresa->id_empresa)?>" data-original-title="Haga clic aquí para editar datos">
					    				<i class="fa fa-edit fa-lg"></i>
					    			</a>
					    		</td>
					    		<td  class="text-center">
					    			<a href="<?=base_url('catalogos/corps/delete_corp/'.$empresa->id_empresa)?>" data-original-title="Haga clic aquí para borrar el banco">
					    				<i class="fa fa-trash fa-lg"></i>
					    			</a>
					    		</td>
				    		<?php endif;?>
				    	</tr>
				    	<?php endforeach?>
				    </tbody>
				</table>				
			</div>

			<?=$this->load->view('admin/empresas/modal_bancos')?>

			<script src="<?php echo base_url()?>assets/js/jquery.dataTables.min.js"></script>
			<script src="<?php echo base_url()?>assets/js/jquery.dataTables.bootstrap.js"></script>
			<script type="text/javascript">
			jQuery(function($) {
				<?php if($this->session->userdata('ID_PERFIL') == 6): ?>
					var oTable1 = $('#sample-table-2').dataTable( {
					"aoColumns": [
				      { "bSortable": false },
				     	null, null, null, null, null, null,
					  { "bSortable": false }
					] } );
				<?php else: ?>
					var oTable1 = $('#sample-table-2').dataTable( {
					"aoColumns": [
				      { "bSortable": false },
				     	null, null, null, 
					  { "bSortable": false }
					] } );
				<?php endif;?>
					
			});
			</script>

			<!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->
