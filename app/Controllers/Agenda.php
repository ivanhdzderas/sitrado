<?php

namespace App\Controllers;

use App\Models\AgendaModel;

class Agenda extends BaseController
{
    public function index()
    {
        return $this->render('agenda/index', [
            'agenda' => model(AgendaModel::class)->forUser((int) $this->user['iduser']),
        ], 'Agenda personal');
    }

    public function store()
    {
        model(AgendaModel::class)->insert([
            'titulo'  => $this->request->getPost('titulo'),
            'tema'    => $this->request->getPost('titulo'),
            'fecha'   => $this->request->getPost('fecha'),
            'f_fin'   => $this->request->getPost('f_fin') ?: $this->request->getPost('fecha'),
            'activo'  => 'SI',
            'usuario' => (int) $this->user['iduser'],
        ]);

        return redirect()->to('/agenda')->with('success', 'Evento agregado.');
    }
}
