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
</style>

<script>
function showSolicitudesModal(title) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Solicitud');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function agregar() {
    window.location = "<?= site_url('login/solicitud') ?>";
}

function aprobar(id, tipo) {
    $.ajax({
        type: "POST",
        url: "<?= site_url('login/asigna_folio_solicitud') ?>",
        data: { id: id, tipo: tipo },
        success: function () {
            location.reload();
        }
    });
}

function eliminar(id) {
    swal({
        title: '¿Deseas borrar la solicitud?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then(function () {
        $.ajax({
            type: "POST",
            url: "<?= site_url('login/eliminar_solicitud') ?>",
            data: { id: id },
            success: function () {
                location.reload();
            }
        });
    });
}

function modificar(id) {
    showSolicitudesModal('Modificar solicitud');
    $.ajax({
        type: "POST",
        url: "<?= site_url('login/modificar_solicitud') ?>",
        data: { id: id },
        success: function (data) {
            $("#modal_body").html(data);
        }
    });
}

function pdf(id) {
    window.open("<?= site_url('login/pdf_solicitud') ?>/" + id);
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Solicitudes documentales</h2>
        <button type="button" class="btn btn-archiva btn-sm" onclick="agregar()">Nueva solicitud</button>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Solicitante</th>
                    <th class="text-center">Departamento</th>
                    <th class="text-center">Código</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($solicitues as $key): ?>
                    <tr>
                        <td><?= esc($key->folio) ?></td>
                        <td class="text-center"><?= esc($key->tipo) ?></td>
                        <td class="text-center"><?= esc($key->solicitante) ?></td>
                        <td class="text-center"><?= esc($key->departamento) ?></td>
                        <td class="text-center"><?= esc($key->codigo) ?></td>
                        <td class="text-center"><?= esc($key->nombre) ?></td>
                        <td class="text-end text-nowrap">
                            <?php if ($key->folio == '0'): ?>
                                <button type="button"
                                        class="btn btn-sm btn-outline-primary me-1"
                                        onclick="aprobar('<?= esc($key->id_solicitud, 'js') ?>','<?= esc($key->tipo, 'js') ?>')">
                                    Aprobar
                                </button>
                            <?php endif; ?>
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger me-1"
                                    onclick="eliminar('<?= esc($key->id_solicitud, 'js') ?>')">
                                Eliminar
                            </button>
                            <?php if ($key->tipo == 'N'): ?>
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary me-1"
                                        onclick="modificar('<?= esc($key->id_solicitud, 'js') ?>')">
                                    Modificar
                                </button>
                            <?php endif; ?>
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    onclick="pdf('<?= esc($key->id_solicitud, 'js') ?>')">
                                PDF
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
                <h5 class="modal-title" id="modal_title">Solicitud</h5>
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
