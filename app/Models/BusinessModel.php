<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    protected $table         = 'business';
    protected $primaryKey    = 'id_business';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['analisis', 'ventaja', 'fecha', 'seleccion', 'solicito'];

    public function listWithSolicitante(): array
    {
        return $this->db->table('business b')
            ->select('b.id_business, b.fecha, b.analisis, b.ventaja, u.nombre')
            ->join('usuario u', 'b.solicito = u.id', 'left')
            ->orderBy('b.id_business', 'DESC')
            ->get()
            ->getResultArray();
    }
}
