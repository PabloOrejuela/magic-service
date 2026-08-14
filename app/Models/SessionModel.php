<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionModel extends Model {
     
    protected $table            = 'sessions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['is_logged','ip','agent','idusuario','status','session_id'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

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

    function _getLogueados(){
        $result = NULL;
        $builder = $this->db->table($this->table);
        $builder->select('*')->where('is_logged', 1);
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

    //Pasar esta función al modelo de sesiones
    public function _cierraSesiones() {

        $now = date('Y-m-d');
        $fechaCierre = $now.' 00:00:01';
        
        $builder = $this->db->table($this->table);

         // Obtener las sesiones que quedaron abiertas de días anteriores
        $sesiones = $builder
            ->where('updated_at <=', $fechaCierre)
            ->where('is_logged', 1)
            ->where('status', 1)
            ->get()
            ->getResult();

        foreach ($sesiones as $sesion) {

            // Archivo físico de la sesión CI4
            $archivoSesion = WRITEPATH . 'session/ci_session' . $sesion->session_id;

            if (is_file($archivoSesion)) {
                unlink($archivoSesion);
            }

            // Marcar la sesión como cerrada
            $builder->set('is_logged', 0);
            $builder->set('status', 0);
            $builder->set('updated_at', date('Y-m-d H:i:s'));
            $builder->where('id', $sesion->id);
            $builder->update();
        }
    }

    function _signOff ($id){
        
        $builder = $this->db->table($this->table);
        $this->db->transStart();

        // Buscar la sesión activa del usuario
        $sesion = $builder
            ->where('idusuario', $id)
            ->where('is_logged', 1)
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$sesion) {
            $this->db->transRollback();
            return 0;
        }

        // Ruta del archivo de sesión de CI4
        $archivoSesion = WRITEPATH . 'session/ci_session' . $sesion->session_id;

        // Destruir el archivo físico de la sesión
        if (is_file($archivoSesion)) {
            unlink($archivoSesion);
        }

        // Marcar la sesión como cerrada
        $builder->set('is_logged', 0);
        $builder->set('status', 0);
        $builder->set('updated_at', date('Y-m-d H:i:s'));
        $builder->where('id', $sesion->id);
        $builder->update();

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return 0;
        }

        return 1;
    }

}
