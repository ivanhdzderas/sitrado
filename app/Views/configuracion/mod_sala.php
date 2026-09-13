<div class="archiva-form">
    <form id="formulario">
        <div class="mb-3">
            <label class="form-label" for="nombre">Nombre de la sala</label>
            <input type="text" name="nombre" id="nombre" value="<?= esc($sala[0]->nombre) ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion" value="<?= esc($sala[0]->direccion) ?>" class="form-control" required>
        </div>
        <button type="submit" id="btn_enviar" class="btn btn-archiva">Guardar</button>
    </form>
</div>
<script>
$("#btn_enviar").off("click").on("click", function () {
    $.ajax({
        type: "POST",
        url: "<?= site_url('login/guardar_sala_mod/' . $sala[0]->id_sala) ?>",
        data: $("#formulario").serialize(),
        success: function () {
            window.location.reload();
        }
    });
    return false;
});
</script>
