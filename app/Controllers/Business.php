<?php

namespace App\Controllers;

use App\Models\BusinessModel;

class Business extends BaseController
{
    public function index()
    {
        return $this->render('business/index', [
            'business' => model(BusinessModel::class)->listWithSolicitante(),
        ], 'Business Case');
    }
}
