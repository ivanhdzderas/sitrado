<?php

namespace App\Models;

use CodeIgniter\Model;

class MejoraModel extends Model
{
    protected $table         = 'mejora';
    protected $primaryKey    = 'id_mejora';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'descripcion', 'beneficios', 'fecha', 'solicitante', 'atendido', 'activo',
    ];

    public function listWithSolicitante(): array
    {
        return $this->db->table('mejora m')
            ->select('m.id_mejora, m.fecha, m.atendido, m.activo, m.descripcion, u.nombre')
            ->join('usuario u', 'm.solicitante = u.id', 'left')
            ->orderBy('m.id_mejora', 'DESC')
            ->get()
            ->getResultArray();
    }
}
