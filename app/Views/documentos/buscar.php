<div class="card-soft mb-3">
    <h2 class="h5 mb-3">Búsqueda de folio / documento</h2>
    <form method="get" action="<?= site_url('buscar-folio') ?>" class="row g-2">
        <div class="col-md-8">
            <input class="form-control form-control-lg" type="search" name="q" value="<?= esc($term ?? '') ?>" placeholder="Folio o nombre del documento" autofocus>
        </div>
        <div class="col-md-4">
            <button class="btn btn-brand btn-lg w-100">Buscar</button>
        </div>
    </form>
</div>

<?php if (($term ?? '') !== ''): ?>
<div class="card-soft">
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Folio</th>
                    <th>Nombre</th>
                    <th>Departamento</th>
                    <th>Tipo</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($documentos)): ?>
                <tr><td colspan="6" class="text-muted">Sin resultados.</td></tr>
            <?php else: ?>
                <?php foreach ($documentos as $d): ?>
                    <tr>
                        <td><?= (int) $d['id'] ?></td>
                        <td><?= esc($d['folio']) ?></td>
                        <td><?= esc($d['nombre']) ?></td>
                        <td><?= esc($d['departamento']) ?></td>
                        <td><?= esc($d['tipo']) ?></td>
                        <td><?= esc($d['estatus']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
