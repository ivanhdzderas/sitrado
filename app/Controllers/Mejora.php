<?php

namespace App\Controllers;

use App\Models\MejoraModel;

class Mejora extends BaseController
{
    public function index()
    {
        return $this->render('mejora/index', [
            'mejoras' => model(MejoraModel::class)->listWithSolicitante(),
        ], 'Mejora continua');
    }
}
