<?php

namespace App\Controllers;

use App\Models\ProyectoModel;
use App\Models\UsuarioModel;

class Proyectos extends BaseController
{
    public function index()
    {
        $model = model(ProyectoModel::class);
        $lista = $this->isAdmin()
            ? $model->listWithLeaders()
            : $model->listForUser((int) $this->user['iduser']);

        return $this->render('proyectos/index', [
            'proyectos' => $lista,
            'usuarios'  => model(UsuarioModel::class)->listOrdered(),
        ], 'Proyectos');
    }

    public function store()
    {
        model(ProyectoModel::class)->insert([
            'nombre_proyecto' => $this->request->getPost('nombre_proyecto'),
            'capitan'         => (int) $this->request->getPost('capitan'),
            'subcapitan'      => (int) $this->request->getPost('subcapitan'),
            'f_inicio'        => $this->request->getPost('f_inicio') ?: date('Y-m-d'),
            'patrocinador'    => (int) ($this->request->getPost('patrocinador') ?: 0),
            'pendiente'       => 'SI',
        ]);

        return redirect()->to('/proyectos')->with('success', 'Proyecto creado.');
    }
}
