<?php 
class Pendiente_retorno extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }		
	}

	public function info($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');

		$db = $this->retorno_model;
		$id_empresa	= $id_empresa;
		$id_banco 	= $id_banco;
		
		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco, 'adc.tipo_movimiento' => 'deposito',  'adc.fecha_movimiento >=' => $this->session->userdata('fecha_ini_retorno'),'adc.fecha_movimiento <=' => $this->session->userdata('fecha_fin_retorno'));
		$depositos = $this->retorno_model->detalle_retorno($filtro);


		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('America/Mexico_City');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

			/** Include PHPExcel */
		require_once PATH.'/assets/phpexcel/phpexcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', strtoupper('Fecha depósito'))
		            ->setCellValue('B1', strtoupper('Folio'))
		            ->setCellValue('C1', strtoupper('Monto del depósito'))
		            ->setCellValue('D1', strtoupper('Cliente'))
		            ->setCellValue('E1', strtoupper('Comisión'))
		            ->setCellValue('F1', strtoupper('Pagos'))
		            ->setCellValue('G1', strtoupper('Pendiente retorno'));


		$objPHPExcel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize(true);

		$cellRespuesta=  $objPHPExcel->setActiveSheetIndex(0);
		
        $i=2;
		foreach($depositos as $deposito): 
          	$comision = genera_comision($db, $deposito->id_cliente, $deposito->monto_deposito); 
            $pagos = total_pagos($db, $id_empresa, $id_banco, $deposito->id_deposito);
            $pendiente_retorno = $deposito->monto_deposito - ($comision + $pagos);
            $cliente = cliente_asignado_deposito($db, $deposito->id_cliente);

            $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($deposito->fecha_deposito));
            $cellRespuesta->setCellValue('B'.$i, $deposito->folio_depto);
            $cellRespuesta->setCellValue('C'.$i, round($deposito->monto_deposito, 2));
            $cellRespuesta->setCellValue('D'.$i, $cliente);
            $cellRespuesta->setCellValue('E'.$i, round($comision,2));
            $cellRespuesta->setCellValue('F'.$i, round($pagos,2));
            $cellRespuesta->setCellValue('G'.$i, round($pendiente_retorno, 2));
           $i++;
        endforeach;
		
		 // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Reporte pendiente de retorno');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_pendiente_retorno_'.date('d-m-Y').'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}

	public function gral()
	{
		$this->load->model('cuentas/retorno_model');
		$this->load->helper('funciones_externas');


		$catalogo_empresas = $this->retorno_model->all_empresas();
		if(isset($id_empresa) and $id_empresa >0):
			$empresas = $this->retorno_model->empresa_general_filtro($id_empresa);
		else:
			$empresas = $this->retorno_model->empresas_general();
		endif;
		$db = $this->retorno_model;


		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('America/Mexico_City');

		if (PHP_SAPI == 'cli')
			die('This example should only be run from a Web Browser');

			/** Include PHPExcel */
		require_once PATH.'/assets/phpexcel/phpexcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file");


		// Add some data
		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', strtoupper('Nombre empresa'))
		            ->setCellValue('B1', strtoupper('Banco'))
		            ->setCellValue('C1', strtoupper('Fecha de depósito'))
		            ->setCellValue('D1', strtoupper('Folio'))
		            ->setCellValue('E1', strtoupper('Monto depósito'))
		            ->setCellValue('F1', strtoupper('Cliente'))
		            ->setCellValue('G1', strtoupper('Comisión'))
		            ->setCellValue('H1', strtoupper('Pagos'))
		            ->setCellValue('I1', strtoupper('Pendiente retorno'));

		$objPHPExcel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'F' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'G' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'H' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'I' )->setAutoSize(true);

		$cellRespuesta=  $objPHPExcel->setActiveSheetIndex(0);
		
        $i=2;
		$id_empresa = 0;
        $id_banco   = 0;

        foreach($empresas as $empresa){
            if($id_empresa != $empresa->id_empresa and $id_banco != $empresa->id_banco){
                $depositos = depositos_pendiente_retorno_gral($db, $empresa->id_empresa, $empresa->id_banco);

            	foreach($depositos as $deposito){
            		$cliente = cliente_asignado_deposito($db, $deposito->id_cliente);
                    $comision = genera_comision($db, $deposito->id_cliente, $deposito->monto_deposito); 
                    $pagos = total_pagos($db, $empresa->id_empresa, $empresa->id_banco, $deposito->id_deposito);
                    $pendiente_retorno = $deposito->monto_deposito - ($comision + $pagos);
                    if($pendiente_retorno > 10){
                    	$cellRespuesta->setCellValue('A'.$i, $empresa->nombre_empresa);
			            $cellRespuesta->setCellValue('B'.$i, $empresa->nombre_banco);
			            $cellRespuesta->setCellValue('C'.$i, formato_fecha_ddmmaaaa($deposito->fecha_deposito));
			            $cellRespuesta->setCellValue('D'.$i, $deposito->folio_depto);
			            $cellRespuesta->setCellValue('E'.$i, round($deposito->monto_deposito,2));
			            $cellRespuesta->setCellValue('F'.$i, $cliente);
			            $cellRespuesta->setCellValue('G'.$i, round($comision, 2));
			            $cellRespuesta->setCellValue('H'.$i, round($pagos, 2));
			            $cellRespuesta->setCellValue('I'.$i, round($pendiente_retorno, 2));
			            $i++;
                    }
               	}

            }           
           
        }
		
		 // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Reporte pendiente gral');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_pendiente_gral'.date('d-m-Y').'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
}