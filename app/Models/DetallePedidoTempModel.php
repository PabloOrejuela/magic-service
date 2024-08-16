<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoTempModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'detalle_pedido_temp';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['cod_pedido','idproducto','cantidad','precio','pvp','subtotal','observacion','created_at','updated_at'];

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

    public function _deleteDetallesTempOld(){
        $ayer = date('Y-m-d', time() - 60 * 60 * 24);
        
        $builder = $this->db->table($this->table);
        $builder->where('created_at <=', $ayer);
        $builder->delete();
        // echo $this->db->getLastQuery();
    }

    public function _getProdDetallePedido($idproducto, $cod_pedido){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $result = $builder->get()->getRow();
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _getDetallePedido($cod_pedido){
        //echo '<pre>'.var_export($cod_pedido, true).'</pre>';exit;
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->join('productos', 'productos.id = '.$this->table.'.idproducto');
        $builder->where('cod_pedido', $cod_pedido);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _updateProdDetalle($idproducto, $cod_pedido, $cantidad, $subtotal){
        
        $builder = $this->db->table($this->table);
        $builder->set('cantidad', $cantidad);
        $builder->set('subtotal', $subtotal);
        $builder->set('updated_at', date('Y-m-d H:m:s'));
        //$builder->set('precio', $precio);
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $builder->update();
    }

    public function _eliminarProdDetalle($idproducto, $cod_pedido){
        
        $builder = $this->db->table($this->table);
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $builder->delete();
    }

    public function _updateProdDetalleObservacion($idproducto, $cod_pedido, $observacion){
        
        $builder = $this->db->table($this->table);
        $builder->set('observacion', $observacion);
        $builder->set('updated_at', date('Y-m-d H:m:s'));
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $builder->update();
    }

    public function _updateProdDetallePrecio($idproducto, $cod_pedido, $precio, $subtotal){
        
        $builder = $this->db->table($this->table);
        $builder->set('pvp', $precio);
        $builder->set('subtotal', $subtotal);
        $builder->set('updated_at', date('Y-m-d H:m:s'));
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $builder->update();
    }

    
}
