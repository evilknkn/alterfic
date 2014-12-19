<?php

include_once('fpdf.php');

class Pdf_contrato extends FPDF
{

	public $qrcode;
	public $no_contrato;
	public $folio;
	
	function Header()
	{
		$this->SetMargins(10,10,10); 

		// Logo
	    /*$this->Image( PATH . 'resources/img/logo_funeza.jpg', 10, 10, 40);
	    $this->SetFont('Arial','B',8);
	    $this->Cell(40,2,'');
	    $this->Cell(40,2,utf8_decode('SUC ZARAGOZA'), 0, 0, 'C');
	    $this->Rect(90, 10, 0, 15);
	    $this->Cell(40,2,utf8_decode('SUC PERIFÉRICO'), 0, 0, 'C');
	    $this->Rect(130, 10, 0, 15);
	    $this->Cell(40,2,utf8_decode('SUC AZCAPOTZALCO'), 0, 0, 'C');
	    $this->Rect(172, 10, 0, 15);
	    $this->Cell(40,2,utf8_decode('SUC LA RAZA'), 0, 0, 'C');
	    $this->ln(3);
	    $this->SetFont('Arial','',6);
	    $this->Cell(40,2,'');
	    $this->Cell(40,2,utf8_decode('Calz. Ignacio Zaragoza No. 1049'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Blvd. Adolfo López Mateos 1535'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Av. Cuitláhuac 2318'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Av. Vallejo 315'), 0, 0, 'C');
	    $this->ln(3);
	    $this->SetFont('Arial','',6);
	    $this->Cell(40,2,'');
	    $this->Cell(40,2,utf8_decode('Col. Agrícola Oriental'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Col. Alfonso XIII'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Col. Clavería'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Col. Vallejo Poniente'), 0, 0, 'C');
	    $this->ln(3);
	    $this->SetFont('Arial','',6);
	    $this->Cell(40,2,'');
	    $this->Cell(40,2,utf8_decode('Del. Iztacalco'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Del. Álvaro Obregón'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Del. Azcapotzalco'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('Del. Gustavo A. Madero'), 0, 0, 'C');
	    $this->ln(3);
	    $this->SetFont('Arial','',6);
	    $this->Cell(40,2,'');
	    $this->Cell(40,2,utf8_decode('México, D.F. C.P. 08500'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('México, D.F. C.P. 01460'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('México, D.F. C.P. 02080'), 0, 0, 'C');
	    $this->Cell(40,2,utf8_decode('México, D.F. C.P. 07790'), 0, 0, 'C');
	    // Salto de línea
	    $this->Ln(5);
	    $this->SetFont('Arial','',12);
	    $this->Cell(10,2,'');
	    $this->Cell(25,2,utf8_decode('www.funeza.com'), 0, 0, 'C');
	    $this->SetFont('Arial','',8);
	    $this->Cell(120,3,utf8_decode('Folio de solicitud: '), 0, 0, 'R');
	    $this->SetFont('Arial','B',8);
	    $this->Cell(37,3,utf8_decode($this->folio), 'B', 0, 'C');*/
	    $this->Ln(25);
	}
	
	// Pie de página
	function Footer()
	{
		$path = "expedientes/contratos/".$this->no_contrato."/";
        $targetPath =  PATH . "/expedientes/contratos/";
        if(!is_dir($targetPath)) {
                @mkdir($targetPath, 0755);
        }
        $targetPath.= $this->no_contrato."/";
        if(!is_dir($targetPath)) {
                @mkdir($targetPath, 0755);
        }

		QRcode::png('||'.$this->no_contrato."||", $targetPath.'qrcontrato.png', 'Q', 5, 1);

	    // Posición: a 1,5 cm del final
	    $this->SetY(-18);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    $this->Cell(95,18,utf8_decode(''),0,0,'L');
	    $this->Image( $targetPath.'qrcontrato.png', 10, 275, 15);
		$this->Cell(95,18,utf8_decode('Página '.$this->PageNo().' de {nb}'),0,0,'R');
	}
}

/* Fin del archivo: pdf.php */
/* Ubicación: ./application/libraries/pdf.php */
