<?php

$file="";
foreach ($nombre->getResult() as $key ) {
$file=base_url().'archivos/'.$key->nombre;



	$varlo=explode(".",$key->nombre);

	if (strtolower($varlo[1]=="webm")){
		?>
		<video autoplay loop width="100%" height="460" controls>
		  <source src="<?php echo $file?>" type="video/webm">
		  Your browser does not support the video tag.
		</video>
		<?php
	}else{
	
	
		header('Location: http://docs.google.com/viewer?url='.$file);
	}

	
}

?>

