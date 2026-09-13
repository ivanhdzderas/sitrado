<?php

namespace App\Controllers;

use App\Models\JuntaModel;
use App\Models\UsuarioModel;

class Juntas extends BaseController
{
    public function index()
    {
        return $this->render('juntas/index', [
            'juntas'   => model(JuntaModel::class)->listForUser($this->user),
            'usuarios' => model(UsuarioModel::class)->listOrdered(),
        ], 'Minutas de reunión');
    }

    public function store()
    {
        model(JuntaModel::class)->insert([
            'tema'       => $this->request->getPost('tema'),
            'fecha'      => $this->request->getPost('fecha'),
            'duracion'   => (int) ($this->request->getPost('duracion') ?: 1),
            'lugar'      => $this->request->getPost('lugar') ?: '',
            'impartidor' => (int) $this->request->getPost('impartidor'),
            'asignada'   => 'NO',
            'tipo'       => 'u',
            'vueltas'    => 0,
            'marcada'    => 'NO',
            'creador'    => (int) $this->user['iduser'],
            'activo'     => 'SI',
        ]);

        return redirect()->to('/juntas')->with('success', 'Minuta creada.');
    }
}
