<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= esc(app_brand_name()) ?> · <?= esc(app_brand_tagline()) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Literata:opsz,wght@7..72,600;7..72,700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="<?= base_url('assets/css/archiva.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/alertify.core.css') ?>" rel="stylesheet">
<link href="<?= base_url('css/alertify.default.css') ?>" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"
        onerror="this.onerror=null;this.src='<?= base_url('assets/js/jquery.datatables.js') ?>'"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="<?= base_url('js/alertify.js') ?>"></script>
<?php
$logged = session()->get('logged_in');
if (empty($logged['iduser'] ?? null)) {
    header('Location: ' . site_url('login'));
    exit;
}
$tipo = $logged['tipo'] ?? '';
$nombre = $logged['nombre'] ?? '';
$initial = mb_strtoupper(mb_substr($nombre !== '' ? $nombre : 'U', 0, 1));
$uri = trim(service('uri')->getPath(), '/');
$is = static function (string $needle) use ($uri): string {
    return str_starts_with($uri, $needle) ? 'active' : '';
};
?>
</head>
<body class="archiva-body">
<div class="archiva-backdrop" id="sidebarBackdrop"></div>
<div class="archiva-shell">
<aside class="archiva-sidebar" id="sidebar">
    <div class="archiva-brand-block">
        <?php if ($logoUrl = app_logo_url()): ?>
            <img src="<?= esc($logoUrl) ?>" alt="<?= esc(app_brand_name()) ?>" class="archiva-logo">
        <?php else: ?>
            <div class="archiva-mark">S</div>
        <?php endif; ?>
        <div>
            <strong><?= esc(app_brand_name()) ?></strong>
            <small><?= esc(app_brand_tagline()) ?></small>
        </div>
    </div>

    <div class="archiva-user">
        <div class="archiva-avatar"><?= esc($initial) ?></div>
        <div class="min-w-0">
            <div class="text-white small text-truncate"><?= esc($nombre) ?></div>
            <div class="small opacity-75 text-truncate"><?= esc($logged['puesto'] ?? $tipo) ?></div>
        </div>
    </div>

    <nav class="nav flex-column archiva-nav">
        <div class="archiva-nav-label">Principal</div>
        <a class="nav-link <?= $uri === 'inicio' || $uri === 'login/inicio' ? 'active' : '' ?>" href="<?= site_url('inicio') ?>">Inicio</a>
        <a class="nav-link <?= $is('buscar') || $is('login/bus_folio') ? 'active' : '' ?>" href="<?= site_url('login/bus_folio') ?>">Buscar folio</a>
        <a class="nav-link <?= $is('agenda') ? 'active' : '' ?>" href="<?= site_url('agenda') ?>">Agenda</a>

        <?php if ($tipo === 'admin'): ?>
            <div class="archiva-nav-label">Administración</div>
            <a class="nav-link <?= $is('avisos') ? 'active' : '' ?>" href="<?= site_url('avisos') ?>">Avisos</a>
            <a class="nav-link <?= $is('salas') || $is('login/salas') ? 'active' : '' ?>" href="<?= site_url('login/salas') ?>">Salas</a>
            <a class="nav-link <?= $is('empresas') ? 'active' : '' ?>" href="<?= site_url('empresas') ?>">Empresas</a>
            <a class="nav-link <?= $is('usuarios') ? 'active' : '' ?>" href="<?= site_url('usuarios') ?>">Usuarios</a>
            <a class="nav-link <?= $is('menus') ? 'active' : '' ?>" href="<?= site_url('menus') ?>">Menús</a>
            <a class="nav-link <?= $is('login/configurar_aprobadores') || $is('configurar_aprobadores') ? 'active' : '' ?>" href="<?= site_url('login/configurar_aprobadores') ?>">Aprobadores</a>
        <?php endif; ?>

        <div class="archiva-nav-label">Operación</div>
        <a class="nav-link <?= $is('documentos') ? 'active' : '' ?>" href="<?= site_url('documentos') ?>">Documentos</a>
        <a class="nav-link <?= $is('solicitud') ? 'active' : '' ?>" href="<?= site_url('solicitudes') ?>">Solicitudes</a>
        <a class="nav-link <?= $is('juntas') ? 'active' : '' ?>" href="<?= site_url('juntas') ?>">Minutas</a>
        <a class="nav-link <?= $is('proyectos') ? 'active' : '' ?>" href="<?= site_url('proyectos') ?>">Proyectos</a>
        <a class="nav-link <?= $is('8d') || $is('login/analisis') ? 'active' : '' ?>" href="<?= site_url('8d') ?>">Análisis 8D</a>
        <a class="nav-link <?= $is('business') ? 'active' : '' ?>" href="<?= site_url('business') ?>">Business Case</a>
        <a class="nav-link <?= $is('mejora') ? 'active' : '' ?>" href="<?= site_url('mejora') ?>">Mejora</a>
        <?php if (($logged['reportes'] ?? '') === 'SI' || $tipo === 'admin'): ?>
            <a class="nav-link <?= $is('reporte') ? 'active' : '' ?>" href="<?= site_url('reporte_minutas') ?>">Reportes</a>
        <?php endif; ?>

        <div class="archiva-nav-label">Cuenta</div>
        <a class="nav-link" href="<?= site_url('editar_perfil') ?>">Mi perfil</a>
        <a class="nav-link" href="<?= site_url('logout') ?>">Cerrar sesión</a>
    </nav>
