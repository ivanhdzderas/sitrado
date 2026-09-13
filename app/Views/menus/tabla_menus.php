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
function showMenusModal(title) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Menú');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function elimina_menu(menu) {
    swal({
        title: '¿Eliminar este menú?',
        text: 'Se eliminará el menú seleccionado',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then(function (isConfirm) {
        if (!isConfirm) return;
        $.post("<?= site_url('login/elimina_menu') ?>", { menu: menu }, function () {
            location.reload();
        });
    });
}

function elimina_submenu(submenu) {
    swal({
        title: '¿Eliminar este submenú?',
        text: 'Se eliminará el submenú seleccionado',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then(function (isConfirm) {
        if (!isConfirm) return;
        $.post("<?= site_url('login/elimina_submenu') ?>", { submenu: submenu }, function () {
            location.reload();
        });
    });
}

function agrega_menu() {
    showMenusModal('Nuevo menú');
    $.post("<?= site_url('login/nuevo_menu') ?>", function (data) {
        $('#modal_body').html(data);
    });
}

function agrega_submenu() {
    showMenusModal('Nuevo submenú');
    $.post("<?= site_url('login/nuevo_submenu') ?>", function (data) {
        $('#modal_body').html(data);
    });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Menús y submenús</h2>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-archiva btn-sm" onclick="agrega_menu()">Nuevo menú</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="agrega_submenu()">Nuevo submenú</button>
        </div>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Menú</th>
                    <th>Submenú</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->getResult() as $key): ?>
                    <tr>
                        <td><?= esc($key->empresa) ?></td>
                        <td><?= esc($key->menu) ?></td>
                        <td><?= esc($key->submenu) ?></td>
                        <td class="text-end text-nowrap">
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger me-1"
                                    onclick="elimina_menu('<?= esc($key->id_menu, 'js') ?>')">
                                Eliminar menú
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="elimina_submenu('<?= esc($key->id_submenu, 'js') ?>')">
                                Eliminar submenú
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Menú</h5>
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
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' }
    });
});
</script>
