<?php

namespace App\Models;

use CodeIgniter\Model;

class JuntaModel extends Model
{
    protected $table         = 'juntas';
    protected $primaryKey    = 'id_junta';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'tema', 'fecha', 'duracion', 'lugar', 'impartidor', 'asignada',
        'tipo', 'vueltas', 'marcada', 'creador', 'activo',
    ];

    public function listForUser(array $user): array
    {
        $builder = $this->db->table('juntas j')
            ->select('j.id_junta, j.fecha, j.tema, j.lugar, j.duracion, j.impartidor, j.creador, j.activo, j.asignada, u.nombre AS impartidor_nombre')
            ->join('usuario u', 'u.id = j.impartidor', 'left')
            ->where('j.activo', 'SI');

        if (($user['tipo'] ?? '') !== 'admin') {
            $uid = (int) ($user['iduser'] ?? 0);
            $builder->groupStart()
                ->where('j.impartidor', $uid)
                ->orWhere('j.creador', $uid)
                ->orWhere("j.id_junta IN (SELECT id_junta FROM integrantes WHERE id_usuario = {$uid})", null, false)
                ->groupEnd();
        }

        return $builder->orderBy('j.fecha', 'DESC')->get()->getResultArray();
    }
}
