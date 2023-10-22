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

    public function pedido_insert(){
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

        if ($data['logged'] == 1 && $this->session->ventas == 1) {

            $producto = [
                'idusuario' => $data['id'],
                'producto' => strtoupper($this->request->getPostGet('producto')),
                'categoria' => strtoupper($this->request->getPostGet('categoria')),
                'precio' => strtoupper($this->request->getPostGet('precio')),
                'items' => $this->request->getPostGet('items'),
                'elementos' => $this->request->getPostGet('elementos'),
                'cantidad' => $this->request->getPostGet('cantidad'),
            ];
            echo '<pre>'.var_export($producto, true).'</pre>';exit;
            //Inserto el nuevo producto
            $idproducto = $this->productoModel->_insert($producto);
            
            //Recibo el id insertado y hago el insert de los items del producto
            $this->itemsProductoModel->_insert($idproducto, $producto['elementos']);

            return redirect()->to('productos');
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
