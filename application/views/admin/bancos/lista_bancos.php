<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de bancos</li>
</ol>
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
		
		<table class="table tile">
		    <thead>
		        <tr>
		            <th>Nombre del banco</th>
		            <th class="text-center">Borrar</th>
		        </tr>
		    </thead>
		    <?php if(count($lista_bancos)!=0):?>
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
			<?php else:?>
				<tr>
					<td class="text-center" colspan="2">-- No hay bancos registrados -- </td>
				</tr>
			<?php endif;?>
		</table>

		<div class="col-sm-12 col-xs-12">
			<?=form_open('',array('class' => 'form-horizontal'))?>
			<div class="form-group">
				<label class=" control-label col-sm-4 col-xs-4">Nombre banco </label>
				<div class="col-xs-8 col-sm-8">
					<div >
						<input type="text" name="nombre_banco" class="form-control" required >
						<button class="btn "><i class=" fa fa-plus"></i> Agregar </button>
					</div>
				</div>
				<div class="col-sm-12 col-xs-12">&nbsp;</div>
					<div class="col-xs-12  col-sm-12"><?=form_error('nombre_banco')?></div>
			</div>
			<?=form_close();?>
		</div>
	</div>
</div>
