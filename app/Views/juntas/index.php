<div class="card-soft mb-3">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Minutas de reunión</h2>
        <button class="btn btn-brand btn-sm" data-bs-toggle="modal" data-bs-target="#modalNueva">Nueva minuta</button>
    </div>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tema</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Duración</th>
                    <th>Impartidor</th>
                    <th>Asignada</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($juntas as $j): ?>
                <tr>
                    <td><?= (int) $j['id_junta'] ?></td>
                    <td><?= esc($j['tema']) ?></td>
                    <td><?= esc($j['fecha']) ?></td>
                    <td><?= esc($j['lugar']) ?></td>
                    <td><?= esc($j['duracion']) ?> h</td>
                    <td><?= esc($j['impartidor_nombre'] ?? $j['impartidor']) ?></td>
                    <td><span class="badge-soft"><?= esc($j['asignada']) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalNueva" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= form_open('juntas') ?>
            <div class="modal-header"><h5 class="modal-title">Nueva minuta</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-2"><label class="form-label">Tema</label><input class="form-control" name="tema" required></div>
                <div class="mb-2"><label class="form-label">Fecha y hora</label><input type="datetime-local" class="form-control" name="fecha" required></div>
                <div class="mb-2"><label class="form-label">Lugar</label><input class="form-control" name="lugar"></div>
                <div class="mb-2"><label class="form-label">Duración (horas)</label><input type="number" class="form-control" name="duracion" value="1" min="1"></div>
                <div class="mb-2"><label class="form-label">Impartidor</label>
                    <select class="form-select" name="impartidor" required>
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
