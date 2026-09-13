<div class="archiva-panel">
    <h2 class="panel-title mb-3">Reportes</h2>

    <form method="post" id="reporte" class="archiva-form" action="<?= site_url('login/reporte') ?>" target="_blank">
        <div class="mb-3">
            <label class="form-label d-block">Tipo de reporte</label>
            <div class="d-flex flex-wrap gap-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tipo[]" value="analisis" id="tipo_8d">
                    <label class="form-check-label" for="tipo_8d">8D</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tipo[]" value="minutas" id="tipo_minutas">
                    <label class="form-check-label" for="tipo_minutas">Minutas</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tipo[]" value="proyectos" id="tipo_proyectos">
                    <label class="form-check-label" for="tipo_proyectos">Proyectos</label>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label" for="tipo_global">Usuario</label>
                <select id="tipo_global" name="tipo_global" class="form-select">
                    <option value=""></option>
                    <option value="todos">Todos</option>
                    <?php foreach ($usuarios->getResult() as $key): ?>
                        <option value="<?= esc($key->id) ?>"><?= esc($key->nombre) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="moderador" id="moderador" value="1">
                    <label class="form-check-label" for="moderador">Moderador</label>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label" for="archivo">Tipo de archivo</label>
                <select id="archivo" name="archivo" class="form-select" required>
                    <option value=""></option>
                    <option value="pdf">PDF</option>
                    <option value="excel">EXCEL</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-archiva" id="btn_enviar">Generar</button>
        </div>
    </form>
</div>
