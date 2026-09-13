<script>
function carga_menus() {
    $.post("<?= site_url('login/combo_menus') ?>", { empresa: $("#empresa").val() }, function (data) {
        $("#menu").prop("disabled", false).html(data);
    });
}

$("#guardar").off("click").on("click", function () {
    $.ajax({
        type: "POST",
        url: "<?= site_url('login/agrega_submenu') ?>",
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
        <select id="empresa" name="empresa" onchange="carga_menus()" class="form-select" required>
            <option value=""></option>
            <?php foreach ($empresas->getResult() as $key): ?>
                <option value="<?= esc($key->id) ?>"><?= esc($key->nombre) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="menu">Menú</label>
        <select id="menu" name="menu" class="form-select" disabled required></select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="nombre_submenu">Nombre del submenú</label>
        <input type="text" id="nombre_submenu" name="nombre_submenu" class="form-control" required>
    </div>
    <button type="button" class="btn btn-archiva" id="guardar">Guardar</button>
</form>
