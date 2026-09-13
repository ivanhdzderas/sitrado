<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo de usuarios compatible con DataTables del CI3.
 */
class UsuarioModel extends Model
{
    protected $table         = 'usuario';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'nombre', 'pass', 'usuario', 'tipo', 'juntas', 'img', 'plaza',
        'departamento', 'puesto', 'nivel', 'reportes', 'correo', 'asistente', 'ingreso',
    ];

    protected array $column = ['nombre', 'usuario', 'tipo', 'juntas'];
    protected array $order  = ['id' => 'desc'];

    public function findByUsername(string $username): ?array
    {
        $row = $this->asArray()->where('usuario', $username)->first();

        return $row ?: null;
    }

    public function attemptLogin(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);
        if ($user === null) {
            return null;
        }

        $stored = (string) $user['pass'];
        $info   = password_get_info($stored);
        $ok     = false;

        if (($info['algoName'] ?? 'unknown') !== 'unknown') {
            $ok = password_verify($password, $stored);
        } elseif (hash_equals($stored, $password)) {
            $ok = true;
            $this->update($user['id'], ['pass' => password_hash($password, PASSWORD_DEFAULT)]);
        }

        return $ok ? $user : null;
    }

    public function listOrdered(): array
    {
        return $this->asArray()->orderBy('nombre', 'ASC')->findAll();
    }

    public function getSiglas(int $userId): array
    {
        $rows = $this->db->table('responsables')
            ->select('siglas')
            ->where('usuario', $userId)
            ->get()
            ->getResultArray();

        return array_column($rows, 'siglas');
    }

    public function getNiveles(): array
    {
        return $this->db->table('niveles')->get()->getResultArray();
    }

    protected function datatablesBuilder()
    {
        $builder = $this->db->table($this->table);
        $request = service('request');
        $search  = $request->getPost('search')['value'] ?? '';
        $i       = 0;
        $columns = [];

        foreach ($this->column as $item) {
            if ($search !== '') {
                if ($i === 0) {
                    $builder->groupStart()->like($item, $search);
                } else {
                    $builder->orLike($item, $search);
                }
            }
            $columns[$i] = $item;
            $i++;
        }
        if ($search !== '') {
            $builder->groupEnd();
        }

        $order = $request->getPost('order');
        if ($order) {
            $builder->orderBy($columns[$order[0]['column']], $order[0]['dir']);
        } else {
            $builder->orderBy(key($this->order), $this->order[key($this->order)]);
        }

        return $builder;
    }

    public function get_datatables()
    {
        $builder = $this->datatablesBuilder();
        $length  = (int) (service('request')->getPost('length') ?? -1);
        $start   = (int) (service('request')->getPost('start') ?? 0);
        if ($length !== -1) {
            $builder->limit($length, $start);
        }

        return $builder->get()->getResult();
    }

    public function count_filtered()
    {
        return $this->datatablesBuilder()->countAllResults();
    }

    public function count_all()
    {
        return $this->db->table($this->table)->countAllResults();
    }

    public function get_by_id($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get()->getRow();
    }

    public function permisos_id($id)
    {
        return $this->db->table('permisos')->where('usuario', $id)->get()->getResult();
    }

    public function saveUsuario($data)
    {
        $this->db->query(
            'INSERT INTO usuario (nombre, pass, usuario, tipo, juntas, departamento, puesto, nivel, reportes, correo)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['nombre'], $data['pass'], $data['usuario'], $data['tipo'],
                $data['minutas'] ?? 'NO', $data['departamento'] ?? '', $data['puesto'] ?? '',
                $data['nivel'] ?? '', $data['reportes'] ?? 'NO', $data['email'] ?? '',
            ]
        );
        $idusuario = $this->db->insertID();

        if (($data['tipo'] ?? '') === 'empr' && ! empty($data['permisos'])) {
            $empresa = $grupo = $subgrupo = '0';
            foreach ($data['permisos'] as $permiso) {
                $tipo   = substr($permiso, 0, 1);
                $numero = (int) substr($permiso, 1);
                switch ($tipo) {
                    case 'E': $empresa = $numero; break;
                    case 'G': $grupo = $numero; break;
                    case 'S':
                        $subgrupo = $numero;
                        $this->db->query(
                            'INSERT INTO permisos (usuario, empresa, grupo, subgrupo) VALUES (?, ?, ?, ?)',
                            [$idusuario, $empresa, $grupo, $subgrupo]
                        );
                        $empresa = $grupo = $subgrupo = '0';
                        break;
                }
            }
        }

        if (! empty($data['doc']) && is_array($data['doc'])) {
            foreach ($data['doc'] as $key) {
                $this->db->query(
                    'INSERT INTO permisos_documentos (id_documento, id_usuario) VALUES (?, ?)',
                    [$key, $idusuario]
                );
            }
        }

        return $idusuario;
    }

    public function updateUsuario($data)
    {
        $this->db->query(
            'UPDATE usuario SET nombre=?, pass=?, usuario=?, tipo=?, juntas=?, departamento=?, reportes=?, puesto=?, nivel=?, correo=? WHERE id=?',
            [
                $data['nombre'], $data['pass'], $data['usuario'], $data['tipo'],
                $data['minutas'] ?? 'NO', $data['departamento'] ?? '', $data['reportes'] ?? 'NO',
                $data['puesto'] ?? '', $data['nivel'] ?? '', $data['email'] ?? '', $data['id'],
            ]
        );
        $this->db->table('permisos')->where('usuario', $data['id'])->delete();

        if (! empty($data['permisos']) && is_array($data['permisos'])) {
            $empresa = $grupo = $subgrupo = '0';
            foreach ($data['permisos'] as $permiso) {
                $tipo   = substr($permiso, 0, 1);
                $numero = (int) substr($permiso, 1);
                switch ($tipo) {
                    case 'E': $empresa = $numero ?: '0'; break;
                    case 'G': $grupo = $numero ?: '0'; break;
                    case 'S': $subgrupo = $numero; break;
                }
                $this->db->query(
                    'INSERT INTO permisos (usuario, empresa, grupo, subgrupo) VALUES (?, ?, ?, ?)',
                    [$data['id'], $empresa, $grupo, $subgrupo]
                );
                $empresa = $grupo = $subgrupo = '0';
            }
        }

        return true;
    }

    public function delete_by_id($id)
    {
        $this->db->table($this->table)->where('id', $id)->delete();
    }

    public function get_by_id_view($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get()->getResult();
    }
}
