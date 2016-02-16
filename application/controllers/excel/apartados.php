<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');
class Apartados extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if($this->session->userdata('USERNAME') == '' ){
			
            $regresar = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://' ) . $_SERVER["SERVER_NAME"] . $_SERVER['REQUEST_URI'];
            redirect( base_url() . 'login/index?r='.urlencode($regresar) );
        }		
	}

	public function info($tipo_excel = null)
	{
		$this->load->model('tool/eloquent_model');
		$this->load->helper('utilerias');
		$this->load->helper('funciones_externas');

		$db = $this->eloquent_model;

		$fecha = fechas_rango_inicio(date('m'));

		$fecha_ini = ($this->input->post('fecha_inicio')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_inicio')) : $fecha['fecha_inicio'] ;
		$fecha_fin = ($this->input->post('fecha_final')) ? formato_fecha_ddmmaaaa($this->input->post('fecha_final')) : $fecha['fecha_fin'] ;

		$select_param 	= 'deptos.status_retorno, deptos.id_deposito, deptos.fecha_deposito, deptos.monto_deposito, deptos.id_cliente, deptos.folio_depto, detail.id_empresa, detail.id_banco, cliente.nombre_cliente, cliente.comision, empresa.nombre_empresa, banco.nombre_banco';
		$table_from 	= "ad_depositos deptos";
		$inner[0]		= array('table'=> 'ad_detalle_cuenta detail', 'on_table' => 'deptos.id_deposito = detail.id_movimiento', 'type_join' => 'inner' );
		$inner[1]		= array('table'=> 'ad_catalogo_bancos banco', 'on_table' => 'banco.id_banco=detail.id_banco', 'type_join' => 'inner' );
		$inner[2]		= array('table'=> 'ad_catalogo_empresa empresa', 'on_table' => 'empresa.id_empresa = detail.id_empresa', 'type_join' => 'inner' );
		$inner[3]		= array('table'=> 'ad_catalogo_cliente cliente', 'on_table' => 'cliente.id_cliente = deptos.id_cliente', 'type_join' => 'left' );
		//$whereIn_array	= array('detail.tipo_movimiento', array('deposito') );
		if( $tipo_excel=='general')
		{
			$whereIn_array	= array('detail.tipo_movimiento', array('deposito') );
			$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin);
			$headers 	= array('Nombre Empresa', 'Banco', 'Fecha depósito', 'Folio', 'Nombre cliente', 'Depósito', 'Comisión'); 

		}else if( $tipo_excel=='pendientesAsignar'){
			$whereIn_array	= array('detail.tipo_movimiento', array( 'deposito') );
			$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin,'deptos.id_cliente ' => 0 );
			$headers 	= array('Nombre Empresa', 'Banco', 'Fecha depósito', 'Folio', 'Nombre cliente', 'Depósito', 'Comisión');

		}else if($tipo_excel =='noPagado'){
			$whereIn_array	= array('deptos.status_retorno', array('no pagado', '') );
			$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin,'deptos.id_cliente !=' => 0, 'detail.tipo_movimiento =' => 'deposito');
			$headers 	= array('Nombre Empresa', 'Banco', 'Fecha depósito', 'Folio', 'Nombre cliente', 'Depósito', 'Comisión');

		}else if($tipo_excel =='Pagado'){
			$whereIn_array	= array('deptos.status_retorno', array('pagado') );
			$where_array 	= array('fecha_movimiento >='=> $fecha_ini, 'fecha_movimiento <='=>$fecha_fin,'detail.tipo_movimiento' => 'deposito' );
			$headers 	= array('Nombre Empresa', 'Banco', 'Fecha depósito', 'Folio', 'Nombre cliente', 'Depósito', 'Comisión');
		}
		

		$params_join = array('select_active'=> 'true', 'select_fields' => $select_param,
							'from' => $table_from, 'number_joins' => count($inner), 'inner_connect' => $inner, 
							'whereIn_active' => 'true', 'whereIn_param' => $whereIn_array,
							'where_active' => 'true', 'where_param' => $where_array );
		
		$lista_deptos = $db->join_dynamic($params_join);

		//print_r(count($headers));exit;


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
		$total_columns 	= 65 + count($headers);		
		$leter 		= array();		

 		for($i=65; $i<$total_columns; $i++) 
		{  
			$leter[] = chr($i);  
			
		}  
		
		$Column = $objPHPExcel->setActiveSheetIndex(0);
		
		for($i=0; $i< count($leter);$i++){
			$Column->setCellValue($leter[$i].'1', strtoupper($headers[$i]));
		}
		
		for($i=0; $i< count($leter);$i++){
			$objPHPExcel->getActiveSheet()->getColumnDimension( $leter[$i] )->setAutoSize(true);
		}   
		

		$cellRespuesta=  $objPHPExcel->setActiveSheetIndex(0);
		
        $i=2;
        
        for($x=0; $x<count($lista_deptos);$x++){

			
			$comision_empresa= round(($lista_deptos[$x]->monto_deposito / 1.16) * $lista_deptos[$x]->comision, 2);

			for($c=0; $c< count($leter);$c++){
				
				$cellRespuesta->setCellValue($leter[$c].$i, $lista_deptos[$x]->nombre_empresa );
				//$cellRespuesta->setCellValue($leter[$c].$i, 'sksdkfmsd');
				$cellRespuesta->setCellValue($leter[$c].$i, $lista_deptos[$x]->nombre_banco);
				$cellRespuesta->setCellValue($leter[$c].$i, formato_fecha_ddmmaaaa($lista_deptos[$x]->fecha_deposito));
				$cellRespuesta->setCellValue($leter[$c].$i, $lista_deptos[$x]->folio_depto );
				$cellRespuesta->setCellValue($leter[$c].$i, $lista_deptos[$x]->nombre_cliente );
				$cellRespuesta->setCellValue($leter[$c].$i, number_format($lista_deptos[$x]->monto_deposito,2));
				$cellRespuesta->setCellValue($leter[$c].$i, number_format($comision_empresa, 2) );
			}
			$i++;
		}
		// foreach($depositos as $deposito): 
  //         	$comision = (($deposito->monto_deposito / 1.16 ) * $cliente->comision);

  //           $cellRespuesta->setCellValue('A'.$i, formato_fecha_ddmmaaaa($deposito->fecha_deposito));
  //           $cellRespuesta->setCellValue('B'.$i, round($deposito->monto_deposito,2));
  //           $cellRespuesta->setCellValue('C'.$i, round($comision, 2));
  //           $cellRespuesta->setCellValue('D'.$i, $deposito->folio_depto);
  //           $cellRespuesta->setCellValue('E'.$i, $deposito->nombre_empresa);
  //           $cellRespuesta->setCellValue('F'.$i, $deposito->nombre_banco);
  //          $i++;
  //       endforeach;
		
		 // Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Reporte de comisión');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="reporte_comision_'.date('d-m-Y').'.xls"');
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