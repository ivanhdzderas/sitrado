<form method="post" id="reporte" class="archiva-form" action="<?= site_url('login/reporte') ?>" target="_blank">
    <input type="hidden" name="tipo[]" value="minutas">

    <div class="mb-3">
        <label class="form-label" for="tipo_global">Usuario</label>
        <select id="tipo_global" name="tipo_global" class="form-select" required>
            <option value=""></option>
            <option value="todos">Todos</option>
            <?php foreach ($usuarios->getResult() as $key): ?>
                <option value="<?= esc($key->id) ?>"><?= esc($key->nombre) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="moderador" id="moderador" value="1">
        <label class="form-check-label" for="moderador">Moderador</label>
    </div>

    <div class="mb-3">
        <label class="form-label" for="fecha_reporte">Fecha</label>
        <input type="date" id="fecha_reporte" name="fecha" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label" for="archivo">Tipo de archivo</label>
        <select id="archivo" name="archivo" class="form-select" required>
            <option value=""></option>
            <option value="pdf">PDF</option>
            <option value="excel">EXCEL</option>
        </select>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-archiva">Generar</button>
    </div>
</form>
