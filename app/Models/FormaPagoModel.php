<?php

namespace App\Models;

use CodeIgniter\Model;

class FormaPagoModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'formas_pago';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['forma_pago', 'estado'];

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

    public function _updateEstado($data) {
        $builder = $this->db->table($this->table);

        if ($data['estado'] == 1) {
            $builder->set('estado', 0);
        }elseif ($data['estado'] == 0) {
            $builder->set('estado', 1);
        }

        $builder->where('id', $data['id']);
        $builder->update();
    }
}
