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

    public function _update($data) {
        $builder = $this->db->table($this->table);
        if ($data['item'] != 'NULL') {
            $builder->set('item', $data['item']);
        }
        if ($data['precio'] != 'NULL') {
            $builder->set('precio', $data['precio']);
        }

        $builder->where('id', $data['id']);
        $builder->update();
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
