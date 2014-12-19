<?php

include_once('fpdf.php');

class Pdf_diagnostico extends FPDF
{

	public $qrcode;
	public $no_contrato;
	public $folio;
	
	function Header()
	{
		$this->SetMargins(10,10,10); 

		// Logo
	    $this->Image( PATH . 'assets/img/logo_gto_pdf.png', 8, 8, 20);
	    //$this->Image( PATH . 'assets/img/logo_gto_pdf_sombra.png', 10, 80, 190);
	    $this->SetTextColor(52, 91, 161);
	   	$this->SetFont('Helvetica','B',20);
	   	$this->Cell(20,8,'');
	   	$this->Cell(170,8,utf8_decode('RESULTADO DEL AUTODIAGNÓSTICO 2014'),0,0,'C');
	   	$this->SetFont('Helvetica','B',16);
	   	$this->Ln(8);
	   	$this->Cell(20,8,'');
	   	$this->Cell(170,8,utf8_decode(strtoupper(APPNAME)),0,0,'C');
	    $this->Ln(25);
	}
	
	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
	    $this->SetY(-18);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    $this->Cell(95,18,utf8_decode('Impreso el '.formato_fecha_texto(date('Y-m-d')).' a las '.date('H:i').' hrs.'),0,0,'L');
		$this->Cell(95,18,utf8_decode('Página '.$this->PageNo().' de {nb}'),0,0,'R');
	}
}

/* Fin del archivo: pdf.php */
/* Ubicación: ./application/libraries/pdf.php */
