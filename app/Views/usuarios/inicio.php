<style>
.select-docs {
    width: 100%;
    min-height: 140px;
}
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
.archiva-modal .form-section {
    background: #fff;
    border: 1px solid #e5ebf2;
    border-radius: 0.85rem;
    padding: 1rem;
    margin-bottom: 1rem;
}
.archiva-modal .form-section-title {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-bottom: 0.75rem;
    font-weight: 700;
}
.archiva-permisos {
    max-height: 220px;
    overflow: auto;
    border: 1px solid #e5ebf2;
    border-radius: 0.65rem;
    padding: 0.75rem;
    background: #fbfdff;
}
.archiva-permisos label {
    font-weight: 500;
}
</style>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Usuarios</h2>
        <button type="button" class="btn btn-archiva" onclick="usuario_anadir()">Nuevo usuario</button>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Tipo</th>
                    <th>Permiso Minutas</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="modal fade archiva-modal" id="modal_form" tabindex="-1" aria-labelledby="modal_form_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_form_title">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form">
                    <input type="hidden" name="id" id="id" value="">

                    <div class="form-section">
                        <div class="form-section-title">Datos generales</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="usuario">Usuario</label>
                                <input type="text" name="usuario" id="usuario" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="pass">Contraseña</label>
                                <input type="text" name="pass" id="pass" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="tipo">Tipo</label>
                                <select id="tipo" name="tipo" class="form-select" required>
                                    <option value=""></option>
                                    <option value="admin">ADMIN</option>
                                    <option value="empr">EMPRESA</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="minutas">Acceso a crear minutas</label>
                                <select id="minutas" name="minutas" class="form-select" required>
                                    <option value=""></option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="reportes">Acceso a reportes</label>
                                <select id="reportes" name="reportes" class="form-select" required>
                                    <option value=""></option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="puesto">Puesto</label>
                                <input type="text" id="puesto" name="puesto" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="departamento">Departamento</label>
                                <input type="text" id="departamento" name="departamento" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="nivel">Nivel</label>
                                <select id="nivel" name="nivel" class="form-select" required>
                                    <option value=""></option>
                                    <?php foreach ($niveles as $key): ?>
                                        <option value="<?= esc($key->nivel) ?>"><?= esc($key->nivel) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-section-title">Documentos</div>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label" for="firstlist">Disponibles</label>
                                <select id="firstlist" class="form-select select-docs" multiple="multiple">
                                    <?php foreach ($documentos as $key): ?>
                                        <option value="<?= esc($key->id) ?>"><?= esc($key->nombre) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2 d-grid gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="AddToSecondList();">Añadir →</button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="DeleteSecondListItem();">← Quitar</button>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="secondlist">Acceso permitido</label>
                                <select id="secondlist" class="form-select select-docs" name="doc[]" multiple="multiple"></select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section mb-0">
                        <div class="form-section-title">Permisos por empresa</div>
                        <div class="archiva-permisos">
                            <?php foreach ($data->getResult() as $empresa): ?>
                                <div class="mb-2">
                                    <label class="d-flex align-items-center gap-2">
                                        <input type="checkbox"
                                               name="permisos[]"
                                               onclick="seleccion1('e<?= esc($empresa->id, 'attr') ?>','E<?= esc($empresa->id, 'attr') ?>')"
                                               id="E<?= esc($empresa->id, 'attr') ?>"
                                               value="E<?= esc($empresa->id, 'attr') ?>">
                                        <span><?= esc($empresa->nombre) ?></span>
                                    </label>
                                    <div id="e<?= esc($empresa->id, 'attr') ?>" class="ms-3 mt-1">
                                        <?php
                                        $data_grupos = login_model()->leer_grupo($empresa->id)->getResult();
                                        foreach ($data_grupos as $grupo):
                                        ?>
                                            <label class="d-flex align-items-center gap-2">
                                                <input type="checkbox"
                                                       onclick="seleccion1('g<?= esc($grupo->id, 'attr') ?>','G<?= esc($grupo->id, 'attr') ?>')"
                                                       name="permisos[]"
                                                       value="G<?= esc($grupo->id, 'attr') ?>"
                                                       id="G<?= esc($grupo->id, 'attr') ?>">
                                                <span><?= esc($grupo->nomber) ?></span>
                                            </label>
                                            <div id="g<?= esc($grupo->id, 'attr') ?>" class="ms-4">
                                                <?php
                                                $data_subgrupos = login_model()->leer_subrupos2($empresa->id, $grupo->id)->getResult();
                                                foreach ($data_subgrupos as $subgrupo):
                                                ?>
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input type="checkbox"
                                                               name="permisos[]"
                                                               value="S<?= esc($subgrupo->id, 'attr') ?>"
                                                               id="S<?= esc($subgrupo->id, 'attr') ?>">
                                                        <span><?= esc($subgrupo->nombre) ?></span>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-archiva">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var save_method;
var datatables;

