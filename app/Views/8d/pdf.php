<?php
header("Content-Type: text/html; charset=iso-8859-1 ");
//$fecha;
$tipo="";
$problema="";
$problema_des="";
$materia_prima="";
$metodos="";
$mano_de_obra="";
$maquinaria="";
$medio_ambiente="";
$cauza_raiz;
$objetivo="";//error_reporting(0);
$costo_total=0;
$presupuesto="";

foreach ($general as $key) {
	$GLOBALS['fecha'] = $key->fecha;
	$fecha=$key->fecha;
	$tipo=$key->tipo;
	$objetivo=$key->objetivo;
	$problema=$key->problema_detectado;
	$problema_des=$key->descripcion_problema;
	$materia_prima=$key->materia_prima;
	$metodos=$key->metodos;
	$mano_de_obra=$key->mano_de_obra;
	$maquinaria=$key->maquinaria;
	$medio_ambiente=$key->medio_ambiente;
	$cauza_raiz=$key->causa_raiz;
	$presupuesto=$key->presupuesto;
}
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
		$this->Cell(40,10,'Reporte 8D',0,0,'R');


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
		$this->Cell(15,10,'MP-F-05',0,0);
		$this->Cell(15,10,'0',0,0);
		$this->Cell(15,10,"02/10/2017",0,0);
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
// Salto de línea
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,10,'Tipo: '.$tipo,0,1);
$pdf->MultiCell(160,3,'Problema detectado: '.utf8_decode($problema),"B",1);
$pdf->MultiCell(160,3,'Descripcion del problema: '.utf8_decode($problema_des),"B",1);
$pdf->MultiCell(160,5,'Objetivo del analisis: '.utf8_decode($objetivo),"B",1);
$pdf->Ln(8);
//$pdf->SetDrawColor(0,80,180);
$pdf->SetFillColor(5,29,77);
$pdf->SetTextColor(255,255,255);
//$pdf->SetTextColor(220,50,50);
$pdf->Cell(175,7,'Equipo de Trabajo',1,0,'C',true);
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->Cell(70,7,'Nombre',1,0);
$pdf->Cell(50,7,'Departamento',1,0);
$pdf->Cell(55,7,'Puesto',1,0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($equipo->getResult() as $key ) {
	$pdf->Cell(70,7,utf8_decode($key->nombre),1,0);
	$pdf->Cell(50,7,utf8_decode($key->departamento),1,0);
	$pdf->Cell(55,7,utf8_decode($key->puesto),1,0);
	$pdf->Ln();
}
//$pdf->Cell(175,7,'','T',0);
$pdf->Ln();
//tabla soluciones temporales
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Soluciones Temporales',1,0,'C',true);
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',7);
foreach ($temporales as $key) {
	$pdf->MultiCell(175,4,'Solucion: '.utf8_decode($key->solucion),1,'L');
	//$pdf->ln();
	$pdf->Cell(75,7,"Responsable: ".utf8_decode($key->nombre),1,0);
	$pdf->Cell(35,7,"Fecha Inicio: ".$key->fecha,1,0);
	$pdf->Cell(35,7,"Fecha Fin: ".$key->f_fin,1,0);
	$pdf->Cell(30,7,"Costo: $ ".$key->money,1,0);
	$costo_total=$costo_total+$key->money;
	$pdf->Ln(10);

}
/*$pdf->Ln();
$pdf->Cell(50,7,'solucion',1,0);
$pdf->Cell(50,7,'Responsable',1,0);
$pdf->Cell(35,7,'Fecha Inicio',1,0);
$pdf->Cell(20,7,'Fecha Fin',1,0);
$pdf->Cell(20,7,'Costo',1,0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($temporales as $key) {
	if (strlen($key->solucion)>43){
		$y = $pdf->GetY();
		$x = $pdf->GetX();
		$width = 50;
		$pdf->MultiCell($width, 2.5 ,utf8_decode($key->solucion), 1);
		$pdf->SetXY($x + $width, $y);
	}else{
		$pdf->cell(50,14,$key->solucion,1,0);
	}
	
	//
	$pdf->Cell(50,14,utf8_decode($key->nombre),1,0);
	$pdf->Cell(35,14,$key->fecha,1,0);
	$pdf->Cell(20,14,$key->f_fin,1,0);
	$pdf->Cell(20,14,"$ ".$key->money,1,0);
	$costo_total=$costo_total+$key->money;
	$pdf->Ln();
}
*/
$pdf->Ln();
//diagrama de pez
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(175,7,'Causa Raiz',1,0,'C',true);
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$y = $pdf->GetY();
$x = $pdf->GetX();
$pdf->Image('assets/img/ishikawa.png',$x,$y,160);

$pdf->SetFont('Arial','',6);
/*
$pdf->SetXY($x, $y+4);
$materia=explode('|', $materia_prima);
$cuantos=count($materia);
$suma=3;
for ($i=0; $i <$cuantos ; $i++) { 
	$pdf->SetXY($x, $y+4+$suma);
	$pdf->Cell(20,7,$materia[$i],0,0);
	$pdf->Ln(3);
	$suma=$suma+3;
}
//$pdf->Cell(20,7,$materia_prima,0,0);
*/


$pdf->SetXY($x+55, $y);
$maquina=explode('|',$maquinaria);
$cuantos=count($maquina);
$suma=3;
for ($i=0; $i <$cuantos ; $i++) { 
	$pdf->SetXY($x+55, $y+$suma);
	$pdf->MultiCell(50,2.5,utf8_decode($maquina[$i]));
	$pdf->Ln(3);
	$suma=$suma+3;
}

$pdf->SetXY($x+120, $y);
$metodo=explode('|', $metodos);
$cuantos=count($metodo);
$suma=3;
for ($i=0; $i <$cuantos ; $i++) { 
	$pdf->SetXY($x+120, $y+$suma);
	$pdf->MultiCell(50,2.5,utf8_decode($metodo[$i]));
	$pdf->Ln(3);
	$suma=$suma+3;
}

$pdf->SetXY($x+55, $y+40);
$ambiente=explode('|',$medio_ambiente);
$cuantos=count($ambiente);
$suma=3;
for ($i=0; $i <$cuantos ; $i++) { 
	$pdf->SetXY($x+55, $y+40+$suma);
	$pdf->MultiCell(50,2.5,utf8_decode($ambiente[$i]));
	$pdf->Ln(3);
	$suma=$suma+3;
}

$pdf->SetXY($x+120, $y+40);
$mano=explode('|', $mano_de_obra);
$cuantos=count($mano);
$suma=3;
for ($i=0; $i <$cuantos ; $i++) { 
	$pdf->SetXY($x+120, $y+40+$suma);
	$pdf->MultiCell(50,2.5,utf8_decode($mano[$i]));
	$pdf->Ln(3);
	$suma=$suma+3;
}

$pdf->SetXY($x, $y+80);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Causa Raiz',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(175,7,utf8_decode($cauza_raiz),1);
$pdf->Ln();

//tabla soluciones Permanentes

$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Soluciones Permanentes',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($permanente->getResult() as $key) {
	$pdf->MultiCell(175,4,'Solucion: '.utf8_decode($key->solucion),1,'L');
	//$pdf->ln();
	$pdf->Cell(75,7,"Responsable: ".utf8_decode($key->nombre),1,0);
	$pdf->Cell(35,7,"Fecha Inicio: ".$key->fecha,1,0);
	$pdf->Cell(35,7,"Fecha Fin: ".$key->f_fin,1,0);
	$pdf->Cell(30,7,"Costo: $ ".$key->money,1,0);
	$costo_total=$costo_total+$key->money;
	$pdf->Ln(10);

}

