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
?>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h2 class="panel-title mb-1">Configurar aprobadores</h2>
            <p class="text-secondary mb-0 small">
                Catálogo de quién autoriza cada tipo de documento por departamento
                (tabla <code>responsables</code>).
            </p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= site_url('login/documentos_autorizar') ?>" class="btn btn-outline-secondary">
                Volver a autorización
            </a>
            <button type="button" class="btn btn-archiva" onclick="nuevoAprobador()">
                Nuevo aprobador
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="tablaAprobadores" class="table table-hover align-middle" width="100%">
            <thead>
                <tr>
                    <th>Departamento</th>
                    <th>Tipo de documento</th>
                    <th>Aprobador</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($aprobadores)): ?>
                    <tr>
                        <td colspan="4" class="text-secondary">No hay aprobadores configurados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($aprobadores as $row): ?>
                        <tr>
                            <td class="fw-semibold"><?= esc($row->departamento) ?></td>
                            <td>
                                <?= esc($tiposDoc[$row->siglas] ?? $row->siglas) ?>
                                <span class="text-secondary small">(<?= esc($row->siglas) ?>)</span>
                            </td>
                            <td><?= esc($row->nombre_usuario ?: ('Usuario #' . $row->usuario)) ?></td>
                            <td class="text-end text-nowrap">
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        onclick="editarAprobador('<?= (int) $row->id_departamento ?>')">
                                    Modificar
                                </button>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="eliminarAprobador('<?= (int) $row->id_departamento ?>')">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalAprobador" tabindex="-1" aria-labelledby="modalAprobadorLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAprobadorLabel">Aprobador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalAprobadorBody">
                <p class="text-secondary mb-0">Cargando…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-archiva" onclick="guardarAprobador()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
function openModalAprobador(title) {
    var el = document.getElementById('modalAprobador');
    if (!el || !window.bootstrap) return;
    if (el.parentElement !== document.body) document.body.appendChild(el);
    $('#modalAprobadorLabel').text(title);
    $('#modalAprobadorBody').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function nuevoAprobador() {
    openModalAprobador('Nuevo aprobador');
    $.post("<?= site_url('login/form_aprobador') ?>", function (html) {
        $('#modalAprobadorBody').html(html);
    });
}

function editarAprobador(id) {
    openModalAprobador('Modificar aprobador');
    $.post("<?= site_url('login/form_aprobador') ?>", { id: id }, function (html) {
        $('#modalAprobadorBody').html(html);
    });
}

function guardarAprobador() {
    var $f = $('#formAprobador');
    if (!$f.length) return;

    var nuevo = $.trim($('#departamento_nuevo').val() || '');
    if (nuevo) {
        var $sel = $('#departamento');
        if ($sel.find('option').filter(function () { return $(this).val() === nuevo; }).length === 0) {
            $sel.append($('<option>', { value: nuevo, text: nuevo }));
        }
        $sel.val(nuevo);
    }

    if (!$f[0].checkValidity()) {
        $f[0].reportValidity();
        return;
    }
    $.post("<?= site_url('login/guardar_aprobador') ?>", $f.serialize(), function (res) {
        if (res && res.ok) {
            Swal.fire({ icon: 'success', title: 'Guardado', timer: 1200, showConfirmButton: false })
                .then(function () { location.reload(); });
        } else {
            Swal.fire({ icon: 'error', title: 'No se pudo guardar', text: 'Revisa departamento, usuario y tipo.' });
        }
    }, 'json').fail(function () {
        Swal.fire({ icon: 'error', title: 'Error de red' });
    });
}

function eliminarAprobador(id) {
    Swal.fire({
        title: '¿Eliminar este aprobador?',
        text: 'Dejará de recibir documentos de ese departamento/tipo para autorizar.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#0b5cab',
        cancelButtonColor: '#94a3b8'
    }).then(function (result) {
        if (!result.isConfirmed) return;
        $.post("<?= site_url('login/eliminar_aprobador') ?>", { id: id }, function (res) {
            if (res && res.ok) {
                Swal.fire({ icon: 'success', title: 'Eliminado', timer: 1000, showConfirmButton: false })
                    .then(function () { location.reload(); });
            } else {
                Swal.fire({ icon: 'error', title: 'No se pudo eliminar' });
            }
        }, 'json');
    });
}

$(function () {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#tablaAprobadores')) {
        $('#tablaAprobadores').DataTable({
            pagingType: 'simple_numbers',
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' },
            columnDefs: [{ targets: [-1], orderable: false }]
        });
    }
});
</script>
