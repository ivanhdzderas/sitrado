<?php
$nombre_usuario = '';
$usuario = '';
$password = '';
foreach ($datos_usuario as $key) {
    $nombre_usuario = $key->nombre;
    $usuario = $key->usuario;
    $password = $key->pass;
}
$avatar = session()->get('logged_in')['img'] ?? '';
$avatarUrl = $avatar === '' || $avatar === null
    ? base_url('assets/img/placeholder.jpg')
    : base_url('assets/img/faces/' . $avatar);
?>

<style>
.perfil-layout {
    display: grid;
    grid-template-columns: minmax(220px, 280px) minmax(0, 1fr);
    gap: 1.5rem;
    align-items: start;
}
@media (max-width: 767.98px) {
    .perfil-layout { grid-template-columns: 1fr; }
}
.perfil-avatar-card {
    background: var(--archiva-surface, #fff);
    border: 1px solid var(--archiva-line, #e5ebf2);
    border-radius: 1rem;
    padding: 1.5rem 1.25rem;
    text-align: center;
    box-shadow: var(--archiva-shadow, 0 8px 24px rgba(15, 35, 55, 0.06));
}
.perfil-avatar-card img {
    width: 128px;
    height: 128px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #eaf2fb;
    background: #f8fafc;
}
.perfil-avatar-card .avatar-actions {
    margin-top: 1rem;
    display: grid;
    gap: 0.5rem;
}
.perfil-form-card {
    background: var(--archiva-surface, #fff);
    border: 1px solid var(--archiva-line, #e5ebf2);
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: var(--archiva-shadow, 0 8px 24px rgba(15, 35, 55, 0.06));
}
.perfil-form-card .form-section-title {
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 1rem;
}
#bloquea.cargando {
    width: 100%;
    height: 100%;
    overflow: hidden;
    top: 0;
    left: 0;
    z-index: 10000;
    text-align: center;
    position: fixed;
    background-color: rgba(0, 0, 0, 0.55);
    color: #fff;
}
</style>

<div id="bloquea" class="cargando" style="display:none;">
    <img style="margin-top: 18%" alt="Espere..." src="<?= base_url('assets/img/cargando.gif') ?>" width="120">
</div>

<div class="archiva-panel">
    <h2 class="panel-title mb-3">Mi perfil</h2>

    <form enctype="multipart/form-data" class="formulario" id="formPerfil">
        <div class="perfil-layout">
            <aside class="perfil-avatar-card">
                <img id="avatarPreview" src="<?= esc($avatarUrl) ?>" alt="Avatar">
                <div class="mt-3 mb-1 fw-semibold"><?= esc($nombre_usuario) ?></div>
                <div class="text-secondary small mb-3"><?= esc($usuario) ?></div>
                <div class="avatar-actions">
                    <label class="btn btn-outline-secondary btn-sm mb-0">
                        Cambiar foto
                        <input type="file" name="archivo" id="imagen" accept="image/*" hidden>
                    </label>
                    <div id="fileInfo" class="text-secondary small"></div>
                </div>
            </aside>

            <div class="perfil-form-card">
                <div class="form-section-title">Datos de cuenta</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= esc($nombre_usuario) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="<?= esc($usuario) ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="pass">Contraseña</label>
                        <input type="password" id="pass" name="pass" class="form-control" value="<?= esc($password) ?>">
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-4 pt-3 border-top">
                    <div class="messages text-secondary small"></div>
                    <button type="button" id="actualiz" class="btn btn-archiva">Guardar cambios</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$(function () {
    var fileExtension = '';

    $('#imagen').on('change', function () {
        var input = this;
        if (!input.files || !input.files[0]) return;
        var file = input.files[0];
        fileExtension = file.name.substring(file.name.lastIndexOf('.') + 1);
        $('#fileInfo').text(file.name + ' · ' + Math.round(file.size / 1024) + ' KB');

        if (window.FileReader && isImage(fileExtension)) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#avatarPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    $('#actualiz').on('click', function () {
        var formData = new FormData($('#formPerfil')[0]);
        $('.messages').text('').show();

        $.ajax({
            url: '<?= site_url('login/actualiza_perfil') ?>',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#bloquea').show();
            },
            success: function () {
                $('#bloquea').hide();
                location.reload();
            },
            error: function () {
                $('#bloquea').hide();
                $('.messages').html('<span class="text-danger">Ha ocurrido un error.</span>');
            }
        });
        return false;
    });
});

function isImage(extension) {
    switch (String(extension).toLowerCase()) {
        case 'jpg':
        case 'gif':
        case 'png':
        case 'jpeg':
        case 'webp':
            return true;
        default:
            return false;
    }
}
</script>
