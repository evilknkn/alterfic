<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ToolSecturModel extends CI_Model{

	public function actualizaDiagnostico(){

		$this->db->where('id_usuario',75);
		$this->db->where('id_usuario',76);
		$this->db->update('dct_mgct_diagnostico',array('estatus' => 0));

	}

	public function actualizaDatosEmpresario($arrayEstatus){

		$this->db->where('id_usuario',76);
		$this->db->update('dct_empresarios_datos',$arrayEstatus);

		$this->db->where('id_usuario',75);
		$this->db->update('dct_empresarios_datos',$arrayEstatus);

	}

	public function borrarSolicitudesPrograma (){

		$this->db->where('id_usuario',75);
		$this->db->delete('dct_programas_solicitudes'); 

		$this->db->where('id_usuario',76);
		$this->db->delete('dct_programas_solicitudes'); 
	}

	public function borrarRespuestasDiagnostico(){
		
		$this->db->where('id_usuario',75);
		$this->db->delete('dct_mgct_respuestas'); 

		$this->db->where('id_usuario',76);
		$this->db->delete('dct_mgct_respuestas');

	}

	public function borrarHistoricos($idUseruno, $idUserdos, $certifiicacionUno, $certifiicacionDos){
		$this->db->where('id_usuario',75);
		$this->db->delete('dct_estandares_competencia');

		$this->db->where('id_estandar',$idUseruno);
		$this->db->delete('dct_estandares_personal');

		$this->db->where('id_usuario',75);
		$this->db->delete('dct_capacitacion');

		$this->db->where('id_usuario',75);
		$this->db->delete('dct_certificaciones');

		$this->db->where('id_certificacion',$certifiicacionUno);
		$this->db->delete('dct_certificacion_vigente');

		$this->db->where('id_usuario',75);
		$this->db->delete('dct_fortalecimiento');

		$this->db->where('id_usuario',75);
		$this->db->delete('dct_vinculacion_financiera');

		$this->db->where('id_usuario',75);
		$this->db->delete('dct_mensaje_destino');

		// $this->db->where('id_usuario',75);
		// $this->db->delete('dct_capacitacion');
		$this->db->where('id_usuario',76);
		$this->db->delete('dct_estandares_competencia');

		$this->db->where('id_estandar',$idUserdos);
		$this->db->delete('dct_estandares_personal');

		$this->db->where('id_usuario',76);
		$this->db->delete('dct_capacitacion');

		$this->db->where('id_usuario',76);
		$this->db->delete('dct_certificaciones');

		$this->db->where('id_certificacion',$certifiicacionDos);
		$this->db->delete('dct_certificacion_vigente');

		$this->db->where('id_usuario',76);
		$this->db->delete('dct_fortalecimiento');

		$this->db->where('id_usuario',76);
		$this->db->delete('dct_vinculacion_financiera');

		$this->db->where('id_usuario',76);
		$this->db->delete('dct_mensaje_destino');
	}
}