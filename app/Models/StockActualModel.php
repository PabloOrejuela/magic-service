<?php

namespace App\Models;

use CodeIgniter\Model;

class StockActualModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'stock_actual';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['item','stock_actual'];

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

    function _getStock($item){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where('item', $item);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _update($data) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        $builder->set('stock_actual', $data['totalUnidades']);
        $builder->where('item', $data['item'] );
        $builder->update();
        return  $this->db->insertID();
    }

    public function _insert($data) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        $builder->set('stock_actual', $data['totalUnidades']);
        $builder->set('item', $data['item'] );
        $builder->insert();
        return  $this->db->insertID();
    }
}
