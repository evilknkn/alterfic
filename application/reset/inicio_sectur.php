<?php 
$msj_success=$this->session->flashdata('success');
if($msj_success) {	?>
	<div class="alert alert-success center" style="padding:5px;">
	<?php echo $msj_success;?>
	</div>	
<?php } ?>	

<?php 


$nombre 		=	$data->nombre;
$domicilio 		= 	$data->domicilio;
$link_img		=	!empty($data->ruta_imagen) ? base_url(). $data->ruta_imagen : base_url()."expedientes/perfiles/no_found.jpg" ;
$correo 		=	$data->correo;
$lada_tel		= 	$data->lada_tel;
$telefono		=	$data->numero_tel;
$ext 			= 	$data->ext_tel;
$lada_cel 		= 	$data->lada_cel;
$celular 		= 	$data->numero_cel;
$municipio 		=	$data->municipio;	
$acceso			=   $acceso_anterior;
$rfc 			= 	$data->rfc;

if($acceso != "0000-00-00 00:00:00"){
$acceso_fecha = formato_fecha_texto(substr($acceso,0,10));
$acceso_time  = substr($acceso,11,19);

$acceso = $acceso_fecha. " a las ". $acceso_time; 
}else{ $acceso=" Primer ingreso.";}

?>
 <div class="container">
	<div id="user-profile-3" class="row">
		<div class="col-xs-12 col-sm-4 center" style="padding:0;margin:0;">
			<div>
				<span class="profile-picture">
					<a href="<?php echo base_url('sectur/usuario/cambiar_img');?>"><img style="height:100px;"  class="img-responsive" alt="<?php echo $nombre; ?>" src="<?php echo $link_img;?>"></img></a>
				</span>
				<div class="width-80 ">
					<div class="inline position-relative">
					<?php echo $nombre; ?>
					</div>
				</div>
				<div>				
					<div class="space-6"></div>
					<a href="<?php echo base_url('sectur/usuario/cambiar_img');?>" class="btn btn-sm btn-primary">
						<i class="icon-camera bigger-120 middle"></i>
						<span class="bigger-110">Cambiar foto de perfil</span>
					</a>
					<div class="space-6"></div>
				</div>
			</div>		
		</div>

		<div class="col-xs-12 col-sm-8" style="padding:0;margin:0;">
			<div class="profile-user-info profile-user-info-striped">
				<div class="profile-info-row"> 
					<div class="profile-info-name"><i class="icon-calendar blue bigger-110  profile-value-icon"></i> Último acceso</div>
					<div class="profile-info-value">
						<span class="profile-value-span"><?php echo $acceso; ?></span>
					</div>
				</div>
			</div>

			<div class="space-4"></div>
			<div class="profile-user-info profile-user-info-striped">
				<div class="profile-info-row">
					<div class="profile-info-name"><i class="icon-user blue bigger-110 profile-value-icon"></i>Domicilio</div>
					<div class="profile-info-value">
						<spa class="profile-value-span"><?php echo $domicilio; ?></span>
					</div>
				</div>
				<div class="profile-info-row">
					<div class="profile-info-name"><i class="icon-map-marker blue bigger-110 profile-value-icon"></i> Municipio </div>
					<div class="profile-info-value">
						<span class="profile-value-span"><?php echo $municipio; ?></span>
					</div>
				</div>
				<div class="profile-info-row">
					<div class="profile-info-name"><i class="icon-folder-open blue bigger-110 profile-value-icon"></i> R.F.C. </div>
					<div class="profile-info-value">
						<span class="profile-value-span"><?php echo $rfc; ?></span>
					</div>
				</div>
				<div class="profile-info-row">
					<div class="profile-info-name"><i class="icon-envelope blue bigger-110 profile-value-icon"></i> Correo </div>
					<div class="profile-info-value">
						<span class="profile-value-span"><?php echo $correo; ?></span>
					</div>
				</div>
				<div class="profile-info-row">
					<div class="profile-info-name"><i class="icon-phone blue bigger-110 profile-value-icon"></i> Teléfono </div>
					<div class="profile-info-value">
						<span class="profile-value-span"><?php echo "(".$lada_tel.") ". $telefono." Ext. " .$ext; ?></span>
					</div>
				</div>

				<div class="profile-info-row">
					<div class="profile-info-name"><i class="icon-mobile-phone blue bigger-110 profile-value-icon"></i> Celular </div>
					<div class="profile-info-value">
						<span class="profile-value-span"><?php echo "(".$lada_cel.") ".$celular; ?></span>
					</div>
				</div>
			</div>
			<div class="space-12"></div>
			
			<div class="profile-user-info center">	
				<?php if($this->session->userdata('ID_USER') == 3 or $this->session->userdata('ID_USER') ==51):?>
				<a href="<?=base_url('sectur/tool/resetUsuarios')?>" class="btn btn-sm btn-primary">
					<i class="icon-cog bigger-120 middle"></i>
					<span class="bigger-110">Resetear usuarios de prueba empresario</span>
				</a>			
				<?php endif;?>
				<a href="<?php echo base_url('sectur/usuario/datos_general');?>" class="btn btn-sm btn-primary" style="margin-left:10px;">
					<i class="icon-edit bigger-120 middle"></i>
					<span class="bigger-110">Actualizar perfil</span>
				</a>						
			</div><div class="space-12"></div>
		</div>	
		
		<div class="page-header">
			<h1> Tickets de soporte abiertos </h1>
		</div>

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Asunto</th>
					<th>Teléfono</th>
					<th>Correo</th>
					<th>Fecha de creación</th>
				</tr>
			</thead>

			<tbody>
				<?php if(count($tickets_abiertos)!=0):?>
				<?php foreach ($tickets_abiertos as $ticket ) :	

				$created_fecha = formato_fecha_texto(substr($ticket->created,0,10));
				$created_time  = substr($ticket->created,11,19);

				$fecha_creacion = $created_fecha. " a las ". $created_time; 

?>
				<tr>
					<td><?php echo $ticket->name?></td>
					<td><?php echo $ticket->subject?></td>
					<td><?php echo $ticket->phone?></td>
					<td><?php echo $ticket->email?></td>
					<td><?php echo $fecha_creacion ?></td>
				</tr>
				<?php endforeach;
				else:
				?>
				<tr>
					<td colspan="5" class="center">-- No hay tickets abiertos --</td>
				</tr>
				<?php endif; ?>
			</tbody>

		</table>
		 
    </div><!-- /user-profile -->
</div>