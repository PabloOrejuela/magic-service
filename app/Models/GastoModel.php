<?php

namespace App\Models;

use CodeIgniter\Model;

class GastoModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'gastos';
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

    function _getGastos(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('valor,'.$this->table.'.documento as documento,sucursal,negocio,proveedores.nombre as proveedor,tipo_gasto,fecha,'.$this->table.'.id as id');
        $builder->join('sucursales', 'sucursales.id='.$this->table.'.idsucursal');
        $builder->join('negocios', 'negocios.id='.$this->table.'.idnegocio');
        $builder->join('proveedores', 'proveedores.id='.$this->table.'.idproveedor', 'left');
        $builder->join('tipos_gasto', 'tipos_gasto.id='.$this->table.'.idtipogasto', 'left');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getGastosTipoGasto($tipoGasto, $idnegocio, $fechaInicio, $fechaFinal){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('valor,'.$this->table.'.documento as documento,sucursal,negocio,proveedores.nombre as proveedor,tipo_gasto,fecha,'.$this->table.'.id as id, gasto_fijo,detalleGastoVariable');
        $builder->join('sucursales', 'sucursales.id='.$this->table.'.idsucursal');
        $builder->join('negocios', 'negocios.id='.$this->table.'.idnegocio');
        $builder->join('proveedores', 'proveedores.id='.$this->table.'.idproveedor','left');
        $builder->join('gastos_fijos', 'gastos_fijos.id='.$this->table.'.gastofijo','left');
        $builder->join('tipos_gasto', 'tipos_gasto.id='.$this->table.'.idtipogasto');
        $builder->where('idtipogasto', $tipoGasto);
        $builder->where("fecha BETWEEN '$fechaInicio' AND '$fechaFinal'", NULL, FALSE );
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        // echo $this->db->getLastQuery();
        return $result;
    }
}
