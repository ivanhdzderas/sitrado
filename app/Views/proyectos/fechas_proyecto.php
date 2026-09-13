<?php
$fecha_inicio="";
$fecha_fin="";
if ($fechas==NULL){
?>
<div class="form-group label-floating col-md-6">
    <label class="control-label">Fecha Inicio</label>
	<input type="date" name="f_inicio" id="f_inicio"  class="form-control" required="required">
</div>
<div class="form-group label-floating col-md-6">
    <label class="control-label">Fecha Fin</label>
	<input type="date" name="f_fin" id="f_fin"  class="form-control" required="required">
</div>
<?php
}else{
foreach ($fechas as $key) {
	$fecha_inicio=$key->f_inicio;
	$fecha_fin=$key->f_fin;
}
?>
<div class="form-group label-floating col-md-6">
    <label class="control-label">Fecha Inicio</label>
	<input type="date" name="f_inicio" id="f_inicio" min="<?php echo $fecha_inicio?>" class="form-control" required="required">
</div>
<div class="form-group label-floating col-md-6">
    <label class="control-label">Fecha Fin</label>
	<input type="date" name="f_fin" id="f_fin" max="<?php echo $fecha_fin?>"  class="form-control" required="required">
</div>
<?php
}
?>