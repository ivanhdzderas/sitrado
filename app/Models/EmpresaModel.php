<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo de empresas compatible con DataTables del CI3.
 */
class EmpresaModel extends Model
{
    protected $table         = 'empresas';
    protected $primaryKey    = 'id';
    protected $returnType    = 'object';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'nombre', 'calle', 'numero_ext', 'numero_int', 'colonia',
        'ciudad', 'estado', 'cp', 'rfc', 'apoderado', 'logo',
    ];

    protected array $column = ['nombre', 'calle', 'numero_ext', 'numero_int', 'colonia', 'ciudad', 'estado', 'cp', 'rfc', 'apoderado'];
    protected array $order  = ['id' => 'desc'];

    public function listAll(): array
    {
        return $this->asArray()->orderBy('nombre', 'ASC')->findAll();
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

    public function saveEmpresa($data)
    {
        $exists = $this->db->table($this->table)->where('nombre', $data['nombre'])->countAllResults();
        if ($exists > 0) {
            return false;
        }

        $this->db->table($this->table)->insert([
            'nombre'     => $data['nombre'],
            'calle'      => $data['calle'] ?? '',
            'numero_ext' => $data['numero_ext'] ?? '',
            'numero_int' => $data['numero_int'] ?? '',
            'colonia'    => $data['colonia'] ?? '',
            'ciudad'     => $data['ciudad'] ?? '',
            'estado'     => $data['estado'] ?? '',
            'cp'         => $data['cp'] ?? '',
            'rfc'        => $data['rfc'] ?? '',
            'apoderado'  => $data['apoderado'] ?? '',
            'logo'       => $data['logo'] ?? '',
        ]);

        return $this->db->insertID();
    }

    public function updateEmpresa($where, $data)
    {
        $this->db->table($this->table)->update($data, $where);

        return $this->db->affectedRows();
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
