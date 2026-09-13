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
function agrega_reporte() {
    var url = "<?php echo base_url()?>nuevo_analisis";
    window.location = url;
}

function elimina_analisis(folio) {
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
        $.post("<?php echo base_url()?>login/elimina_analisis",
            { id: folio },
            function (data) {
                location.reload();
            }
        );
    });
}

function convertir(folio) {
    swal({
        title: '¿Estás seguro de querer convertir a proyecto este documento?',
        //text: "No podrás revertir este cambio",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
        buttonsStyling: false
    }).then(function () {
        var url = "<?php echo base_url()?>login/convertir_proyecto";
        $.post(url,
            { id: folio },
            function (data) {
                //if (data === "success") {
                    window.location = "<?php echo base_url()?>proyectos";
                /*}else{
                    swal({ title: "Existe",
                       text: "El proyecto Folio "+folio+" 8D, ya existe",
                       timer: 5000,
                       showConfirmButton: false
                    });
                }*/
            }
        );
    });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Analisis 8D'S</h2>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Solicitante</th>
                    <th>Problematica</th>
                    <th>Tipo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($analisis->getResult() as $key) { ?>
                    <tr>
                        <td><?php echo $key->folio?></td>
                        <td><?php echo $key->fecha?></td>
                        <td><?php echo $key->nombre?></td>
                        <td><?php echo $key->problema_detectado?></td>
                        <td><?php echo $key->tipo?></td>
                        <td class="text-end text-nowrap">
                            <a href="<?php echo base_url()?>login/pdf_8d/<?php echo $key->folio?>"
                               target="_blank"
                               class="btn btn-sm btn-outline-secondary">PDF</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">8D</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="body_modal">
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
