<?php

namespace App\Models;

use CodeIgniter\Model;

class ChecadorModel extends Model
{
    protected $table         = 'checador';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['usuario', 'fecha', 'hora', 'movimiento'];

    public function registrar(int $userId, string $movimiento): bool
    {
        return $this->insert([
            'usuario'    => $userId,
            'fecha'      => date('Y-m-d'),
            'hora'       => date('H:i:s'),
            'movimiento' => $movimiento,
        ]) !== false;
    }
}
