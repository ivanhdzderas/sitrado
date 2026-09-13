<?php
header("Content-Type: text/html; charset=iso-8859-1 ");

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
		$this->Cell(40,10,'Reporte de Minuta',0,0,'R');


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
		$this->Cell(15,10,'MP-F-23',0,0);
		$this->Cell(15,10,'0',0,0);
		$this->Cell(15,10,"23/10/2017",0,0);
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
	$pdf->Cell(175,7,'Fecha y Hora: '.$key->fecha,0,1);
	//$pdf->ln();
	$pdf->Cell(175,7,'Tema: '.utf8_decode($key->tema),0,1);
	//$pdf->ln();
	$pdf->Cell(175,7,'Lugar: '.utf8_decode($key->lugar),0,1);
	//$pdf->ln();utf8_decode(
	$query=login_model()->carga_datos_usuario($key->impartidor)->getResult();
	foreach ($query as $alfa) {
		$pdf->Cell(175,7,'Moderador: '.utf8_decode($alfa->nombre),0,1);
	}
	$pdf->Cell(175,7,'Duracion: '.$key->duracion." Hora",0,1);
	//$pdf->ln();
}

$pdf->SetTextColor(255,255,255);

$pdf->Cell(175,7,'Temas Tratados',1,1,'C',true);
$pdf->SetTextColor(0,0,0);
/*$pdf->Cell(80,7,'Tema',1,0);
$pdf->Cell(80,7,'Reponsable',1,0);
$pdf->Cell(40,7,'Fecha Compromiso',1,0);
*/
foreach ($detallado->getResult() as $key) {
	$pdf->multicell(175,4,'Tema: '.utf8_decode($key->tema),1);
	$query=login_model()->carga_datos_usuario($key->id_usuario_encargado)->getResult();
	foreach ($query as $alfa) {
		$pdf->Cell(88,7,'Responsable: '.utf8_decode($alfa->nombre),1);
	}
	$pdf->Cell(87,7,'Fecha Compromiso: '.$key->fecha_compromiso,1);
	$pdf->Ln(10);
}
$pdf->ln(15);
$pdf->Cell(175,7,'Firmas',0,1,'C');
$pdf->ln(25);
$pdf->SetFont('Arial','B',8);



$parti=login_model()->participantes_junta($id);
$conteo=1;
foreach ($parti as $key) {
	if ($conteo==1){
		$pdf->cell(8);
		$pdf->Cell(50,7,utf8_decode($key->nombre),"T",0,'C');
		$conteo=$conteo+1;
	}else if($conteo==2){
		$pdf->cell(2);
		$pdf->Cell(50,7,utf8_decode($key->nombre),"T",0,'C');
		$conteo=$conteo+1;
	}else if($conteo==3){
		$pdf->cell(2);
		$pdf->Cell(50,7,utf8_decode($key->nombre),"T",0,'C');
		$pdf->ln(15);
		$conteo=1;
	}

}
$pdf->Output();
?>