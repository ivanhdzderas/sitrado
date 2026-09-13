
    <div class="card">
        <div class="card-content">
            <form id="formulario">
                <div class="form-group">
                    Tipo de Solicitud:
                    <?php 
                    switch($todo[0]->tipo){
                        case "N":
                            echo "Nuevo";
                        break;
                        case "M":
                            echo "Moodificar";
                        break;
                        case "C":
                            echo "Cancelar";
                        break;
                    }
                    ?><br />
                    Fecha Solicitud:<?php echo $todo[0]->fecha?><br />
                    Solicitante:<?php echo $todo[0]->solicitante?>
                </div>
                <div class="form-group">
                    <label class="control-label">Codigo</label>
                    <input type="text" id="codigo" name="codigo" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo $todo[0]->nombre?>" class="form-control">
                </div>
                <button type="submit" id="btn_enviar" class="btn btn-fill btn-rose">Guardar</button>

            </form>
        </div>
    </div>
    <script>
    $("#btn_enviar").click(function(){
    var url = "<?php echo base_url()?>login/modifica_solicitud/<?php echo $todo[0]->id_solicitud?>/<?php echo $todo[0]->tipo?>"; 
    $.ajax({
           type: "POST",
           url: url,
           data:{codigo:$("#codigo").val(),nombre:$("#nombre").val()}, // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               location.reload();
               
               //$("#respuesta").html(data); // Mostrar la respuestas del script PHP.
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
</script>