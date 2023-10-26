<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Proveedores extends BaseController {

    public function index(){
        
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->proveedores == 1) {
            
            $data['session'] = $this->session;

            //echo '<pre>'.var_export($data['vendedores'], true).'</pre>';exit;
            $data['title']='Proveedores';
            $data['subtitle']='Proveedores';
            $data['main_content']='proveedores/grid_proveedores';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    /**
     * Formulario para crear un nuevo proveedor
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function create() {

        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->proveedores == 1) {
            
            $data['session'] = $this->session;

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Proveedores';
            $data['subtitle']='Registrar Proveedor';
            $data['main_content']='proveedores/form-proveedor-new';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }
}
