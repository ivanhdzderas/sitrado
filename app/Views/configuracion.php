<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Salas de junta</h2>
        <button type="button" class="btn btn-archiva" data-bs-toggle="modal" data-bs-target="#myModal" onclick="agregar_sala()">
            Nueva sala
        </button>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($salas)): ?>
                    <tr>
                        <td colspan="3" class="text-secondary">No hay salas registradas.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($salas as $key): ?>
                        <tr>
                            <td class="fw-semibold"><?= esc($key->nombre) ?></td>
                            <td><?= esc($key->direccion) ?></td>
                            <td class="text-end">
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#myModal"
                                        onclick="modificar('<?= esc($key->id_sala, 'js') ?>')">
                                    Modificar
                                </button>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="elimina('<?= esc($key->id_sala, 'js') ?>')">
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

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Sala</h5>
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

<script>
function elimina(id) {
    Swal.fire({
        title: '¿Eliminar esta sala de junta?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
        confirmButtonColor: '#0b5cab',
        cancelButtonColor: '#94a3b8'
    }).then(function (result) {
        if (!result.isConfirmed) return;
        $.post("<?= site_url('login/elimina_sala') ?>", { id: id }, function () {
            Swal.fire({ icon: 'success', title: 'Sala eliminada' }).then(function () {
                window.location.reload();
            });
        });
    });
}

function modificar(id) {
    $('#myModalLabel').text('Modificar sala');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    $.post("<?= site_url('login/mod_sala') ?>", { id: id }, function (data) {
        $('#modal_body').html(data);
    });
}

function agregar_sala() {
    $('#myModalLabel').text('Nueva sala');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    $.post("<?= site_url('login/agrega_sala') ?>", function (data) {
        $('#modal_body').html(data);
    });
}

$(function () {
    if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#datatables')) {
        $('#datatables').DataTable({
            pagingType: 'simple_numbers',
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Todos']],
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' }
        });
    }
});
</script>
