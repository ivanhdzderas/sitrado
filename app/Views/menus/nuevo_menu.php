<script>
$("#guardar").off("click").on("click", function () {
    $.ajax({
        type: "POST",
        url: "<?= site_url('login/agrega_menu') ?>",
        data: $("#nuevo_menu").serialize(),
        success: function () {
            location.reload();
        }
    });
    return false;
});
</script>
<form id="nuevo_menu" class="archiva-form">
    <div class="mb-3">
        <label class="form-label" for="empresa">Empresa</label>
        <select id="empresa" name="empresa" class="form-select" required>
            <option value=""></option>
            <?php foreach ($empresas->getResult() as $key): ?>
                <option value="<?= esc($key->id) ?>"><?= esc($key->nombre) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="nombre_menu">Nombre del menú</label>
        <input type="text" id="nombre_menu" name="nombre_menu" class="form-control" required>
    </div>
    <button type="button" class="btn btn-archiva" id="guardar">Guardar</button>
</form>
