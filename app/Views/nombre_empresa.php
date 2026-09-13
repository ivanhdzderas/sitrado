<?php
foreach ($nombre->getResult() as $empresa) {
	echo "<h1><center>".$empresa->nombre."</center></h1>";
}
?>