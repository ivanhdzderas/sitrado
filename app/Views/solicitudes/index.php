<div class="card-soft">
    <h2 class="h5 mb-3">Solicitudes de documentos</h2>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Folio</th>
                    <th>Tipo</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Solicitante</th>
                    <th>Departamento</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($solicitudes)): ?>
                <tr><td colspan="7" class="text-muted">Sin solicitudes.</td></tr>
            <?php else: ?>
                <?php foreach ($solicitudes as $s): ?>
                    <tr>
                        <td><?= (int) $s['id_solicitud'] ?></td>
                        <td><?= esc($s['folio']) ?></td>
                        <td><?= esc($s['tipo']) ?></td>
                        <td><?= esc($s['codigo']) ?></td>
                        <td><?= esc($s['nombre']) ?></td>
                        <td><?= esc($s['solicitante']) ?></td>
                        <td><?= esc($s['departamento']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
