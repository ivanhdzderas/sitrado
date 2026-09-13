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
function showProyectosModal(title, bodyId) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Proyecto');
    $('#' + (bodyId || 'body_modal')).html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function liberar(subproyecto, proyecto){
    var el = document.getElementById('myModal');
    if (el && window.bootstrap && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(el).hide();
    }
    swal({
      title: '¿Porque deseas reactivar la actividad?',
      input: 'text',
      showCancelButton: true,
      confirmButtonText: 'Submit',
      showLoaderOnConfirm: true,
      preConfirm: function (text) {
        return new Promise(function (resolve, reject) {
           if (text =='') {
            reject('No se acepta campo vacio')
           }else{
            resolve()
           }
        })
      },
      allowOutsideClick: false
    }).then(function (text) {
        var url="<?php echo base_url()?>login/reactivar";
        $.post(url,{subproyecto:subproyecto,nota:text},
        function (data){
           swal({
                type: 'success',
                title: 'Reactivacion de actividad generada'
                })
                detalla_pryecto(proyecto);
                if (el && window.bootstrap && bootstrap.Modal) {
                    bootstrap.Modal.getOrCreateInstance(el).show();
                }
        });


    }, function (dismiss) {
                    if (dismiss === 'cancel') {
                        if (el && window.bootstrap && bootstrap.Modal) {
                            bootstrap.Modal.getOrCreateInstance(el).show();
                        }
                    }
                })
}
function detalla_pryecto(proyecto){
    var url="<?php echo base_url()?>login/detalla_proyecto/"+proyecto;
    window.location.href=url;
    /*$("#modal_title").html("Detallado del proyecto");
      $.post(url,{proyecto:proyecto},
        function (data){
            $("#body_modal").html(data);
        });*/
}

function grafica(proyecto){
    var url="<?php echo base_url()?>login/gantt/"+proyecto;

    var form = document.createElement('FORM');
    form.method='POST';
    form.action = url;
    form.target="_blank";

    var input = document.createElement("input");
    input.id="proyecto";
    input.name="proyecto";
    input.type="hidden";
    input.value=proyecto;
    form.appendChild(input);
    document.body.appendChild(form);

    form.submit();



    var url="<?php echo base_url()?>login/raci/"+proyecto;
    window.open(url,'_blank');
}
function nuevo_proyecto(){
    showProyectosModal('Nuevo Proyecto');
    var url="<?php echo base_url()?>nuevo_proyecto";
    $.post(url,
        function(data){
            $("#body_modal").html(data);
        });
 };

function eliminar(proyecto){
    swal({
        title: '¿Estás seguro de querer eliminar este proyecto?',
        text: "No podrás revertir este cambio",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Borrar',
        buttonsStyling: false
    }).then(function() {
        $.post("<?php echo site_url('login/eliminar_proyecto')?>",
            {proyecto:proyecto},
            function(data){
                location.reload();
        });
    });
    }

function terminar(id){
    swal({
      title: '¿Deseas dar por termininado el proyecto?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText:'NO',
    }).then(function (result) {
      var url="<?php echo base_url()?>login/termia_proyecto";
      $.post(url,
        {id:id},
        function (data){
            location.reload();
        });
    })
}
</script>

<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Proyecto</h5>
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

<div class="modal fade archiva-modal" id="myModal2" tabindex="-1" aria-labelledby="modal_title2" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title2">Proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="body_modal2">
                <p class="text-secondary mb-0">Cargando…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Proyectos</h2>
        <button type="button" class="btn btn-archiva btn-sm" onclick="nuevo_proyecto()">Nuevo proyecto</button>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Lider de proyecto</th>
                    <th>Back up</th>
                    <th class="text-end">Fecha Inicio</th>
                    <th class="text-end">Fecha Fin</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_proyectos->getResult() as $proyecto): ?>
                    <tr>
                        <td>
                            <a href="#" style="cursor:pointer;" onclick="detalla_pryecto('<?= esc($proyecto->id_proyecto, 'js') ?>'); return false;">
                                <?= esc($proyecto->nombre_proyecto) ?>
                            </a>
                        </td>
                        <td>
                            <?php
                            $query = login_model()->extre_impartidor($proyecto->capitan);
                            foreach ($query->getResult() as $nombre) {
                                echo esc($nombre->nombre);
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $query = login_model()->extre_impartidor($proyecto->subcapitan);
                            foreach ($query->getResult() as $nombre) {
                                echo esc($nombre->nombre);
                            }
                            ?>
                        </td>
                        <td class="text-end"><?= esc($proyecto->f_inicio) ?></td>
                        <td class="text-end"><?= esc($proyecto->f_fin) ?></td>
                        <td class="text-center">
                            <?php if (is_null($proyecto->f_fin)): ?>
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="terminar('<?= esc($proyecto->id_proyecto, 'js') ?>')">Activo</button>
                            <?php else: ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" disabled>Terminado</button>
                            <?php endif; ?>
                        </td>
                        <td class="text-end text-nowrap">
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary me-1"
                                    onclick="grafica('<?= esc($proyecto->id_proyecto, 'js') ?>')">
                                Gráficas
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="eliminar('<?= esc($proyecto->id_proyecto, 'js') ?>')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' }
    });
});
</script>
