<?php

namespace App\Controllers;

use App\Models\ChecadorModel;
use App\Models\UsuarioModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login', [
            'title' => 'Iniciar sesión',
        ]);
    }

    public function attempt()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()->with('error', 'Usuario y contraseña son obligatorios.');
        }

        $usuarios = model(UsuarioModel::class);
        $user     = $usuarios->attemptLogin($username, $password);

        if ($user === null) {
            return redirect()->back()->with('error', 'Credenciales incorrectas.');
        }

        $siglas = $usuarios->getSiglas((int) $user['id']);

        $sessionData = [
            'nombre'       => $user['nombre'],
            'iduser'       => (int) $user['id'],
            'img'          => $user['img'],
            'tipo'         => $user['tipo'],
            'juntas'       => $user['juntas'],
            'usuario'      => $user['usuario'],
            'plaza'        => $user['plaza'],
            'nivel'        => $user['nivel'],
            'reportes'     => $user['reportes'],
            'departamento' => $user['departamento'],
            'puesto'       => $user['puesto'],
            'siglas'       => $siglas,
            'correo'       => $user['correo'] ?? '',
        ];

        model(ChecadorModel::class)->registrar((int) $user['id'], 'ENTRADA');

        $config = db_connect()->table('configuracion')->get()->getRowArray();
        if ($config) {
            $this->session->set('grade', [
                'proyectos' => $config['encargada_proyectos'] ?? null,
            ]);
        }

        $this->session->set('logged_in', $sessionData);

        return redirect()->to('/inicio');
    }

    public function logout()
    {
        $user = $this->session->get('logged_in');

        if ($user && ! empty($user['iduser'])) {
            model(ChecadorModel::class)->registrar((int) $user['iduser'], 'SALIDA');
        }

        $this->session->remove(['logged_in', 'grade']);
        $this->session->destroy();

        return redirect()->to('/login')->with('success', 'Sesión finalizada correctamente.');
    }
}
