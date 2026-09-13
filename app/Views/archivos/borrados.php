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
function showBorradosModal(title) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Documento');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function ver(documento) {
    var url = "http://docs.google.com/viewer?url=<?php echo base_url()?>papelera/documentos/" + documento + "&amp;embedded=true";
    $('#iframe').attr('src', url);
    showBorradosModal(documento);
}

function documentos_activos() {
    var url = "<?php echo base_url()?>documentos";
    window.location = url;
}

function eliminar(documento) {
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
        $.post("<?php echo site_url('login/eliminar_eliminar')?>",
            { documento: documento },
            function () {
                location.reload();
            });
    });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Documentos borrados</h2>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="documentos_activos()">Documentos activos</button>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $carpeta = "papelera/documentos";
                if (is_dir($carpeta)) {
                    if ($dir = opendir($carpeta)) {
                        while (($archivo = readdir($dir)) !== false) {
                            if ($archivo != '.' && $archivo != '..' && $archivo != '.htaccess') {
                                ?>
                                <tr>
                                    <td><?php echo $archivo ?></td>
                                    <td class="text-end text-nowrap">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-secondary me-1"
                                                onclick="ver('<?php echo $archivo ?>')">
                                            Ver
                                        </button>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="eliminar('<?php echo $archivo ?>')">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        closedir($dir);
                    }
                }
                ?>
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
                <iframe style="" id="iframe" name="iframe" width="100%" height="880"></iframe>
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
