<?php

use App\Models\LoginModel;

if (! function_exists('login_model')) {
    /**
     * Acceso al LoginModel desde vistas (compatibilidad CI3 → CI4).
     */
    function login_model(): LoginModel
    {
        return model(LoginModel::class);
    }
}

if (! function_exists('logged_in')) {
    /**
     * Datos de sesión del usuario autenticado.
     *
     * @return array<string, mixed>|mixed|null
     */
    function logged_in(?string $key = null)
    {
        $data = session()->get('logged_in') ?? [];

        if ($key === null) {
            return $data;
        }

        return $data[$key] ?? null;
    }
}

if (! function_exists('app_brand_name')) {
    /** Nombre visible del sistema. */
    function app_brand_name(): string
    {
        return 'Sitrado';
    }
}

if (! function_exists('app_brand_tagline')) {
    /** Descripción / eslogan del sistema. */
    function app_brand_tagline(): string
    {
        return 'Sistema de Trazabilidad Documental';
    }
}

if (! function_exists('app_logo_path')) {
    /** Ruta absoluta de logo.png en public/, o null si no existe. */
    function app_logo_path(): ?string
    {
        $path = FCPATH . 'logo.png';

        return is_file($path) ? $path : null;
    }
}

if (! function_exists('app_logo_url')) {
    /** URL pública de logo.png, o null si no hay archivo. */
    function app_logo_url(): ?string
    {
        return app_logo_path() !== null ? base_url('logo.png') : null;
    }
}
