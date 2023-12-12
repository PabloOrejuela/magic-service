<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'detalle_pedido';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
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
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->set('cantidad', $cantidad);
        $builder->set('subtotal', $subtotal);
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $builder->update();
    }

    public function _eliminarProdDetalle($idproducto, $cod_pedido){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $builder->delete();
    }

    public function _updateProdDetalleObservacion($idproducto, $cod_pedido, $observacion){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->set('observacion', $observacion);
        $builder->where('cod_pedido', $cod_pedido);
        $builder->where('idproducto', $idproducto);
        $builder->update();
    }
}
