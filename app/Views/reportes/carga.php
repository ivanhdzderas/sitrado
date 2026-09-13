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

$pdf->SetFont('Arial','B',10);
$pdf->Cell(140,6,'Usuario: '.$usuario->getResult()[0]->nombre,0);
$hoy = date("Y-m-d"); 
$pdf->Cell(35,6,'Fecha: '.$hoy,0);
$pdf->Ln(8);

$pdf->SetFillColor(5,29,77);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Proyectos',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();

$pdf->Cell(35,6,'Responsable: '.$responsable->getNumRows().' actividades',0);
$pdf->Ln();
$pdf->Cell(35,6,'Aprobador: '.$aprobado->getNumRows().' actividades',0);
$pdf->Ln();
$pdf->Cell(35,6,'Consultado: '.$consultado->getNumRows().' actividades',0);
$pdf->Ln();
$pdf->Cell(35,6,'Informado: '.$informado->getNumRows().' actividades',0);
$pdf->Ln(12);


//$pdf->Image($nombre_pastel.".png",70,50,60);
//unlink($nombre_pastel.".png");

//$pdf->Ln(30);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Responsables',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);

foreach ($responsable->getResult() as $key) {
	$pdf->MultiCell(175,4,'Proyecto: '.utf8_decode($key->proyecto),1,'L');
	$pdf->MultiCell(175,4,'Actividad: '.utf8_decode($key->subproyecto),1,'L');
	$pdf->Cell(58,6,"Fecha Inicio:".$key->f_inicio,1);
	$pdf->Cell(58,6,"Fecha Fin:".$key->f_fin,1);
	if ($key->terminado=="SI"){
		$pdf->Cell(59,6,'Estatus: Terminado',1);
	}else{
		if (date('Y-m-d')>$key->f_fin){
			$pdf->Cell(59,6,'Estatus: Fuera de Tiempo',1);
			
		}else{
			$pdf->Cell(59,6,'Estatus: En Tiempo',1);
		}
	}
	$pdf->Ln(12);
}
$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Aprobador',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($aprobado->getResult() as $key) {
	$pdf->MultiCell(175,4,'Proyecto: '.utf8_decode($key->proyecto),1,'L');
	$pdf->MultiCell(175,4,'Actividad: '.utf8_decode($key->subproyecto),1,'L');
	$pdf->Cell(58,6,"Fecha Inicio:".$key->f_inicio,1);
	$pdf->Cell(58,6,"Fecha Fin:".$key->f_fin,1);
	if ($key->terminado=="SI"){
		$pdf->Cell(59,6,'Estatus: Terminado',1);
	}else{
		if (date('Y-m-d')>$key->f_fin){
			$pdf->Cell(59,6,'Estatus: Fuera de Tiempo',1);
			
		}else{
			$pdf->Cell(59,6,'Estatus: En Tiempo',1);
		}
	}
	$pdf->Ln(12);
}
$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Consultado',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($consultado->getResult() as $key) {
	$pdf->MultiCell(175,4,'Proyecto: '.utf8_decode($key->proyecto),1,'L');
	$pdf->MultiCell(175,4,'Actividad: '.utf8_decode($key->subproyecto),1,'L');
	$pdf->Cell(58,6,"Fecha Inicio:".$key->f_inicio,1);
	$pdf->Cell(58,6,"Fecha Fin:".$key->f_fin,1);
	if ($key->terminado=="SI"){
		$pdf->Cell(59,6,'Estatus: Terminado',1);
	}else{
		if (date('Y-m-d')>$key->f_fin){
			$pdf->Cell(59,6,'Estatus: Fuera de Tiempo',1);
			
		}else{
			$pdf->Cell(59,6,'Estatus: En Tiempo',1);
		}
	}
	$pdf->Ln(12);
}

$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Informado',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($informado->getResult() as $key) {
	$pdf->MultiCell(175,4,'Proyecto: '.utf8_decode($key->proyecto),1,'L');
	$pdf->MultiCell(175,4,'Actividad: '.utf8_decode($key->subproyecto),1,'L');
	$pdf->Cell(58,6,"Fecha Inicio:".$key->f_inicio,1);
	$pdf->Cell(58,6,"Fecha Fin:".$key->f_fin,1);
	if ($key->terminado=="SI"){
		$pdf->Cell(59,6,'Estatus: Terminado',1);
	}else{
		if (date('Y-m-d')>$key->f_fin){
			$pdf->Cell(59,6,'Estatus: Fuera de Tiempo',1);
			
		}else{
			$pdf->Cell(59,6,'Estatus: En Tiempo',1);
		}
	}
	$pdf->Ln(12);
}

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(5,29,77);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'Minutas',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
$pdf->Cell(35,6,'Moderador: '.$moderador->getNumRows().' Minutas',0);
$pdf->Ln();

$pdf->Cell(35,6,'Tareas: '.$actividades->getNumRows().' actividades',0);


