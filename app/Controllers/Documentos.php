<?php

namespace App\Controllers;

use App\Models\DocumentoModel;

class Documentos extends BaseController
{
    public function index()
    {
        return $this->render('documentos/index', [
            'documentos' => model(DocumentoModel::class)->listWithRelations(),
        ], 'Documentos');
    }

    public function buscar()
    {
        $term = trim((string) $this->request->getGet('q'));

        return $this->render('documentos/buscar', [
            'term'       => $term,
            'documentos' => $term !== '' ? model(DocumentoModel::class)->searchByFolio($term) : [],
        ], 'Búsqueda de folio');
    }
}
