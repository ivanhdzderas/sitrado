<label class="control-label">Seleccione Cual sub-grupo puede ver este archivo</label>
<?php
foreach ($permisos->getResult() as $key) {
	?>

	<div class="checkbox">
		<label>
			<input type="checkbox" name="permisos[]" value="<?php echo $key->id?>"  ><span class="checkbox-material"><span class="check"></span></span> <?php echo $key->nomber?> / <?php echo $key->nombre?>
		</label>
	</div>
	
	<?php
}
?>
