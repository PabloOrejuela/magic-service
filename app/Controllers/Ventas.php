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
            date_default_timezone_set('America/Guayaquil');
            $date = date('ymdHis');

            //Borramos pedidos 
            
            // ejecutamos la función pasándole la fecha que queremos
            $this->saber_dia(date('Y-m-d'));
            
            $diaSemana = date('l');
            if($diaSemana == "Sunday"){
                //echo "Es ".$diaSemana;
            }else{
                //echo "No ".$diaSemana;
            }

            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['productos'] = $this->productoModel->findAll();
            $data['sectores'] = $this->sectoresEntregaModel->findAll();
            $data['horariosEntrega'] = $this->horariosEntregaModel->findAll();
            $data['cod_pedido'] = $this->session->id.$date;

            //echo '<pre>'.var_export($this->session , true).'</pre>';exit;

            $data['title']='Ordenes y pedidos';
            $data['subtitle']='Nuevo pedido';
            $data['main_content']='ventas/form-pedido';
            return view('dashboard/index', $data);
            
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    function saber_dia($nombredia) {
        $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
        $fecha = $dias[date('N', strtotime($nombredia))];
        return $fecha;
    }
        

    function clientes_select(){
        $documento = $this->request->getPostGet('documento');
        $data['clientes'] = $this->clienteModel->_getCliente($documento);
        //$data['clientes'] = $this->clienteModel->findAll();
        echo view('clientes_select', $data);
    }

    function clientes_select_telefono(){
        $telefono = $this->request->getPostGet('telefono');
        $cliente = $this->clienteModel->_getClienteByPhone($telefono);
        //$data['clientes'] = $this->clienteModel->findAll();
        echo json_encode($cliente);
        //echo view('clientes_select', $data);
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

    function actualizaMensajero($mensajero, $cod_pedido){

        if ($mensajero != 0) {
            $this->pedidoModel->_actualizaMensajero($mensajero, $cod_pedido);
        }
        
        return true;
    }

    function actualizarHorarioEntrega($horario_entrega, $cod_pedido){
        
        if ($horario_entrega != 0) {
            $this->pedidoModel->_actualizaHorarioEntrega($horario_entrega, $cod_pedido);
        }
        
        return true;
    }

    function actualizarEstadoPedido($estado_pedido, $cod_pedido){

        if ($estado_pedido != 0) {
            $this->pedidoModel->_actualizarEstadoPedido($estado_pedido, $cod_pedido);
        }
        return true;
    }

    function actualizarHoraSalidaPedido($hora_salida_pedido, $cod_pedido){

        if ($hora_salida_pedido != 0) {
            $this->pedidoModel->_actualizarHoraSalidaPedido($hora_salida_pedido, $cod_pedido);
        }
        return true;
    }

    function get_costo_horario($horario){
        //$producto = $this->request->getPostGet('producto');
        $costo_horario = $this->horariosEntregaModel->find($horario);
        
        echo json_encode($costo_horario);
    }

    function detalle_pedido_insert($idproducto, $cantidad, $cod_pedido){
        $error = '';

        $producto = $this->productoModel->find($idproducto);

        if ($producto) {
            $datosExiste = $this->detallePedidoModel->_getProdDetallePedido($idproducto, $cod_pedido);
            
            if ($datosExiste) {
                $cantidad = $datosExiste->cantidad + $cantidad;
                $subtotal = $cantidad * $datosExiste->precio;
                
                $this->detallePedidoModel->_updateProdDetalle($idproducto, $cod_pedido, $cantidad, $subtotal);

            }else{
                $subtotal = $cantidad * $producto->precio;

                $data = [
                    'cod_pedido' => $cod_pedido,
                    'idproducto' => $idproducto,
                    'cantidad' => $cantidad,
                    'precio' => $producto->precio,
                    'subtotal' => $subtotal,
                ];

                $this->detallePedidoModel->save($data);
            }
        }else{
            $error = 'No existe el producto';
        }
        $res['datos'] = $this->cargaProductos($cod_pedido);
        $res['total'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['subtotal'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['error'] = $error;
        echo json_encode($res);
    }

    function detalle_pedido_insert_observacion($idproducto, $cod_pedido, $observacion){
        $error = '';

        $datosExiste = $this->detallePedidoModel->_getProdDetallePedido($idproducto, $cod_pedido);
            
        if ($datosExiste) {
            $this->detallePedidoModel->_updateProdDetalleObservacion($idproducto, $cod_pedido, $observacion);
        }
        
        $res['datos'] = $this->cargaProductos($cod_pedido);
        $res['total'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['subtotal'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['error'] = $error;
        echo json_encode($res);
    }

    function detalle_pedido_delete_producto($idproducto, $cod_pedido){
        $error = '';

        $datosExiste = $this->detallePedidoModel->_getProdDetallePedido($idproducto, $cod_pedido);

        if ($datosExiste) {
            if ($datosExiste->cantidad > 1) {
                $cantidad = $datosExiste->cantidad - 1;
                $subtotal = $cantidad * $datosExiste->precio;

                $this->detallePedidoModel->_updateProdDetalle($idproducto, $cod_pedido, $cantidad, $subtotal);
            }else{
                $this->detallePedidoModel->_eliminarProdDetalle($idproducto, $cod_pedido);
            }
        }

        $res['datos'] = $this->cargaProductos($cod_pedido);
        $res['total'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['subtotal'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['error'] = $error;
        echo json_encode($res);
    }

    function getDetallePedido($cod_pedido){
        $error = '';
        $subtotal = 0;
        $cantidad = 0;
        $detalle = $this->detallePedidoModel->_getDetallePedido($cod_pedido);

        if ($detalle) {
            $res['datos'] = $detalle;
            foreach ($detalle as $key => $value) {
                $subtotal += $value->cantidad * $value->precio;
            }
            
        }else{
            $res['datos'] = 'NO existe ese pedido';
        }
        $res['subtotal'] = $subtotal;
        $res['error'] = $error;
        echo json_encode($res);
    }

    function cargaProductos($cod_pedido){
        $resultado = $this->detallePedidoModel->_getDetallePedido($cod_pedido);
        $fila = '';
        $numFila = 0;
        if ($resultado) {
            foreach ($resultado as $row) {
                $numFila++;
                //$cod_pedido = "231114181156";
                $fila .= '<tr id="fila_'.$numFila.'">';
                $fila .= '<td>'.$numFila.'</td>';
                $fila .= '<td>'.$row->id.'</td>';
                $fila .= '<td>'.$row->producto.'</td>';
                $fila .= '<td><input type="text" class="form-control name="observacion_'.$row->idproducto.'" value="'.$row->observacion.'" onchange="observacion('.$row->idproducto. ','.$cod_pedido.')" id="observa_'.$row->idproducto.'"></td>';
                $fila .= '<td>'.$row->precio.'</td>';
                $fila .= '<td>'.$row->cantidad.'</td>';
                
                $fila .= '<td><a onclick="eliminaProducto('.$row->idproducto. ','.$cod_pedido.')" class="borrar">
                            <img src="'.site_url().'public/images/delete.png" width="20" >
                            </a></td>';
                $fila .= '</tr>';
                
            }
            return $fila;
        }
        
    }

    function totalDetallePedido($cod_pedido){
        $resultado = $this->detallePedidoModel->_getDetallePedido($cod_pedido);
        $total = 0;

        if ($resultado) {
            foreach ($resultado as $row) {
                $total += $row->subtotal;
            }
        }
        
        return $total;
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
                'fecha' => date('Y-m-d'),

                'fecha_entrega' => $this->request->getPostGet('fecha_entrega'),
                'horario_entrega' => $this->request->getPostGet('horario_entrega'),
                
                'idcliente' => $this->request->getPostGet('idcliente'),
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                
                
                'vendedor' => $this->request->getPostGet('vendedor'),
                'venta_extra' => $this->request->getPostGet('venta_extra'),
                
                //DETALLE
               
                //TOTALES
                'valor_neto' => $this->request->getPostGet('valor_neto'),
                'descuento' => $this->request->getPostGet('descuento'),
                'transporte' => $this->request->getPostGet('transporte'),
                'horario_extra' => $this->request->getPostGet('horario_extra'),
                'cargo_domingo' => $this->request->getPostGet('cargo_domingo'),
                'total' => $this->request->getPostGet('total'),
            ];
            echo '<pre>'.var_export($pedido, true).'</pre>';exit;
            //VALIDACIONES
            $this->validation->setRuleGroup('pedidoInicial');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                //Codigo del pedido
                //$pedido['cod'] = $this->pedidoModel->_makeCodproduct($pedido);
                //echo '<pre>'.var_export($pedido, true).'</pre>';exit;
                //Verifico que exista el cliente, si no existe lo creo y si exiete solo inserto el id
                $cliente = $this->clienteModel->find($pedido['idcliente']);
                if ($cliente) {
                    
                    
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

                    //echo '<pre>'.var_export($pedido, true).'</pre>';exit;
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
            $data['horariosEntrega'] = $this->horariosEntregaModel->findAll();
            $data['estadosPedido'] = $this->estadoPedidoModel->findAll();
            $data['mensajeros'] = $this->usuarioModel->_getUsuariosRol(5);
            //echo '<pre>'.var_export($data['mensajeros'], true).'</pre>';exit;
            $data['title']='Pedidos';
            $data['subtitle']='Listado de pedidos';
            $data['main_content']='ventas/form-pedidos-inicio';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function pedido_edit($pedido) {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            // $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            // $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['pedido'] = $this->pedidoModel->_getDatosPedido($pedido);
            // $data['mensajeros'] = $this->usuarioModel->_getUsuariosRol(5);
            // $data['horariosEntrega'] = $this->horariosEntregaModel->FindAll();

            // //echo '<pre>'.var_export($data['horariosEntrega'], true).'</pre>';exit;
            $data['title']='Ventas';
            $data['subtitle']='Editar Pedido';
            $data['main_content']='ventas/form-pedido-edit';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function pedidos_ventana() {
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
            return view('dashboard/index_ventana', $data);
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
