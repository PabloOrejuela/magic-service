<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoCambiosModel extends Model {

    protected $table            = 'pedido_cambios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idusuario', 'idpedido', 'fecha', 'detalle','created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;

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

    function _getCambiosPedido($idpedido){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(
            $this->table.'.id as id,idpedido,pedido_cambios.idusuario as idusuario,nombre,detalle,'
            .$this->table.'.created_at,'.$this->table.'.updated_at'
        );
        $builder->join('usuarios', $this->table.'.idusuario = usuarios.id');
        $builder->where($this->table.'.idpedido', $idpedido);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getCambioAnterior($idcambio){
        $detalle = $this->find($idcambio);
        if (!$detalle) {
            return null;
        }

        return $this->select(
            $this->table.'.id as id,idproducto,nombre,descripcion,detalle,'
            .$this->table.'.created_at,'.$this->table.'.updated_at,idusuario'
        )   
            ->join('usuarios', $this->table.'.idusuario = usuarios.id')
            ->where('idproducto', $detalle->idproducto)
            ->where($this->table.'.id <', $idcambio)
            ->orderBy($this->table.'.id', 'DESC')
            ->first();
    }
}
