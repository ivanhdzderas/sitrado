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
function showArchivosModal(title) {
    var el = document.getElementById('myModal');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    $('#modal_title').text(title || 'Documento');
    $('#modal_body').html('<p class="text-secondary mb-0">Cargando…</p>');
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function showUploadModal() {
    var el = document.getElementById('modalUpload');
    if (!el || !window.bootstrap || !bootstrap.Modal) {
        console.error('Bootstrap Modal no disponible');
        return;
    }
    if (el.parentElement !== document.body) {
        document.body.appendChild(el);
    }
    bootstrap.Modal.getOrCreateInstance(el).show();
}

function elimina_archivo(documento) {
    var url = "<?php echo base_url()?>login/elimina_archivo";
    $.post(url, { documento: documento }, function () {
        location.reload();
    });
}

function modificar(documento) {
    showArchivosModal('Modificar permisos');
    var url = "<?php echo base_url()?>login/modificar_permisos_documento";
    $.post(url, { documento: documento, empresa: "<?php echo $this->uri->segment(2)?>" },
        function (data) {
            $("#modal_body").html(data);
        });
}
</script>

<div class="archiva-panel">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="panel-title mb-0">Documentos</h2>
        <?php
        $tipo = session()->get('logged_in')['tipo'];
        if ($tipo == "admin" or $tipo == "doc") {
            ?>
            <button type="button" class="btn btn-archiva btn-sm" onclick="showUploadModal()">Agregar archivo</button>
            <?php
        }
        ?>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Archivo</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data->getResult() as $documento): ?>
                    <tr>
                        <td><?php echo $documento->nombre ?></td>
                        <td class="text-end text-nowrap">
                            <?php if ($documento->descarga == "SI"): ?>
                                <a class="btn btn-sm btn-outline-secondary me-1"
                                   href="<?php echo base_url()?>descargar/<?php echo $documento->nombre ?>">
                                    Descargar
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger me-1"
                                        onclick="elimina_archivo('<?php echo $documento->id ?>')">
                                    Eliminar
                                </button>
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary"
                                        onclick="modificar('<?php echo $documento->id ?>')">
                                    Modificar
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$mensaje = session()->get('mensaje_documento');
if ($mensaje <> "") {
    ?>
    <script>
    alertify.success("<?php echo $mensaje?>");
    </script>
    <?php
    session()->unset_userdata('mensaje_documento');
}
?>

<?php
$tipo = session()->get('logged_in')['tipo'];
if ($tipo == "admin" or $tipo == "doc") {
    ?>
<div class="modal fade archiva-modal" id="modalUpload" tabindex="-1" aria-labelledby="modal_upload_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_upload_title">Subir archivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?= heading('Suba un archivo zip, rar, pdf, docx o txt', 3); ?>
                <?= $error; ?>
                <?= form_open_multipart('do_upload'); ?>
                <div class="mb-3">
                    <input type="file" name="userfile" size="20" required="required" class="form-control" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Seleccione descarga</label>
                    <select name="descarga" class="form-control" required="required">
                        <option value=""></option>
                        <option value="SI">SI DESCARGAR</option>
                        <option value="NO">NO DESCARGAR</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Seleccione cuál sub-grupo puede ver este archivo</label>
                    <?php foreach ($subgrupos->getResult() as $key): ?>
                        <div class="form-check">
                            <input class="form-check-input" name="permisos[]" type="checkbox" value="<?php echo $key->id ?>" id="perm_<?php echo $key->id ?>" />
                            <label class="form-check-label" for="perm_<?php echo $key->id ?>">
                                <?php echo $key->nomber ?> / <?php echo $key->nombre ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="text" name="menu" value="<?php echo $numero ?>" style="visibility: hidden;">
                <input type="text" style="visibility: hidden;" name="empresa" value="<?php echo $numero1 ?>">
                <input type="text" style="visibility: hidden;" name="submenu" value="<?php echo $numero3 ?>">
                <button type="submit" class="btn btn-archiva btn-sm">Subir Archivo</button>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <?php
}
?>

<div class="modal fade archiva-modal" id="myModal" tabindex="-1" aria-labelledby="modal_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Documento</h5>
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
