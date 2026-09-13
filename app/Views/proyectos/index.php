<div class="card-soft mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Proyectos</h2>
        <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nuevo proyecto</button>
    </div>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Proyecto</th>
                    <th>Capitán</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Pendiente</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($proyectos as $p): ?>
                <tr>
                    <td><?= (int) $p['id_proyecto'] ?></td>
                    <td><?= esc($p['nombre_proyecto']) ?></td>
                    <td><?= esc($p['capitan_nombre'] ?? $p['capitan']) ?></td>
                    <td><?= esc($p['f_inicio']) ?></td>
                    <td><?= esc($p['f_fin'] ?? '—') ?></td>
                    <td><span class="badge-soft"><?= esc($p['pendiente'] ?? '') ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalNuevo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('proyectos') ?>
            <div class="modal-header"><h5 class="modal-title">Nuevo proyecto</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label">Nombre</label><input class="form-control" name="nombre_proyecto" required></div>
                <div class="mb-2"><label class="form-label">Fecha inicio</label><input type="date" class="form-control" name="f_inicio" value="<?= date('Y-m-d') ?>"></div>
                <div class="mb-2"><label class="form-label">Capitán</label>
                    <select class="form-select" name="capitan" required>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= (int) $u['id'] ?>"><?= esc($u['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-2"><label class="form-label">Subcapitán</label>
                    <select class="form-select" name="subcapitan" required>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= (int) $u['id'] ?>"><?= esc($u['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-2"><label class="form-label">Patrocinador</label>
                    <select class="form-select" name="patrocinador">
                        <option value="0">—</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= (int) $u['id'] ?>"><?= esc($u['nombre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer"><button class="btn btn-brand">Crear</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>
