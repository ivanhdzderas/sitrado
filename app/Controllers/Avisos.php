<?php

namespace App\Controllers;

use App\Models\AvisoModel;

class Avisos extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return $this->render('avisos/index', [
            'avisos' => model(AvisoModel::class)->listAll(),
        ], 'Avisos');
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        model(AvisoModel::class)->insert([
            'mensaje' => $this->request->getPost('mensaje'),
            'activo'  => 'SI',
        ]);

        return redirect()->to('/avisos')->with('success', 'Aviso creado.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        model(AvisoModel::class)->update($id, ['activo' => 'NO']);

        return redirect()->to('/avisos')->with('success', 'Aviso desactivado.');
    }
}
