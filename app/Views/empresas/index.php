<div class="card-soft mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Empresas</h2>
        <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalNueva">Nueva empresa</button>
    </div>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>RFC</th>
                    <th>Apoderado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($empresas as $e): ?>
                <tr>
                    <td><?= esc($e['nombre']) ?></td>
                    <td><?= esc($e['ciudad']) ?></td>
                    <td><?= esc($e['estado']) ?></td>
                    <td><?= esc($e['rfc']) ?></td>
                    <td><?= esc($e['apoderado']) ?></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEdit<?= (int) $e['id'] ?>">Editar</button>
                    </td>
                </tr>
                <div class="modal fade" id="modalEdit<?= (int) $e['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <?= form_open('empresas/' . $e['id']) ?>
                            <div class="modal-header"><h5 class="modal-title">Editar empresa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body">
                                <div class="mb-2"><label class="form-label">Nombre</label><input class="form-control" name="nombre" value="<?= esc($e['nombre']) ?>" required></div>
                                <div class="mb-2"><label class="form-label">Calle</label><input class="form-control" name="calle" value="<?= esc($e['calle']) ?>"></div>
                                <div class="row g-2 mb-2">
                                    <div class="col-6"><label class="form-label">No. Ext</label><input class="form-control" name="numero_ext" value="<?= esc($e['numero_ext']) ?>"></div>
                                    <div class="col-6"><label class="form-label">No. Int</label><input class="form-control" name="numero_int" value="<?= esc($e['numero_int']) ?>"></div>
                                </div>
                                <div class="mb-2"><label class="form-label">Colonia</label><input class="form-control" name="colonia" value="<?= esc($e['colonia']) ?>"></div>
                                <div class="row g-2 mb-2">
                                    <div class="col-6"><label class="form-label">Ciudad</label><input class="form-control" name="ciudad" value="<?= esc($e['ciudad']) ?>"></div>
                                    <div class="col-6"><label class="form-label">Estado</label><input class="form-control" name="estado" value="<?= esc($e['estado']) ?>"></div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-4"><label class="form-label">CP</label><input class="form-control" name="cp" value="<?= esc($e['cp']) ?>"></div>
                                    <div class="col-8"><label class="form-label">RFC</label><input class="form-control" name="rfc" value="<?= esc($e['rfc']) ?>"></div>
                                </div>
                                <div class="mb-2"><label class="form-label">Apoderado</label><input class="form-control" name="apoderado" value="<?= esc($e['apoderado']) ?>"></div>
                            </div>
                            <div class="modal-footer"><button class="btn btn-brand">Guardar</button></div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalNueva" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('empresas') ?>
            <div class="modal-header"><h5 class="modal-title">Nueva empresa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label">Nombre</label><input class="form-control" name="nombre" required></div>
                <div class="mb-2"><label class="form-label">Ciudad</label><input class="form-control" name="ciudad"></div>
                <div class="mb-2"><label class="form-label">Estado</label><input class="form-control" name="estado"></div>
                <div class="mb-2"><label class="form-label">RFC</label><input class="form-control" name="rfc"></div>
                <div class="mb-2"><label class="form-label">Apoderado</label><input class="form-control" name="apoderado"></div>
            </div>
            <div class="modal-footer"><button class="btn btn-brand">Crear</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>
