<?php

$file="";
foreach ($nombre->getResult() as $key ) {
$file=base_url().'archivos/'.$key->nombre;



		?>
		<video autoplay loop width="100%" height="460" controls>
		  <source src="<?php echo $file?>" type="video/webm">
		  <source src="<?php echo $file?>" type="video/mp4">
		  Your browser does not support the video tag.
		</video>
		<?php
	
}

?>

