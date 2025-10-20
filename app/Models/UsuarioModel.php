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
        'idrol_2',
        'estado',
        'inventarios',
        'es_vendedor'
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
            'usuarios.id as id,nombre,user,telefono,email,password,cedula,idroles,rol,admin,ventas,clientes,proveedores,reportes,gastos,inventarios,estado'
        )->where('user', $usuario['user'])->where('estado', 1);
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
            'usuarios.id as id,nombre,user,telefono,email,password,cedula,idroles,rol,idrol_2,admin,ventas,proveedores,reportes,direccion,es_vendedor,estado'
        );
        $builder->join('roles', 'roles.id=usuarios.idroles');
        $builder->orderBy('nombre', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result[] = $row;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getNombreUsuario($id){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('nombre')->where('id', $id);
        $builder->orderBy('nombre', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                $result = $row->nombre;
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    function _getUsuariosRol($idrol){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where('idroles', $idrol)->orwhere('es_vendedor',1)->where('estado', 1);
        $builder->orderBy('nombre', 'asc');
        $query = $builder->get();
        if ($query->getResult() != null) {
            foreach ($query->getResult() as $row) {
                if ($row->estado == 1) {
                    $result[] = $row;
                }
                
            }
        }
        //echo $this->db->getLastQuery();
        return $result;
    }

    //Pasar esta función al modelo de sesiones
    function _updateLoggin($usuario){
        //echo '<pre>'.var_export($usuario, true).'</pre>';exit;
        $result = NULL;
        $builder = $this->db->table($this->table);
        //$builder->set('logged', $usuario['logged']);
        $builder->set('ip', $usuario['ip']);
        $builder->where('id', $usuario['id']);
        $builder->update();
    }

    //Pasar esta función al modelo de sesiones
    function _closeSession($usuario){
        $result = NULL;
        $builder = $this->db->table($this->table);
        //$builder->set('logged', 0);
        $builder->set('ip', NULL);
        $builder->where('id', $usuario['id']);
        $builder->update();
    }

    //Pasar esta función al modelo de sesiones
    function _signOff ($id){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $this->db->transStart();
        //$builder->set('logged', 0);
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
        $builder->set('password', $data['password']);
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
            $builder->set('password', $data['password']);
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
}
