<script>
$("#guardar_proyecto").click(function(){
    var url="<?php echo base_url()?>login/guarda_mod_proyecto";
    $.ajax({
        type:   "POST",
        url:    url,
        data:   $("#form_proyecto").serialize(),
        success: function(data)
        {
            $("#body_modal").html(data);
            location.reload();
        }
    });
    return false; // Evitar ejecutar el submit del formulario.
});
</script>
<div class="card-content">
    <form method="post" id="form_proyecto">
        <div class="form-group">
            <label class="control-label">Nombre Proyecto</label>
            <input type="text" name="proyecto" value="<?php echo $proyecto[0]->nombre_proyecto?>" class="form-control">
        </div>
        <div class="form-group ">
            <label class="control-label">Fecha inicio</label>
            <input type="date" name="finicio" value="<?php echo $proyecto[0]->f_inicio?>" class="form-control">
        </div>
        
        <div class="form-group ">
            <label class="control-label">Lider de proyecto</label>
            <select name="capitan" class="form-control">
                <option></option>
                <?php
                $seleccion="";
                
                foreach ($usuarios->getResult() as $key) {
                    if ($key->id==$proyecto[0]->capitan){
                        $seleccion="selected='selected'";
                    }else{
                        $seleccion="";
                    }
                    ?>
                        <option <?php echo $seleccion?> value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                    <?php
                }
                ?>
            </select>
            
        </div>
        <div class="form-group label-floating">
            <label class="control-label">Back up</label>
            <select name="subcapitan" class="form-control">
                <option></option>
                <?php
                $seleccion="";
                foreach ($usuarios->getResult() as $key) {
                    if ($key->id==$proyecto[0]->subcapitan){
                        $seleccion="selected='selected'";
                    }else{
                        $seleccion="";
                    }
                    ?>
                        <option <?php echo $seleccion?> value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div class="form-group label-floating">
            <label class="control-label">Patrocinador</label>
            <select name="Patrocinador" class="form-control">
                <option></option>
                <?php
                $seleccion="";
                foreach ($usuarios->getResult() as $key) {
                    if ($key->id==$proyecto[0]->patrocinador){
                        $seleccion="selected='selected'";
                    }else{
                        $seleccion="";
                    }
                    ?>
                        <option <?php echo $seleccion?> value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <input type="text" id="id" name="id" value="<?php echo $proyecto[0]->id_proyecto?>" style="display: none;">
        <button id="guardar_proyecto" class="btn btn-fill btn-rose">Guardar</button>
    </form>
</div>

