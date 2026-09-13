<script>
 $("#guardar_minuta").click(function(){
        
        var url = "<?php echo base_url()?>guarda_junta"; // El script a dónde se realizará la petición.
        $.ajax({
               type: "POST",
               url: url,
               data: $("#form_minuta").serialize(), // Adjuntar los campos del formulario enviado.
               success: function(data)
               {
                   
                        //$("#modal_body").html(data);
                        window.location="<?php echo base_url()?>juntas";
                        //$("#boton_enviar").html(data);
                    
               }
             });

        return false; // Evitar ejecutar el submit del formulario.
     });

</script>

<center><h5><b>Nueva Minuta</b></h5></center>
<div class="row"> 
    <form id="form_minuta">                                            
        <div class="col-lg-10 col-lg-offset-1">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">&#xE264;</i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Tema o Titulo
                    </label>
                    <input name="tema" type="text" class="form-control" required="required">
                </div>
            </div>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">record_voice_over</i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Moderador
                    </label>
        <select name="impartidor"  class="form-control" required="required">
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
            </div>
        </div>
        <div class="col-lg-10 col-lg-offset-1">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">&#xE55F;</i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Lugar
                    </label>
                    <select id="lugar" name="lugar" class="form-control" required="required">
                        <option value=""></option>
                        <?php
                        foreach ($salas as $key) {
                            ?>
                            <option value="<?php echo $key->nombre?>"><?php echo $key->nombre."--".$key->direccion?></option>
                            <?php
                        }
                        ?>
                    </select>
                    
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-lg-offset-1">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">&#xE916;</i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Fecha y hora
                    </label>
                   <input name="fecha" value="" required="required"  type="datetime-local" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-lg-10 col-lg-offset-1">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">&#xE192;</i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Duracion
                    </label>
                        <select name="duracion"  class="form-control" required="required">
                            <option value=""></option>
                                <?php
                                    for ($i=1; $i<=24 ; $i++) { 
                                        if ($i==1){
                                            $hora="Hora";
                                        }else{
                                            $hora="Horas";
                                        }
                                       ?>
                                       <option value="<?php echo $i?>"><?php echo $i." ".$hora?></option>
                                       <?php 
                                    }
                                ?>
                        </select>
                  
                </div>
            </div>
        </div>

         <div class="col-lg-10 col-lg-offset-1">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="material-icons">&#xE923;</i>
                </span>
                <div class="form-group label-floating">
                    <label class="control-label">Tipo de Minuta
                    </label>
                    <input type="radio" name="tipo"   value="u" checked >Unica<br>
                    <input type="radio" name="tipo"   value="s">Semanal<br>
                    <input type="radio" name="tipo"   value="m">Mensual<br>
                </div>
            </div>
        </div>


        <div class="col-lg-10 col-lg-offset-1">
            <button class="btn btn-success" id="guardar_minuta">Guardar</button>
        </div>
    </form>
</div>
