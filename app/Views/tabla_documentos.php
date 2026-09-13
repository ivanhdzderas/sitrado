<style>
.archiva-modal .modal-content {
    border: 0;
    border-radius: 1rem;
    box-shadow: 0 18px 50px rgba(15, 35, 55, 0.22);
    overflow: hidden;
}
.archiva-modal .modal-header {
    background: linear-gradient(135deg, #0b5cab 0%, #1473c7 55%, #1f8a8a 100%);
    color: #fff;
    border-bottom: 0;
    padding: 1rem 1.25rem;
}
.archiva-modal .modal-title {
    font-family: var(--archiva-display, Georgia, serif);
    font-size: 1.15rem;
    font-weight: 700;
}
.archiva-modal .btn-close {
    filter: invert(1) grayscale(1) brightness(2);
}
.archiva-modal .modal-body {
    background: #f7f9fc;
    padding: 1.25rem;
}
.archiva-modal .modal-footer {
    background: #fff;
    border-top: 1px solid #e5ebf2;
}
.archiva-modal .modal-dialog {
    max-width: 720px;
}
</style>

<script>
function showDocumentosModal(title) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Documento');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function carga_nuevo_documento() {
    showDocumentosModal('Nuevo documento');
    $.post("<?= site_url('login/nuevo_documento') ?>", function (data) {
        $("#modal_body").html(data);
    });
}

function carga_menus() {
    var empresa = $("#empresa").val();
    $.post("<?= site_url('login/combo_menus') ?>", { empresa: empresa }, function (data) {
        $("#menu").prop("disabled", false).html(data);
    });
    $.post("<?= site_url('login/permisos_grupales') ?>", { empresa: empresa }, function (data) {
        $("#permisos_grupales").html(data);
    });
}

function carga_submenu() {
    $.post("<?= site_url('login/combo_submenu') ?>", { menu: $("#menu").val() }, function (data) {
        $("#submenu").prop("disabled", false).html(data);
    });
}

function editar_documento(documento, empresa) {
    showDocumentosModal('Modificar documento');
    $.post("<?= site_url('login/modificar_permisos_documento') ?>", {
        empresa: empresa,
        documento: documento
    }, function (data) {
        $("#modal_body").html(data);
    });
}

function documentos_borrados() {
    window.location = "<?= site_url('documentos_borrados') ?>";
}

function eliminar(id) {
    swal({
        title: '¿Estás seguro de querer eliminar este documento?',
        text: "No podrás revertir este cambio",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Borrar',
        buttonsStyling: false
    }).then(function () {
        $.post("<?= site_url('login/elimina_archivo') ?>", { documento: id }, function () {
            location.reload();
        });
    });
}

function ver(id) {
    window.open("<?= site_url('leer') ?>/" + id);
}

function tracking(id) {
    showDocumentosModal('Tracking');
    $.post("<?= site_url('login/tracking') ?>", { id: id }, function (data) {
        $("#modal_body").html(data);
    });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Documentos</h2>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-archiva btn-sm" onclick="carga_nuevo_documento()">Nuevo documento</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="documentos_borrados()">Documentos borrados</button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th class="text-center">Rev.</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Menú</th>
                    <th class="text-center">Submenú</th>
                    <th class="text-center">Fecha alta</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($doc as $documento): ?>
                    <tr>
                        <td><?= esc($documento->nombre) ?></td>
                        <td class="text-center"><?= esc($documento->rev) ?></td>
                        <td class="text-center">
                            <?= esc($documento->estatus) ?>
                            <?php if ($documento->estatus === 'P'): ?>
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary ms-1"
                                        onclick="tracking('<?= esc($documento->id, 'js') ?>')">
                                    Tracking
                                </button>
                            <?php endif; ?>
                        </td>
                        <td class="text-center"><?= esc($documento->menu) ?></td>
                        <td class="text-center"><?= esc($documento->submenu) ?></td>
                        <td class="text-center">
                            <?php
                            if (!empty($documento->fecha) && $documento->fecha !== '0') {
                                $date = date_create($documento->fecha);
                                echo $date ? esc(date_format($date, 'Y/m/d')) : '';
                            }
                            ?>
                        </td>
                        <td class="text-end text-nowrap">
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary me-1"
                                    onclick="editar_documento('<?= esc($documento->id, 'js') ?>','<?= esc($documento->id_empresa, 'js') ?>')">
                                Modificar
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger me-1"
                                    onclick="eliminar('<?= esc($documento->id, 'js') ?>')">
                                Eliminar
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary me-1"
                                    onclick="ver('<?= esc($documento->id, 'js') ?>')">
                                Ver
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    onclick="window.open('<?= site_url('descargar/' . $documento->id) ?>')">
                                Descargar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body">
                <p class="text-secondary mb-0">Cargando…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    if (!$.fn.DataTable) {
        console.error('DataTables no está cargado');
        return;
    }
    if ($.fn.DataTable.isDataTable('#datatables')) {
        return;
    }

    $('#datatables').DataTable({
        pagingType: 'simple_numbers',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' },
        columnDefs: [{
            targets: [-1],
            orderable: false
        }]
    });
});
</script>
