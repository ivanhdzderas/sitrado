<option value=""></option>
<?php
foreach ($submenus->getResult() as $key) {
	?>
		<option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
	<?php
	}
?>