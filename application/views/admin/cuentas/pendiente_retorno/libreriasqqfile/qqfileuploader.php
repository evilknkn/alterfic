<?php

class qqFileUploader {
	
    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function initializer(array $allowedExtensions = array(), $sizeLimit = 10485760, $formObj, $xhrObj){        
        $allowedExtensions = array_map("strtolower", $allowedExtensions);
            
        $this->allowedExtensions = $allowedExtensions;        
        $this->sizeLimit = $sizeLimit;
        
        $this->checkServerSettings();       

        if (isset($_GET['qqfile'])) {
            $this->file = $xhrObj;
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = $formObj;
        } else {
            $this->file = false; 
        }
    }
    
    private function checkServerSettings(){        
        $postSize = $this->toBytes(ini_get('post_max_size'));
        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));        
        
        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit){
            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';             
            die("{'error':'increase post_max_size and upload_max_filesize to $size'}");    
        }        
    }
    
    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;        
        }
        return $val;
    }
    
    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE){
        if (!is_writable($uploadDirectory)){
            return array('error' => "Error de servidor: el directorio es de solo lectura.");
        }
        
        if (!$this->file){
            return array('error' => 'No hay archivos para subir.');
        }
        
        $size = $this->file->getSize();
        
        if ($size == 0) {
            return array('error' => 'El archivo está vacío');
        }
        
        if ($size > $this->sizeLimit) {
            return array('error' => 'El archivo es demasiado grande');
        }
        
        $pathinfo = pathinfo($this->file->getName());
        $filename = sha1($pathinfo['filename']);
        //$filename = uniqid();
        //$filename = md5(uniqid());
        $ext = $pathinfo['extension'];
        $filename = sha1($filename. '.' . $ext).rand(10, 1000);
        //print_r($filename);
        
        if($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)){
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'El formato es inválido, el archivo debe tener alguno de estos formatos: '. $these . '.');
        }
        
        if(!$replaceOldFile){
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $filename. '.' . $ext)) {
                //$filename .= rand(10, 99);
                $filename .= ($filename);
            }
        }
        
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)){
            //return array('success'=>true, 'directory' => $uploadDirectory . $filename . '.' . $ext);
            return array('success'=>true, 'directory' =>  $filename ) ;
        } else {
            return array('error'=> 'Error al guardar el archivo en el servidor.' .
                ' Se canceló la carga del archivo.');
        }
        
    }    
}

/* Fin del archivo: qqFileUploader.php */
/* Ubicación: ./application/libraries/qqFileUploader.php */
