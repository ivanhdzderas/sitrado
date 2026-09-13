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
(function ($) {
    if ($.fn.modal) return;
    $.fn.modal = function (action) {
        return this.each(function () {
            if (!window.bootstrap || !bootstrap.Modal) return;
            var inst = bootstrap.Modal.getOrCreateInstance(this);
            if (action === 'hide') inst.hide();
            if (action === 'show') inst.show();
        });
    };
})(jQuery);

function showDiagramaModal(title) {
    var el = document.getElementById('ModalVisor');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title_visor').text(title || 'Estructura');
    $('#modal_body_visor').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function mostrar(tipo, empresa) {
    var titulo = (tipo === 'grupo') ? 'Agregar grupo' : 'Agregar subgrupo';
    showDiagramaModal(titulo);
    var url = (tipo === 'grupo')
        ? "<?php echo site_url('login/grupo') ?>"
        : "<?php echo site_url('login/subgrupo') ?>";
    $.post(url, { empresa: empresa }, function (data) {
        $("#modal_body_visor").html(data);
    });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Estructura</h2>
        <div class="d-flex flex-wrap gap-2">
            <button type="button"
                    class="btn btn-archiva btn-sm"
                    onclick="mostrar('grupo','<?php echo $id_empresa ?>')">
                Agregar grupo
            </button>
            <button type="button"
                    class="btn btn-outline-secondary btn-sm"
                    onclick="mostrar('subgrupo','<?php echo $id_empresa ?>')">
                Agregar subgrupo
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Grupo</th>
                    <th class="text-end">Acciones</th>
                    <th>Subgrupo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pas->getResult() as $empresa): ?>
                    <tr>
                        <td><?php echo $empresa->grupo ?></td>
                        <td class="text-end text-nowrap">
                            <?php if ($empresa->idgrupo != NULL): ?>
                                <a class="btn btn-sm btn-outline-danger"
                                   href="../elimina_grupo/<?php echo $empresa->idgrupo ?>/<?php echo $empresa->idempresa ?>">
                                    Eliminar
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $empresa->subgrupo ?></td>
                        <td class="text-end text-nowrap">
                            <?php if ($empresa->idsubgrupos != NULL): ?>
                                <a class="btn btn-sm btn-outline-danger"
                                   href="../elimina_subgrupo/<?php echo $empresa->idsubgrupos ?>/<?php echo $empresa->idempresa ?>">
                                    Eliminar
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade archiva-modal" id="ModalVisor" tabindex="-1" aria-labelledby="modal_title_visor" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title_visor">Estructura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modal_body_visor">
                <p class="text-secondary mb-0">Cargando…</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
