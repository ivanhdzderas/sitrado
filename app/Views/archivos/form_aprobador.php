<?php
$tiposDoc = [
    'POL' => 'Políticas',
    'D'   => 'Directriz',
    'P'   => 'Procedimientos',
    'I'   => 'Instructivo',
    'F'   => 'Formatos',
    'M'   => 'Misión',
    'V'   => 'Visión',
    'O'   => 'Objetivos',
    'VAL' => 'Valores',
    'AY'  => 'Ayuda Visual',
    'MP'  => 'Mapa de Proceso',
    'T'   => 'Tutoriales',
    'OR'  => 'Organigramas',
    'IP'  => 'Interrelación de Procesos',
];

$id           = $item->id_departamento ?? '';
$departamento = $item->departamento ?? '';
$usuarioId    = $item->usuario ?? '';
$siglas       = $item->siglas ?? '';
$deptoLibre = false;
if ($departamento !== '') {
    foreach ($departamentos as $d) {
        if ((string) $d->departamento === (string) $departamento) {
            $deptoLibre = false;
            break;
        }
        $deptoLibre = true;
    }
    if (empty($departamentos)) {
        $deptoLibre = true;
    }
}
?>

<form id="formAprobador" autocomplete="off">
    <input type="hidden" name="id_departamento" value="<?= esc($id) ?>">

    <div class="mb-3">
        <label class="form-label" for="departamento">Departamento</label>
        <select class="form-select" id="departamento" name="departamento" required>
            <option value="">Seleccione…</option>
            <?php foreach ($departamentos as $d): ?>
                <option value="<?= esc($d->departamento) ?>" <?= $departamento === $d->departamento ? 'selected' : '' ?>>
                    <?= esc($d->departamento) ?>
                </option>
            <?php endforeach; ?>
            <?php if ($deptoLibre): ?>
                <option value="<?= esc($departamento) ?>" selected><?= esc($departamento) ?></option>
            <?php endif; ?>
        </select>
        <div class="form-text">O escribe uno nuevo abajo si no está en la lista.</div>
        <input type="text"
               class="form-control mt-2"
               id="departamento_nuevo"
               placeholder="Nuevo departamento (opcional)"
               oninput="if (this.value.trim()) { $('#departamento').val(''); }">
    </div>

    <div class="mb-3">
        <label class="form-label" for="siglas">Tipo de documento</label>
        <select class="form-select" id="siglas" name="siglas" required>
            <option value="">Seleccione…</option>
            <?php foreach ($tiposDoc as $code => $label): ?>
                <option value="<?= esc($code) ?>" <?= $siglas === $code ? 'selected' : '' ?>>
                    <?= esc($label) ?> (<?= esc($code) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-0">
        <label class="form-label" for="usuario">Usuario aprobador</label>
        <select class="form-select" id="usuario" name="usuario" required>
            <option value="">Seleccione…</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= (int) $u->id ?>" <?= (string) $usuarioId === (string) $u->id ? 'selected' : '' ?>>
                    <?= esc($u->nombre) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</form>

<script>
(function () {
    var $nuevo = $('#departamento_nuevo');
    var $sel = $('#departamento');
    $('#formAprobador').off('submit.aprob').on('submit.aprob', function (e) {
        e.preventDefault();
    });
    // Si hay texto en "nuevo", úsalo como departamento al serializar
    $nuevo.off('change.aprob blur.aprob').on('change.aprob blur.aprob', function () {
        var v = $.trim(this.value);
        if (!v) return;
        if ($sel.find('option[value="' + v.replace(/"/g, '\\"') + '"]').length === 0) {
            $sel.append($('<option>', { value: v, text: v }));
        }
        $sel.val(v);
    });
})();
</script>
