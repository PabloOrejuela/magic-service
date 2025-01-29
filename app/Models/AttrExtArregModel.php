<?php

namespace App\Models;

use CodeIgniter\Model;

class AttrExtArregModel extends Model {

    protected $table            = 'attr_ext_arreg';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'iddetalle','para','celular','mensaje_fresas','peluche','globo','tarjeta',
        'opciones','bebida','huevo','frases_paredes','fotos','complementos'
    ];

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

    public function _getAttrExtArreg($iddetalle, $idcategoria){
        $objeto = false;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('iddetalle', $iddetalle);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $objeto = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $objeto;
    }

    public function _getAttrArreg($iddetalle, $idcategoria){
        $objeto = null;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('iddetalle', $iddetalle);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $objeto = $row;
            }
        }else{
            $objeto = null;
        }

        $res = $this->_isAttrComplete($objeto,  $idcategoria);
        //echo $this->db->getLastQuery();
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
    public function _isAttrComplete($objeto, $idcategoria){
        //verifico para cada categoría si tiene datos en cada campo
        
        if (isset($objeto) && $objeto != NULL) {
            if ($idcategoria == 1) {
                //Arreglo Frutal
                $attrs = array('para','celular','mensaje_fresas','peluche','globo');
                
                if (trim($objeto->para) != '' && trim($objeto->celular) != '' && trim($objeto->mensaje_fresas) != '' && trim($objeto->peluche) != '' && trim($objeto->globo) != '') {
                    return true;
                } else {
                    return false;
                }
                
            }else if ($idcategoria == 2) {
                //Arreglo Floral
                $attrs = array('para','celular','mensaje_fresas','peluche','globo');
                if (trim($objeto->para) != '' && trim($objeto->celular) != '' && trim($objeto->mensaje_fresas) != '' && trim($objeto->peluche) != '' && trim($objeto->globo) != '') {
                    return true;
                } else {
                    return false;
                }
                
            }else if ($idcategoria == 3) {
                //Desayuno Sorpresa
                $attrs = array('para','celular','mensaje_fresas','peluche','globo','bebida','huevo');
                if (trim($objeto->para) != '' && trim($objeto->celular) != '' && trim($objeto->mensaje_fresas) != '' && trim($objeto->peluche) != '' && trim($objeto->globo) != '' && trim($objeto->bebida) != '' && trim($objeto->huevo) != '') {
                    return true;
                } else {
                    return false;
                }
                
            }else if ($idcategoria == 4) {
                //Magic Box
                $attrs = array('para','celular','mensaje_fresas','peluche','globo','frases_paredes','fotos');
                if (trim($objeto->para) != '' && trim($objeto->celular) != '' && trim($objeto->mensaje_fresas) != '' && trim($objeto->peluche) != '' && trim($objeto->globo) != '' && trim($objeto->frases_paredes) != '' && trim($objeto->fotos) != '') {
                    return true;
                } else {
                    return false;
                }
                
            }else if ($idcategoria == 5) {
                //Bocaditos
                $attrs = array('para','celular','opciones');
                if (trim($objeto->para) != '' && trim($objeto->celular) != '' && trim($objeto->opciones) != '') {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
