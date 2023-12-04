<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Gastos extends BaseController {
    
    public function index(){
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->gastos == 1) {
            
            $data['session'] = $this->session;
            $data['gastos'] = $this->gastoModel->_getGastos();

            //echo '<pre>'.var_export($data['gastos'], true).'</pre>';exit;
            $data['title']='Gastos';
            $data['subtitle']='Gastos';
            $data['main_content']='gastos/grid_gastos';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    /**
     * Formulario para crear un nuevo GASTO
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
            $data['sucursales'] = $this->sucursalModel->findAll();
            $data['negocios'] = $this->negocioModel->findAll();
            $data['proveedores'] = $this->proveedorModel->findAll();
            $data['tipos_gasto'] = $this->tipoGastoModel->findAll();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Gastos';
            $data['subtitle']='Registrar Gasto';
            $data['main_content']='gastos/form-gasto-new';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function insert(){
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

        if ($data['logged'] == 1 && $this->session->clientes == 1) {

            $gasto = [
                'idsucursal' => strtoupper($this->request->getPostGet('sucursal')),
                'idnegocio' => strtoupper($this->request->getPostGet('negocio')),
                'idproveedor' => strtoupper($this->request->getPostGet('proveedor')),
                'idtipogasto' => strtoupper($this->request->getPostGet('tipo')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'valor' => strtoupper($this->request->getPostGet('valor')),
            ];

            $this->validation->setRuleGroup('gasto');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($gasto, true).'</pre>';exit;

                //Inserto el nuevo cliente
                $this->gastoModel->insert($gasto);
                return redirect()->to('gastos');
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