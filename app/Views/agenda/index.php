<div class="card-soft mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Agenda personal</h2>
        <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nuevo evento</button>
    </div>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($agenda)): ?>
                <tr><td colspan="3" class="text-muted">No hay pendientes.</td></tr>
            <?php else: ?>
                <?php foreach ($agenda as $item): ?>
                    <tr>
                        <td><?= esc($item['titulo']) ?></td>
                        <td><?= esc($item['fecha']) ?></td>
                        <td><?= esc($item['f_fin']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalNuevo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('agenda') ?>
            <div class="modal-header"><h5 class="modal-title">Nuevo evento</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label">Título</label><input class="form-control" name="titulo" required></div>
                <div class="mb-2"><label class="form-label">Fecha inicio</label><input type="date" class="form-control" name="fecha" required></div>
                <div class="mb-2"><label class="form-label">Fecha fin</label><input type="date" class="form-control" name="f_fin"></div>
            </div>
            <div class="modal-footer"><button class="btn btn-brand">Guardar</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>
