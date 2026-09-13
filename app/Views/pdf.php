<?php

header("Content-Type: text/html; charset=iso-8859-1 ");
//$fecha;

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
		$this->Cell(40,10,'Carga de Usuario',0,0,'R');


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
		$this->Cell(15,10,'MP-F-21',0,0);
		$this->Cell(15,10,'0',0,0);
		$this->Cell(15,10,"07/12/2017",0,0);
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



if (isset($minutas)){
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->Cell(140,6,"Actividades pendientes de Minutas");
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	foreach ($minutas as $key) {
		$pdf->SetFillColor(5,29,77);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(175,7,"Tema: ".utf8_decode($key->tema),1,0,'L',true);
		$pdf->ln();
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(175,7,"Actividad: ".utf8_decode($key->actividad),1);
		$pdf->ln();
		$pdf->Cell(58,7,"Encargado: ".utf8_decode($key->nombre),1);
		$pdf->Cell(46,7,"Fecha Compromiso: ".utf8_decode($key->fecha_compromiso),1);
		$pdf->SetFont('Arial','B',8);
		if ($fecha<=$key->fecha_compromiso){
			$pdf->Cell(71,7,'Estatus: En Fechas',1);
		}else{
			$pdf->SetTextColor(220,50,50);
			$pdf->Cell(71,7,' Estatus: Fuera de Fechas',1);
			$pdf->SetTextColor(0,0,0);
		}
		$pdf->ln(15);	
	}
}

if(isset($analisis)){
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->Cell(140,6,"Actividades pendientes de 8D");
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',8);
	foreach ($analisis as $key) {
		$pdf->SetFillColor(5,29,77);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(20,7,"Folio: ".utf8_decode($key->folio),1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(155,7,"Problema: ".utf8_decode($key->problema_detectado),1);
		$pdf->ln();
		$pdf->Cell(175,7,"Tarea: ".utf8_decode($key->problema_detectado),1);
		$pdf->ln();
		$pdf->Cell(87,7,"Encargado: ".utf8_decode($key->usuario),1);
		$pdf->SetFont('Arial','B',8);
		if ($fecha<=$key->f_fin){
			$pdf->Cell(88,7,'Estatus: En Fechas',1);
		}else{
			$pdf->SetTextColor(220,50,50);
			$pdf->Cell(88,7,' Estatus: Fuera de Fechas',1);
			$pdf->SetTextColor(0,0,0);
		}
		$pdf->ln(15);	
	}
}

if (isset($proyectos)){
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->Cell(140,6,"Actividades pendientes de Proyectos");
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',8);
	foreach ($proyectos as $key) {
		$pdf->SetFillColor(5,29,77);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(175,7,"Proyecto: ".utf8_decode($key->proyecto),1,0,'L',true);
		$pdf->ln();
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(175,7,"Tarea: ".utf8_decode($key->subproyecto),1);
		$pdf->ln();
		$pdf->Cell(58,7,"Encargado: ".utf8_decode($key->nombre),1);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(46,7,"Fecha Inicio: ".utf8_decode($key->f_inicio),1);
		$pdf->SetFont('Arial','B',8);
		if ($fecha<=$key->f_fin){
			$pdf->Cell(71,7,'Estatus: En Fechas',1);
		}else{
			$pdf->SetTextColor(220,50,50);
			$pdf->Cell(71,7,' Estatus: Fuera de Fechas',1);
			$pdf->SetTextColor(0,0,0);
		}
		$pdf->ln(15);	
	}
}
$pdf->Output();

?>