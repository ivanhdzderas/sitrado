<div style="padding-top: 20px; font-size: 25px">
<label>Seleccione empresa a trabajar: </label>
<select id="empresa" class="form-control" onchange="window.location='<?php echo base_url("empresas/")?>'+this.value">
<option value=""></option>
<?php

foreach ($data->getResult() as $empresa){
	?>
	<option value="<?php echo $empresa->id?>"><?php echo $empresa->nombre?></option>
	<?php
};
?>
</select>

<??>
</div>