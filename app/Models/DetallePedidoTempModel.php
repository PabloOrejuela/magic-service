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
    protected $allowedFields    = ['cod_pedido','idpedido','idproducto','cantidad','precio','pvp','subtotal','observacion','created_at','updated_at'];

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

    public function _getProdDetallePedido($idproducto, $idpedido){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('idpedido', $idpedido);
        $builder->where('idproducto', $idproducto);
        $builder->orderBy('id', 'asc');
        $builder->limit(1);
        $result = $builder->get()->getRow();
        //echo $this->db->getLastQuery();exit;
        return $result;
    }

    /*
    *   Esta tabla se usa para traer el detalle del pedido que está en la tabla temporal, 
    *   Se puede usar el modelo y eliminar está función en el futuro
    */
    // public function _getDetallePedido($idpedido){
    //     //echo '<pre>'.var_export($cod_pedido, true).'</pre>';exit;
    //     $result = NULL;
    //     $builder = $this->db->table($this->table);
    //     $builder->select('*');
    //     $builder->join('productos', 'productos.id = '.$this->table.'.idproducto');
    //     $builder->where('idpedido', $idpedido);
    //     $query = $builder->get();
    //     if ($query->getResult() != null) {
    //         foreach ($query->getResult() as $row) {
    //             $result[] = $row;
    //         }
    //     }
    //     //echo $this->db->getLastQuery();
    //     return $result;
    // }

    public function _updateProdDetalle($idproducto, $idpedido, $cantidad, $subtotal){
        
        $builder = $this->db->table($this->table);
        $builder->set('cantidad', $cantidad);
        $builder->set('subtotal', $subtotal);
        $builder->set('updated_at', date('Y-m-d H:m:s'));
        //$builder->set('precio', $precio);
        $builder->where('idpedido', $idpedido);
        $builder->where('idproducto', $idproducto);
        $res = $builder->update();

        return $res;
    }

    public function _eliminarProdDetalle($idproducto, $idpedido){
        
        $builder = $this->db->table($this->table);
        $builder->where('idpedido', $idpedido);
        $builder->where('idproducto', $idproducto);
        $res = $builder->delete();

        return $res;
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function _delete($detalletemporal){
        $builder = $this->db->table($this->table);
        foreach ($detalletemporal as $key => $detalle) {
            $builder->where('idpedido', $detalle->idpedido);
            $builder->delete();
        }
    }


    public function _eliminarProdsDetalle($idpedido){
        
        $builder = $this->db->table($this->table);
        $builder->where('idpedido', $idpedido);
        $builder->delete();
    }

    public function _updateProdDetalleObservacion($idproducto, $idpedido, $observacion){
        
        $builder = $this->db->table($this->table);
        $builder->set('observacion', $observacion);
        $builder->set('updated_at', date('Y-m-d H:m:s'));
        $builder->where('idpedido', $idpedido);
        $builder->where('idproducto', $idproducto);
        $builder->update();
    }

    public function _updateProdDetallePrecio($idproducto, $idpedido, $precio, $subtotal){
        
        $builder = $this->db->table($this->table);
        $builder->set('pvp', $precio);
        $builder->set('subtotal', $subtotal);
        $builder->set('updated_at', date('Y-m-d H:m:s'));
        $builder->where('idpedido', $idpedido);
        $builder->where('idproducto', $idproducto);
        $builder->update();
    }

    
}
