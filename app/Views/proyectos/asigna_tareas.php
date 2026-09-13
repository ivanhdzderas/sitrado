<script>
function carga_fechas(){
	var url="<?php echo base_url()?>fechas_proyecto";
	var proyecto='<?php echo $id_proyect?>';
	$.post(url,
            {proyecto:proyecto},
            function(data){

                $("#div_fechas").html(data);
             });
}
$("#btn_tarea").click(function(){
    var url="<?php echo base_url()?>asigna_tareas";
    var data=$("#form_tareas").serialize();
    data=data+"&proyecto="+'<?php echo $id_proyect?>';

 	$.ajax({
        type:   "POST",
        url:    url,
        data:   data,
        success: function(data)
        {
			$("#modal_title").html("Asigna tareas");
			var url="<?php echo base_url()?>signa_tareas";
			var proyecto='<?php echo $id_proyect?>';
			$.post(url,
				{proyecto,proyecto},
				function (data){
				$("#body_modal").html(data);
				carga_tareas();
				});
        }
    });
    //nuevas_tareas();
    return false; // Evitar ejecutar el submit del formulario.
});


$(document).ready(function(){
	$("#myModal2").on('hidden.bs.modal', function () {
            $("#myModal").fadeIn();
    });
    	
});
function aplica(tarea){
	var texto="accion"+tarea
	switch($("#"+texto).val()){
		case "elimina":
			var url="<?php echo base_url()?>elimina_tarea";
	 		$.post(url,
            	{id_tarea:tarea},
            	function(data){
               		carga_tareas();
             }); 

			break;
		case "responsabilidad":
			$("#myModal2").modal();
			$("#myModal").fadeOut();
			url="<?php echo base_url()?>login/responsables";
			$.post(url,
            	{id_tarea:tarea},
            	function(data){
               		$("#body_modal2").html(data);
             }); 
			break;
	}
}
	function carga_tareas(){
		var url="<?php echo base_url()?>tareas_sin_asignar";
		var proyecto='<?php echo $id_proyect?>';
		$.post(url,
			{proyecto:proyecto},
        function (data){
            //$("#list_tareas").html(data);
            location.reload();
        });
	}
</script>
<div class="card-content">
	<div id="entrada_tareas">
		<form method="post" id="form_tareas">
	        <div class="form-group label-floating col-md-6">
	           <label class="control-label">Tarea</label> 
				<input type="text" id="nombre_tarea" name="nombre_tarea" class="form-control" required="required">
	        </div>
	        <div class="form-group label-floating col-md-6">
	           <label class="control-label">Realiza</label>
				<select name="usuario_tarea" id="usuario_tarea" class="form-control" required="required">
					<option></option>
						<?php
							foreach ($usuarios->getResult() as $usuario) {
							?>
								<option value="<?php echo $usuario->id?>"><?php echo $usuario->nombre?></option>
							<?php
							}
						?>
				</select>
	        </div>
	        <div class="form-group label-floating col-md-6">
	           <label class="control-label">Responsable de Validar</label>
				<select name="responsable" id="responsable" class="form-control" required="required">
					<option></option>
						<?php
							foreach ($usuarios->getResult() as $usuario) {
							?>
								<option value="<?php echo $usuario->id?>"><?php echo $usuario->nombre?></option>
							<?php
							}
						?>
				</select>
	        </div>
	        <div id="div_fechas">
		        <div class="form-group label-floating col-md-6">
		            <label class="control-label">Fecha Inicio</label>
					<input type="date" name="f_inicio" id="f_inicio" class="form-control" required="required">
		        </div>
		        <div class="form-group label-floating col-md-6">
		            <label class="control-label">Fecha Fin</label>
					<input type="date" name="f_fin" id="f_fin" class="form-control" required="required">
		        </div>
		    </div>
	        <button id="btn_tarea" class="btn btn-success">Asignar</button>
	    </form>	
	</div>
	<div id="list_tareas">

	</div>
	
</div>