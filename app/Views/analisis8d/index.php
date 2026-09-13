<div class="card-soft">
    <h2 class="h5 mb-3">Análisis 8D</h2>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Tipo</th>
                    <th>Problema</th>
                    <th>Solicitante</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($analisis as $a): ?>
                <tr>
                    <td><?= esc($a['folio']) ?></td>
                    <td><?= esc($a['fecha']) ?></td>
                    <td><?= esc($a['tipo']) ?></td>
                    <td><?= esc($a['problema_detectado']) ?></td>
                    <td><?= esc($a['nombre'] ?? '') ?></td>
                    <td><span class="badge-soft"><?= esc($a['estatus'] ?? '') ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