$pdf->Ln();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Moderador',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($moderador->getResult() as $key) {
	$pdf->MultiCell(175,4,'Titulo Minuta: '.utf8_decode($key->nombre),1,'L');
	$pdf->MultiCell(175,4,'Actividad: '.utf8_decode($key->actividad),1,'L');
	$nombre=login_model()->carga_datos_usuario($key->impartidor)->getResult();
	$pdf->Cell(80,6,'Moderador Minuta: '.utf8_decode($nombre[0]->nombre),1);
	$pdf->Cell(50,6,'Lugar: '.utf8_decode($key->lugar),1);
	$pdf->Cell(45,6,'Fecha y Hora: '.utf8_decode($key->fecha),1);
	$pdf->Ln();
	$pdf->Cell(87,6,'Fecha Compromiso: '.utf8_decode($key->fecha_compromiso),1);
	if ($key->terminado=="SI"){
		$pdf->Cell(88,6,'Estatus: '.utf8_decode("Estatus: Terminado"),1);
	}else{
		if (date('Y-m-d')>$key->fecha_compromiso){
			$pdf->Cell(88,6,'Estatus: '.utf8_decode("Fuera de Tiempo"),1);
		}else{
			$pdf->Cell(88,6,'Estatus: '.utf8_decode("En Tiempo"),1);
		}
	}
	$pdf->Ln(12);
}

$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Tareas',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($actividades->getResult() as $key) {
	$pdf->MultiCell(175,4,'Titulo Minuta: '.utf8_decode($key->nombre),1,'L');
	$pdf->MultiCell(175,4,'Actividad: '.utf8_decode($key->actividad),1,'L');
	$nombre=login_model()->carga_datos_usuario($key->impartidor)->getResult();
	$pdf->Cell(80,6,'Moderador Minuta: '.utf8_decode($nombre[0]->nombre),1);
	$pdf->Cell(50,6,'Lugar: '.utf8_decode($key->lugar),1);
	$pdf->Cell(45,6,'Fecha y Hora: '.utf8_decode($key->fecha),1);
	$pdf->Ln();
	$pdf->Cell(87,6,'Fecha Compromiso: '.utf8_decode($key->fecha_compromiso),1);
	if ($key->terminado=="SI"){
		$pdf->Cell(88,6,'Estatus: '.utf8_decode("Estatus: Terminado"),1);
	}else{
		if (date('Y-m-d')>$key->fecha_compromiso){
			$pdf->Cell(88,6,'Estatus: '.utf8_decode("Fuera de Tiempo"),1);
		}else{
			$pdf->Cell(88,6,'Estatus: '.utf8_decode("En Tiempo"),1);
		}
	}
	
	$pdf->Ln(12);
}

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(5,29,77);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(175,7,'8D',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
$pdf->Cell(35,6,'Soluciones Temporales: '.$temporal->getNumRows().' Minutas',0);
$pdf->Ln();
$pdf->Cell(35,6,'Soluciones Permanentes: '.$permanente->getNumRows().' actividades',0);
$pdf->Ln();
$pdf->Cell(35,6,'Soluciones Preventivos: '.$preventivo->getNumRows().' actividades',0);
$pdf->Ln();
$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Soluciones Temporales',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($temporal->getResult() as $key) {
	$pdf->MultiCell(175,4,'Problema: '.utf8_decode($key->problema_detectado),1,'L');
	$pdf->MultiCell(175,4,'Solucion: '.utf8_decode($key->solucion),1,'L');
	$pdf->Cell(40,6,'Fecha Inicio: '.utf8_decode($key->f_inicio),1);
	$pdf->Cell(40,6,'Fecha Fin: '.utf8_decode($key->f_fin),1);
	$pdf->Cell(40,6,'Fecha Analisis: '.utf8_decode($key->fecha),1);
	$pdf->Cell(55,6,'Activo: '.utf8_decode($key->activo),1);
	$pdf->Ln(12);
}

$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Soluciones Permanentes',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($permanente->getResult() as $key) {
	$pdf->MultiCell(175,4,'Problema: '.utf8_decode($key->problema_detectado),1,'L');
	$pdf->MultiCell(175,4,'Solucion: '.utf8_decode($key->solucion),1,'L');
	$pdf->Cell(40,6,'Fecha Inicio: '.utf8_decode($key->f_inicio),1);
	$pdf->Cell(40,6,'Fecha Fin: '.utf8_decode($key->f_fin),1);
	$pdf->Cell(40,6,'Fecha Analisis: '.utf8_decode($key->fecha),1);
	$pdf->Cell(55,6,'Activo: '.utf8_decode($key->activo),1);
	$pdf->Ln(12);
}

$pdf->SetFont('Arial','B',13);
$pdf->Cell(35,6,'Soluciones Preventivas',0);
$pdf->Ln();
$pdf->SetFont('Arial','',7);
foreach ($preventivo->getResult() as $key) {
	$pdf->MultiCell(175,4,'Problema: '.utf8_decode($key->problema_detectado),1,'L');
	$pdf->MultiCell(175,4,'Solucion: '.utf8_decode($key->solucion),1,'L');
	$pdf->Cell(40,6,'Fecha Inicio: '.utf8_decode($key->f_inicio),1);
	$pdf->Cell(40,6,'Fecha Fin: '.utf8_decode($key->f_fin),1);
	$pdf->Cell(40,6,'Fecha Analisis: '.utf8_decode($key->fecha),1);
	$pdf->Cell(55,6,'Activo: '.utf8_decode($key->activo),1);
	$pdf->Ln(12);
}

$pdf->Output();

?>