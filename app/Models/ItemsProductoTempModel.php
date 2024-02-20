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
            new_id,
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

    function _getItemsNewProducto($idNew){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(
            'items.id as id, 
            items.item as item, 
            precio_unitario,
            precio_actual,
            pvp,
            cuantificable,
            porcentaje,
            estado,
            new_id,
            cantidad,
            '.$this->table.'.idproducto as idproducto');
        $builder->where($this->table.'.new_id', $idNew);
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

    function _insertItems($idproducto, $items, $item, $idnew){
        
        $builder = $this->db->table($this->table);
        foreach ($items as $key => $value) {
            //echo $item->id.'<br>';
            $builder->set('item', $value->id);
            $builder->set('idproducto', $idproducto);
            $builder->set('new_id', $idnew);
            $builder->set('cantidad', 1);
            $builder->insert();
        }
        $builder->set('item', $item);
        $builder->set('idproducto', $idproducto);
        $builder->set('new_id', $idnew);
        $builder->set('cantidad', 1);
        $builder->insert();
        return  $this->db->insertID();
    }

    function _insertNewItem($idproducto, $item, $idNew){
        
        $builder = $this->db->table($this->table);
        $builder->set('item', $item->id);
        $builder->set('new_id', $idNew);
        $builder->set('idproducto', $idproducto);
        $builder->set('precio_unitario', $item->precio);
        $builder->set('precio_actual', $item->precio);
        $builder->set('pvp', $item->precio);
        $builder->set('porcentaje', 1);
        $builder->set('cantidad', 1);
        $builder->insert();
        return  $this->db->insertID();
    }

    function _insertNewItemTemp($idproducto, $newId, $item){
        
        $builder = $this->db->table($this->table);
        $builder->set('item', $item->id);
        $builder->set('new_id', $newId);
        $builder->set('idproducto', $idproducto);
        $builder->set('precio_unitario', $item->precio);
        $builder->set('precio_actual', $item->precio);
        $builder->set('pvp', $item->precio);
        $builder->set('porcentaje', $item->porcentaje);
        $builder->set('cantidad', 1);
        $builder->insert();
        //sreturn  $this->db->insertID();
    }

    public function _deleteItemsTempOld(){
        $ayer = date('Y-m-d', time() - 60 * 60 * 24);
        $builder = $this->db->table($this->table);
        $builder->where('created_at <=', $ayer);
        $builder->delete();
    }

    function _updateDataItems($data){
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        // $precio = $data['porcentaje']*$data['precio'];
        
        $builder = $this->db->table($this->table);
        $builder->set('porcentaje', $data['porcentaje']);
        $builder->set('precio_unitario', $data['precio_unitario']);
        $builder->set('precio_actual', $data['precio_actual']);
        $builder->set('pvp', $data['pvp']);
        $builder->where('new_id', $data['idNew']);
        $builder->where('item', $data['idItem']);
        $builder->update();
    }

    function _updatePvp($data){
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        // $precio = $data['porcentaje']*$data['precio'];
        
        $builder = $this->db->table($this->table);
        $builder->set('pvp', $data['pvp']);
        $builder->where('new_id', $data['idNew']);
        $builder->where('item', $data['idItem']);
        $builder->update();
    }

    public function _deleteItem($item, $newId){
        $this->db->transStart();
        $builder = $this->db->table($this->table);
        $builder->where('item',$item);
        $builder->where('new_id',$newId);
        $builder->delete();
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        }else{
            return true;
        }
    }

    function _getItemsTempProducto($newId){
        
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(
            'items.id as id, 
            items.item as item, 
            precio, 
            cuantificable,
            porcentaje,
            estado,
            new_id,
            cantidad,
            '.$this->table.'.idproducto as idproducto');
        $builder->where($this->table.'.new_id', $newId);
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
}
