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

function detalla_pryecto(proyecto){
    showProyectosModal('Detallado del proyecto');
    var url="<?php echo base_url()?>login/detalla_proyecto2";
    $.post(url,{proyecto:proyecto},
        function (data){
            $("#body_modal").html(data);
        });
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
function nuevas_tareas(){
    showProyectosModal('Asigna tareas');
    var url="<?php echo base_url()?>signa_tareas";
    $.post(url,
        function (data){
            $("#body_modal").html(data);
        });
 };

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
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Lider de proyecto</th>
                    <th>Back up</th>
                    <th class="text-end">Fecha Inicio</th>
                    <th class="text-end">Fecha Fin</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nombre = "";
                foreach ($lista_proyectos->getResult() as $proyecto) {
                    if ($nombre <> $proyecto->nombre_proyecto) {
                ?>
                    <tr>
                        <td><?= esc($proyecto->nombre_proyecto) ?></td>
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
                        <td class="text-end text-nowrap">
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary me-1"
                                    onclick="detalla_pryecto('<?= esc($proyecto->id_proyecto, 'js') ?>')">
                                Ver
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    onclick="grafica('<?= esc($proyecto->id_proyecto, 'js') ?>')">
                                Gráficas
                            </button>
                        </td>
                    </tr>
                <?php
                        $nombre = $proyecto->nombre_proyecto;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
