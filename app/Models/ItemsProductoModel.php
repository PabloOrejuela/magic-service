<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemsProductoModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'items_productos';
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

    public function _insert($idproducto, $data) {

        //echo '<pre>'.var_export($idproducto, true).'</pre>';exit;

        //Inserto el nuevo producto
        $builder = $this->db->table($this->table);

        //recorro el arreglo y grabo 
        foreach ($data as $key => $value) {

            if ($idproducto != 'NULL' && $idproducto != '') {
                $builder->set('idproducto', $idproducto);
            }

            if ($value != 'NULL' && $value != '') {
                $builder->set('item', $key);
            }

            if ($value != 'NULL' && $value != '') {
                $builder->set('cantidad', $value);
            }
            
            $builder->insert();
        }    
    }

    public function _insertItemsPersonalizado($idproducto, $data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;

        //Inserto el nuevo producto
        $builder = $this->db->table($this->table);

        //recorro el arreglo y grabo 
        foreach ($data as $key => $value) {

            if ($idproducto != 'NULL' && $idproducto != '') {
                $builder->set('idproducto', $idproducto);
            }

            if ($value->id != 'NULL' && $value->id != '') {
                $builder->set('item', $value->id);
            }

            if ($value->porcentaje != 'NULL' && $value->porcentaje != '') {
                $builder->set('porcentaje', $value->porcentaje);
            }

            if ($value->cantidad != 'NULL' && $value->cantidad != '') {
                $builder->set('cantidad', 1);
            }
            
            $builder->insert();
        }    
    }

    function _getItemsProducto($idproducto){
        $result = NULL;
        $builder = $this->db->table($this->table);
        //$builder->select('*')->where($this->table.'.idproducto', $idproducto);
        $builder->select(
            'items.id as id, 
            items.item as item, 
            precio, 
            cuantificable,
            porcentaje,
            estado, 
            cantidad,
            '.$this->table.'.idproducto as idproducto');
        $builder->join('items', $this->table.'.item = items.id');
        $builder->where($this->table.'.idproducto', $idproducto);
        //$builder->join('items', 'items_productos.item = items.id');
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
