<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Proveedores extends BaseController {

    public function index(){
        
        if ($this->session->proveedores == 1) {
            
            $data['session'] = $this->session;
            $data['proveedores'] = $this->proveedorModel->findAll();

            //echo '<pre>'.var_export($data['vendedores'], true).'</pre>';exit;
            $data['title']='Proveedores';
            $data['subtitle']='Proveedores';
            $data['main_content']='proveedores/grid_proveedores';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
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

        if ($this->session->proveedores == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Proveedores';
            $data['subtitle']='Registrar Proveedor';
            $data['main_content']='proveedores/form-proveedor-new';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
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

        if ($this->session->proveedores == 1) {
            
            $data['session'] = $this->session;
            $data['proveedor'] = $this->proveedorModel->find($id);
            $data['negocios'] = $this->negocioModel->findAll();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Proveedores';
            $data['subtitle']='Registrar Proveedor';
            $data['main_content']='proveedores/form-proveedor-edit';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function insert(){

        if ($this->session->clientes == 1) {

            $proveedor = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'celular_contacto' => strtoupper($this->request->getPostGet('celular_contacto')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'contacto' => strtoupper($this->request->getPostGet('contacto')),
                'idnegocio' => strtoupper($this->request->getPostGet('negocio')),
            ];

            $this->validation->setRuleGroup('proveedor');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($proveedor, true).'</pre>';exit;

                //Inserto el nuevo proveedor
                $this->proveedorModel->insert($proveedor);
                return redirect()->to('proveedores');
            }
        }else{

            return redirect()->to('logout');
        }
    }

    public function update(){
        
        if ($this->session->clientes == 1) {
            $id = $this->request->getPostGet('id');
            $proveedor = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'celular_contacto' => strtoupper($this->request->getPostGet('celular_contacto')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'contacto' => strtoupper($this->request->getPostGet('contacto')),
                'idnegocio' => strtoupper($this->request->getPostGet('negocio')),
            ];

            $this->validation->setRuleGroup('proveedor');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($proveedor, true).'</pre>';exit;

                //Actualizo el proveedor
                $this->proveedorModel->update($id, $proveedor);
                return redirect()->to('proveedores');
            }
        }else{

            return redirect()->to('logout');
        }
    }
    
    public function getProveedoresByNegocio($idnegocio){
        $proveedores = $this->proveedorModel->where('idnegocio', $idnegocio)->findAll();
        return $this->response->setJSON($proveedores);
    }
}
