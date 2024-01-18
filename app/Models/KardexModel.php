<?php

namespace App\Models;

use CodeIgniter\Model;

class KardexModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'kardex_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['item', 'movimiento','unidades','observacion'];

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

    function _getSumaStockItem($item){
        $result = 0;
        $builder = $this->db->table($this->table);
        $builder->selectSum('unidades', 'totalUnidades')->where('item', $item);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row->totalUnidades;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _insert($data) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        $builder->set('item', $data['item']);
        $builder->set('movimiento', $data['movimiento']);
        if ($data['movimiento'] != 1 && $data['movimiento'] != 5) {
            $data['unidades'] = $data['unidades'] * -1;
        } 
        $builder->set('unidades', $data['unidades']);
        $builder->set('observacion', $data['observacion']);
        $builder->insert();
        return  $this->db->insertID();
    }
}
