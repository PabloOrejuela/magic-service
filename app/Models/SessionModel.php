<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model {
     
    protected $table            = 'sessions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['is_logged','ip','agent','idusuario','status'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

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

    function _getLogueados(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where('is_logged', 1);
        $builder->orderBy('nombre', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    //Pasar esta función al modelo de sesiones
    public function _cierraSesiones() {
        $now = date('Y-m-d');
        $fechaCierre = $now.' 00:00:01';
        //echo '<pre>'.var_export($usuarios, true).'</pre>';exit;
        $builder = $this->db->table($this->table);

        $builder->where('updated_at <=', $fechaCierre);
        $builder->set('status', 0);
        $builder->update();
        //echo $this->db->getLastQuery();
    }

}
