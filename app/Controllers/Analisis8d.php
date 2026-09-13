<?php

namespace App\Controllers;

use App\Models\Analisis8dModel;

class Analisis8d extends BaseController
{
    public function index()
    {
        return $this->render('analisis8d/index', [
            'analisis' => model(Analisis8dModel::class)->listWithSolicitante(),
        ], 'Análisis 8D');
    }
}
