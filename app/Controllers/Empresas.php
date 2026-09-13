<?php

namespace App\Controllers;

use App\Models\EmpresaModel;

class Empresas extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return $this->render('empresas/index', [
            'empresas' => model(EmpresaModel::class)->listAll(),
        ], 'Empresas');
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        model(EmpresaModel::class)->insert([
            'nombre'     => $this->request->getPost('nombre'),
            'calle'      => $this->request->getPost('calle') ?: '',
            'numero_ext' => $this->request->getPost('numero_ext') ?: '',
            'numero_int' => $this->request->getPost('numero_int') ?: '',
            'colonia'    => $this->request->getPost('colonia') ?: '',
            'ciudad'     => $this->request->getPost('ciudad') ?: '',
            'estado'     => $this->request->getPost('estado') ?: '',
            'cp'         => $this->request->getPost('cp') ?: '',
            'rfc'        => $this->request->getPost('rfc') ?: '',
            'apoderado'  => $this->request->getPost('apoderado') ?: '',
            'logo'       => '',
        ]);

        return redirect()->to('/empresas')->with('success', 'Empresa creada.');
    }

    public function update(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        model(EmpresaModel::class)->update($id, [
            'nombre'     => $this->request->getPost('nombre'),
            'calle'      => $this->request->getPost('calle') ?: '',
            'numero_ext' => $this->request->getPost('numero_ext') ?: '',
            'numero_int' => $this->request->getPost('numero_int') ?: '',
            'colonia'    => $this->request->getPost('colonia') ?: '',
            'ciudad'     => $this->request->getPost('ciudad') ?: '',
            'estado'     => $this->request->getPost('estado') ?: '',
            'cp'         => $this->request->getPost('cp') ?: '',
            'rfc'        => $this->request->getPost('rfc') ?: '',
            'apoderado'  => $this->request->getPost('apoderado') ?: '',
        ]);

        return redirect()->to('/empresas')->with('success', 'Empresa actualizada.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        model(EmpresaModel::class)->delete($id);

        return redirect()->to('/empresas')->with('success', 'Empresa eliminada.');
    }
}
