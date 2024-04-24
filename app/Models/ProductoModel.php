<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DateTime;

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
        $builder->select($this->table.'.id as id,producto,idcategoria,estado,categoria,'.$this->table.'.updated_at, attr_temporal, precio');
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

    function _getProductosTemp(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select("*");
        $builder->where('attr_temporal', 1);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getLastId(){
        $result = 0;
        $builder = $this->db->table($this->table);
        $builder->selectMax('id');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row->id;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getProductoAutocomplete($producto){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->like('producto', $producto);
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

    public function _insertPersonalizado($data) {

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

        if ($data['precio'] != 'NULL' && $data['precio'] != '') {
            $builder->set('precio', $data['precio']);
        }

        if ($data['image'] != 'NULL' && $data['image'] != '') {
            $builder->set('image', $data['image']);
        }

        if ($data['arreglo_temporal'] != 'NULL' && $data['arreglo_temporal'] != '') {
            $builder->set('attr_temporal', $data['arreglo_temporal']);
        }

        if ($data['observaciones'] != 'NULL' && $data['observaciones'] != '') {
            $builder->set('observaciones', $data['observaciones']);
        }

        $builder->insert();
        return  $this->db->insertID();
    }

    public function _insertNewProduct($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;

        //Inserto el nuevo producto
        $builder = $this->db->table($this->table);
        if ($data['producto'] != 'NULL' && $data['producto'] != '') {
            $builder->set('producto', $data['producto']);
        }

        if ($data['idcategoria'] != 'NULL' && $data['idcategoria'] != '') {
            $builder->set('idcategoria', $data['idcategoria']);
        }

        if ($data['precio'] != 'NULL' && $data['precio'] != '') {
            $builder->set('precio', $data['precio']);
        }

        if ($data['image'] != 'NULL' && $data['image'] != '') {
            $builder->set('image', $data['image']);
        }

        if ($data['idusuario'] != 'NULL' && $data['idusuario'] != '') {
            $builder->set('idusuario', $data['idusuario']);
        }

        if ($data['observaciones'] != 'NULL' && $data['observaciones'] != '') {
            $builder->set('observaciones', $data['observaciones']);
        }

        $builder->insert();
        return  $this->db->insertID();
    }

    public function _updateProducto($producto) {

        //echo '<pre>'.var_export($producto, true).'</pre>';exit;

        //Inserto el nuevo producto
        $builder = $this->db->table($this->table);
        if ($producto['producto'] != 'NULL' && $producto['producto'] != '') {
            $builder->set('producto', $producto['producto']);
        }

        if ($producto['idusuario'] != 'NULL' && $producto['idusuario'] != '') {
            $builder->set('idusuario', $producto['idusuario']);
        }

        if ($producto['precio'] != 'NULL' && $producto['precio'] != '') {
            $builder->set('precio', $producto['precio']);
        }

        if ($producto['image'] != 'NULL' && $producto['image'] != '') {
            $builder->set('image', $producto['image']);
        }

        if ($producto['observaciones'] != 'NULL' && $producto['observaciones'] != '') {
            $builder->set('observaciones', $producto['observaciones']);
        }

        $builder->where('id', $producto['idproducto']);
        $builder->update();
        return  $this->db->insertID();
    }

    function _desactivaProductosTemporales() {
        $builder = $this->db->table($this->table);
        $now = new \DateTime(date("Y-m-d"));
        $dias = 0;
        $diferencia = 0;

        //Traigo los productos que tienen Attr temporal
        $prodTemporales = $this->_getProductosTemp();

        if ($prodTemporales) {
            foreach ($prodTemporales as $key => $value) {
            
                $fechaActualizacion = new \DateTime(date($value->updated_at));
                $diferencia = date_diff($fechaActualizacion, $now);
                $dias = $diferencia->format('%R%a');
                //echo '<pre>'.var_export($dias, true).'</pre>';exit;
                if ($dias > '+30') {
                    //revisar
                    $builder->set('estado', 0);
                    $builder->where('id', $value->id);
                    $builder->update();
                }
            }
        }
    }
}
