<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model {

    protected $DBGroup          = 'default';
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre',
        'user',
        'telefono',
        'email',
        'direccion',
        'password',
        'cedula',
        'idroles',
        'logged',
        'ip',
        'estado',
        'inventarios'
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

    function _getUsuario($usuario){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(
            'usuarios.id as id,nombre,user,telefono,email,password,cedula,idroles,logged,rol,admin,ventas,clientes,proveedores,reportes,gastos,inventarios'
        )->where('user', $usuario['user'])->where('password', md5($usuario['password']));
        $builder->join('roles', 'roles.id=usuarios.idroles');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getAllUsers(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select(
            'usuarios.id as id,nombre,user,telefono,email,password,cedula,idroles,logged,rol,admin,ventas,proveedores,reportes,rol,direccion,estado'
        );
        $builder->join('roles', 'roles.id=usuarios.idroles');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getUsuariosRol($idrol){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where('idroles', $idrol);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _updateLoggin($usuario){
        //echo '<pre>'.var_export($usuario, true).'</pre>';exit;
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->set('logged', $usuario['logged']);
        $builder->set('ip', $usuario['ip']);
        $builder->where('id', $usuario['id']);
        $builder->update();
    }

    function _getLogStatus($id){
        $result = NULL;
        $builder = $this->db->table('usuarios');
        $builder->select('logged')->where('id', $id);
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row->logged;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _closeSession($usuario){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->set('logged', 0);
        $builder->set('ip', NULL);
        $builder->where('id', $usuario['id']);
        $builder->update();
    }

    function _signOff ($id){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $this->db->transStart();
        $builder->set('logged', 0);
        $builder->set('ip', NULL);
        $builder->where('id', $id);
        $builder->update();
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return 0;
        }else{
            return 1;
        }
    }

    public function _insert($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        $builder = $this->db->table($this->table);
        $this->db->transStart();
        $builder->set('nombre', $data['nombre']);
        $builder->set('user', $data['user']);
        $builder->set('password', md5($data['password']));
        $builder->set('telefono', $data['telefono']);
        $builder->set('email', $data['email']);
        $builder->set('cedula', $data['cedula']);
        $builder->set('direccion', $data['direccion']);
        $builder->set('idroles', $data['idroles']);

        $builder->insert();
        //echo $this->db->getLastQuery();
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            echo log_message();
        }
        //return  $this->db->insertID();
    }

    public function _update($data) {

        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        $builder = $this->db->table($this->table);
        $this->db->transStart();
        $builder->set('nombre', $data['nombre']);
        $builder->set('user', $data['user']);
        if ($data['password'] != null && $data['password'] != '') {
            $builder->set('password', md5($data['password']));
        }
        
        $builder->set('telefono', $data['telefono']);
        $builder->set('email', $data['email']);
        $builder->set('cedula', $data['cedula']);
        $builder->set('direccion', $data['direccion']);
        $builder->set('idroles', $data['idroles']);
        $builder->where('id', $data['id']);
        $builder->update();
        //echo $this->db->getLastQuery();
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            echo log_message();
        }
        //return  $this->db->insertID();
    }

    public function _cierraSesiones($usuarios) {

        //echo '<pre>'.var_export($usuarios, true).'</pre>';exit;
        // $builder = $this->db->table($this->table);
        // $this->db->transStart();
        // $builder->set('nombre', $data['nombre']);
        // $builder->set('user', $data['user']);
        // if ($data['password'] != null && $data['password'] != '') {
        //     $builder->set('password', md5($data['password']));
        // }
        
        // $builder->set('telefono', $data['telefono']);
        // $builder->set('email', $data['email']);
        // $builder->set('cedula', $data['cedula']);
        // $builder->set('direccion', $data['direccion']);
        // $builder->set('idroles', $data['idroles']);
        // $builder->where('id', $data['id']);
        // $builder->update();
        // //echo $this->db->getLastQuery();
        // $this->db->transComplete();
        // if ($this->db->transStatus() === false) {
        //     echo log_message();
        // }
        return  1;
    }
}
