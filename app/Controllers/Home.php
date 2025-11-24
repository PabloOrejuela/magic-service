<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Home extends BaseController {

    public function index() {

        if ($this->session->ventas == 1) {
            
            $data['session'] = $this->session;

            /*
             * Verificar si hay productos temporales con mas de 30 días de haber sido creados y los desactiva
             */
            $this->productoModel->_desactivaProductosTemporales();

            //Borro todos los items de la tabla items temporales insertados hasta el día anterior
            $this->itemsProductoTempModel->_deleteItemsTempOld();
            
            /*
             * Cierro todas las que estén abiertas y no se hayan creado ese día
             * desde las 00:00:01
             */
            $this->sessionModel->_cierraSesiones();

            return redirect()->to('pedidos');
        }else{
            $this->logout();
        }
    }

    public function getClientIp() {
        $ip = null;

        // Lista de cabeceras comunes que podrían contener la IP real
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $key) {
            if (!empty($_SERVER[$key])) {
                $ipList = explode(',', $_SERVER[$key]); // puede haber varias IPs separadas por comas
                foreach ($ipList as $ipCandidate) {
                    $ipCandidate = trim($ipCandidate);
                    // Validar que sea una IP pública válida
                    if (filter_var(
                        $ipCandidate,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                    )) {
                        return $ipCandidate;
                    }
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
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

            $ip = $this->getClientIp();
            $agent = $_SERVER['HTTP_USER_AGENT'];

            $estado = $this->estadoSistema();
            
            if ($estado[0]->estado == 0) {
                return redirect()->to('mantenimiento');
            }else{

                if (isset($usuario) && $usuario != NULL && password_verify($data['password'], $usuario->password)) {
                    //valido el login y pongo el id en sesion  && $usuario->id != 1 
                    
                    $iduser = $usuario->id;

                    $this->session->version = $this->configuracionModel->findAll();

                    //CREO LA SESION NUEVA EN LA TABLA DE SESIONES
                    $session = [
                        'is_logged' => 1,
                        'ip' => $ip,
                        'agent' => $agent,
                        'status' => 1,
                        'idusuario' => $iduser,
                    ];

                    $idsession = $this->sessionModel->insert($session);

                    $sessiondata = [
                        //'is_logged' => 1,
                        'id' => $usuario->id,
                        'nombre' => $usuario->nombre,
                        'idroles' => $usuario->idroles,
                        'rol' => $usuario->rol,
                        'cedula' => $usuario->cedula,
                        'admin' => $usuario->admin,
                        'ventas' => $usuario->ventas,
                        'clientes' => $usuario->clientes,
                        'proveedores' => $usuario->proveedores,
                        'gastos' => $usuario->gastos,
                        'reportes' => $usuario->reportes,
                        'inventarios' => $usuario->inventarios,
                        'ip' => $ip,
                        'is_logged' => $session['is_logged'],
                        'agent' => $agent,
                        'status' => $session['status'],
                        'idsession' => $idsession,
                        'codigo_pedido' => ''
                    ];
                    //echo '<pre>'.var_export($sessiondata, true).'</pre>';exit;
                    $this->session->set($sessiondata);
            
                    return redirect()->to('inicio');

                }else{
                    $this->session->setFlashdata('mensaje', $data);
                    //$this->logout();
                    return redirect()->back()->with('mensaje', 'Hubo un problema, no puede ingresar al sistema, puede deberse a: Usuario / contraseña incorrectos o su usuario ha sido desactivado, contacte con el administrador');
                }
            }
        }
        
    }

    public function estadoSistema(){
        return $this->configuracionModel->findAll();
    }
    
    public function logout(){
        //destruyo la session y salgo
        $session = [
            'is_logged' => 0,
            'status' => 0
        ];
        //echo '<pre>'.var_export($user, true).'</pre>';exit;
        if ($this->session->idsession) {
            $this->sessionModel->update($this->session->idsession, $session);
        }
        $this->session->destroy();
        //return redirect()->to('/')->with('mensaje', 'Su sesión ha expirado o se ha logueado en otro equipo.');

        $data['mensaje'] = 'Su sesión ha expirado o se ha cerrado o se ha logueado en otro equipo.';

        // Carga la vista directamente
        $data['title']='Magic Service';
        $data['main_content']='home/login';
        return view('includes/template_login', $data); 
    }
}
