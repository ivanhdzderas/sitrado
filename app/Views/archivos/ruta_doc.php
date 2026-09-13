<?php
$ruta1=login_model()->carga_nombre_grupo($grupo);
$nombre1="";
$idempresa="";
foreach ($ruta1->getResult() as $key) {
	$nombre1=$key->nomber;
	$idempresa=$key->empresa;
}

$logo="";
$nombre_empresa="";
$alfa=login_model()->nombre_empresa($idempresa);
foreach ($alfa->getResult() as $key) {
	$logo=$key->logo;
	$nombre_empresa=$key->nombre;
}

$nombre_al=login_model()->carga_nombre_subgrupo($subgrupo);
$nombre2="";
foreach ($nombre_al->getResult() as $key) {
$nombre2=$key->nombre;

}

	echo "<h3 style='position:relative; top:-90px'><img  src='".base_url()."logos/".$logo."'><br />".$nombre_empresa." <br />&ensp;&ensp;Menu:".$nombre1." <br /> &ensp;&ensp; &ensp;&ensp;SubMenu: ".$nombre2."</h3>";


?>