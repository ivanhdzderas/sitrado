<?php

namespace App\Models;

use CodeIgniter\Model;

class SolicitudModel extends Model
{
    protected $table         = 'solicitud';
    protected $primaryKey    = 'id_solicitud';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'folio', 'tipo', 'codigo', 'nombre', 'solicitante', 'fecha', 'tiempo', 'especificar',
    ];

    public function listWithSolicitante(): array
    {
        return $this->db->table('solicitud s')
            ->select('s.folio, s.tipo, s.codigo, s.nombre, s.id_solicitud, u.nombre AS solicitante, u.departamento')
            ->join('usuario u', 's.solicitante = u.id', 'left')
            ->orderBy('s.id_solicitud', 'DESC')
            ->get()
            ->getResultArray();
    }
}
