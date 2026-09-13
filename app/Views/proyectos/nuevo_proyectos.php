<script>
$("#guardar_proyecto").click(function(){
    var url="<?php echo base_url()?>guarda_proyecto";
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
            <input type="text" name="proyecto" class="form-control">
        </div>
        <div class="form-group ">
            <label class="control-label">Fecha inicio</label>
            <input type="date" name="finicio" class="form-control">
        </div>
        
        <div class="form-group ">
            <label class="control-label">Lider de proyecto</label>
            <select name="capitan" class="form-control">
                <option></option>
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
            <label class="control-label">Back up</label>
            <select name="subcapitan" class="form-control">
                <option></option>
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
            <label class="control-label">Patrocinador</label>
            <select name="Patrocinador" class="form-control">
                <option></option>
                <?php
                foreach ($usuarios->getResult() as $key) {
                    ?>
                        <option value="<?php echo $key->id?>"><?php echo $key->nombre?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <button id="guardar_proyecto" class="btn btn-fill btn-rose">Guardar</button>
    </form>
</div>

