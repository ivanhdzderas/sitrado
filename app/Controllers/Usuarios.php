<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Usuarios extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return $this->render('usuarios/index', [
            'usuarios' => model(UsuarioModel::class)->listOrdered(),
            'niveles'  => model(UsuarioModel::class)->getNiveles(),
        ], 'Usuarios');
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = [
            'nombre'       => $this->request->getPost('nombre'),
            'usuario'      => $this->request->getPost('usuario'),
            'pass'         => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'tipo'         => $this->request->getPost('tipo') ?: 'empr',
            'juntas'       => $this->request->getPost('juntas') ?: 'NO',
            'img'          => '',
            'plaza'        => (int) ($this->request->getPost('plaza') ?: 0),
            'departamento' => $this->request->getPost('departamento') ?: '',
            'puesto'       => $this->request->getPost('puesto') ?: '',
            'nivel'        => $this->request->getPost('nivel') ?: '',
            'reportes'     => $this->request->getPost('reportes') ?: 'NO',
            'correo'       => $this->request->getPost('correo') ?: '',
            'asistente'    => (int) ($this->request->getPost('asistente') ?: 0),
            'ingreso'      => date('Y-m-d'),
        ];

        model(UsuarioModel::class)->insert($data);

        return redirect()->to('/usuarios')->with('success', 'Usuario creado.');
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = [
            'nombre'       => $this->request->getPost('nombre'),
            'usuario'      => $this->request->getPost('usuario'),
            'tipo'         => $this->request->getPost('tipo'),
            'juntas'       => $this->request->getPost('juntas'),
            'departamento' => $this->request->getPost('departamento'),
            'puesto'       => $this->request->getPost('puesto'),
            'nivel'        => $this->request->getPost('nivel'),
            'reportes'     => $this->request->getPost('reportes'),
            'correo'       => $this->request->getPost('correo'),
        ];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $data['pass'] = password_hash($password, PASSWORD_DEFAULT);
        }

        model(UsuarioModel::class)->update($id, $data);

        return redirect()->to('/usuarios')->with('success', 'Usuario actualizado.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        model(UsuarioModel::class)->delete($id);

        return redirect()->to('/usuarios')->with('success', 'Usuario eliminado.');
    }

    public function perfil()
    {
        $usuario = model(UsuarioModel::class)->find($this->user['iduser']);

        return $this->render('usuarios/perfil', [
            'usuario' => $usuario,
        ], 'Mi perfil');
    }

    public function actualizarPerfil()
    {
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'correo' => $this->request->getPost('correo'),
            'puesto' => $this->request->getPost('puesto'),
        ];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $data['pass'] = password_hash($password, PASSWORD_DEFAULT);
        }

        model(UsuarioModel::class)->update($this->user['iduser'], $data);

        $logged = $this->session->get('logged_in');
        $logged['nombre'] = $data['nombre'];
        $logged['correo'] = $data['correo'];
        $logged['puesto'] = $data['puesto'];
        $this->session->set('logged_in', $logged);

        return redirect()->to('/perfil')->with('success', 'Perfil actualizado.');
    }
}
