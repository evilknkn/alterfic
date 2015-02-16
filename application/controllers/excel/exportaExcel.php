<?php 
class exportaExcel extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }		
	}

	public function depositos()
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas_helper');

		$empresas 	= $this->depositos_model->lista_empresas(array('ace.tipo_usuario' => 1));
		$db			= $this->depositos_model;
		$db_mov		= $this->movimiento_model;

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
		            ->setCellValue('A1', strtoupper('Nombre de empresa'))
		            ->setCellValue('B1', strtoupper('Banco'))
		            ->setCellValue('C1', strtoupper('Total depósito'))
		            ->setCellValue('D1', strtoupper('Total salida'))
		            ->setCellValue('E1', strtoupper('Saldo'));


		$objPHPExcel->getActiveSheet()->getColumnDimension( 'A' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'B' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'C' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'D' )->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension( 'E' )->setAutoSize(true);

		$cellRespuesta=  $objPHPExcel->setActiveSheetIndex(0);
		$total_depto =0 ;
        $total_salida =0 ;
        $total_saldo = 0;
        $i=2;
		foreach($empresas as $empresa): 
            $depto = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito');
            $depto_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito_interno');
            
            $salida = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida');
            $salida_pago = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_pago');
            $salida_mov_int = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'mov_int');
            $salida_comision = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida_comision');
            
            $total_depto =   $depto + $depto_int;
            $total_salida = $salida + $salida_mov_int + $salida_pago + $salida_comision;

            $saldo = $total_depto - $total_salida; 
            $total_saldo = $total_saldo + $saldo;

            $cellRespuesta->setCellValue('A'.$i, $empresa->nombre_empresa);
            $cellRespuesta->setCellValue('B'.$i, $empresa->nombre_banco);
            $cellRespuesta->setCellValue('C'.$i, '$'.convierte_moneda($total_depto));
            $cellRespuesta->setCellValue('D'.$i, '$'.convierte_moneda($total_salida));
            $cellRespuesta->setCellValue('E'.$i, '$'.convierte_moneda($saldo));
           $i++;
        endforeach;
		 // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Reporte de depósitos');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_depositos_'.date('d-m-Y').'.xls"');
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