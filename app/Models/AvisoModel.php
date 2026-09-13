<?php

namespace App\Models;

use CodeIgniter\Model;

class AvisoModel extends Model
{
    protected $table         = 'avisos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['mensaje', 'activo'];

    public function listAll(): array
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }

    public function unreadForUser(int $userId): array
    {
        return $this->db->table('avisos a')
            ->select('a.id, a.mensaje')
            ->where('a.activo', 'SI')
            ->where("a.id NOT IN (SELECT aviso FROM visto_avisos WHERE usuario = {$userId})", null, false)
            ->get()
            ->getResultArray();
    }
}
