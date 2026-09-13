<?php
foreach ($nombre->getResult() as $empresa) {
	echo "<h3 style='position:relative; top:-90px'><img src='".base_url()."logos/".$empresa->logo."' width='300px'><br/>".$empresa->nombre;
}
?>