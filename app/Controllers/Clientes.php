<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use TCPDF;

class Clientes extends BaseController {

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function index(){

        $data = $this->acl();
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
    
        $data = $this->acl();

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

    /**
     * Formulario para registrar un nuevo cliente
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function cliente_create() {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->clientes == 1) {
            
            $data['session'] = $this->session;

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Clientes';
            $data['subtitle']='Registrar Cliente';
            $data['main_content']='clientes/form-cliente-new';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function cliente_insert(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->clientes == 1) {

            $cliente = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                'telefono_2' => strtoupper($this->request->getPostGet('telefono_2')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'direccion' => strtoupper($this->request->getPostGet('direccion')),
                'email' => $this->request->getPostGet('email'),
            ];

            $this->validation->setRuleGroup('cliente');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($cliente, true).'</pre>';exit;

                //Inserto el nuevo cliente
                $this->clienteModel->insert($cliente);
                return redirect()->to('clientes');
            }
        }else{

            $this->logout();
        }
    }

    /**
     * Formulario para registrar un nuevo cliente
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function cliente_edit($idcliente) {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->clientes == 1) {
            
            $data['session'] = $this->session;
            $data['cliente'] = $this->clienteModel->find($idcliente);

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Clientes';
            $data['subtitle']='Editar Cliente';
            $data['main_content']='clientes/form-cliente-edit';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    /**
     * Genera reporte de historial de pedidos de un cliente
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function print_client_historial($idcliente) {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->clientes == 1) {
            
            $data['session'] = $this->session;
            $data['pedidos'] = $this->pedidoModel->_getHistorialPedidos($idcliente);
            $data['cliente'] = $this->clienteModel->find($idcliente);

            //echo '<pre>'.var_export($data['cliente'], true).'</pre>';exit;
            $data['title']='Clientes';
            $data['subtitle']='Historial del Cliente';
            $data['main_content']='clientes/reporte_historial_cliente';
            return view('dashboard/index', $data);

        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    function pruebaPDF($cliente){
        //require __DIR__ . '/vendor/autoload.php';
        $data['cliente'] = $this->pedidoModel->find($idcliente);
        $pdf = new TCPDF();                 // create TCPDF object with default constructor args

        //IMPORTANTE ESTA LÍNEA
        $this->response->setHeader('Content-Type', 'application/pdf'); 

        $pdf->AddPage();                    // pretty self-explanatory
        $pdf->Write(1, 'Aquí va el historial de compras de ese cliente ordenado por fechas');      // 1 is line height

        $pdf->Output('Historial de compras cliente: '.$cliente->nombre.'.pdf');    // send the file inline to the browser (default).
    }

    function pruebaExcel(){
        //require __DIR__ . '/vendor/autoload.php';
        $pdf = new TCPDF();                 // create TCPDF object with default constructor args

        //IMPORTANTE ESTA LÍNEA
        $this->response->setHeader('Content-Type', 'application/pdf'); 
        
        $pdf->AddPage();                    // pretty self-explanatory
        $pdf->Write(1, 'Hello world');      // 1 is line height

        $pdf->Output('hello_world.pdf');    // send the file inline to the browser (default).
    }

    public function cliente_update(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->clientes == 1) {

            $id = $this->request->getPostGet('id');

            $cliente = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                'telefono_2' => strtoupper($this->request->getPostGet('telefono_2')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'direccion' => strtoupper($this->request->getPostGet('direccion')),
                'email' => $this->request->getPostGet('email'),
            ];

            $this->validation->setRuleGroup('cliente');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($cliente, true).'</pre>';exit;

                //Inserto el nuevo cliente
                $this->clienteModel->update($id, $cliente);
                return redirect()->to('clientes');
            }
        }else{

            $this->logout();
        }
    }
}
