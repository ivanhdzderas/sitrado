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
		$this->Cell(40,10,'Carga de Usuarios',0,0,'R');


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
		$this->Cell(15,10,'MP-F-22',0,0);
		$this->Cell(15,10,'0',0,0);
		$this->Cell(15,10,"07/12/2017",0,0);
		$this->Ln(8);

		$this->SetFont('Arial','B',10);
		$this->SetFillColor(5,29,77);
		$this->SetTextColor(255,255,255);
		$this->Cell(75,7,'Nombre',1,0,'C',true);
		$this->Cell(25,7,'Pendientes',1,0,'C',true);
		$this->Cell(25,7,'Cerrados',1,0,'C',true);
		$this->Cell(25,7,'Total',1,0,'C',true);
		$this->Cell(25,7,'%',1,0,'C',true);
		
		$this->SetTextColor(0,0,0);
		$this->Ln();

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
$pdf->SetFont('Arial','',7);
foreach ($usuarios->getResult() as $key) {
	$pdf->Cell(75,7,$key->nombre,1,0);
	$Pendientes=count (login_model()->pendientes_8d($key->id));
	$pdf->Cell(25,7,$Pendientes,1,0);
	$soluciones=count (login_model()->soluciones_8d($key->id));
	$pdf->Cell(25,7,$soluciones,1,0);
	$pdf->Cell(25,7,($Pendientes+$soluciones),1,0);
	$total=$Pendientes+$soluciones;
	if ($total>0){
		$porcentaje=($soluciones*100)/$total;
	}else{
		$porcentaje=0;
	}
	$pdf->Cell(25,7,(round($porcentaje,0).'%'),1,0);
	$pdf->ln();
}
$pdf->Output();
?>