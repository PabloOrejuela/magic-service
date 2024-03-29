<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [
        'item','precio','estado'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    //protected $deletedField  = 'deleted_at';

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

    function _getItemsCuantificables(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where('cuantificable', 1);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getItemCuantificable($nombre){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->like('item', $nombre);
        $builder->where('cuantificable', 1);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getProductoAutocomplete($item){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->like('item', $item);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    public function _updateEstado($data) {
        $builder = $this->db->table($this->table);

        if ($data['estado'] == 1) {
            $builder->set('estado', 0);
        }elseif ($data['estado'] == 0) {
            $builder->set('estado', 1);
        }

        $builder->where('id', $data['id']);
        $builder->update();
    }

    public function _insert($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        $builder = $this->db->table($this->table);
        $this->db->transStart();
        $builder->set('item', $data['item']);
        $builder->set('precio', $data['precio']);
        $builder->insert();
        //echo $this->db->getLastQuery();
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            echo log_message();
        }
        //return  $this->db->insertID();
    }

    public function _itemDelete($data) {
        $builder = $this->db->table($this->table);

        $builder->set('estado', 0);
        $builder->where('id', $data['id']);
        $builder->update();
    }

}
