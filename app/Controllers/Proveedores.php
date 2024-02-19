<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Proveedores extends BaseController {

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function index(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->proveedores == 1) {
            
            $data['session'] = $this->session;
            $data['proveedores'] = $this->proveedorModel->findAll();

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

        $data = $this->acl();

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

    /**
     * Formulario para editar un nuevo proveedor
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function edit($id) {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->proveedores == 1) {
            
            $data['session'] = $this->session;
            $data['proveedor'] = $this->proveedorModel->find($id);

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Proveedores';
            $data['subtitle']='Registrar Proveedor';
            $data['main_content']='proveedores/form-proveedor-edit';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function insert(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->clientes == 1) {

            $proveedor = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'celular_contacto' => strtoupper($this->request->getPostGet('celular_contacto')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'contacto' => strtoupper($this->request->getPostGet('contacto')),
            ];

            $this->validation->setRuleGroup('proveedor');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($proveedor, true).'</pre>';exit;

                //Inserto el nuevo cliente
                $this->proveedorModel->insert($proveedor);
                return redirect()->to('proveedores');
            }
        }else{

            $this->logout();
        }
    }

    public function update(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->clientes == 1) {
            $id = $this->request->getPostGet('id');
            $proveedor = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'celular_contacto' => strtoupper($this->request->getPostGet('celular_contacto')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'contacto' => strtoupper($this->request->getPostGet('contacto')),
            ];

            $this->validation->setRuleGroup('proveedor');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($proveedor, true).'</pre>';exit;

                //Inserto el nuevo cliente
                $this->proveedorModel->update($id, $proveedor);
                return redirect()->to('proveedores');
            }
        }else{

            $this->logout();
        }
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
