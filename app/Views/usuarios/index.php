<div class="card-soft mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Usuarios</h2>
        <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevo">Nuevo usuario</button>
    </div>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Departamento</th>
                    <th>Puesto</th>
                    <th>Correo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= esc($u['nombre']) ?></td>
                    <td><?= esc($u['usuario']) ?></td>
                    <td><span class="badge-soft"><?= esc($u['tipo']) ?></span></td>
                    <td><?= esc($u['departamento']) ?></td>
                    <td><?= esc($u['puesto']) ?></td>
                    <td><?= esc($u['correo']) ?></td>
                    <td class="text-end">
                        <button class="btn btn-sm btn-outline-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit<?= (int) $u['id'] ?>">Editar</button>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit<?= (int) $u['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <?= form_open('usuarios/' . $u['id']) ?>
                            <div class="modal-header"><h5 class="modal-title">Editar usuario</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                            <div class="modal-body">
                                <div class="mb-2"><label class="form-label">Nombre</label><input class="form-control" name="nombre" value="<?= esc($u['nombre']) ?>" required></div>
                                <div class="mb-2"><label class="form-label">Usuario</label><input class="form-control" name="usuario" value="<?= esc($u['usuario']) ?>" required></div>
                                <div class="mb-2"><label class="form-label">Nueva contraseña</label><input type="password" class="form-control" name="password" placeholder="Dejar vacío para no cambiar"></div>
                                <div class="row g-2">
                                    <div class="col-6"><label class="form-label">Tipo</label>
                                        <select class="form-select" name="tipo">
                                            <option value="admin" <?= $u['tipo'] === 'admin' ? 'selected' : '' ?>>admin</option>
                                            <option value="empr" <?= $u['tipo'] === 'empr' ? 'selected' : '' ?>>empr</option>
                                        </select>
                                    </div>
                                    <div class="col-6"><label class="form-label">Juntas</label>
                                        <select class="form-select" name="juntas">
                                            <option value="SI" <?= $u['juntas'] === 'SI' ? 'selected' : '' ?>>SI</option>
                                            <option value="NO" <?= $u['juntas'] === 'NO' ? 'selected' : '' ?>>NO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-2 mt-2"><label class="form-label">Departamento</label><input class="form-control" name="departamento" value="<?= esc($u['departamento']) ?>"></div>
                                <div class="mb-2"><label class="form-label">Puesto</label><input class="form-control" name="puesto" value="<?= esc($u['puesto']) ?>"></div>
                                <div class="mb-2"><label class="form-label">Nivel</label><input class="form-control" name="nivel" value="<?= esc($u['nivel']) ?>"></div>
                                <div class="mb-2"><label class="form-label">Reportes</label>
                                    <select class="form-select" name="reportes">
                                        <option value="SI" <?= $u['reportes'] === 'SI' ? 'selected' : '' ?>>SI</option>
                                        <option value="NO" <?= $u['reportes'] === 'NO' ? 'selected' : '' ?>>NO</option>
                                    </select>
                                </div>
                                <div class="mb-2"><label class="form-label">Correo</label><input class="form-control" name="correo" value="<?= esc($u['correo']) ?>"></div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-brand">Guardar</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalNuevo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('usuarios') ?>
            <div class="modal-header"><h5 class="modal-title">Nuevo usuario</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label">Nombre</label><input class="form-control" name="nombre" required></div>
                <div class="mb-2"><label class="form-label">Usuario</label><input class="form-control" name="usuario" required></div>
                <div class="mb-2"><label class="form-label">Contraseña</label><input type="password" class="form-control" name="password" required></div>
                <div class="row g-2">
                    <div class="col-6"><label class="form-label">Tipo</label>
                        <select class="form-select" name="tipo"><option value="empr">empr</option><option value="admin">admin</option></select>
                    </div>
                    <div class="col-6"><label class="form-label">Juntas</label>
                        <select class="form-select" name="juntas"><option value="NO">NO</option><option value="SI">SI</option></select>
                    </div>
                </div>
                <div class="mb-2 mt-2"><label class="form-label">Departamento</label><input class="form-control" name="departamento"></div>
                <div class="mb-2"><label class="form-label">Puesto</label><input class="form-control" name="puesto"></div>
                <div class="mb-2"><label class="form-label">Correo</label><input class="form-control" name="correo"></div>
            </div>
            <div class="modal-footer"><button class="btn btn-brand">Crear</button></div>
            <?= form_close() ?>
        </div>
    </div>
</div>
