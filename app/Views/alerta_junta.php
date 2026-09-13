<?php 
foreach ($datos_junta->getResult() as $key) {
	?>

		<b>Tema:</b>  <?php echo $key->tema?><br />
		<b>Lugar: </b> <?php  echo $key->lugar?><br />
		<b>Fecha:</b>  <?php echo $key->fecha?><br/>
	<?php
}
?>