<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc(app_brand_name()) ?> · Acceso</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Literata:opsz,wght@7..72,600;7..72,700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/archiva.css') ?>" rel="stylesheet">
</head>
<body>
<div class="archiva-login">
    <div class="archiva-login-panel">
        <?php if ($logoUrl = app_logo_url()): ?>
            <img src="<?= esc($logoUrl) ?>" alt="<?= esc(app_brand_name()) ?>" class="archiva-login-logo">
        <?php endif; ?>
        <h1 class="brand"><?= esc(app_brand_name()) ?></h1>
        <p class="lede"><?= esc(app_brand_tagline()) ?></p>

        <?php if (! empty($error_message)): ?>
            <div class="alert alert-danger py-2"><?= esc($error_message) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?= form_open('login/user_login_process') ?>
            <div class="mb-3">
                <label class="form-label" for="username">Usuario</label>
                <input type="text" class="form-control form-control-lg" id="username" name="username" required autofocus autocomplete="username">
            </div>
            <div class="mb-4">
                <label class="form-label" for="password">Contraseña</label>
                <input type="password" class="form-control form-control-lg" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn btn-archiva btn-lg w-100">Ingresar</button>
        <?= form_close() ?>
    </div>
</div>
</body>
</html>
