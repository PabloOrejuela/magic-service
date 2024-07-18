<?php

namespace App\Models;

use CodeIgniter\Model;

class VariablesSistemaModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'variables_sistema';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['variable', 'valor'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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

    function _getAll(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $query = $builder->get();
        if ($query->getResult() != null) {
            // foreach ($query->getResult() as $row) {
            //     $result[] = $row;
            // }
            $result[] = $row;
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

}
