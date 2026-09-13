<script>
	$(function(){
 $("#guardar_preminuta").click(function(){
 var url = "<?php echo base_url()?>guardar_actividad"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#pre_minuta").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
					location.reload();
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
});
</script>
<form method="post" id="pre_minuta">
	<div class="row">
		<div class="col-md-10">
			<div class="form-group label-floating is-empty">
				<label class="control-label">Actividad</label>
				<input type="text" class="form-control" name="actividad" >
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group label-floating is-empty">
				<label class="control-label">Participante</label>
				<select name="participante" class="form-control">
					<option ></option>
					<?php
						foreach ($usuarios as $key ) {
							?>
								<option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
							<?php
						};
					?>
				</select>
			
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group is-empty">
				<label class="control-label">Fecha Compromiso</label>
				<input name="fecha_compromiso" value="" required="required"  type="date" class="form-control">
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group is-empty">
				<label class="control-label">Es necesario subir archivo</label>
				<select name="archivo" required="required" class="form-control">
					<option ></option>
					<option value="NO">NO</option>
					<option value="SI">SI</option>
				</select>
				
			</div>
		</div>
		<div class="col-md-10">
			<button class="btn btn-success" id="guardar_preminuta">Guardar</button>
		</div>
	</div>
</form>