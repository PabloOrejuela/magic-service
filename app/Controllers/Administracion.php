<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Administracion extends BaseController {
    public function index() {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1) {
            
            $data['session'] = $this->session;

            //echo '<pre>'.var_export($data['vendedores'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Administración';
            $data['main_content']='administracion/admin_home';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function productos() {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['productos'] = $this->productoModel->_getProductos();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Productos';
            $data['main_content']='administracion/grid_productos';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }
}
