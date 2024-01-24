<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemsProductoTempModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'items_productos_temp';
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

    function _getItemsProducto($idproducto){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(
            'items.id as id, 
            items.item as item, 
            precio, 
            cuantificable,
            porcentaje,
            estado, 
            cantidad,
            '.$this->table.'.idproducto as idproducto');
        $builder->where($this->table.'.idproducto', $idproducto);
        $builder->join('items', $this->table.'.item = items.id');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _insertItems($idproducto, $items, $item){
        
        $builder = $this->db->table($this->table);
        foreach ($items as $key => $value) {
            //echo $item->id.'<br>';
            $builder->set('item', $value->id);
            $builder->set('idproducto', $idproducto);
            $builder->set('cantidad', 1);
            $builder->insert();
        }
        $builder->set('item', $item);
        $builder->set('idproducto', $idproducto);
        $builder->set('cantidad', 1);
        $builder->insert();
        return  $this->db->insertID();
    }

    function _insertNewItem($idproducto, $item){
        
        $builder = $this->db->table($this->table);
        $builder->set('item', $item);
        $builder->set('idproducto', $idproducto);
        $builder->set('cantidad', 1);
        $builder->insert();
        return  $this->db->insertID();
    }
}
