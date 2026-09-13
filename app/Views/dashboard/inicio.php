<div class="stat-grid mb-4">
    <div class="stat-card">
        <div class="label">Usuarios</div>
        <div class="value"><?= (int) ($stats['usuarios'] ?? 0) ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Documentos</div>
        <div class="value"><?= (int) ($stats['documentos'] ?? 0) ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Proyectos</div>
        <div class="value"><?= (int) ($stats['proyectos'] ?? 0) ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Minutas activas</div>
        <div class="value"><?= (int) ($stats['juntas'] ?? 0) ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Análisis 8D</div>
        <div class="value"><?= (int) ($stats['analisis'] ?? 0) ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Avisos nuevos</div>
        <div class="value"><?= (int) ($stats['avisos'] ?? 0) ?></div>
    </div>
</div>

<div class="card-soft">
    <h2 class="h5 mb-2">Hola, <?= esc($user['nombre'] ?? '') ?></h2>
    <p class="text-muted mb-3">
        Panel principal del Sistema Documental migrado a CodeIgniter 4.
        Usa el menú para navegar por documentos, minutas, proyectos y más.
    </p>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-brand" href="<?= site_url('documentos') ?>">Ver documentos</a>
        <a class="btn btn-outline-secondary" href="<?= site_url('juntas') ?>">Minutas</a>
        <a class="btn btn-outline-secondary" href="<?= site_url('proyectos') ?>">Proyectos</a>
        <a class="btn btn-accent" href="<?= site_url('buscar-folio') ?>">Buscar folio</a>
    </div>
</div>
