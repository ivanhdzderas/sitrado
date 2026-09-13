<div class="card-soft">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Documentos</h2>
        <a class="btn btn-outline-secondary btn-sm" href="<?= site_url('buscar-folio') ?>">Buscar folio</a>
    </div>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Menú</th>
                    <th>Submenú</th>
                    <th>Estatus</th>
                    <th>Rev</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($documentos as $d): ?>
                <tr>
                    <td><?= (int) $d['id'] ?></td>
                    <td><?= esc($d['nombre']) ?></td>
                    <td><?= esc($d['empresa'] ?? '') ?></td>
                    <td><?= esc($d['menu'] ?? '') ?></td>
                    <td><?= esc($d['submenu'] ?? '') ?></td>
                    <td><span class="badge-soft"><?= esc($d['estatus'] ?? '') ?></span></td>
                    <td><?= esc($d['rev'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
