<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyectoModel extends Model
{
    protected $table         = 'proyecto';
    protected $primaryKey    = 'id_proyecto';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'nombre_proyecto', 'capitan', 'subcapitan', 'f_inicio', 'f_fin', 'patrocinador', 'pendiente',
    ];

    public function listWithLeaders(): array
    {
        return $this->db->table('proyecto p')
            ->select('p.*, c.nombre AS capitan_nombre, s.nombre AS subcapitan_nombre')
            ->join('usuario c', 'c.id = p.capitan', 'left')
            ->join('usuario s', 's.id = p.subcapitan', 'left')
            ->orderBy('p.id_proyecto', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function listForUser(int $userId): array
    {
        return $this->db->query(
            "SELECT DISTINCT p.id_proyecto, p.nombre_proyecto, p.f_inicio, p.f_fin, p.capitan, p.subcapitan, p.pendiente,
                    c.nombre AS capitan_nombre
             FROM subproyecto sp
             INNER JOIN proyecto p ON sp.id_proyecto = p.id_proyecto
             LEFT JOIN consultores co ON co.folio_proyecto = sp.id_subproyecto
             LEFT JOIN informados i ON i.folio_proyecto = sp.id_subproyecto
             LEFT JOIN usuario c ON c.id = p.capitan
             WHERE (sp.id_usuario = ? OR sp.responsable = ? OR p.capitan = ? OR p.subcapitan = ?
                    OR co.id_usuario = ? OR i.id_usuario = ?)
               AND sp.terminado = 'NO'
             ORDER BY p.id_proyecto DESC",
            [$userId, $userId, $userId, $userId, $userId, $userId]
        )->getResultArray();
    }
}
