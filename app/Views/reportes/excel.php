<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
function obtenerFechaEnLetra($fecha){
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' de '.$mes.' del '.$anno;
}



error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once  'PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$logo = 'assets/img/logo.png'; // Provide path to your logo file
$objDrawing->setPath($logo);
$objDrawing->setOffsetX(8);    // setOffsetX works properly
$objDrawing->setOffsetY(300);  //setOffsetY has no effect
$objDrawing->setCoordinates('A1');
$objDrawing->setHeight(75); // logo height
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); 




	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E3:G3');
	$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000000'))));

	$objPHPExcel->getActiveSheet()->setCellValue('E3',"Carga de Usuarios");
	$objPHPExcel->getActiveSheet()->setCellValue('G4',"Fecha");
	$objPHPExcel->getActiveSheet()->setCellValue('G5','07/12/2017');
	$objPHPExcel->getActiveSheet()->setCellValue('F4',"Rev");
	$objPHPExcel->getActiveSheet()->setCellValue('F5',"0");
	$objPHPExcel->getActiveSheet()->setCellValue('E4',"Codigo");
	$objPHPExcel->getActiveSheet()->setCellValue('E5',"MP-F-22");
	

	$objPHPExcel->getActiveSheet()
        ->getStyle('A1:Z6')
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('ffffff');
	
	$conteo=6;

	
		$conteo=$conteo+2;
		$objPHPExcel->getActiveSheet()->getStyle('A'.($conteo-1))->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => '000000'))));
		$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A'.$conteo, 'Nombre')
	            ->setCellValue('B'.$conteo, 'pendientes')
	            ->setCellValue('C'.$conteo, 'Cerrados')
	            ->setCellValue('D'.$conteo, 'Total')
	            ->setCellValue('E'.$conteo, '%');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($conteo-1).':F'.($conteo-1));
		           
	    $objPHPExcel->getActiveSheet()
	        ->getStyle('A'.$conteo.':F'.$conteo)
	        ->getFill()
	        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	        ->getStartColor()
	        ->setRGB('2a2655');
		$objPHPExcel->getActiveSheet()->getStyle('A'.$conteo.':F'.$conteo)->applyFromArray(array('font' => array('bold' => true,'color' => array('rgb' => 'ffffff'))));
		$conteo=$conteo+1;

		foreach ($usuarios->getResult() as $key) {
			
		

			$objPHPExcel->getActiveSheet()->setCellValue('A'.$conteo,$key->nombre);
			$Pendientes=count (login_model()->pendientes_8d($key->id));
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$conteo,$Pendientes);
			$soluciones=count (login_model()->soluciones_8d($key->id));
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$conteo,$soluciones);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$conteo,($Pendientes+$soluciones));


			$total=$Pendientes+$soluciones;
			if ($total>0){
				$porcentaje=($soluciones*100)/$total;
			}else{
				$porcentaje=0;
			}
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$conteo,(round($porcentaje,0).'%'));
			$conteo=$conteo+1;
		}


		

	
	
	

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file

$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save("Reporte_carga.xlsx");
header('Location: '.base_url().'Reporte_carga.xlsx');

?>


