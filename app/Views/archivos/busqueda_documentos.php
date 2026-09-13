
<div class="col-md-6 col-md-offset-3">
    <div class="card">
        <div class="card-content text-center">
            <form id="formulario">
            	<div class="form-group ">
            		<label class="control-label" style="color: #000;font-size: 16px" >Folio a buscar</label>
            		<input type="text" id="folio" name="folio" class="form-control">
            	</div>
            	<button type="button" class="btn btn-info" id="btn_enviar">Buscar</button>
            </form>
        </div>
    </div>
</div>
<script>
$("#btn_enviar").click(function(){
 var url = "<?php echo base_url()?>login/resultado_busqueda"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formulario").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#resultado").html(data); // Mostrar la respuestas del script PHP.
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
</script>
<div class="col-md-10 col-md-offset-1" id="resultado">
    
</div>