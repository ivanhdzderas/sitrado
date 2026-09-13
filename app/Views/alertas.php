<?php
/**
 * Campana de notificaciones (AJAX → #alertas_usuarios).
 * Solo markup del botón; la lógica vive en archiva-alerts.js
 */

$rows = static function ($q): int {
    if ($q === null || $q === false || $q === '') {
        return 0;
    }
    if (is_array($q)) {
        return count($q);
    }
    if (is_object($q) && method_exists($q, 'getNumRows')) {
        return (int) $q->getNumRows();
    }

    return 0;
};

$gradeProyectos = session()->get('grade')['proyectos'] ?? null;
$iduser = session()->get('logged_in')['iduser'] ?? null;
$esEncargadoProyectos = ($iduser !== null && $gradeProyectos !== null && (string) $iduser === (string) $gradeProyectos);
$plaza = session()->get('logged_in')['plaza'] ?? null;

$cuantos = $rows($pendientes1 ?? null);
$cuantos2 = $rows($pendientes2 ?? null);
$cuantos3 = $rows($pendientes3 ?? null);
$cuantos4 = is_array($pendientes4 ?? null) ? count($pendientes4) : $rows($pendientes4 ?? null);
$cuantos5 = 0;
$cuantos6 = 0;
$cuantos8 = 0;
$cuantos9 = 0;
$cuantos10 = $rows($pendientes10 ?? null);
$cuantos11 = 0;
$cuantos12 = $rows($pendientes12 ?? null);
$cuantos13 = 0;
$cuantos14 = $rows($pendientes14 ?? null);
$cuantos15 = $rows($pendientes15 ?? null);
$cuantos16 = $rows($pendientes16 ?? null);
$cuantos17 = $rows($pendientes17 ?? null);
$cuantos18 = $rows($pendientes18 ?? null);

$cuantos7 = 0;
if (! empty($pendientes7) && is_object($pendientes7)) {
    foreach ($pendientes7->getResult() as $key) {
        $rev = login_model()->revisar_doc($key->id);
        if (! empty($rev) && isset($rev[0]->total) && (int) $rev[0]->total === 0) {
            $cuantos7++;
        }
    }
}

if ($esEncargadoProyectos) {
    $cuantos5 = $rows($pendientes5 ?? null);
    $cuantos6 = $rows($pendientes6 ?? null);
    $cuantos9 = $rows($pendientes9 ?? null);
    $cuantos13 = $rows($pendientes13 ?? null);
}

if ((string) $plaza === '1') {
    $cuantos8 = $rows($pendientes8 ?? null);
    $cuantos11 = $rows($pendientes11 ?? null);
}

$cuantos_total = $cuantos + $cuantos2 + $cuantos3 + $cuantos4 + $cuantos5 + $cuantos6
    + $cuantos7 + $cuantos8 + $cuantos9 + $cuantos10 + $cuantos11 + $cuantos12
    + $cuantos13 + $cuantos14 + $cuantos15 + $cuantos16 + $cuantos17 + $cuantos18;
?>

<?php if ($cuantos_total > 0): ?>
<button type="button" class="btn archiva-notify has-items">
    <span class="notify-label">Avisos</span>
    <span class="notify-badge"><?= (int) $cuantos_total ?></span>
</button>
<?php else: ?>
<button type="button" class="btn archiva-notify" disabled title="Sin pendientes">
    <span class="notify-label">Avisos</span>
    <span class="notify-badge muted">0</span>
</button>
<?php endif; ?>
