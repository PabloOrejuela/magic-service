<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Ventas extends BaseController {

    public function index() {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['productos'] = $this->productoModel->findAll();
            $data['sectores'] = $this->sectoresEntregaModel->findAll();

            $data['title']='Ordenes y pedidos';
            $data['subtitle']='Nuevo pedido';
            $data['main_content']='ventas/form-pedido';
            return view('dashboard/index', $data);
            
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    function clientes_select(){
        $documento = $this->request->getPostGet('documento');
        $data['clientes'] = $this->clienteModel->_getCliente($documento);
        //$data['clientes'] = $this->clienteModel->findAll();
        echo view('clientes_select', $data);
    }

    function get_valor_producto($producto){
        //$producto = $this->request->getPostGet('producto');
        $data['producto'] = $this->productoModel->_getProducto($producto);
        
        echo view('precio_producto', $data);
    }

    function get_valor_sector($sector){
        //$producto = $this->request->getPostGet('producto');
        $data['sector'] = $this->sectoresEntregaModel->find($sector);
        
        echo view('precio_sector', $data);
    }

    public function pedido_insert(){
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

        if ($data['logged'] == 1 && $this->session->ventas == 1) {

        
            $pedido = [
                'idusuario' => $data['id'],
                'fecha' => $this->request->getPostGet('fecha'),
                //Cliente
                'idcliente' => $this->request->getPostGet('idcliente'),
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                
                'vendedor' => $this->request->getPostGet('vendedor'),
                'producto' => $this->request->getPostGet('producto'),
                'formas_pago' => $this->request->getPostGet('formas_pago'),
                'valor_neto' => $this->request->getPostGet('valor_neto'),
                'descuento' => $this->request->getPostGet('descuento'),
                'transporte' => $this->request->getPostGet('transporte'),
                'total' => $this->request->getPostGet('total'),
                'sectores' => $this->request->getPostGet('sectores'),
                'venta_extra' => $this->request->getPostGet('venta_extra'),
            ];

            //VALIDACIONES
            $this->validation->setRuleGroup('pedido');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                //Codigo del pedido
                $pedido['cod'] = $this->pedidoModel->_makeCodproduct($pedido);

                //Verifico que exista el cliente, si no existe lo creo y si exiete solo inserto el id
                $cliente = $this->clienteModel->find($pedido['idcliente']);
                if ($cliente) {
                    
                    //echo '<pre>'.var_export($pedido, true).'</pre>';exit;
                    //Inserto el nuevo producto
                    $this->pedidoModel->_insert($pedido);

                    return redirect()->to('pedidos');
                }else{
                    //Inserto el cliente nuevo
                    $data = [
                        'nombre' => strtoupper($this->request->getPostGet('nombre')),
                        'documento' => strtoupper($this->request->getPostGet('documento')),
                        'telefono' => strtoupper($this->request->getPostGet('telefono')),
                    ];
                    $pedido['idcliente'] = $this->clienteModel->_insert($data);

                    echo '<pre>'.var_export($producto, true).'</pre>';exit;
                    //Inserto el nuevo pedido
                    $this->pedidoModel->_insert($pedido);

                    return redirect()->to('pedidos');
                }
                
            }
            
        }else{

            $this->logout();
        }
    }

    public function pedidos() {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['pedidos'] = $this->pedidoModel->_getPedidos();
            $data['mensajeros'] = $this->usuarioModel->_getUsuariosRol(5);
            //echo '<pre>'.var_export($data['mensajeros'], true).'</pre>';exit;
            $data['title']='Ventas';
            $data['subtitle']='Pedidos';
            $data['main_content']='ventas/form-pedidos-inicio';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
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
