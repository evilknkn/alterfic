<?php 
date_default_timezone_set('America/Mexico_City');
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
            $cellRespuesta->setCellValue('C'.$i, $total_depto);
            $cellRespuesta->setCellValue('D'.$i, $total_salida);
            $cellRespuesta->setCellValue('E'.$i, $saldo);
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

	public function detalle_depositos($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');

		$datos_empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'acb.id_banco' => $id_banco));
		
		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco);

		$movimientos 	= $this->movimiento_model->lista_movimientos($filtro, $this->session->userdata('fecha_ini_depositos'), $this->session->userdata('fecha_fin_depositos') );
		$clientes	= $this->clientes_model->lista_clientes();

		$db = $this->depositos_model;
		$db_mov = $this->movimiento_model;
		$db_cliente = $this->clientes_model;

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
		            ->setCellValue('A1', strtoupper('Fecha'))
		            ->setCellValue('B1', strtoupper('Depósito'))
		            ->setCellValue('C1', strtoupper('Salida'))
		            ->setCellValue('D1', strtoupper('Folio'))
		            ->setCellValue('E1', strtoupper('Comisión'))
		            ->setCellValue('F1', strtoupper('Monto a retornar'))
		            ->setCellValue('G1', strtoupper('Pendiente de reorno'))
		            ->setCellValue('H1', strtoupper('Total retornado'))
		            ->setCellValue('I1', strtoupper('Detalle'));

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
		
		$total_depto    = 0 ;
        $total_sal      = 0 ;        
        $comisio_cliente=0;
        $catidad_retornar=0;
        $pendiente=0;
        $pagos=0;
        foreach($movimientos as $movimiento): 
                        $type_mov = $movimiento->tipo_movimiento;
            if($type_mov == 'deposito')
            {
            	$deposito = lista_depositos($db_mov, $movimiento->folio_mov ); //print_r($deposito );exit;
                //print_r($deposito);
                $cantidad_deposito = $deposito->monto_deposito; 
                $cliente_asig = cliente_asignado($db_mov, $deposito->id_deposito);
                $total_depto = $total_depto + $deposito->monto_deposito;
                $comisio_cliente = genera_comision($db_cliente, $cliente_asig, $deposito->monto_deposito);
                $catidad_retornar = ($cantidad_deposito) - ($comisio_cliente) ;
                $pagos = total_pagos($db_mov, $id_empresa, $id_banco, $deposito->id_deposito);
                $pendiente=$catidad_retornar - $pagos;

                $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($movimiento->fecha_movimiento));
                $cellRespuesta->setCellValue('B'.$i, $cantidad_deposito);
                $cellRespuesta->setCellValue('C'.$i, '');
                $cellRespuesta->setCellValue('D'.$i, $movimiento->folio_mov);
                $cellRespuesta->setCellValue('E'.$i, $comisio_cliente);
                $cellRespuesta->setCellValue('F'.$i, $catidad_retornar);
                $cellRespuesta->setCellValue('G'.$i, $pendiente);
                $cellRespuesta->setCellValue('H'.$i, $pagos);
                $cellRespuesta->setCellValue('I'.$i, '');
            }else if( $type_mov == 'deposito_interno' )
            {
            	$deposito = lista_depositos($db_mov, $movimiento->folio_mov ); 
                //print_r($movimiento->folio_mov);exit;
                $cantidad_deposito = $deposito->monto_deposito;
                $total_depto = $total_depto + $cantidad_deposito;

                $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($movimiento->fecha_movimiento));
                $cellRespuesta->setCellValue('B'.$i, $cantidad_deposito);
                $cellRespuesta->setCellValue('C'.$i, '');
                $cellRespuesta->setCellValue('D'.$i, $movimiento->folio_mov);
                $cellRespuesta->setCellValue('E'.$i, '');
                $cellRespuesta->setCellValue('F'.$i, '');
                $cellRespuesta->setCellValue('G'.$i, '');
                $cellRespuesta->setCellValue('H'.$i, '');
                $cellRespuesta->setCellValue('I'.$i, 'Movimiento depósito interno');
            }else
            {
                $salida = lista_salidas($db_mov, $movimiento->folio_mov);
                $total_sal = $total_sal + $salida->monto_salida;

                $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($movimiento->fecha_movimiento));
                $cellRespuesta->setCellValue('B'.$i, '');
                $cellRespuesta->setCellValue('C'.$i, $salida->monto_salida);
                $cellRespuesta->setCellValue('D'.$i, $movimiento->folio_mov);
                $cellRespuesta->setCellValue('E'.$i, '');
                $cellRespuesta->setCellValue('F'.$i, '');
                $cellRespuesta->setCellValue('G'.$i, '');
                $cellRespuesta->setCellValue('H'.$i, '');
                $cellRespuesta->setCellValue('I'.$i, $salida->detalle_salida);
            }

        $i++;
        endforeach;

		 // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Reporte detalle depósitos');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_detalle_depositos_'.date('d-m-Y').'.xls"');
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

	public function movimientos_internos($id_empresa, $id_banco)
	{	
		$this->load->model('cuentas/movimientos_internos_model', 'movimientos_model');
		$this->load->model('catalogo/empresas_model');
		$this->load->helper('funciones_externas');

		$empresa_data = $this->empresas_model->empresa(array('id_empresa'=>$id_empresa));

		$nombre_empresa = $empresa_data->nombre_empresa;
		$db	= $this->empresas_model;

		$filtro = array('id_empresa'=> $id_empresa, 'id_banco' => $id_banco, 'fecha_mov >=' => $this->session->userdata('fecha_ini_mov_int'), 'fecha_mov <= ' => $this->session->userdata('fecha_fin_mov_int')) ;
		$movimientos = $this->movimientos_model->lista_movimientos($filtro);

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
		            ->setCellValue('B1', strtoupper('Fecha'))
		            ->setCellValue('C1', strtoupper('Monto'))
		            ->setCellValue('D1', strtoupper('Folio entrada'))
		            ->setCellValue('E1', strtoupper('Folio salida'));


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
		foreach($movimientos as $movimiento): 
            

            $cellRespuesta->setCellValue('A'.$i, nombre_empresa($db, $movimiento->empresa_destino));
            $cellRespuesta->setCellValue('B'.$i, formato_fecha_ddmmaaaa($movimiento->fecha_mov));
            $cellRespuesta->setCellValue('C'.$i, $movimiento->monto);
            $cellRespuesta->setCellValue('D'.$i, $movimiento->folio_entrada);
            $cellRespuesta->setCellValue('E'.$i, $movimiento->folio_salida);
           $i++;
        endforeach;
		 // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Reporte de movimientos internos');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_mov_internos_'.date('d-m-Y').'.xls"');
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

	public function depositos_persona()
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas_helper');

		$empresas 	= $this->depositos_model->lista_empresas(array('ace.tipo_usuario' => 2));
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
		$i=2;
		$total_depto =0 ;
        $total_salida =0 ;
        $total_saldo = 0;
        foreach($empresas as $empresa): 

        $depto  = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'deposito');
        $salida = montos($db_mov, $empresa->id_empresa, $empresa->id_banco, 'salida');

        $saldo = $depto - $salida; 

        $total_depto = $total_depto + $depto;
        $total_salida = $total_salida + $salida;
        $total_saldo = $total_saldo + $saldo;

            $cellRespuesta->setCellValue('A'.$i, $empresa->nombre_empresa);
            $cellRespuesta->setCellValue('B'.$i, $empresa->nombre_banco);
            $cellRespuesta->setCellValue('C'.$i, $depto);
            $cellRespuesta->setCellValue('D'.$i, $salida);
            $cellRespuesta->setCellValue('E'.$i, $saldo);
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

	public function detalle_depositos_persona($id_empresa, $id_banco)
	{
		$this->load->model('cuentas/depositos_model');
		$this->load->model('users/clientes_model');
		$this->load->model('cuentas/detalle_cuenta_model', 'movimiento_model');
		$this->load->helper('funciones_externas_helper');
		$this->load->helper('cuentas');

		$datos_empresa = $this->depositos_model->empresa(array('ace.id_empresa' => $id_empresa, 'acb.id_banco' => $id_banco));
		
		$filtro = array('adc.id_empresa' => $id_empresa, 'adc.id_banco' => $id_banco);

		$movimientos 	= $this->movimiento_model->lista_movimientos($filtro, $this->session->userdata('fecha_ini_deposito_per'), $this->session->userdata('fecha_fin_deposito_per') );
		$clientes	= $this->clientes_model->lista_clientes();

		$db = $this->depositos_model;
		$db_mov = $this->movimiento_model;
		$db_cliente = $this->clientes_model;

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
		            ->setCellValue('A1', strtoupper('Fecha'))
		            ->setCellValue('B1', strtoupper('Depósito'))
		            ->setCellValue('C1', strtoupper('Salida'))
		            ->setCellValue('D1', strtoupper('Folio'))
		            ->setCellValue('E1', strtoupper('Detalle'));

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
		
		$total_depto    = 0 ;
        $total_sal      = 0 ;        
        $comisio_cliente=0;
        $catidad_retornar=0;
        $pendiente=0;
        $pagos=0;
        foreach($movimientos as $movimiento): 
                        $type_mov = $movimiento->tipo_movimiento;
            if($type_mov == 'deposito')
            {
            	$deposito = lista_depositos($db_mov, $movimiento->folio_mov ); //print_r($deposito );exit;
                //print_r($deposito);
                $cantidad_deposito = $deposito->monto_deposito; 
                $cliente_asig = cliente_asignado($db_mov, $deposito->id_deposito);
                $total_depto = $total_depto + $deposito->monto_deposito;
                $comisio_cliente = genera_comision($db_cliente, $cliente_asig, $deposito->monto_deposito);
                $catidad_retornar = ($cantidad_deposito) - ($comisio_cliente) ;
                $pagos = total_pagos($db_mov, $id_empresa, $id_banco, $deposito->id_deposito);
                $pendiente=$catidad_retornar - $pagos;

                $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($movimiento->fecha_movimiento));
                $cellRespuesta->setCellValue('B'.$i, $cantidad_deposito);
                $cellRespuesta->setCellValue('C'.$i, '');
                $cellRespuesta->setCellValue('D'.$i, $movimiento->folio_mov);
            }else if( $type_mov == 'deposito_interno' )
            {
            	$deposito = lista_depositos($db_mov, $movimiento->folio_mov ); 
                //print_r($movimiento->folio_mov);exit;
                $cantidad_deposito = $deposito->monto_deposito;
                $total_depto = $total_depto + $cantidad_deposito;

                $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($movimiento->fecha_movimiento));
                $cellRespuesta->setCellValue('B'.$i, $cantidad_deposito);
                $cellRespuesta->setCellValue('C'.$i, '');
                $cellRespuesta->setCellValue('D'.$i, $movimiento->folio_mov);
            }else
            {
                $salida = lista_salidas($db_mov, $movimiento->folio_mov);
                $total_sal = $total_sal + $salida->monto_salida;

                $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($movimiento->fecha_movimiento));
                $cellRespuesta->setCellValue('B'.$i, '');
                $cellRespuesta->setCellValue('C'.$i, $salida->monto_salida);
                $cellRespuesta->setCellValue('D'.$i, $movimiento->folio_mov);
                $cellRespuesta->setCellValue('E'.$i, $salida->detalle_salida);
            }

        $i++;
        endforeach;

		 // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Reporte detalle depósitos');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_detalle_depositos_'.date('d-m-Y').'.xls"');
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
