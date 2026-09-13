<?php 
foreach ($tema_junta->getResult() as $tema) {
    $fecha_compromiso=$tema->fecha_compromiso;
    $tema_ju=$tema->tema;
    $archivo=$tema->archivo;
}
?>
<b>Activida: <?php echo $tema_ju?></b><br />
<b>Fecha Compromiso: <?php echo $fecha_compromiso?></b><br />
