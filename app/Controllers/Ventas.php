<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Ventas extends BaseController {

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function index() {

        $data = $this->acl();

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

    public function estadisticaVentas() {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            date_default_timezone_set('America/Guayaquil');
            $date = date('ymdHis');

            $data['title']='Ventas';
            $data['subtitle']='Estadísticas de Ventas';
            $data['main_content']='ventas/estadistica-ventas';
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
        
        echo json_encode($data);
        //echo view('precio_sector', $data);
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

    function updatePrecioActualTempProduct(){

        $prod['idproducto'] =  strtoupper($this->request->getPostGet('idproducto'));
        $prod['precio_actual'] =  strtoupper($this->request->getPostGet('precio_actual'));
        $prod['item'] =  strtoupper($this->request->getPostGet('item'));
        $prod['new_id'] =  strtoupper($this->request->getPostGet('idNew'));
        
        if ($prod['precio_actual'] != 0 && $prod['precio_actual'] != '' ) {
            $this->itemsProductoTempModel->_updatePrecio($prod);
        }
        return true;
    }

    function insertAttrArreglo(){
        
        $data['iddetalle'] =  $this->request->getPostGet('iddetalle');
        $data['idcategoria'] =  $this->request->getPostGet('idcategoria');
        $data['para'] =  strtoupper($this->request->getPostGet('para'));
        $data['celular'] =  strtoupper($this->request->getPostGet('celular'));
        $data['mensaje_fresas'] =  strtoupper($this->request->getPostGet('mensaje_fresas'));
        $data['peluche'] =  strtoupper($this->request->getPostGet('peluche'));
        $data['globo'] =  strtoupper($this->request->getPostGet('globo'));
        $data['tarjeta'] =  strtoupper($this->request->getPostGet('tarjeta'));
        $data['opciones'] =  strtoupper($this->request->getPostGet('opciones'));
        $data['bebida'] =  strtoupper($this->request->getPostGet('bebida'));
        $data['huevo'] =  strtoupper($this->request->getPostGet('huevo'));
        $data['frases_paredes'] =  strtoupper($this->request->getPostGet('frases_paredes'));
        $data['fotos'] =  strtoupper($this->request->getPostGet('fotos'));

        //Valido los campos requeridos y hago el insert en la tabla
        if ($data['para'] != '' && $data['celular'] != '') {
            $res['response'] = $this->attrExtArregModel->insert($data);
        }else{
            $res['response'] = null;
        }

        if ($res['response'] && $res['response'] != null) {
            $res['mensaje'] = "Exito";
        }else{
            $res['mensaje'] = "Error";
        }

        echo json_encode($res);
    }

    function actualizaObservacionPedido(){

        $observacionPedido =  strtoupper($this->request->getPostGet('observacionPedido'));
        $cod_pedido =  strtoupper($this->request->getPostGet('codigoPedido'));

        if ($observacionPedido != '' ) {
            $this->pedidoModel->_actualizaObservacionPedido($observacionPedido, $cod_pedido);
        }
        return true;
    }

    function deleteItemsTempProduct(){

        $idproducto = $this->request->getPostGet('idproducto');

        $this->itemsProductoTempModel->_deleteItems($idproducto);

        return true;
    }

    function get_costo_horario($horario){
        //$producto = $this->request->getPostGet('producto');
        $costo_horario = $this->horariosEntregaModel->find($horario);
        
        echo json_encode($costo_horario);
    }

    function getProductosAutocomplete(){
        $producto = $this->request->getPostGet('producto');
        $productos = $this->productoModel->_getProductoAutocomplete($producto);

        echo json_encode($productos);
    }

    function getItemsAutocomplete(){
        $item = $this->request->getPostGet('item');
        $items = $this->itemModel->_getProductoAutocomplete($item);

        echo json_encode($items);
    }

    function updateItemsTempProduct(){

        $data = [
            'idproducto' => $this->request->getPostGet('idproducto'),
            'precio_unitario' => $this->request->getPostGet('precio_unitario'),
            'precio_actual' => $this->request->getPostGet('precio_actual'),
            'pvp' => $this->request->getPostGet('pvp'),
            'porcentaje' => $this->request->getPostGet('porcentaje'),
            'idItem' => $this->request->getPostGet('idItem'),
            'idNew' => $this->request->getPostGet('idNew'),
        ];
        $this->itemsProductoTempModel->_updateDataItems($data);

        return true;
    }

    function updatePvpTempProduct(){

        $data = [
            'pvp' => $this->request->getPostGet('pvp'),
            'idItem' => $this->request->getPostGet('idItem'),
            'idNew' => $this->request->getPostGet('idNew'),
        ];
        $this->itemsProductoTempModel->_updatePvp($data);

        return true;
    }

    function detalle_pedido_insert_temp(){

        $idproducto = $this->request->getPostGet('idproducto');
        $cantidad = $this->request->getPostGet('cantidad');
        $cod_pedido = $this->request->getPostGet('cod_pedido');
        
        $error = '';

        $producto = $this->productoModel->find($idproducto);

        if ($producto) {
            $datosExiste = $this->detallePedidoTempModel->_getProdDetallePedido($idproducto, $cod_pedido);
            
            if ($datosExiste) {
                $cantidad = $datosExiste->cantidad + $cantidad;
                
                $precio = $datosExiste->precio;
                if ($datosExiste->pvp != '0.00') {
                    $subtotal = ($cantidad * $datosExiste->pvp);
                }else{
                    $subtotal = ($cantidad * $datosExiste->precio);
                }
               
                // echo '<pre>'.var_export($subtotal, true).'</pre>';exit;
                $this->detallePedidoTempModel->_updateProdDetalle($idproducto, $cod_pedido, $cantidad, $subtotal);

            }else{
                $subtotal = ($cantidad * $producto->precio);
                // echo '<pre>'.var_export($subtotal, true).'</pre>';exit;
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

    function detalle_prod_insert_temp_EDIT(){
        $error = 'No se pudo insertar';
        $result = 'No se pudo insertar';
        $idproducto = $this->request->getPostGet('idproducto');
        $item = $this->request->getPostGet('item');
        $idNew = $this->request->getPostGet('idNew');

        $datosTempExiste = $this->itemsProductoTempModel->_getItemsNewProducto($idNew);

        if ($datosTempExiste) {
            //Traigo los datos del item a insertar
            $dataItem = $this->itemModel->find($item);

            //Verifico que el item no exista en la tabla
            $verifica = $this->itemsProductoTempModel->_verificaItem($idNew, $item);
            if (!isset($verifica) || $verifica == 0 || $verifica == NULL) {
                $result = $this->itemsProductoTempModel->_insertNewItem($idproducto, $dataItem, $idNew);
            }
            

        }else{
            //Traigo los items de la tabla Items Producto
            $items = $this->itemsProductoModel->_getItemsProducto($idproducto);

            //Inserto todos los items en la tabla temporal 
            $result = $this->itemsProductoTempModel->_insertItems($idproducto, $items, $item, $idNew);
        }
        //echo '<pre>'.var_export($result, true).'</pre>';exit;
        $res['datos'] = $this->itemsProductoTempModel->_getItemsNewProducto($idNew);
        $res['error'] = $result;
        echo json_encode($res);
    }

    function detalle_prod_insert_temp(){
        $error = 'No se pudo insertar';
        $result = 'No se pudo insertar';
        $idproducto = $this->request->getPostGet('idproducto');
        $item = $this->request->getPostGet('item');
        $idNew = $this->request->getPostGet('idNew');

        //Traigo los datos del item a insertar
        $dataItem = $this->itemModel->find($item);

        //Verifico que el item no exista en la tabla
        $verifica = $this->itemsProductoTempModel->_verificaItem($idNew, $item);
        if (!isset($verifica) || $verifica == 0 || $verifica == NULL) {
            $result = $this->itemsProductoTempModel->_insertNewItem($idproducto, $dataItem, $idNew);
        }
        
        //echo '<pre>'.var_export($result, true).'</pre>';exit;
        $res['datos'] = $this->itemsProductoTempModel->_getItemsNewProducto($idNew);
        $res['error'] = $result;
        echo json_encode($res);
    }

    function detalle_prodnew_insert_temp(){
        
        $error = 'No se pudo insertar';
        $result = 'No se pudo insertar';
        $idproducto = $this->request->getPostGet('idproducto');
        $item = $this->request->getPostGet('item');
        $idNew = $this->request->getPostGet('idNew');

        //$datosTempExiste = $this->itemsProductoTempModel->_getItemsNewProducto($idNew);

        $dataItem = $this->itemModel->find($item);

        //Verifico que no haya sido ya agregado
        $verifica = $this->itemsProductoTempModel->_verificaItem($idNew, $item);
        if (!isset($verifica) || $verifica == 0 || $verifica == NULL) {
            $result = $this->itemsProductoTempModel->_insertNewItem($idproducto, $dataItem, $idNew);
        }
        
        //echo '<pre>'.var_export($result, true).'</pre>';exit;
        $res['datos'] = $this->itemsProductoTempModel->_getItemsNewProducto($idNew);
        $res['error'] = $result;
        $res['verifica'] = $result;
        echo json_encode($res);
    }

    function detalle_pedido_update_precio_temp(){

        $idproducto = $this->request->getPostGet('idproducto');
        $cod_pedido = $this->request->getPostGet('cod_pedido');
        $precio = $this->request->getPostGet('precio');
        $cant = $this->request->getPostGet('cant');

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
                $cantidad += $value->cantidad;
            }
            
        }else{
            $res['datos'] = 'NO existe ese pedido';
        }
        $res['cantidad'] = $cantidad;
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

    function getProducto($id){
        $error = "No se encontró el producto";
        $res['producto'] = $this->productoModel->_getProducto($id);
        if ($res['producto']) {
            $error = "Exito";
        }
        $res['error'] = $error;
        echo json_encode($res);
    }

    function deleteItemTempProduct(){
        $itemsTemp = null;
        $error = "No se pudo borrar el item";
        $item = $this->request->getPostGet('idItem');
        $new_id = $this->request->getPostGet('idproducto');

        $id = $this->itemsProductoTempModel->_deleteItem($item, $new_id);
        if ($id) {
            $res['datos'] = $this->itemsProductoTempModel->_getItemsNewProducto($new_id);
        }
        
        echo json_encode($res);
    }

    public function getItemsProducto($idproducto){

        $items = $this->itemsProductoModel->_getItemsProducto($idproducto);
        //echo '<pre>'.var_export($items, true).'</pre>';exit;

        //Inserto en la tabla temporal los items que traigo de la tabla de items producto
        $this->insertProductTemp($idproducto, $items);

        //Por seguridad traigo los items que están en la tabla temporal
        $info['itemsTemp'] = $this->itemsProductoTempModel->_getItemsProducto($idproducto);
        $precio = $this->productoModel->_getPrecioProducto($idproducto);
        $info['precio'] = $precio->precio;
        
        //Retorno los items
        echo json_encode($info);
    }

    public function insertProductTemp($idproducto, $items){
        $itemsTemp = NULL;
        $lastId = $this->productoModel->_getLastId();
        $newId = $idproducto.$lastId;
        foreach ($items as $key => $item) {
            $this->itemsProductoTempModel->_insertNewItemTemp($idproducto, $newId, $item);
        }
        $itemsTemp = $this->itemsProductoTempModel->_getItemsProducto($idproducto, $newId);
        
        return $itemsTemp;
    }



    function cargaProductos_temp($cod_pedido){
        $resultado = $this->detallePedidoTempModel->_getDetallePedido($cod_pedido);
        $fila = '';
        $numFila = 0;
        if ($resultado) {
            foreach ($resultado as $row) {
                $numFila++;
                
                $fila .= '<tr id="fila_'.$numFila.'">';
                $fila .= '<td>'.$numFila.'</td>';
                $fila .= '<td>'.$row->id.'</td>';
                $fila .= '<td>'.$row->producto.'</td>';
                $fila .= '<td>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="observacion_'.$row->idproducto.'" 
                                value="'.$row->observacion.'" 
                                onchange="observacion('.$row->idproducto. ','.$cod_pedido.')" 
                                id="observa_'.$row->idproducto.'"
                            >
                        </td>';
                $fila .= '<td>
                            <input 
                                type="text" 
                                class="form-control input-precio" 
                                name="precio_'.$row->idproducto.'" 
                                value="'.$row->pvp.'" 
                                onchange="actualizaPrecio('.$row->idproducto. ','.$cod_pedido.')" 
                                id="precio_'.$row->idproducto.'"
                            >
                        </td>';
                
                $fila .= '<td id="cant_'.$row->idproducto.'" class="cant_arreglo">'.$row->cantidad.'</td>';
                
                $fila .= '<td><a onclick="eliminaProducto('.$row->idproducto. ','.$cod_pedido.')" class="btn btn-borrar">
                            <img src="'.site_url().'public/images/delete.png" width="25" >
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

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            $cod_pedido = $this->request->getPostGet('cod_pedido');
            $detalleTemporal = $this->detallePedidoTempModel->_getDetallePedido($cod_pedido);
        
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
                'valor_mensajero_edit' => $this->request->getPostGet('valor_mensajero_edit'),
                'valor_mensajero' => $this->request->getPostGet('valor_mensajero'),
                'total' => $this->request->getPostGet('total'),
            ];

            $cliente = [
                'idcliente' => $this->request->getPostGet('idcliente'),
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                'telefono_2' => strtoupper($this->request->getPostGet('telefono_2')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'direccion' => '',
                'email' => $this->request->getPostGet('email'),
            ];

            //echo '<pre>'.var_export($detalleTemporal, true).'</pre>';exit;
            //VALIDACIONES
            $this->validation->setRuleGroup('pedidoInicial');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                
                //Verifico que exista el cliente, si no existe lo creo y si exiete solo inserto el id
                $clienteExiste = $this->clienteModel->find($cliente['idcliente']);
                
                if ($clienteExiste) {
                    
                    //Inserto el nuevo producto
                    $this->pedidoModel->_insert($pedido);

                    //Inserto el detalle
                    $this->detallePedidoModel->_insert($detalleTemporal);
                    $mensaje = 1;
                    $this->session->setFlashdata('mensaje', $mensaje);
                    return redirect()->to('pedidos');
                }else{

                    //Inserto el cliente nuevo
                    $pedido['idcliente'] = $this->clienteModel->_insert($cliente);

                    //Inserto el nuevo pedido
                    $this->pedidoModel->_insert($pedido);

                    //Inserto el detalle
                    $mensaje = 1;
                    $this->session->setFlashdata('mensaje', $mensaje);
                    return redirect()->to('pedidos');
                }
                
            }
            
        }else{

            $this->logout();
        }
    }

    public function pedido_update(){

        $data = $this->acl();
        

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
                'formas_pago' => $this->request->getPostGet('formas_pago'),
                'banco' => $this->request->getPostGet('banco'),
                'sector' => $this->request->getPostGet('sectores'),
                          
                'vendedor' => $this->request->getPostGet('vendedor'),
                'observaciones' => $this->request->getPostGet('observaciones'),
                'venta_extra' => $this->request->getPostGet('venta_extra'),
               
                //TOTALES
                'valor_neto' => $this->request->getPostGet('valor_neto'),
                'descuento' => $this->request->getPostGet('descuento'),
                'transporte' => $this->request->getPostGet('transporte'),
                'horario_extra' => $this->request->getPostGet('horario_extra'),
                'domingo' => $this->request->getPostGet('cargo_domingo'),
                'cargo_horario' => $this->request->getPostGet('cargo_horario'),
                'valor_mensajero_edit' => $this->request->getPostGet('valor_mensajero_edit'),
                'valor_mensajero' => $this->request->getPostGet('valor_mensajero'),
                'total' => $this->request->getPostGet('total'),
            ];

            $cliente = [
                'idcliente' => $this->request->getPostGet('idcliente'),
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'telefono' => strtoupper($this->request->getPostGet('telefono')),
                'telefono_2' => strtoupper($this->request->getPostGet('telefono_2')),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'procedencia' => $this->request->getPostGet('procedencia'),
                'direccion' => '',
                'email' => $this->request->getPostGet('email'),
            ];
            //echo '<pre>'.var_export($pedido, true).'</pre>';exit;
            
            //VALIDACIONES
            $this->validation->setRuleGroup('pedido');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                
                //Verifico que exista el cliente, si no existe lo creo y si exiete solo inserto el id
                $clienteExiste = $this->clienteModel->find($cliente['idcliente']);
                // echo '<pre>'.var_export($pedido, true).'</pre>';exit;
                if ($clienteExiste) {

                    //Inserto el nuevo producto
                    $this->pedidoModel->_insert($pedido);

                    //Inserto el detalle
                    $this->detallePedidoModel->_insert($detalleTemporal);

                    return redirect()->to('pedidos');
                }else{

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

    function getEstadosPedido(){
        $estadosPedido = $this->estadoPedidoModel->findAll();

        echo json_encode($estadosPedido);
    }

    function getMensajeros(){
        $mensajeros = $this->usuarioModel->_getUsuariosRol(5);

        echo json_encode($mensajeros);
    }

    function getHorasEntrega(){
        $horasEntrega = $this->horariosEntregaModel->findAll();

        echo json_encode($horasEntrega);
    }

    public function pedidos() {
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['pedidos'] = $this->pedidoModel->_getPedidos();
            $data['horariosEntrega'] = $this->horariosEntregaModel->findAll();
            $data['estadosPedido'] = $this->estadoPedidoModel->findAll();
            $data['mensajeros'] = $this->usuarioModel->_getUsuariosRol(5);
            
            //echo '<pre>'.var_export($data['procedencias'], true).'</pre>';exit;
            $data['mensaje'] = '';
            $data['title']='Pedidos';
            $data['subtitle']='Listado de pedidos';
            $data['main_content']='ventas/grid-pedidos';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function pedido_edit($pedido) {
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['pedido'] = $this->pedidoModel->_getDatosPedido($pedido);
            $data['detalle'] = $this->detallePedidoModel->_getDetallePedido($data['pedido']->cod_pedido);
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['mensajeros'] = $this->usuarioModel->_getUsuariosRol(5);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['productos'] = $this->productoModel->findAll();
            $data['sectores'] = $this->sectoresEntregaModel->findAll();
            $data['horariosEntrega'] = $this->horariosEntregaModel->findAll();
            $data['bancos'] = $this->bancoModel->findAll();
            $data['procedencias'] = $this->procedenciaModel->findAll();

            //echo '<pre>'.var_export($data['detalle'], true).'</pre>';exit;
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
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['pedidos'] = $this->pedidoModel->_getPedidos();
            $data['mensajeros'] = $this->usuarioModel->_getUsuariosRol(5);
            //echo '<pre>'.var_export($data['mensajeros'], true).'</pre>';exit;
            $data['title']='Ventas';
            $data['subtitle']='Pedidos';
            $data['main_content']='ventas/grid-pedidos';
            return view('dashboard/index_ventana', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function cotizador(){

        $data = $this->acl();
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['productos'] = $this->productoModel->findAll();

            //delete de los items de la tabla temporal de hace un día
            $this->itemsProductoTempModel->_deleteItemsTempOld();

            //echo '<pre>'.var_export($data['productos'] , true).'</pre>';exit;
            $data['title']='Ventas';
            $data['subtitle']='Cotizar producto';
            $data['main_content']='ventas/form-cotizador';
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
