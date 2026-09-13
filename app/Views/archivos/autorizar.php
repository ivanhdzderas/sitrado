<script>
function aplicar(id) {
    if ($("#accion" + id).val() == "") {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Debe seleccionar un campo'
        });
        return false;
    }
    var url = "<?php echo base_url()?>login/guarda_estatus_doc";
    if ($("#accion" + id).val() == "R") {
        swal({
            title: '¿Porque fue Rechazado el documento?',
            input: 'text',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: function (email) {
                return new Promise(function (resolve, reject) {
                    setTimeout(function () {
                        if (email === '') {
                            reject('No se puede enviar un campo vacio');
                        } else {
                            resolve();
                        }
                    }, 1000);
                });
            },
            allowOutsideClick: false
        }).then(function (email) {
            $.post(url,
                { estatus: $("#accion" + id).val(), mensaje: email, id: id },
                function () {
                    location.reload();
                });
        });
    } else {
        $.post(url,
            { estatus: $("#accion" + id).val(), id: id },
            function () {
                window.location.href = "<?php echo base_url()?>login/documentos_autorizar";
            });
    }
}

function ver(id) {
    window.open("<?php echo base_url()?>leer/" + id);
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Documentos por autorizar</h2>
        <a href="<?= site_url('login/configurar_aprobadores') ?>" class="btn btn-outline-primary btn-sm">
            Configurar aprobadores
        </a>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th class="text-center">Departamento</th>
                    <th class="text-center">Tipo de Documento</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentos->getResult() as $key): ?>
                    <?php if (login_model()->revisar_doc($key->id)[0]->total == 0): ?>
                        <tr>
                            <td><?php echo $key->nombre ?></td>
                            <td class="text-center"><?php echo $key->departamento ?></td>
                            <?php
                            switch ($key->tipo) {
                                case "POL":
                                    ?>
                                    <td class="text-center">Politicas</td>
                                    <?php
                                    break;
                                case "P":
                                    ?>
                                    <td class="text-center">Procedimientos</td>
                                    <?php
                                    break;
                                case "D":
                                    ?>
                                    <td class="text-center">Directriz</td>
                                    <?php
                                    break;
                                case "I":
                                    ?>
                                    <td class="text-center">Instructivo</td>
                                    <?php
                                    break;
                                case "F":
                                    ?>
                                    <td class="text-center">Formato</td>
                                    <?php
                                    break;
                                case "IP":
                                    ?>
                                    <td class="text-center">Interrelacion de Procesos</td>
                                    <?php
                                    break;
                            }
                            ?>
                            <td class="text-end text-nowrap">
                                <div class="d-inline-flex flex-wrap align-items-center gap-2 justify-content-end">
                                    <select id="accion<?php echo $key->id ?>" class="form-select form-select-sm" style="width: auto; min-width: 8rem;">
                                        <option value=""></option>
                                        <option value="A">Aprobar</option>
                                        <option value="R">Rechazar</option>
                                    </select>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="aplicar('<?php echo $key->id ?>')">Aplicar</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="ver('<?php echo $key->id ?>')">Ver</button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
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
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' },
        columnDefs: [{
            targets: [-1],
            orderable: false
        }]
    });
});
</script>