</aside>

<div class="archiva-main">
    <header class="archiva-topbar">
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm archiva-menu-toggle" id="menuToggle" aria-label="Menú">Menú</button>
            <h1><?= esc(app_brand_name()) ?></h1>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div id="alertas_usuarios" class="archiva-notify-slot"></div>
            <div class="d-none d-md-block text-secondary small"><?= esc($logged['departamento'] ?? '') ?></div>
        </div>
    </header>
    <div class="archiva-content">
<script>
(function () {
  var sidebar = document.getElementById('sidebar');
  var backdrop = document.getElementById('sidebarBackdrop');
  var toggle = document.getElementById('menuToggle');
  function close() {
    sidebar.classList.remove('is-open');
    backdrop.classList.remove('is-visible');
  }
  toggle && toggle.addEventListener('click', function () {
    sidebar.classList.toggle('is-open');
    backdrop.classList.toggle('is-visible');
  });
  backdrop && backdrop.addEventListener('click', close);
})();
window.ArchivaAlertsConfig = {
  badgeUrl: <?= json_encode(site_url('alertas')) ?>,
  panelUrl: <?= json_encode(site_url('login/alertas2')) ?>,
  leerBase: <?= json_encode(site_url('leer') . '/') ?>,
  proyectos2Url: <?= json_encode(site_url('proyectos2')) ?>,
  detallaProyectoUrl: <?= json_encode(site_url('login/detalla_proyecto')) ?>,
  yaPedimentoUrl: <?= json_encode(site_url('login/ya_pedimento')) ?>,
  pendientesJuntasUrl: <?= json_encode(site_url('login/pendientes_juntas')) ?>,
  detProyectoUrl: <?= json_encode(site_url('login/det_proyecto')) ?>,
  archivo8dUrl: <?= json_encode(site_url('login/archivo_8d')) ?>,
  documentosAutorizarUrl: <?= json_encode(site_url('login/documentos_autorizar')) ?>,
  revisarDocUrl: <?= json_encode(site_url('login/revisar_doc')) ?>,
  revisaUrl: <?= json_encode(site_url('login/revisa')) ?>,
  solicitudesUrl: <?= json_encode(site_url('solicitudes')) ?>,
  solucionReagendarUrl: <?= json_encode(site_url('login/solucion_reagendar')) ?>,
  atenderReagendarUrl: <?= json_encode(site_url('login/atender_reagendar')) ?>,
  vistoUrl: <?= json_encode(site_url('login/visto')) ?>,
  visto2Url: <?= json_encode(site_url('login/visto2')) ?>,
  terminarAgendaUrl: <?= json_encode(site_url('login/terminar_agenda')) ?>,
  verNotaReagendarUrl: <?= json_encode(site_url('login/ver_nota_reagendar')) ?>,
  pollMs: 15000
};
</script>
<script src="<?= base_url('assets/js/archiva-alerts.js') ?>"></script>
