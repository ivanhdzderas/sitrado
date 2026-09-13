<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Sistema Documental') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>
<body class="app-body">
<?php
$uri = service('uri')->getPath();
$isAdmin = ($user['tipo'] ?? '') === 'admin';
$initial = mb_strtoupper(mb_substr($user['nombre'] ?? 'U', 0, 1));
$navActive = static function (string $path) use ($uri): string {
    return str_starts_with(ltrim($uri, '/'), ltrim($path, '/')) ? 'active' : '';
};
?>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="app-shell">
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <?php if ($logoUrl = app_logo_url()): ?>
                <img src="<?= esc($logoUrl) ?>" alt="<?= esc(app_brand_name()) ?>" class="brand-logo">
            <?php else: ?>
                <div class="brand-mark">S</div>
            <?php endif; ?>
            <div>
                <div class="brand-title"><?= esc(app_brand_name()) ?></div>
                <div class="brand-sub"><?= esc(app_brand_tagline()) ?></div>
            </div>
        </div>

        <div class="user-chip">
            <div class="avatar"><?= esc($initial) ?></div>
            <div class="min-w-0">
                <div class="text-white small text-truncate"><?= esc($user['nombre'] ?? '') ?></div>
                <div class="small opacity-75 text-truncate"><?= esc($user['puesto'] ?? $user['tipo'] ?? '') ?></div>
            </div>
        </div>

        <nav class="side-nav">
            <div class="nav-section">Principal</div>
            <a class="<?= $navActive('inicio') ?>" href="<?= site_url('inicio') ?>"><i class="bi bi-house-door"></i> Inicio</a>
            <a class="<?= $navActive('buscar-folio') ?>" href="<?= site_url('buscar-folio') ?>"><i class="bi bi-search"></i> Buscar folio</a>
            <a class="<?= $navActive('agenda') ?>" href="<?= site_url('agenda') ?>"><i class="bi bi-calendar3"></i> Agenda</a>

            <?php if ($isAdmin): ?>
                <div class="nav-section">Administración</div>
                <a class="<?= $navActive('avisos') ?>" href="<?= site_url('avisos') ?>"><i class="bi bi-megaphone"></i> Avisos</a>
                <a class="<?= $navActive('empresas') ?>" href="<?= site_url('empresas') ?>"><i class="bi bi-building"></i> Empresas</a>
                <a class="<?= $navActive('usuarios') ?>" href="<?= site_url('usuarios') ?>"><i class="bi bi-people"></i> Usuarios</a>
            <?php endif; ?>

            <div class="nav-section">Operación</div>
            <a class="<?= $navActive('documentos') ?>" href="<?= site_url('documentos') ?>"><i class="bi bi-folder2-open"></i> Documentos</a>
            <a class="<?= $navActive('solicitudes') ?>" href="<?= site_url('solicitudes') ?>"><i class="bi bi-file-earmark-plus"></i> Solicitudes</a>
            <a class="<?= $navActive('juntas') ?>" href="<?= site_url('juntas') ?>"><i class="bi bi-journal-text"></i> Minutas</a>
            <a class="<?= $navActive('proyectos') ?>" href="<?= site_url('proyectos') ?>"><i class="bi bi-kanban"></i> Proyectos</a>
            <a class="<?= $navActive('8d') ?>" href="<?= site_url('8d') ?>"><i class="bi bi-diagram-3"></i> Análisis 8D</a>
            <a class="<?= $navActive('business') ?>" href="<?= site_url('business') ?>"><i class="bi bi-briefcase"></i> Business Case</a>
            <a class="<?= $navActive('mejora') ?>" href="<?= site_url('mejora') ?>"><i class="bi bi-lightning"></i> Mejora</a>

            <div class="nav-section">Cuenta</div>
            <a class="<?= $navActive('perfil') ?>" href="<?= site_url('perfil') ?>"><i class="bi bi-person"></i> Mi perfil</a>
            <a href="<?= site_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
        </nav>
    </aside>

    <div class="main">
        <header class="topbar">
            <div class="d-flex align-items-center gap-2">
                <button class="menu-toggle" id="menuToggle" type="button" aria-label="Menú">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title"><?= esc($title ?? '') ?></h1>
            </div>
            <div class="d-none d-md-block text-muted small">
                <?= esc($user['departamento'] ?? '') ?>
            </div>
        </header>

        <main class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <?= $content ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(() => {
  const sidebar = document.getElementById('sidebar');
  const backdrop = document.getElementById('sidebarBackdrop');
  const toggle = document.getElementById('menuToggle');
  const close = () => { sidebar.classList.remove('open'); backdrop.classList.remove('show'); };
  toggle?.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    backdrop.classList.toggle('show');
  });
  backdrop?.addEventListener('click', close);
})();
</script>
</body>
</html>
