<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archivos extends  CI_Controller {
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }
		
		$this->load->model('Repositorio_model');
		
	}
	function descarga ($crypto){
		
		$datos = $this->Repositorio_model->valida_imagen($crypto);
		
		if(count($datos)>0):
			$ext=  substr($datos->nombre_archivo, -3);

			//$fichero = PATH.$datos->ruta_repo.$datos->clave_repo.'.'.$ext;
			$fichero = $fichero = base_url().$datos->ruta_repo.$datos->clave_repo.'.'.$ext;
			$file = $fichero;
			//echo basename($datos->nombre_archivo);
			$nombre = genera_slug($datos->nombre_archivo);
			//echo $fichero;
			redirect($fichero);
			//print_r($fichero);exit;
	
					// header('Content-Description: File Transfer');
				 //    header('Content-Type: '.$datos->mime);
				 //    header('Content-Disposition: attachment; filename='.basename($datos->nombre_archivo));
				 //    header('Content-Disposition: attachment; filename='.$datos->nombre_archivo);
				 //    header('Content-Length: ' . $datos->bytes);
				 //    ob_clean();
				 //     flush();
				 //    readfile($fichero);
				    exit;
			

			//$this->load->view('soporte_view/test_image');
		else:
			echo "Ruta de archivo no encontrada ";
		endif;
	}

	private function mime_extension ($crypto){
		$datos = $this->Repositorio_model->valida_imagen($crypto);	
	}

	public function subir_archivo(){

		$carpeta 	= 	$this->input->get('carpeta');
		$qqfile 	=	$this->input->get('qqfile');
		
		$this->load->library('qqFileUploader');
		$this->load->library('qqUploadedFileForm');
		$this->load->library('qqUploadedFileXhr');
		$this->load->helper('funciones_externas');
		//$this->load->model('documento');

		create_file($carpeta);
		  
		
		$path = "files/".$carpeta."/";
        $targetPath =  $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . "/files/";
      
		usleep(100000);

		$fileName;
		$fileSize;
		$extension = null;
		
		if (isset($_GET['qqfile'])){
		    $fileName = $_GET['qqfile'];
		    $extension = $_GET['extension'];
			// xhr request
			$headers = apache_request_headers();
			$fileSize = (int)$headers['Content-Length'];
		} elseif (isset($_FILES['qqfile'])){
			$extension = $_POST['extension'];
		    $fileName = genera_slug(basename($_FILES['qqfile']['name']));
		    $fileSize = $_FILES['qqfile']['size'];
		} else {
			die ('{error: "server-error file not passed"}');
		}
		

		
        $tam_max = 4;
		$allowed_extensions = explode('|', $extension);
		$size_limit = $tam_max * 1024 * 1024;
		$this->qqfileuploader->initializer($allowed_extensions, $size_limit, $this->qquploadedfileform, $this->qquploadedfilexhr);
		$resultado = $this->qqfileuploader->handleUpload($path, TRUE);

		
		if(isset($resultado['success']) ){
			$nombre_archivo = genera_slug($fileName);
			$clave = $resultado['directory'];
			
			$ruta = $path;
			$mime = get_mime_by_extension($fileName);
			$bytes= $fileSize;
			$this->Repositorio_model->insert_repo($nombre_archivo, $clave, $ruta, $nombre_archivo, $mime, $bytes);

			$resultado = array('success'=>1, 'directory' => 'archivos/descarga/'.$clave);

		}
		echo htmlspecialchars(json_encode($resultado), ENT_NOQUOTES);
		/*
		echo '{error:"Pruebas"}';*/
	}

	
}