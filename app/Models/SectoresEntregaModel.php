<?php

namespace App\Models;

use CodeIgniter\Model;

class SectoresEntregaModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'sectores_entrega';
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

    function _getSectores(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(''.$this->table.'.id as idsector, sector, costo_entrega, estado, sucursal, direccion, idsucursal');
        $builder->join('sucursales', 'sucursales.id='.$this->table.'.idsucursal');
        $builder->orderBy('sector', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _updateSucursalSector($idsector, $sucursal, $costo_entrega) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        if ($sucursal != 'NULL' && $sucursal != '') {
            $builder->set('idsucursal', $sucursal);
        }

        if ($costo_entrega != 'NULL' && $costo_entrega != '') {
            $builder->set('costo_entrega', $costo_entrega);
        }

        $builder->where('id', $idsector);
        $builder->update();
    }
}
