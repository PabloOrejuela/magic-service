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

    function _getSucursales(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(''.$this->table.'.id as idsector, sector, costo_entrega, estado, sucursal, direccion');
        $builder->join('sucursales', 'sucursales.id='.$this->table.'.idsucursal');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _updateSucursalSector($idsector, $sucursal) {

        //Inserto el nuevo cliente
        $builder = $this->db->table($this->table);
        if ($sucursal != 'NULL' && $sucursal != '') {
            $builder->set('idsucursal', $sucursal);
        }
        $builder->where('id', $idsector);
        $builder->update();
    }
}
