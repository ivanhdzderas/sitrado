<script>
	$(function(){
 $("#guardar_preminuta").click(function(){
 var url = "<?php echo base_url()?>guarda_modificado"; // El script a dónde se realizará la petición.
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
<?php 
$nombre="";
$participante="";
$fecha="";
$archivo="";
foreach ($actividad as $key) {
	$nombre=$key->tema;
	$participante=$key->id_usuario_encargado;
	$fecha= $key->fecha_compromiso;
	$archivo=$key->archivo;
}
?>
<form method="post" id="pre_minuta">
	<div class="row">
		<div class="col-md-10">
			<div class="form-group  is-empty">
				<label class="control-label">Actividad</label>
				<input type="text" class="form-control" name="actividad" value ="<?php echo $nombre?>" >
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group is-empty">
				<label class="control-label">Participante</label>

				<select name="participante" class="form-control">
					<option ></option>
					<?php
						foreach ($usuarios->getResult() as $key ) {
							if ($key->id==$participante){
								$seleccion='selected="selected"';
							}else{
								$seleccion="";
							}
							?>
								<option <?php echo $seleccion?> value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
							<?php
						};
					?>
				</select>
			
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group is-empty">
				<label class="control-label">Fecha Compromiso</label>
				<input name="fecha_compromiso"  required="required" value="<?php echo $fecha?>"  type="date" class="form-control">
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group is-empty">
				<label class="control-label">Es necesario subir archivo</label>
				<select name="archivo" required="required" class="form-control">
					<option ></option>
					<?php
					if ($archivo=="NO"){
						?>
					<option selected="selected" value="NO">NO</option>
					<option value="SI">SI</option>
						<?PHP
					}else{
						?>
						<option  value="NO">NO</option>
						<option selected="selected" value="SI">SI</option>
						<?php
					}
					?>
					
				</select>
				
			</div>
		</div>
		<input type="text" style="visibility: hidden;" value="<?php echo $tema?>" id="tema" name="tema"> 
		<div class="col-md-10">
			<button class="btn btn-success" id="guardar_preminuta">Guardar</button>
		</div>
	</div>
</form>