<?php
$ruta1=login_model()->ruta1documento($menu1);
$nombre1="";
$idempresa="";
foreach ($ruta1->getResult() as $key) {
	$nombre1=$key->nombre;
	$idempresa=$key->empresa;
}

$nombre_al=login_model()->nombre_empresa($idempresa);
$nombre_empresa="";
$logo="";

foreach ($nombre_al->getResult() as $key) {
$nombre_empresa=$key->nombre;
$logo=$key->logo;
}
$ruta2=login_model()->ruta2documento($menu2)->getResult();
$nombre2="";
foreach ($ruta2 as $key) {
	$nombre2=$key->nombre;
}
if ($logo==""){
	echo "<h2 style='position:relative; top:-90px'>".$nombre_empresa."<br />Menu:".$nombre1." <br /> SubMenu: ".$nombre2."</h2>";

}else{
echo "<h2 style='position:relative; top:-90px'>"."<img src='".base_url()."logos/".$logo."' width='200px'><br />".$nombre_empresa."<br />&ensp;&ensp;&ensp;Menu:".$nombre1."<br /> &ensp;&ensp;&ensp;&ensp;&ensp;SubMenu: ".$nombre2."</h2>";}
?>