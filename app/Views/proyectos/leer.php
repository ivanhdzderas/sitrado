<?php



$file="";
foreach ($nombre->getResult() as $key ) {
	

	$varlo=explode(".",$key->archivo);

	$file=base_url().'archivos_proyectos/'.$key->id_subproyecto.".".$varlo[1];

	

	if (file_exists ($file)){

	}else{
		$file=base_url().'archivos_proyectos/'.$key->archivo;
	}
	header('Location: http://docs.google.com/viewer?url='.$file);
	//print_r('<iframe src="http://docs.google.com/gview?url='.$file .'&embedded=true" style="width:700px; height:880px;" frameborder="0"></iframe>');
	
	
	
}

