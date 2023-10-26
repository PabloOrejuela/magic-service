<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

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

    function _getCliente($documento){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where('documento', $documento);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _insert($data) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        if ($data['nombre'] != 'NULL' && $data['nombre'] != '') {
            $builder->set('nombre', $data['nombre']);
        }

        if ($data['telefono'] != 'NULL' && $data['telefono'] != '') {
            $builder->set('idtelefono', $data['telefono']);
        }

        if ($data['documento'] != 'NULL' && $data['documento'] != '') {
            $builder->set('documento', $data['documento']);
        }
        $builder->insert();
        return  $this->db->insertID();
    }
}