function usuariosModalEl() {
    return document.getElementById('modal_form');
}

function showUsuariosModal() {
    var el = usuariosModalEl();
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function hideUsuariosModal() {
    var el = usuariosModalEl();
    if (!el || !window.bootstrap || !bootstrap.Modal) return;
    var inst = bootstrap.Modal.getInstance(el);
    if (inst) inst.hide();
}

$(document).ready(function () {
    if (!$.fn.DataTable) {
        console.error('DataTables no está cargado');
        return;
    }
    if ($.fn.DataTable.isDataTable('#datatables')) {
        return;
    }

    datatables = $('#datatables').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= site_url('login/usuario_lista') ?>",
            type: "POST"
        },
        columnDefs: [{
            targets: [-1],
            orderable: false,
            className: 'text-end'
        }],
        language: { url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json' }
    });
});

function usuario_anadir() {
    save_method = 'add';
    $('#form')[0].reset();
    $('#id').val('');
    $('#secondlist').empty();
    $('#modal_form_title').text('Añadir nuevo usuario');
    showUsuariosModal();
}

function usuario_editar(id) {
    save_method = 'update';
    $('#form')[0].reset();
    $('#secondlist').empty();

    $.ajax({
        url: "<?= site_url('login/usuario_editar') ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('[name="id"]').val(data.id);
            $('[name="nombre"]').val(data.nombre);
            $('[name="usuario"]').val(data.usuario);
            $('[name="tipo"]').val(data.tipo);
            $('[name="minutas"]').val(data.juntas);
            $('[name="reportes"]').val(data.reportes);
            $('[name="pass"]').val(data.pass);
            $('[name="puesto"]').val(data.puesto);
            $('[name="departamento"]').val(data.departamento);
            $('[name="nivel"]').val(data.nivel);
            $('[name="email"]').val(data.correo);
            $('#modal_form_title').text('Editar usuario');
            showUsuariosModal();
        },
        error: function () {
            alert('Error get data from ajax');
        }
    });

    $.ajax({
        url: "<?= site_url('login/permisos_usuario') ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            for (var x = 0; x < data.length; x++) {
                $('#E' + data[x].empresa).prop('checked', true);
                $('#G' + data[x].grupo).prop('checked', true);
                $('#S' + data[x].subgrupo).prop('checked', true);
            }
        },
        error: function () {
            alert('Usuario sin permisos');
        }
    });
}

function reload_table() {
    $('#datatables').DataTable().ajax.reload(null, false);
}

function save() {
    var url = (save_method == 'add')
        ? "<?= site_url('login/agrega_usuario') ?>"
        : "<?= site_url('login/usuario_actualizar') ?>";

    // Seleccionar todos los docs permitidos para que viajen en el serialize
    $('#secondlist option').prop('selected', true);

    $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function () {
            hideUsuariosModal();
            reload_table();
            swal('La información añadida ha sido guardada.');
            location.reload();
        },
        error: function () {
            alert('Error adding / update data');
        }
    });
}

function usuario_eliminar(id) {
    swal({
        title: '¿Estás seguro de querer eliminar este usuario?',
        text: "No podrás revertir este cambio",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Borrar',
        closeOnConfirm: false
    }).then(function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url: "<?= site_url('login/usuario_eliminar') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function () {
                hideUsuariosModal();
                reload_table();
                swal('El usuario ha sido eliminado');
            },
            error: function () {
                alert('Error adding / update data');
            }
        });
    });
}

function view_usuario(id) {
    $.ajax({
        url: "<?= site_url('login/usuario_por_id') ?>/" + id,
        type: "GET",
        success: function (result) {
            $('#haha').empty().html(result).fadeIn('slow');
        }
    });
}

function envio_email(id) {
    $.ajax({
        url: "<?= site_url('login/envio_correo_usuario') ?>/",
        type: "POST",
        data: { id: id },
        success: function () {
            swal('Envio Satisfactorio');
        },
        error: function () {
            swal('Oops...', 'Algo ocurrio en el servidor', 'error');
        }
    });
}

function seleccion1(coordenada, origen) {
    if (document.getElementById(origen).checked == true) {
        $('#' + coordenada + ' input[type=checkbox]').prop('checked', true);
    } else {
        $('#' + coordenada + ' input[type=checkbox]').prop('checked', false);
    }
}

function AddToSecondList() {
    var fl = document.getElementById('firstlist');
    var sl = document.getElementById('secondlist');
    for (var i = 0; i < fl.options.length; i++) {
        if (fl.options[i].selected) {
            sl.add(fl.options[i], null);
            i--;
        }
    }
    return false;
}

function DeleteSecondListItem() {
    var fl = document.getElementById('firstlist');
    var sl = document.getElementById('secondlist');
    for (var i = 0; i < sl.options.length; i++) {
        if (sl.options[i].selected) {
            fl.add(sl.options[i], null);
            i--;
        }
    }
    return false;
}
</script>