/*


$pdf->Cell(50,7,'solucion',1,0);
$pdf->Cell(50,7,'Responsable',1,0);
$pdf->Cell(35,7,'Fecha Inicio',1,0);
$pdf->Cell(20,7,'Fecha Fin',1,0);
$pdf->Cell(20,7,'Costo',1,0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($permanente as $key) {
	
	if (strlen($key->solucion)>40){
		$ancho=50;
        $altura=1.15;
        $cantidad_lineas= strlen($key->solucion);
 		if($cantidad_lineas > $ancho){
 			$cant_espacios = $cantidad_lineas/$ancho;
 			$rendondear=round($cant_espacios,2);
 			$altura=$altura*$rendondear;
 		}
		$y = $pdf->GetY();
		$x = $pdf->GetX();
		$width = 50;
		$pdf->MultiCell($ancho, $altura ,utf8_decode($key->solucion),1);
		$pdf->SetXY($x + $width, $y);
	}else{
		$pdf->cell(50,14,$key->solucion,1,0);
	}

	$pdf->Cell(50,14,utf8_decode($key->nombre),1,0);
	$pdf->Cell(35,14,$key->fecha,1,0);
	$pdf->Cell(20,14,$key->f_fin,1,0);
	$pdf->Cell(20,14,"$ ".$key->money,1,0);
	$costo_total=$costo_total+$key->money;
	$pdf->Ln();
}

*/
$pdf->Ln();

//tabla acciones Preventivas
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Acciones Preventivas',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($preventivo as $key) {
	$pdf->MultiCell(175,4,'Solucion: '.utf8_decode($key->solucion),1,'L');
	//$pdf->ln();
	$pdf->Cell(75,7,"Responsable: ".utf8_decode($key->nombre),1,0);
	$pdf->Cell(35,7,"Fecha Inicio: ".$key->fecha,1,0);
	$pdf->Cell(35,7,"Fecha Fin: ".$key->f_fin,1,0);
	$pdf->Cell(30,7,"Costo: $ ".$key->money,1,0);
	$costo_total=$costo_total+$key->money;
	$pdf->Ln(10);

}
/*$pdf->Ln();
$pdf->Cell(50,7,'solucion',1,0);
$pdf->Cell(50,7,'Responsable',1,0);
$pdf->Cell(35,7,'Fecha Inicio',1,0);
$pdf->Cell(20,7,'Fecha Fin',1,0);
$pdf->Cell(20,7,'Costo',1,0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($preventivo as $key) {
	if (strlen($key->solucion)>43){
		$y = $pdf->GetY();
		$x = $pdf->GetX();
		$width = 50;
		$pdf->MultiCell($width, 2.5 ,utf8_decode($key->solucion), 1);
		$pdf->SetXY($x + $width, $y);
	}else{
		$pdf->cell(50,14,$key->solucion,1,0);
	}

	//$pdf->Cell(50,7,$key->solucion,"L",0);
	$pdf->Cell(50,14,utf8_decode($key->nombre),1,0);
	$pdf->Cell(35,14,$key->fecha,1,0);
	$pdf->Cell(20,14,$key->f_fin,1,0);
	$pdf->Cell(20,14,"$ ".$key->money,1,0);
	$costo_total=$costo_total+$key->money;
	$pdf->Ln();

}
*/
$pdf->ln();
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(50,7,"Presupuesto Inicial",1,0,'C',true);
$pdf->Cell(50,7,"Presupuesto Final",1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->ln();
$pdf->SetFont('Arial','',7);
$pdf->cell(50,7,"$ ".number_format($presupuesto,2,'.',','),1,0);
$pdf->cell(50,7,"$ ".number_format($costo_total,2,'.',','),1,0);
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