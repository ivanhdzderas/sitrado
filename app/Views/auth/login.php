<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Login') ?> · <?= esc(app_brand_name()) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
</head>
<body>
<div class="login-page">
    <div class="login-card">
        <div class="mb-4">
            <div class="badge-soft mb-2"><?= esc(app_brand_name()) ?></div>
            <h1>Bienvenido</h1>
            <p class="text-muted mb-0"><?= esc(app_brand_tagline()) ?></p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger py-2"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success py-2"><?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>

        <?= form_open('login') ?>
            <div class="mb-3">
                <label class="form-label" for="username">Usuario</label>
                <input type="text" class="form-control form-control-lg" id="username" name="username" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label" for="password">Contraseña</label>
                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-brand btn-lg w-100">Iniciar sesión</button>
        <?= form_close() ?>
    </div>
</div>
</body>
</html>
