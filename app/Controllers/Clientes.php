<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Clientes extends BaseController {

    public function index(){
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->clientes == 1) {
            
            $data['session'] = $this->session;
            $data['clientes'] = $this->clienteModel->_getClientes();

            //echo '<pre>'.var_export($data['vendedores'], true).'</pre>';exit;
            $data['title']='Clientes';
            $data['subtitle']='Gestión de clientes';
            $data['main_content']='clientes/form_lista_clientes';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    /*
    * Recibe info del form y cambia el estado
    *
    * @param Type var post
    * @return void
    * @throws conditon
    * @date 10-10-2023
    */
    public function cliente_delete($id) {
    
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $item = [
                'id' => $id,
            ];
            //echo '<pre>'.var_export($item, true).'</pre>';exit;
            $this->clienteModel->_clienteDelete($item);
            return redirect()->to('clientes');
        }else{

            $this->logout();
        }
    }
}
