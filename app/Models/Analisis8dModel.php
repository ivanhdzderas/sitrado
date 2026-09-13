<?php

namespace App\Models;

use CodeIgniter\Model;

class Analisis8dModel extends Model
{
    protected $table         = 'analisis_8d';
    protected $primaryKey    = 'id_8d';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'folio', 'fecha', 'fecha_cierre', 'tipo', 'solicitante', 'problema_detectado',
        'descripcion_problema', 'creado', 'notas', 'estatus', 'efectivo_accion',
        'materia_prima', 'metodos', 'mano_de_obra', 'maquinaria', 'medio_ambiente',
        'causa_raiz', 'lider', 'objetivo', 'presupuesto',
    ];

    public function listWithSolicitante(): array
    {
        return $this->db->table('analisis_8d a')
            ->select('a.folio, a.fecha, a.tipo, a.problema_detectado, a.estatus, u.nombre')
            ->join('usuario u', 'a.solicitante = u.id', 'left')
            ->orderBy('a.folio', 'DESC')
            ->get()
            ->getResultArray();
    }
}
