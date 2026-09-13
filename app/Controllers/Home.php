<?php

namespace App\Controllers;

use App\Models\Analisis8dModel;
use App\Models\AvisoModel;
use App\Models\DocumentoModel;
use App\Models\JuntaModel;
use App\Models\ProyectoModel;
use App\Models\UsuarioModel;

class Home extends BaseController
{
    public function index()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/inicio');
        }

        return redirect()->to('/login');
    }

    public function inicio()
    {
        $stats = [
            'usuarios'   => model(UsuarioModel::class)->countAllResults(),
            'documentos' => model(DocumentoModel::class)->countAllResults(),
            'proyectos'  => model(ProyectoModel::class)->countAllResults(),
            'juntas'     => model(JuntaModel::class)->where('activo', 'SI')->countAllResults(),
            'analisis'   => model(Analisis8dModel::class)->countAllResults(),
            'avisos'     => count(model(AvisoModel::class)->unreadForUser((int) $this->user['iduser'])),
        ];

        return $this->render('dashboard/inicio', [
            'stats' => $stats,
        ], 'Inicio');
    }
}
