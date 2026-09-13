<option value=""></option>
<?php
foreach ($menu->getResult() as $key) {
	?>
		<option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
	<?php
	}
?>