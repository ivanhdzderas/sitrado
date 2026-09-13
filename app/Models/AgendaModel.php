<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table         = 'pendientes';
    protected $primaryKey    = 'id_pendiente';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['titulo', 'tema', 'fecha', 'f_fin', 'activo', 'usuario'];

    public function forUser(int $userId): array
    {
        return $this->where('activo', 'SI')
            ->where('usuario', $userId)
            ->orderBy('fecha', 'ASC')
            ->findAll();
    }
}
