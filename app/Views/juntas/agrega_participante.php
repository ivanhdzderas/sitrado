<script>
function carga_participantes(){
	var url="<?php echo base_url()?>carga_participantes";
	var junta="<?php echo $junta?>";
	 $.post(url,
            {junta:junta},
            function(data){
                $("#lista_participante_junta").html(data);
             }); 

}
$( document ).ready(function() {
    carga_participantes();
});
 $("#guardar_participante").click(function(){
	var url="<?php echo base_url()?>guardar_participante";
	 $.ajax({
           type: "POST",
           url: url,
           data: $("#form_combocados").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               carga_participantes();
               $("#form_combocados")[0].reset();
           }
         });
	return false;
});
   $(document).ready(function() {
    /*$('#participante').select2();*/
});
</script>
<form method="post" id="form_combocados">
	<div class="row">
		
		<div class="col-md-10">
			<div class="form-group label-floating is-empty">
				<label class="control-label">Participante</label>
				<select style="width: 100%" name="participante" id="participante" class="form-control">
					<option ></option>
					<?php
						foreach ($usuarios->getResult() as $key ) {
							?>
								<option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
							<?php
						};
					?>
				</select>
			
			</div>
		</div>
		
		<input type="text" id="junta" name="junta" value="<?php echo $junta?>" style="visibility: hidden;">
		<div class="col-md-10">
			<button class="btn btn-success" id="guardar_participante">Agregar</button>
		</div>
	</div>
</form>

<div id="lista_participante_junta">
</div>