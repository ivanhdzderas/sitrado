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
function showAvisosModal(title) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Aviso');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function edita(id) {
    showAvisosModal('Editar aviso');
    var url = "<?php echo base_url()?>login/edita_aviso";
    $.post(url, { id: id }, function (data) {
        $("#modal_body").html(data);
    });
}

function elimina(id) {
    swal({
        title: '¿Deseas deshabilitar el aviso?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Borrar',
        buttonsStyling: false
    }).then(function () {
        $.post("<?php echo site_url('login/elimina_aviso')?>",
            { id: id },
            function (data) {
                if (data == "SI") {
                    location.reload();
                } else {
                    swal("Ocurrio un problema con el servidor. ");
                }
            });
    });
}

function carga_nuevo_aviso() {
    showAvisosModal('Nuevo aviso');
    var url = "<?php echo base_url()?>login/nuevo_aviso";
    $.post(url, function (data) {
        $("#modal_body").html(data);
    });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Avisos</h2>
        <button type="button" class="btn btn-archiva btn-sm" onclick="carga_nuevo_aviso()">Nuevo aviso</button>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Mensaje</th>
                    <th class="text-center">Activo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista as $key): ?>
                    <tr>
                        <td><?php echo $key->id ?></td>
                        <td><?php echo $key->mensaje ?></td>
                        <td class="text-center"><?php echo $key->activo ?></td>
                        <td class="text-end text-nowrap">
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary me-1"
                                    onclick="edita('<?php echo $key->id ?>')">
                                Editar
                            </button>
                            <?php if ($key->activo == "SI"): ?>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="elimina('<?php echo $key->id ?>')">
                                    Deshabilitar
                                </button>
                            <?php endif; ?>
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
                <h5 class="modal-title" id="modal_title">Aviso</h5>
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
