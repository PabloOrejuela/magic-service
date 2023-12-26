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
            $this->detallePedidoTempModel->_deleteDetallesTempOld();

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

    function clientes_select(){
        $documento = $this->request->getPostGet('documento');
        $cliente = $this->clienteModel->_getCliente($documento);
        //$data['clientes'] = $this->clienteModel->findAll();
        echo json_encode($cliente);
    }

    function clientes_select_telefono(){
        $telefono = $this->request->getPostGet('telefono');
        $cliente = $this->clienteModel->_getClienteByPhone($telefono);
        //$data['clientes'] = $this->clienteModel->findAll();
        echo json_encode($cliente);
        //echo view('clientes_select', $data);
    }

    function clientes_select_telefono_2(){
        $telefono = $this->request->getPostGet('telefono');
        $cliente = $this->clienteModel->_getClienteByPhoneDos($telefono);
        echo json_encode($cliente);
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

        if ($mensajero != 0 && $mensajero != NULL) {
            $this->pedidoModel->_actualizaMensajero($mensajero, $cod_pedido);
        }
        
        return true;
    }

    function actualizarHorarioEntrega($horario_entrega, $cod_pedido){
        
        if ($horario_entrega != 0) {
            $this->pedidoModel->_actualizaHorarioEntrega($horario_entrega, $cod_pedido);
        }
        $data['horario'] = $horario_entrega;
        echo json_encode($data);
    }

    function actualizarEstadoPedido($estado_pedido, $cod_pedido){

        if ($estado_pedido != 0) {
            $this->pedidoModel->_actualizarEstadoPedido($estado_pedido, $cod_pedido);
        }
        return true;
    }

    function actualizarHoraSalidaPedido(){

        $hora_salida_pedido =  strtoupper($this->request->getPostGet('horaSalidaPedido'));
        $cod_pedido =  strtoupper($this->request->getPostGet('codigoPedido'));

        if ($hora_salida_pedido != 0 && $hora_salida_pedido != '' ) {
            $this->pedidoModel->_actualizarHoraSalidaPedido($hora_salida_pedido, $cod_pedido);
        }
        return true;
    }

    function actualizaObservacionPedido(){

        $observacionPedido =  strtoupper($this->request->getPostGet('observacionPedido'));
        $cod_pedido =  strtoupper($this->request->getPostGet('codigoPedido'));

        if ($observacionPedido != '' ) {
            $this->pedidoModel->_actualizaObservacionPedido($observacionPedido, $cod_pedido);
        }
        return true;
    }

    function get_costo_horario($horario){
        //$producto = $this->request->getPostGet('producto');
        $costo_horario = $this->horariosEntregaModel->find($horario);
        
        echo json_encode($costo_horario);
    }

    function detalle_pedido_insert_temp($idproducto, $cantidad, $cod_pedido){
        $error = '';

        $producto = $this->productoModel->find($idproducto);

        if ($producto) {
            $datosExiste = $this->detallePedidoTempModel->_getProdDetallePedido($idproducto, $cod_pedido);
            
            if ($datosExiste) {
                $cantidad = $datosExiste->cantidad + $cantidad;
                $precio = $datosExiste->precio;
                if ($datosExiste->pvp != '0.00') {
                    $subtotal = $cantidad * $datosExiste->pvp;
                }else{
                    $subtotal = $cantidad * $datosExiste->precio;
                }
                
                
                $this->detallePedidoTempModel->_updateProdDetalle($idproducto, $cod_pedido, $cantidad, $precio, $subtotal);

            }else{
                $subtotal = $cantidad * $producto->precio;

                $data = [
                    'cod_pedido' => $cod_pedido,
                    'idproducto' => $idproducto,
                    'cantidad' => $cantidad,
                    'precio' => $producto->precio,
                    'pvp' => $producto->precio,
                    'subtotal' => $subtotal,
                ];

                $this->detallePedidoTempModel->_saveProdDetalle($data);
            }
        }else{
            $error = 'No existe el producto';
        }
        $res['datos'] = $this->cargaProductos_temp($cod_pedido);
        $res['total'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['subtotal'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['error'] = $error;
        echo json_encode($res);
    }

    function detalle_pedido_insert_observacion_temp($idproducto, $cod_pedido, $observacion){
        $error = '';

        $datosExiste = $this->detallePedidoTempModel->_getProdDetallePedido($idproducto, $cod_pedido);
            
        if ($datosExiste) {
            $this->detallePedidoTempModel->_updateProdDetalleObservacion($idproducto, $cod_pedido, $observacion);
        }
        
        $res['datos'] = $this->cargaProductos_temp($cod_pedido);
        $res['total'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['subtotal'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['error'] = $error;
        echo json_encode($res);
    }

    function detalle_pedido_update_precio_temp($idproducto, $cod_pedido, $precio, $cant){
        $error = '';
        $subtotal = number_format($precio * $cant,2);

        $datosExiste = $this->detallePedidoTempModel->_getProdDetallePedido($idproducto, $cod_pedido);
            
        if ($datosExiste) {
            $this->detallePedidoTempModel->_updateProdDetallePrecio($idproducto, $cod_pedido, $precio, $subtotal);
        }
        
        $res['datos'] = $this->cargaProductos_temp($cod_pedido);
        $res['total'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['subtotal'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['error'] = $error;
        echo json_encode($res);
    }

    function detalle_pedido_delete_producto_temp($idproducto, $cod_pedido){
        $error = '';

        $datosExiste = $this->detallePedidoTempModel->_getProdDetallePedido($idproducto, $cod_pedido);

        if ($datosExiste) {
            if ($datosExiste->cantidad > 1) {
                $cantidad = $datosExiste->cantidad - 1;
                $subtotal = $cantidad * $datosExiste->precio;

                $this->detallePedidoTempModel->_updateProdDetalle($idproducto, $cod_pedido, $cantidad, $subtotal);
            }else{
                $this->detallePedidoTempModel->_eliminarProdDetalle($idproducto, $cod_pedido);
            }
        }

        $res['datos'] = $this->cargaProductos_temp($cod_pedido);
        $res['total'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['subtotal'] = number_format($this->totalDetallePedido($cod_pedido), 2);
        $res['error'] = $error;
        echo json_encode($res);
    }

    function getDetallePedido_temp($cod_pedido){
        $error = '';
        $subtotal = 0;
        $cantidad = 0;
        $detalle = $this->detallePedidoTempModel->_getDetallePedido($cod_pedido);

        if ($detalle) {
            $res['datos'] = $detalle;
            foreach ($detalle as $key => $value) {
                $subtotal += $value->subtotal;
            }
            
        }else{
            $res['datos'] = 'NO existe ese pedido';
        }
        $res['subtotal'] = $subtotal;
        $res['error'] = $error;
        echo json_encode($res);
    }

    function getDatosPedido($id){
        $error = '';
        $subtotal = 0;
        $cantidad = 0;
        $datos = $this->pedidoModel->_getDatosPedido($id);

        if ($datos) {
            $res['datos'] = $datos;
            $res['detalle'] = $this->detallePedidoModel->_getDetallePedido($datos->cod_pedido);
            
        }else{
            $res['datos'] = 'NO existe ese pedido';
        }
        $res['error'] = $error;
        echo json_encode($res);
    }

    function cargaProductos_temp($cod_pedido){
        $resultado = $this->detallePedidoTempModel->_getDetallePedido($cod_pedido);
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
                $fila .= '<td><input type="text" class="form-control" name="observacion_'.$row->idproducto.'" value="'.$row->observacion.'" onchange="observacion('.$row->idproducto. ','.$cod_pedido.')" id="observa_'.$row->idproducto.'"></td>';
                $fila .= '<td><input type="text" class="form-control input-precio" name="precio_'.$row->idproducto.'" value="'.$row->pvp.'" onchange="actualizaPrecio('.$row->idproducto. ','.$cod_pedido.')" id="precio_'.$row->idproducto.'"></td>';
                //$fila .= '<td>'.$row->precio.'</td>';
                $fila .= '<td id="cant_'.$row->idproducto.'">'.$row->cantidad.'</td>';
                
                $fila .= '<td><a onclick="eliminaProducto('.$row->idproducto. ','.$cod_pedido.')" class="borrar">
                            <img src="'.site_url().'public/images/delete.png" width="20" >
                            </a></td>';
                $fila .= '</tr>';
                
            }
            return $fila;
        }
        
    }

    function totalDetallePedido($cod_pedido){
        $resultado = $this->detallePedidoTempModel->_getDetallePedido($cod_pedido);
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
            $cod_pedido = $this->request->getPostGet('cod_pedido');
            $detalleTemporal = $this->detallePedidoTempModel->_getDetallePedido($cod_pedido );
        
            $pedido = [
                'cod_pedido' => $cod_pedido,
                'idusuario' => $data['id'],
                'fecha' => date('Y-m-d'),
                'idcliente' => $this->request->getPostGet('idcliente'),

                'fecha_entrega' => $this->request->getPostGet('fecha_entrega'),
                'horario_entrega' => $this->request->getPostGet('horario_entrega'),
                'sector' => $this->request->getPostGet('sectores'),
                          
                'vendedor' => $this->request->getPostGet('vendedor'),
                'venta_extra' => $this->request->getPostGet('venta_extra'),
               
                //TOTALES
                'valor_neto' => $this->request->getPostGet('valor_neto'),
                'descuento' => $this->request->getPostGet('descuento'),
                'transporte' => $this->request->getPostGet('transporte'),
                'horario_extra' => $this->request->getPostGet('horario_extra'),
                'cargo_domingo' => $this->request->getPostGet('cargo_domingo'),
                'total' => $this->request->getPostGet('total'),
            ];

            $cliente = [
                'idcliente' => $this->request->getPostGet('idcliente'),
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                'telefono_2' => strtoupper($this->request->getPostGet('telefono_2')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'direccion' => '',
                'email' => strtoupper($this->request->getPostGet('email')),
            ];

            
            //VALIDACIONES
            $this->validation->setRuleGroup('pedidoInicial');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{

                //echo '<pre>'.var_export($pedido, true).'</pre>';exit;
                //Verifico que exista el cliente, si no existe lo creo y si exiete solo inserto el id
                $clienteExiste = $this->clienteModel->find($cliente['idcliente']);
                if ($clienteExiste) {

                    //Inserto el nuevo producto
                    $this->pedidoModel->_insert($pedido);

                    //Inserto el detalle
                    $this->detallePedidoModel->_insert($detalleTemporal);

                    return redirect()->to('pedidos');
                }else{
                    // echo '<pre>'.var_export($cliente, true).'</pre>';
                    // echo '<pre>'.var_export($detalleTemporal, true).'</pre>';exit;
                    // echo '<pre>'.var_export($pedido, true).'</pre>';
                    // echo '<pre>'.var_export($detalleTemporal, true).'</pre>';exit;
                    //Inserto el cliente nuevo
                    $pedido['idcliente'] = $this->clienteModel->_insert($cliente);

                    //Inserto el nuevo pedido
                    $this->pedidoModel->_insert($pedido);

                    //Inserto el detalle
                    $this->detallePedidoModel->_insert($detalleTemporal);
                    
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
