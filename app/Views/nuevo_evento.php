<script>
$(function(){
 $("#btn_guardar").click(function(){
 var url = "<?php echo base_url()?>login/guardar_evento"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#RegisterValidation").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#RegisterValidation").html("Guardado con exito");
               location.reload();
               //setTimeout("window", 2000);
               //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
});
</script>

 <form id="RegisterValidation"  method="">
    <div class="card-content">
        <div class="form-group label-floating">
            <label class="control-label">
                Titulo Tema
            </label>
            <input class="form-control" name="titulo" type="text" required="true" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label">
                Fecha inicio
            </label>
            <input class="form-control" name="f_inicio" type="date" required="true" />
        </div>
        <div class="form-group label-floating">
            <label class="control-label">
                Fecha Fin
            </label>
            <input class="form-control" name="f_fin" type="date" required="true"  />
        </div>
        <div class="form-group label-floating">
            <label class="control-label">
                Descripcion
            </label>
            <textarea name="descripcion" class="form-control"></textarea>
            
        </div>
        <div class="form-group label-floating">
            <label class="control-label">
                Tipo
            </label>
            <select name="tipo" class="form-control">
                <option value=""></option>
                <option value="Beneficio">Dia otorgado como Beneficio</option>
                <option value="Asueto">Dia Asueto</option>
                <option value="Medio">Medio Dia</option>
                <option value="Interno">Evento Interno</option>
                <option value="Capacitacion">Dia de capacitacion</option>
            </select>
            
        </div>   

        <div class="form-footer text-right">
            <button type="submit" id="btn_guardar" class="btn btn-rose btn-fill">Guardar</button>
        </div>
    </div>
</form>