<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'rol','admin','ventas','clientes',
        'reportes','proveedores','gastos',
        'entregas','inventarios'
    ];

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

    public function _updatePermiso($id, $permiso, $campo){
        $builder = $this->db->table($this->table);
        $builder->set($campo, $permiso);
        $builder->where('id', $id);
        $builder->update();
    }

    function _getPermiso($id, $campo){
        
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('idcategoria', $idcategoria);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }
}
