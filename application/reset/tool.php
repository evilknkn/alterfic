<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tool extends CI_controller{

	function __construct()
	{
		parent::__construct();
		
		if($this->session->userdata('USER_NAME') == '')
        {
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
		//$this->load->model('sectur/toolsecturmodel');
		$this->load->model('empresario/Dinfe_model');
	}

	public function resetUsuarios(){
			$this->load->model('toolsecturmodel');
		
		###### Actualiza estatus a cero en diagnostico #####
		$this->toolsecturmodel->actualizaDiagnostico();

		##### Actualizar estatus de captura de datos #####
		$arrayEstatus = array(	'datos_general' => 0,
								'avatar_img' => 0  ,
								'dinfe_estandar_competencia' => 0,
								'dinfe_capacitacion' => 0,
								'dinfe_certificacion' => 0,
								'dinfe_fortaleza' => 0,
								'dinfe_vinculacion' => 0,
								'resumen_dinfe' => 0);

		$this->toolsecturmodel->actualizaDatosEmpresario($arrayEstatus);
		
		##### Borrar solicitudes a un programa #####
		$this->toolsecturmodel->borrarSolicitudesPrograma();

		##### Borrar respuestas de autodianostico #####		

		$this->toolsecturmodel->borrarRespuestasDiagnostico();

		##### Borrar histoicos #####
		$reg_estandar = $this->Dinfe_model->retorna_registro(75);
		if(isset($reg_estandar->id_estandar)): $idUseruno =  $reg_estandar->id_estandar; else: $idUseruno =  ""; endif;

		$reg_estandar2 = $this->Dinfe_model->retorna_registro(76);
		if(isset($reg_estandar2->id_estandar)): $idUserdos =  $reg_estandar2->id_estandar; else: $idUserdos =  ""; endif;

		$certificacion = $this->Dinfe_model->return_registro_certificacion(75);
		if(isset($certificacion->id_certificacion)): $certifiicacionUno = $certificacion->id_certificacion; else: $certifiicacionUno = ""; endif;

		$certificacion2 = $this->Dinfe_model->return_registro_certificacion(75);
		if(isset($certificacion2->id_certificacion)): $certifiicacionDos = $certificacion2->id_certificacion; else: $certifiicacionDos = ""; endif;

		$this->toolsecturmodel->borrarHistoricos($idUseruno, $idUserdos, $certifiicacionUno, $certifiicacionDos);	

		$this->session->set_flashdata('success', 'Los usuarios han sido reseteados correctamente');
		redirect('sectur/inicio','refresh');
	}

}