<script>
  $(document).ready(function() {
    $('#nombre').select2();
});
</script>

<div class="form-group">
    <label class="control-label">Documento</label>
    <select id="nombre" name="nombre" class="form-control">
    	<option value=""></option>
    	<?php
    	foreach ($archivos as $key) {
    		?>
    		<option value="<?php echo $key->nombre?>"><?php echo $key->nombre?></option>
    		<?php
    	}
    	?>
    </select>
</div>
<div class="form-group">
    <label class="control-label">Descripcion del Cambio</label>
    <textarea id="descripcion" name="descripcion" class="form-control"></textarea>
</div>
<button type="submit" id="btn_enviar" class="btn btn-fill btn-rose">Enviar</button>
<script>
	$("#btn_enviar").click(function(){
 	var url = "<?php echo base_url()?>login/guardar_solicitud_documento/otro"; // El script a dónde se realizará la petición.
 	//alert($("#formulario").serialize());
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               swal(
				  'Solicitud enviada con exito'
				)
               setTimeout("location.reload();", 2000);
               //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
</script>