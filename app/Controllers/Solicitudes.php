<?php

namespace App\Controllers;

use App\Models\SolicitudModel;

class Solicitudes extends BaseController
{
    public function index()
    {
        return $this->render('solicitudes/index', [
            'solicitudes' => model(SolicitudModel::class)->listWithSolicitante(),
        ], 'Solicitudes');
    }
}
