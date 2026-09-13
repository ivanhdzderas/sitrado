<?php
$tiles = [
    ['code' => 'POL', 'label' => 'Políticas', 'hint' => 'Marco normativo', 'tone' => 'navy', 'fn' => "documentos('POL')"],
    ['code' => 'D', 'label' => 'Directrices', 'hint' => 'Lineamientos', 'tone' => 'teal', 'fn' => "documentos('D')"],
    ['code' => 'P', 'label' => 'Procedimientos', 'hint' => 'Pasos operativos', 'tone' => 'amber', 'fn' => "documentos('P')"],
    ['code' => 'I', 'label' => 'Instructivos', 'hint' => 'Guías de trabajo', 'tone' => 'slate', 'fn' => "documentos('I')"],
    ['code' => 'MP', 'label' => 'Mapa de procesos', 'hint' => 'Visión de flujo', 'tone' => 'indigo', 'fn' => "documentos('MP')"],
    ['code' => 'F', 'label' => 'Formatos', 'hint' => 'Plantillas y formas', 'tone' => 'forest', 'fn' => "documentos('F')"],
    ['code' => 'T', 'label' => 'Videos y tutoriales', 'hint' => 'Capacitación', 'tone' => 'wine', 'fn' => "documentos('T')"],
    ['code' => 'OR', 'label' => 'Organigramas', 'hint' => 'Estructura', 'tone' => 'copper', 'fn' => "documentos('OR')"],
    ['code' => 'IP', 'label' => 'Interrelación', 'hint' => 'Procesos vinculados', 'tone' => 'navy', 'fn' => "documentos('IP')"],
    ['code' => 'EV', 'label' => 'Eventos', 'hint' => 'Calendario', 'tone' => 'teal', 'fn' => 'eventos()'],
];
$nombre = session()->get('logged_in')['nombre'] ?? '';
$first = $nombre !== '' ? explode(' ', $nombre)[0] : '';
?>

<section class="archiva-home-intro">
    <h2>Bienvenido<?= $first !== '' ? ', ' . esc($first) : '' ?></h2>
    <p>Elige el tipo de documento o recurso. El acceso depende de tus permisos.</p>
</section>

<div class="row g-3">
    <?php foreach ($tiles as $tile): ?>
        <div class="col-6 col-md-4 col-xl-3">
            <button type="button"
                    class="btn archiva-tile w-100"
                    data-tone="<?= esc($tile['tone']) ?>"
                    onclick="<?= $tile['fn'] ?>">
                <span class="code"><?= esc($tile['code']) ?></span>
                <span class="label"><?= esc($tile['label']) ?></span>
                <span class="hint"><?= esc($tile['hint']) ?></span>
            </button>
        </div>
    <?php endforeach; ?>
</div>

<input type="hidden" id="tipo" name="tipo" value="">

<script>
function documentos(tipo) {
    window.location.href = "<?= site_url('login/documento') ?>/" + tipo;
}
function eventos() {
    window.location.href = "<?= site_url('login/eventos') ?>";
}
</script>
