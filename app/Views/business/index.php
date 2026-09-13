<div class="card-soft">
    <h2 class="h5 mb-3">Business Case</h2>
    <div class="table-wrap">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Análisis</th>
                    <th>Ventaja</th>
                    <th>Solicitó</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($business as $b): ?>
                <tr>
                    <td><?= (int) $b['id_business'] ?></td>
                    <td><?= esc($b['fecha']) ?></td>
                    <td><?= esc(character_limiter(strip_tags($b['analisis'] ?? ''), 80)) ?></td>
                    <td><?= esc(character_limiter(strip_tags($b['ventaja'] ?? ''), 80)) ?></td>
                    <td><?= esc($b['nombre'] ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
