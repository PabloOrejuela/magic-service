<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Inventarios extends BaseController {

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function index(){
        $data = $this->acl();
        
        if ($data['logged'] == 1 && $this->session->inventarios == 1) {
            
            $data['session'] = $this->session;
            $data['items'] = $this->itemModel->_getItemsCuantificables();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Inventarios';
            $data['subtitle']='Gestión de Inventarios';
            $data['main_content']='inventarios/frm_gestion_inventarios';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    function get_item_cuantificable(){
        $name = $this->request->getPostGet('name');
        $items = $this->itemModel->_getItemCuantificable($name);
        
        echo json_encode($items);
    }

    public function logout(){
        //destruyo la session  y salgo
        
        $user = [
            'id' => $this->session->idusuario,
            'logged' => 0,
            'ip' => 0
        ];
        //echo '<pre>'.var_export($user, true).'</pre>';exit;
        $this->usuarioModel->_updateLoggin($user);
        $this->session->destroy();
        return redirect()->to('/');
    }
}
