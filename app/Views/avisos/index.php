<div class="card-soft mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Avisos</h2>
        <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nuevo aviso</button>
    </div>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mensaje</th>
                    <th>Activo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($avisos as $a): ?>
                <tr>
                    <td><?= (int) $a['id'] ?></td>
                    <td><?= esc(character_limiter(strip_tags($a['mensaje'] ?? ''), 120)) ?></td>
                    <td><span class="badge-soft"><?= esc($a['activo']) ?></span></td>
                    <td class="text-end">
                        <?php if ($a['activo'] === 'SI'): ?>
                            <?= form_open('avisos/' . $a['id'] . '/eliminar') ?>
                                <button class="btn btn-sm btn-outline-danger">Desactivar</button>
                            <?= form_close() ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalNuevo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('avisos') ?>
            <div class="modal-header"><h5 class="modal-title">Nuevo aviso</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <label class="form-label">Mensaje</label>
                <textarea class="form-control" name="mensaje" rows="5" required></textarea>
            </div>
            <div class="modal-footer"><button class="btn btn-brand">Publicar</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>
