<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'productos';
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

    function _getProducto($id){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where($this->table.'.id', $id);
        //$builder->join('items_productos', $this->table.'.id = items_productos.idproducto');
        //$builder->join('items', 'items_productos.item = items.id');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getPrecioProducto($id){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('precio')->where($this->table.'.id', $id);
        //$builder->join('items_productos', $this->table.'.id = items_productos.idproducto');
        //$builder->join('items', 'items_productos.item = items.id');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

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

    function _getProductos(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select($this->table.'.id as id,producto,idcategoria,estado,categoria');
        $builder->join('categorias', $this->table.'.idcategoria = categorias.id');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getProductosCategoria($idcategoria){
        
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

    public function _insert($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;

        //Inserto el nuevo producto
        $builder = $this->db->table($this->table);
        if ($data['producto'] != 'NULL' && $data['producto'] != '') {
            $builder->set('producto', $data['producto']);
        }

        if ($data['categoria'] != 'NULL' && $data['categoria'] != '') {
            $builder->set('idcategoria', $data['categoria']);
        }

        if ($data['idusuario'] != 'NULL' && $data['idusuario'] != '') {
            $builder->set('idusuario', $data['idusuario']);
        }
        $builder->insert();
        return  $this->db->insertID();
    }
}
