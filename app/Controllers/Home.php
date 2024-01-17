<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController {

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function index() {

        $data = $this->acl();
        
        if ($data['logged'] == 1 ) {
            
            $data['session'] = $this->session;
            return redirect()->to('pedidos');
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function validate_login(){
        $data = array(
            'user' => $this->request->getPostGet('user'),
            'password' => $this->request->getPostGet('password'),
        );
        
        $this->validation->setRuleGroup('login');
        
        
        if (!$this->validation->withRequest($this->request)->run()) {
            //Depuración
            //dd($validation->getErrors());
            
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }else{ 

            $usuario = $this->usuarioModel->_getUsuario($data);
            $ip = $_SERVER['REMOTE_ADDR'];
            //echo '<pre>'.var_export($usuario, true).'</pre>';exit;

            $estado = $this->estadoSistema();
            
            if ($estado[0]->estado == 0) {
                return redirect()->to('mantenimiento');
            }else{

                if (isset($usuario) && $usuario != NULL ) {
                    //valido el login y pongo el id en sesion  && $usuario->id != 1 
                    //echo '<pre>'.var_export($this->estadoSistema, true).'</pre>';
                    if ($usuario->logged == 1 ) {
                        //Está logueado así que lo deslogueo
                        $user = [
                            'id' => $usuario->id,
                            'logged' => 0,
                            'ip' => 0
                        ];
                        $this->usuarioModel->update($usuario->id, $user);
                    }
                    
                    $sessiondata = [
                        //'is_logged' => 1,
                        'id' => $usuario->id,
                        'nombre' => $usuario->nombre,
                        'idroles' => $usuario->idroles,
                        'rol' => $usuario->rol,
                        'cedula' => $usuario->cedula,
                        'logged' => $usuario->logged,
                        'rol' => $usuario->rol,
                        'admin' => $usuario->admin,
                        'ventas' => $usuario->ventas,
                        'clientes' => $usuario->clientes,
                        'proveedores' => $usuario->proveedores,
                        'gastos' => $usuario->gastos,
                        'reportes' => $usuario->reportes,
                    ];
            
                    $user = [
                        'id' => $usuario->id,
                        'logged' => 1,
                        'ip' => $ip
                    ];
                    //echo '<pre>'.var_export($user, true).'</pre>';exit;
                    $this->usuarioModel->_updateLoggin($user);
                    $this->session->version = $this->configuracionModel->_getVersion();

                    
                    $this->session->set($sessiondata);
            
                    return redirect()->to('inicio');

                }else{
                    $this->session->setFlashdata('mensaje', $data);
                    //$this->logout();
                    return redirect()->back()->with('mensaje', 'Hubo un error, usuario o contraseña incorrectos');
                }
            }
        }
        
    }

    public function estadoSistema(){
        return $this->configuracionModel->findAll();
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
