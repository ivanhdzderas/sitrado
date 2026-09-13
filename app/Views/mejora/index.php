<div class="card-soft">
    <h2 class="h5 mb-3">Mejora continua</h2>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Solicitante</th>
                    <th>Atendido</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($mejoras as $m): ?>
                <tr>
                    <td><?= (int) $m['id_mejora'] ?></td>
                    <td><?= esc($m['fecha']) ?></td>
                    <td><?= esc(character_limiter(strip_tags($m['descripcion'] ?? ''), 100)) ?></td>
                    <td><?= esc($m['nombre'] ?? '') ?></td>
                    <td><?= esc($m['atendido']) ?></td>
                    <td><?= esc($m['activo']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
