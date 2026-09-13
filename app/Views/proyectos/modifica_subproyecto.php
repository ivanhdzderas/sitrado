<script>
   $("#btn_tarea").click(function(){
    var url = "<?php echo base_url()?>login/actualiza_subproyecto";
    $.ajax({
           type: "POST",
           url: url,
           data: $("#form_tareas").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
                //$('#body_modal').html(data);
               //$('#myModal').modal('toggle');
               location.reload();
           }
         });

    return false; // Evitar ejecutar el submit del formulario.
 });
</script>
<?php
foreach ($subproyecto as $key) {
    $nombre=$key->nombre;
    $id_usuario=$key->id_usuario;
    $f_inicio=$key->f_inicio;
    $f_fin=$key->f_fin;
    $id_subproyecto=$key->id_subproyecto;
    $validar=$key->responsable;
}
?>
<div id="entrada_tareas">
    <form method="post" id="form_tareas">
        <input type="text" id="id" name="id" value="<?php echo $id_subproyecto?>" style="display: none;">
        <div class="form-group label-floating col-md-6">
           <label class="control-label">Tarea</label> 
            <input type="text" id="nombre_tarea" value="<?php echo $nombre?>" name="nombre_tarea" class="form-control" required="required">
        </div>
        <div class="form-group label-floating col-md-6">
           <label class="control-label">Realiza</label>
            <select name="usuario_tarea" id="usuario_tarea" class="form-control" required="required">
                <option></option>
                    <?php
                        foreach ($usuarios->getResult() as $usuario) {
                            $seleccion="";
                            if ($id_usuario==$usuario->id){
                                $seleccion="selected";
                            }else{
                                $seleccion="";
                            }
                        ?>
                            <option <?php echo $seleccion?> value="<?php echo $usuario->id?>"><?php echo $usuario->nombre?></option>
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
                            $seleccion="";
                            if ($responsable==$usuario->id){
                                $seleccion="selected";
                            }else{
                                $seleccion="";
                            }
                        ?>
                            <option <?php echo $seleccion?> value="<?php echo $usuario->id?>"><?php echo $usuario->nombre?></option>
                        <?php
                        }
                    ?>
                </select>
        </div>
        <div id="div_fechas">
            <div class="form-group label-floating col-md-6">
                <label class="control-label">Fecha Inicio</label>
                <input type="date" name="f_inicio" value="<?php echo $f_inicio?>" id="f_inicio" class="form-control" required="required">
            </div>
            <div class="form-group label-floating col-md-6">
                <label class="control-label">Fecha Fin</label>
                <input type="date" name="f_fin" id="f_fin" value="<?php echo $f_fin?>" class="form-control" required="required">
            </div>
        </div>
        <button id="btn_tarea" class="btn btn-success">Asignar</button>
    </form> 
</div>