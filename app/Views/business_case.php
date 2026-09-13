<?php
require FCPATH . 'fpdf/fpdf.php';
class PDF extends FPDF
{
	function Header()
	{
		$this->SetFont('Arial','B',10);
		$this->Image('assets/img/logo.jpg',10,8,25);
		$this->Cell(60);
		// Título
		$this->SetTextColor(0,32,96);

		$this->SetFillColor(255,255,255);
		//$pdf->SetFillColor(150,150,150);
		$this->SetFont('Arial','B',12);
		$this->Cell(30,10,'',0,0,'C');
		$this->Cell(40);
		$this->Cell(40,10,'Synergy to Business',0,0,'R',true);
		$this->Ln(6);

		$this->SetTextColor(0,0,0);
		$this->Cell(90,10,'',0,0,'C');
		$this->Cell(40);
		$this->Cell(40,10,'Business Case',0,0,'R');


		$this->Ln(6);
		$this->SetFont('Arial','B',6);
		$this->Cell(85,10,'',0,0,'C');
		$this->Cell(40);
		$this->Cell(15,10,'Codigo',0,0);
		$this->Cell(15,10,'Rev.',0,0);
		$this->Cell(15,10,'Fecha',0,0);
		$this->Ln(3);
		$this->Cell(85,10,'',0,0,'C');
		$this->Cell(40);
		$this->Cell(15,10,'MP-F-19',0,0);
		$this->Cell(15,10,'0',0,0);
		$this->Cell(15,10,"16/10/2017",0,0);
		$this->Ln(8);
	}
	function Footer(){
		// Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Número de página
	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(150,150,150);
//$pdf->SetTextColor(220,50,50);
$pdf->SetFillColor(5,29,77);
foreach ($general as $key) {
	$pdf->Cell(175,7,'Soliticante: '.utf8_decode($key->nombre),0,0);
	$pdf->Ln();
	$pdf->Cell(175,7,'Fecha de Solicitud: '.$key->fecha,0,0);
	$pdf->Ln(16);
	
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(175,7,'Analisis de los hechos',1,0,'C',true);
	$pdf->Ln();
	$pdf->SetTextColor(0,0,0);
	$pdf->multicell(175,7,$key->analisis,1);
	$pdf->Ln(8);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(175,7,'Defincion de la ventaja',1,0,'C',true);
	$pdf->Ln();
	$pdf->SetTextColor(0,0,0);
	$pdf->multicell(175,7,$key->ventaja,1);
	$pdf->Ln(8);	
}
$pdf->SetFillColor(5,29,77);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Alternativas',1,0,'C',true);
$pdf->Ln();
foreach ($alternativas->getResult() as $key) {
	$pdf->SetTextColor(0,0,0);
	$pdf->multicell(175,7,utf8_decode($key->alternativa),1);
}
$pdf->Ln(8);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Alternativa Seleccionada',1,0,'C',true);
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->multicell(175,7,utf8_decode($seleccionada[0]->alternativa),1);
$pdf->Ln(8);

$pdf->ln(30);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,7,'____________________',0,0,'C');
$pdf->Cell(50,7,'____________________',0,0,'C');
$pdf->Cell(50,7,'____________________',0,0,'C');
$pdf->ln();
$pdf->Cell(50,7,'Elaboro',0,0,'C');
$pdf->Cell(50,7,'Reviso',0,0,'C');
$pdf->Cell(50,7,'Aprobo',0,0,'C');
$pdf->Output();
?>