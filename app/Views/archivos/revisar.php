<script>
function aciva_doc(id) {
    var url = "<?php echo base_url()?>login/activa_doc";
    $.post(url, { documento: id }, function () {
        location.reload();
    });
}

function eliminar(id) {
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
        $.post("<?php echo site_url('login/elimina_archivo2')?>",
            { documento: id },
            function () {
                location.reload();
            });
    });
}

function ver_notas(id) {
    var url = "<?php echo base_url()?>login/notas_doc";
    $.post(url, { id: id }, function (data) {
        swal(data);
    });
}

function ver(id) {
    window.open("<?php echo base_url()?>leer/" + id);
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Documentos</h2>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th class="text-center">Departamento</th>
                    <th class="text-center">Tipo de Documento</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentos->getResult() as $key): ?>
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
                            case "MP":
                                ?>
                                <td class="text-center">Mapa de Procesos</td>
                                <?php
                                break;
                            case "OR":
                                ?>
                                <td class="text-center">Organigrama</td>
                                <?php
                                break;
                        }
                        ?>
                        <td class="text-center">
                            <?php
                            switch ($key->estatus) {
                                case 'R':
                                    echo "Rechazado";
                                    ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary ms-1" onclick="ver_notas('<?php echo $key->id ?>')">Notas</button>
                                    <?php
                                    break;
                                case 'A':
                                    echo "Aprobado;";
                                    break;
                            }
                            if ($key->tipo == "MP") {
                                $query = login_model()->buscar_verificacion($key->id);

                                switch ($query[0]->estatus) {
                                    case 'R':
                                        echo "Rechazado";
                                        ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary ms-1" onclick="ver_notas('<?php echo $key->id ?>')">Notas</button>
                                        <?php
                                        break;
                                    case 'A':
                                        echo "Aprobado;";
                                        break;
                                }
                            }
                            ?>
                        </td>
                        <td class="text-end text-nowrap">
                            <?php
                            if ($key->estatus == "A") {
                                ?>
                                <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="aciva_doc('<?php echo $key->id ?>')">Activar Archivo</button>
                                <?php
                            } else if ($key->estatus == "R") {
                                ?>
                                <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="eliminar('<?php echo $key->id ?>')">Borrar Archivo</button>
                                <?php
                            }

                            if ($key->tipo == "MP") {
                                $query = login_model()->buscar_verificacion($key->id);

                                if ($query[0]->estatus == "A") {
                                    ?>
                                    <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="aciva_doc('<?php echo $key->id ?>')">Activar Archivo</button>
                                    <?php
                                } else if ($query[0]->estatus == "R") {
                                    ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="eliminar('<?php echo $key->id ?>')">Borrar Archivo</button>
                                    <?php
                                }
                            }
                            ?>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="ver('<?php echo $key->id ?>')">Ver</button>
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
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' },
        columnDefs: [{
            targets: [-1],
            orderable: false
        }]
    });
});
</script>
