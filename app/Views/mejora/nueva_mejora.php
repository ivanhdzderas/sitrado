<div class="card">
    <form id="RegisterValidation" >
        
        <div class="card-content">
            <h4 class="card-title">Registro de Mejora</h4>
            <div class="form-group label-floating">
                <label class="control-label">
                    Solicitante
                    <small>*</small>
                </label>
                
                <select id="usuario" name="usuario" class="form-control">
                    <option value=""></option>
                    <?php
                    foreach ($usuarios->getResult() as $key) {
                        ?>
                        <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-group label-floating">
                <label class="control-label">
                    Descripcion del problema
                    <small>*</small>
                </label>
                <textarea id="problema" name="problema" class="form-control"></textarea>
            </div>
            <div class="form-group label-floating">
                <label class="control-label">
                    Beneficios
                    <small>*</small>
                </label>
                <textarea id="beneficio" name="beneficio" class="form-control"></textarea>
            </div>
            <div class="form-footer text-right">
                
                <button type="submit" class="btn btn-rose btn-fill" id="guardar">Guardar</button>
            </div>
        </div>
    </form>
</div>
<script>
    $("#guardar").click(function(){
     var url = "<?php echo base_url()?>login/guardar_mejora"; // El script a dónde se realizará la petición.
        $.ajax({
               type: "POST",
               url: url,
               data: $("#RegisterValidation").serialize(), // Adjuntar los campos del formulario enviado.
               success: function(data)
               {
                   //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
                    location.reload();
               }
             });

        return false; // Evitar ejecutar el submit del formulario.
     });
</script>