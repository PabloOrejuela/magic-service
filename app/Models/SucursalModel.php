<?php

namespace App\Models;

use CodeIgniter\Model;

class SucursalModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'sucursales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function _insert($data) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        if ($data['sucursal'] != 'NULL' && $data['sucursal'] != '') {
            $builder->set('sucursal', $data['sucursal']);
        }

        if ($data['direccion'] != 'NULL' && $data['direccion'] != '') {
            $builder->set('direccion', $data['direccion']);
        }

        $builder->insert();
        return  $this->db->insertID();
    }

    public function _update($data) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        if ($data['sucursal'] != 'NULL' && $data['sucursal'] != '') {
            $builder->set('sucursal', $data['sucursal']);
        }

        if ($data['direccion'] != 'NULL' && $data['direccion'] != '') {
            $builder->set('direccion', $data['direccion']);
        }
        $builder->where('id', $data['id']);
        $builder->update();
    }
}
