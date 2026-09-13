<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentoModel extends Model
{
    protected $table         = 'documentos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'nombre', 'menu', 'activo', 'descarga', 'submenu', 'estatus',
        'tipo', 'departamento', 'folio', 'fecha', 'rev', 'todos',
    ];

    public function listWithRelations(): array
    {
        return $this->db->table('documentos d')
            ->select('d.id, d.fecha, d.rev, d.nombre, d.estatus, d.descarga, d.departamento, d.tipo, d.activo, m.nombre AS menu, s.nombre AS submenu, e.nombre AS empresa, e.id AS id_empresa')
            ->join('menu m', 'd.menu = m.id', 'left')
            ->join('submenu s', 'd.submenu = s.id', 'left')
            ->join('empresas e', 'm.empresa = e.id', 'left')
            ->orderBy('d.id', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function searchByFolio(string $term): array
    {
        return $this->like('folio', $term)
            ->orLike('nombre', $term)
            ->orderBy('id', 'DESC')
            ->findAll(50);
    }
}
