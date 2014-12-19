<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Lista de empresas</li>
</ol>
<div class="col-sm-12 col-xs-12"><p>Aquí usted puede ver la lista de empresas cliente que se tienen registradas,
				asimismo puede registrar nuevas empresas ingresando el nombre en el campo "nombre de empresa" y haciendo clic en "guarda". </p>
				</div>
<div class=" col-sm-12 col-xs-12 text-center ">
	<?php if($this->session->flashdata('success')):?>
	    <div class="text-center col-sm-9 col-xs-9">
	        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
	    </div>
    <?php endif;?>
  	
    <div class="row col-sm-12 col-xs-12 text-left" style="margin-left:15px">
    	<a href="<?=base_url('catalogos/corps/add_empresa_persona')?>" class="btn"> <i class="fa fa-plus"></i> Agregar empresa o persona</a>
    </div>
	<div class=" col-sm-10 col-xs-10">
		<?=$this->load->view('includes/pagination');?>
		
			<table class="table tile tablesorter" style="margin-top:60px;font-size:15px">
			    <thead>
			        <tr>
			            <th>Nombre empresa</th>
			            <th class="text-center">Banco</th>
			            <th>No. cuenta</th>
			            <th>Clabe</th>
			            <th>Tipo de cuenta</th>
			            <th></th>
			            <th>Editar</th>
			            <th class="text-center">Borrar</th>
			        </tr>
			    </thead>
			    <tbody>
			    	<?php foreach($empresas as $empresa):
			    	$nombre_banco = bancos_empresa($db, $empresa->id_empresa);
			    	$nombre_banco = join(',', $nombre_banco)?>
			    	<tr>
			    		<td><?=$empresa->nombre_empresa;?></td>
			    		<td><?=$nombre_banco?></td>
			    		<td><?=$empresa->no_cuenta?></td>
			    		<td><?=$empresa->clabe_bancaria?></td>
			    		<td><?=($empresa->tipo_usuario ==1 )?'Empresa':'Persona';?></td>
			    		<td class="text-center">
			    			<?=form_open('catalogos/corps/add_banco')?>
			    			<input type="hidden" name="id_empresa" value="<?=$empresa->id_empresa?>" >
			    			<select name="id_banco" class=" m-b-10" style="background-color: transparent;height:25px;padding 5px;font-size: 15px;  ;width:190px;" required>
								<option value="">Seleccione un banco</option>
								<?php foreach($bancos as $banco):?>
									<option value="<?=$banco->id_banco?>"><?=$banco->nombre_banco?></option>
								<?php endforeach;?>
							</select>
							<button class="btn"> Agregar</button>
							<?=form_close();?>
			    		</td>
			    		<td>
			    			<a href="<?=base_url('catalogos/corps/edit_corp/'.$empresa->id_empresa)?>" data-original-title="Haga clic aquí para editar datos">
			    				<i class="fa fa-edit fa-lg"></i>
			    			</a>
			    		</td>
			    		<td  class="text-center">
			    			<a href="<?=base_url('catalogos/corps/delete_corp/'.$empresa->id_empresa)?>" data-original-title="Haga clic aquí para borrar el banco">
			    				<i class="fa fa-trash fa-lg"></i>
			    			</a>
			    		</td>
			    	</tr>
			    	<?php endforeach?>
			    </tbody>
			</table>				
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("table")
	.tablesorter({widthFixed: true, })
	.tablesorterPager({container: $("#pager")});
});
</script>
