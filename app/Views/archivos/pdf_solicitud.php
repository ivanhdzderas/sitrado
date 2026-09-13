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
		$this->Cell(40,10,'Solicitud de documentos',0,0,'R');


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
		$this->Cell(15,10,'MP-F-02',0,0);
		$this->Cell(15,10,'0',0,0);
		$this->Cell(15,10,"07/09/2017",0,0);
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
$pdf->Cell(15,10,'Tipo:',0,0);
$pdf->ln();
$pdf->SetFillColor(5,29,77);





switch($general[0]->tipo){
	case "N":
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,'Nuevo Documento:',1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'X',1,0,'C');
		$pdf->cell(8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,utf8_decode('Modificación:'),1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'',1,0,'C');
		$pdf->cell(8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,utf8_decode('Cancelación:'),1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'',1,0,'C');
		$pdf->cell(8);
		break;
	case "M":
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,'Nuevo Documento:',1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'',1,0,'C');
		$pdf->cell(8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,utf8_decode('Modificación:'),1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'X',1,0,'C');
		$pdf->cell(8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,utf8_decode('Cancelación:'),1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'',1,0,'C');
		$pdf->cell(8);
		break;
	case "C":
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,'Nuevo Documento:',1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'',1,0,'C');
		$pdf->cell(8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,utf8_decode('Modificación:'),1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'',1,0,'C');
		$pdf->cell(8);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(35,8,utf8_decode('Cancelación:'),1,0,'L',true);
		$pdf->SetTextColor(0,0,0);
		$pdf->Cell(8,8,'X',1,0,'C');
		$pdf->cell(8);
		break;
}
$fecha=date_create($general[0]->fecha);
$pdf->Cell(33,8,'Fecha: '.date_format($fecha, 'd-m-Y'));
$pdf->ln(12);
$pdf->Cell(32,8,"Dpto. solicitante:",0,0);
$pdf->Cell(80,7,utf8_decode($general[0]->departamento),"B",0);
$pdf->ln(12);
$pdf->Cell(32,8,"Solicitante:",0,0);
$pdf->Cell(80,7,utf8_decode($general[0]->solicitante),"B",0);
$pdf->cell(20);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(35,8,utf8_decode('N° Solicitud:'),1,0,'L',true);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(19,8,$general[0]->tipo."-".str_pad ($general[0]->folio,4,"0",STR_PAD_LEFT),1,0,'C');
$pdf->ln(15);


$pdf->SetTextColor(255,255,255);
$pdf->Cell(186,8,utf8_decode('Descripción del documento'),1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->ln(15);
$pdf->cell(42,8,utf8_decode("Código de documento:"),0,0,"R");
$pdf->cell(80,7,utf8_decode($general[0]->codigo),"B",0);
$pdf->cell(10);
if ($general[0]->tiempo>1){
$pdf->cell(39,8,utf8_decode("Tiempo de Retención: "),0,0);
$pdf->cell(15,7,$general[0]->tiempo.utf8_decode(" años"),"B",0);
}else{
$pdf->cell(39,8,utf8_decode("Tiempo de Retención: "),0,0);
$pdf->cell(15,7,$general[0]->tiempo.utf8_decode(" año"),"B",0);
}
$pdf->ln(12);
$pdf->Cell(42,8,"Nombre del documento:",0,0);
$pdf->Cell(142,7,utf8_decode($general[0]->nombre),"B",0);
$pdf->ln(12);
$pdf->cell(42,8,"Especificar cambio:",0,0,"R");
//$pdf->Cell(142,7,utf8_decode($general[0]->especificar),"B",0);
$pdf->multicell(142,3,utf8_decode($general[0]->especificar));
$pdf->SetY(90);

$pdf->Cell(186,50,"",1,0);
$pdf->Output();
?>