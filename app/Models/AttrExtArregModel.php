<?php

namespace App\Models;

use CodeIgniter\Model;

class AttrExtArregModel extends Model {

    protected $table            = 'attr_ext_arreg';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'iddetalle','para','celular','mensaje_fresas','peluche','globo','tarjeta',
        'opciones','bebida','huevo','frases_paredes','fotos'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
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

    public function _getAttrExtArreg($iddetalle){
        $result = false;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('iddetalle', $iddetalle);
        $query = $builder->get();
        if ($query->getResult() != null) {
            $result = true;
        }
        //echo $this->db->getLastQuery();
        return $result;
    }
}
