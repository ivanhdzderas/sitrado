<div class="card-soft" style="max-width:640px">
    <h2 class="h5 mb-3">Mi perfil</h2>
    <?= form_open('perfil') ?>
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input class="form-control" name="nombre" value="<?= esc($usuario['nombre'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input class="form-control" value="<?= esc($usuario['usuario'] ?? '') ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input class="form-control" name="correo" value="<?= esc($usuario['correo'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Puesto</label>
            <input class="form-control" name="puesto" value="<?= esc($usuario['puesto'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" name="password" placeholder="Dejar vacío para no cambiar">
        </div>
        <button class="btn btn-brand">Guardar cambios</button>
    <?= form_close() ?>
</div>
