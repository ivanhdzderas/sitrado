<div id="bloquea" class="cargando" style="display:none;">
    <img style="margin-left: 5%;margin-top: 15%" alt="Espere..." src="<?= base_url('assets/img/cargando.gif') ?>" width="20%" />
</div>
<style>
.cargando {
    width: 100%;
    height: 100%;
    overflow: hidden;
    top: 0;
    left: 0;
    z-index: 10000;
    text-align: center;
    position: absolute;
    background-color: #000;
    color: #fff;
    opacity: 0.8;
}
</style>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Empresas</h2>
        <button type="button" class="btn btn-archiva" onclick="empresas_anadir()">Añadir nueva empresa</button>
    </div>

    <div class="table-responsive">
        <table id="datatables" class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Calle</th>
                    <th>Número Ext</th>
                    <th>Número Int</th>
                    <th>Colonia</th>
                    <th>Ciudad</th>
                    <th>Estado</th>
                    <th>CP</th>
                    <th>RFC</th>
                    <th>Apoderado</th>
                    <th class="text-end">Acción</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modal_form" tabindex="-1" aria-labelledby="modal_form_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_form_title">Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="empresas_body">
                <form action="#" id="form" enctype="multipart/form-data" class="archiva-form">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="mb-2">
                        <label class="form-label" for="nombre_empresa">Nombre</label>
                        <input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control" placeholder="Nombre empresa">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="calle">Calle</label>
                        <input type="text" name="calle" id="calle" class="form-control" placeholder="Calle">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label" for="numero_ext">Número exterior</label>
                            <input type="text" name="numero_ext" id="numero_ext" class="form-control" placeholder="Número exterior">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="numero_int">Número interior</label>
                            <input type="text" name="numero_int" id="numero_int" class="form-control" placeholder="Número interior">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="colonia">Colonia</label>
                        <input type="text" name="colonia" id="colonia" class="form-control" placeholder="Colonia">
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label" for="ciudad">Ciudad</label>
                            <input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Ciudad">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="estado">Estado</label>
                            <input type="text" name="estado" id="estado" class="form-control" placeholder="Estado">
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <label class="form-label" for="cp">CP</label>
                            <input type="text" name="cp" id="cp" class="form-control" placeholder="Código postal">
                        </div>
                        <div class="col-8">
                            <label class="form-label" for="rfc">RFC</label>
                            <input type="text" name="rfc" id="rfc" class="form-control" placeholder="RFC">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="apoderado">Apoderado</label>
                        <input type="text" name="apoderado" id="apoderado" class="form-control" placeholder="Apoderado">
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="logo">Logo</label>
                        <input type="file" id="logo" name="archivo" class="form-control" size="20">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-archiva">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var save_method;
var datatables;
var empresasFormHtml = null;

function empresasModalEl() {
    return document.getElementById('modal_form');
}

function showEmpresasModal() {
    var el = empresasModalEl();
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function hideEmpresasModal() {
    var el = empresasModalEl();
    if (!el || !window.bootstrap || !bootstrap.Modal) return;
    var inst = bootstrap.Modal.getInstance(el);
    if (inst) inst.hide();
}

$(document).ready(function () {
    empresasFormHtml = $('#empresas_body').html();

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
            url: "<?= site_url('login/empresas_lista') ?>",
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

function restoreEmpresasForm() {
    if (empresasFormHtml) {
        $('#empresas_body').html(empresasFormHtml);
    }
}

function empresas_anadir() {
    save_method = 'add';
    restoreEmpresasForm();
    $('#form')[0].reset();
    $('#id').val('');
    $('#modal_form_title').text('Añadir nueva empresa');
    $('#btnSave').show();
    showEmpresasModal();
}

function empresas_editar(id) {
    save_method = 'update';
    restoreEmpresasForm();
    $('#form')[0].reset();
    $('#btnSave').show();

    $.ajax({
        url: "<?= site_url('login/empresas_editar') ?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('[name="id"]').val(data.id);
            $('[name="nombre_empresa"]').val(data.nombre);
            $('[name="calle"]').val(data.calle);
            $('[name="numero_ext"]').val(data.numero_ext);
            $('[name="numero_int"]').val(data.numero_int);
            $('[name="colonia"]').val(data.colonia);
            $('[name="ciudad"]').val(data.ciudad);
            $('[name="estado"]').val(data.estado);
            $('[name="cp"]').val(data.cp);
            $('[name="rfc"]').val(data.rfc);
            $('[name="apoderado"]').val(data.apoderado);
            $('#modal_form_title').text('Editar empresa');
            showEmpresasModal();
        },
        error: function () {
            alert('Error get data from ajax');
        }
    });
}

function reload_table() {
    $('#datatables').DataTable().ajax.reload(null, false);
}

function save() {
    var url = (save_method == 'add')
        ? "<?= site_url('login/empresas_anadir') ?>"
        : "<?= site_url('login/empresas_actualizar') ?>";

    if (!$('#logo').val()) {
        $.ajax({
            url: url,
            type: "POST",
            data: $("#form").serialize(),
            dataType: "JSON",
            success: function () {
                hideEmpresasModal();
                reload_table();
                swal('La información añadida ha sido guardada.');
            },
            error: function () {
                alert('Error adding / update data');
            }
        });
    } else {
        var formData = new FormData($("#form")[0]);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                hideEmpresasModal();
                $('#bloquea').show();
            },
            success: function () {
                $('#bloquea').hide();
                reload_table();
                swal('La información añadida ha sido guardada.');
            },
            error: function () {
                $('#bloquea').hide();
                alert('Error adding / update data');
            }
        });
    }
}

function empresas_ver(id) {
    $('#btnSave').hide();
    $('#modal_form_title').text('Estructura');
    showEmpresasModal();
    $('#empresas_body').html('<p class="text-secondary mb-0">Cargando…</p>');

    $.ajax({
        url: "<?= site_url('login/vista_estructura') ?>",
        type: "POST",
        data: { id: id },
        success: function (data) {
            $("#empresas_body").html(data);
        },
        error: function () {
            $("#empresas_body").html('<p class="text-danger mb-0">No se pudo cargar la estructura.</p>');
        }
    });
}

function empresas_eliminar(id) {
    swal({
        title: '¿Estás seguro de querer eliminar esta empresa?',
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
            url: "<?= site_url('login/empresas_eliminar') ?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function () {
                hideEmpresasModal();
                reload_table();
                swal('La empresa ha sido eliminada');
            },
            error: function () {
                alert('Error adding / update data');
            }
        });
    });
}

function view_empresas(id) {
    $.ajax({
        url: "<?= site_url('login/empresas_por_id') ?>/" + id,
        type: "GET",
        success: function (result) {
            $('#haha').empty().html(result).fadeIn('slow');
        }
    });
}
</script>

<?php
$mensaje = session()->get('mensaje_empresas');
$tipo = session()->get('tipo');
switch ($tipo) {
    case 'ok':
        ?>
        <script>alertify.success(<?= json_encode((string) $mensaje) ?>);</script>
        <?php
        session()->remove('mensaje_empresas');
        session()->remove('tipo');
        break;
    case 'error':
        ?>
        <script>alertify.error(<?= json_encode((string) $mensaje) ?>);</script>
        <?php
        session()->remove('mensaje_empresas');
        session()->remove('tipo');
        break;
}
?>
