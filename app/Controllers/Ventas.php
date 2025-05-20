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
            
            //Borramos temporal de pedidos
            $this->detallePedidoTempModel->_deleteDetallesTempOld();
            
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['categorias'] = $this->categoriaModel->orderBy('categoria', 'asc')->findAll();
            $data['productos'] = $this->productoModel->findAll();
            $data['sectores'] = $this->sectoresEntregaModel->orderBy('sector', 'asc')->findAll();
            $data['horariosEntrega'] = $this->horariosEntregaModel->findAll();
            $data['cod_pedido'] = $this->session->codigo_pedido;
            $data['variablesSistema'] = $this->variablesSistemaModel->findAll();

            $data['detalle'] = $this->detallePedidoTempModel->where('cod_pedido', $data['cod_pedido'])
                                                            ->join('productos','productos.id = detalle_pedido_temp.idproducto')
                                                            ->findAll();
            //$data['detalle'] = $this->detallePedidoTempModel->_getDetallePedido($data['cod_pedido']);

            
            if ($data['cod_pedido'] != '' && isset($data['cod_pedido'])) {

                //Busco arreglos con este código en la tabla de temporales y de detalle y los elimino 
                $this->detallePedidoTempModel->_eliminarProdsDetalle($data['cod_pedido']);
                
                $data['title']='Ordenes y pedidos';
                $data['subtitle']='Nuevo pedido';
                $data['main_content']='ventas/form-pedido';
                return view('dashboard/index', $data);
            } else {
                
                $mensaje = 'SIN CODIGO';
                $this->session->set('mensaje', $mensaje);
                $data['title']='Pedidos';
                $data['subtitle']='Listado de pedidos';
                $data['main_content']='ventas/grid-pedidos';
                return view('dashboard/index', $data);
            }
            
        }else{
            return redirect()->to('logout');
        }
    }

    /*
     * Esta función recibe el código desde el archivo JS del navbar
     * y guarda en sesión el codigo
    */
    function generaCodigoPedido(){

        //En caso de que se haya quedado un código en sesión lo borro
        $this->session->set('codigo_pedido', '');

        //Recibo el código
        $codigo = $this->request->getPostGet('codigo');

        //pongo el código en la sesion
        $this->session->set('codigo_pedido', $codigo);

        $data['resultado'] = "Exito";
        echo json_encode($data);
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
            return redirect()->to('logout');
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
        //$cliente = $this->clienteModel->_getClienteByPhone($telefono);

        $cliente['respuesta'] = $this->clienteModel->where('telefono', $telefono)->orWhere('telefono_2', $telefono)->find();
        //echo $this->db->getLastQuery();
        
        //echo '<pre>'.var_export($cliente, true).'</pre>';exit;
        echo json_encode($cliente);
        //echo view('clientes_select', $data);
    }

    function get_valor_producto($producto){
        //$producto = $this->request->getPostGet('producto');
        $data['producto'] = $this->productoModel->_getProducto($producto);
        
        echo view('precio_producto', $data);
    }

    function get_valor_sector(){
        $sector = $this->request->getPostGet('sector');
        $data['sector'] = $this->sectoresEntregaModel->find($sector);
        
        echo json_encode($data);
        //echo view('precio_sector', $data);
    }

    function getDetallle(){
        $codigo = $this->request->getPostGet('codigo');
        $data['detalle'] = $this->detallePedidoTempModel->find($codigo);
        
        echo json_encode($data);
        //echo view('precio_sector', $data);
    }

    function actualizaMensajero($mensajero, $cod_pedido){

        if ($mensajero != 0 && $mensajero != NULL) {
            $this->pedidoModel->_actualizaMensajero($mensajero, $cod_pedido);
        }
        
        return true;
    }

    function actualizarHorarioEntrega(){

        $id = $this->request->getPostGet('id');

        $datos['rango_entrega_desde'] = $this->request->getPostGet('entregaDesde');
        $datos['rango_entrega_hasta'] = $this->request->getPostGet('entregaHasta');
        
        $this->pedidoModel->update($id, $datos);

        $data['entrega_desde'] = $datos['rango_entrega_desde'];
        $data['entrega_hasta'] = $datos['rango_entrega_hasta'];
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

    function getAttrExtraTicket(){

        $iddetalle = $this->request->getPostGet('iddetalle');
        $datos['infoExtra'] = $this->attrExtArregModel
                    ->where('iddetalle', $iddetalle)
                    ->first();
        //echo $this->db->getLastQuery();
        echo json_encode($datos);
    }

    function actualizaValorCampoTicket(){

        $id =  strtoupper($this->request->getPostGet('id'));
        $campo = $this->request->getPostGet('campo');

        //Verfica si tiene datos en la tabla
        $verifica = $this->attrExtArregModel->where('iddetalle', $id)->first();
        if ($verifica) {
            $this->attrExtArregModel
                    ->where('iddetalle', $id)
                    ->set([$campo => strtoupper($this->request->getPostGet('valor'))])
                    ->update();
        } else {
            $prod = [
                'iddetalle' => $id,
                $campo => strtoupper($this->request->getPostGet('valor')),
            ];
            $this->attrExtArregModel->insert($prod);
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

    function updateDevolucion(){
        $id = $this->request->getPostGet('id');
        $valor_devuelto = $this->request->getPostGet('valor_devuelto');
        $observacionDevolucion = strtoupper($this->request->getPostGet('observacionDevolucion'));
        
        if ($valor_devuelto != '0.00' && $valor_devuelto != '') {
            $data = [
                'valor_devuelto' => $valor_devuelto,
                'observacion_devolucion' => $observacionDevolucion
            ];
        } else {
            $data = [
                'valor_devuelto' => '0.00',
                'observacion_devolucion' => ''
            ];
        }
        
        $this->pedidoModel->update($id, $data);
        //return true;
    }

    function deleteItemsTempProduct(){

        $idproducto = $this->request->getPostGet('idproducto');

        $res = $this->itemsProductoTempModel->_deleteItems($idproducto);
        return true;
    }

    function deleteItemsTempProductCotizador(){

        $new_id = $this->request->getPostGet('new_id');

        $this->itemsProductoTempModel->where('new_id', $new_id)->delete();
        //echo $this->db->getLastQuery();exit;
        return true;
    }

    function get_costo_horario(){

        $horario = $this->request->getPostGet('horario');
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
                
                $this->detallePedidoTempModel->insert($data);
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

    function detalle_pedido_insert_observacion_temp(){
        $error = '';
        $idproducto = $this->request->getPostGet('idproducto');
        $cod_pedido = $this->request->getPostGet('cod_pedido');
        $observacion = $this->request->getPostGet('observacion');

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

    function actualizaMensajeSession(){
        $this->session->set('mensaje', '3');
        $res['msj'] = '3';
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
        $newId = $idproducto.$lastId.$this->session->id.rand(1,99);

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
            $idnegocio = 1;

            //Si el pedido tiene el detalle de bocaditos $idnegocio = 2, es decir se un pedido de karana
            if ($detalleTemporal[0]->idcategoria == 5) {
                $idnegocio = 2;
            }
            
            if ($this->request->getPostGet('sin_remitente') != null) {
                $sin_remitente = $this->request->getPostGet('sin_remitente');
            } else {
                $sin_remitente = 0;
            }

            $pedidos = $this->pedidoModel->orderBy('orden', 'asc')->findAll();
            
            $pedido = [
                'cod_pedido' => $cod_pedido,
                'idusuario' => $data['id'],
                'fecha' => date('Y-m-d'),
                'idcliente' => $this->request->getPostGet('idcliente'),
                'sin_remitente' => $sin_remitente,
                
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
                'rango_entrega_desde' => $this->request->getPostGet('rango_entrega_desde'),
                'rango_entrega_hasta' => $this->request->getPostGet('rango_entrega_hasta'),
                'cargo_domingo' => $this->request->getPostGet('cargo_domingo'),
                'valor_mensajero_edit' => $this->request->getPostGet('valor_mensajero_edit'),
                'valor_mensajero' => $this->request->getPostGet('valor_mensajero'),
                'total' => $this->request->getPostGet('total'),
                'idnegocio' => $idnegocio
                
            ];
            

            $clienteID = $this->request->getPostGet('idcliente');
            $cliente = [
                'nombre' => $this->request->getPostGet('nombre'),
                'telefono' => $this->request->getPostGet('telefono'),
                'telefono_2' => $this->request->getPostGet('telefono_2'),
                'documento' => $this->request->getPostGet('documento'),
                'direccion' => '',
                'email' => strtolower($this->request->getPostGet('email')),
            ];
            

            //VALIDACIONES
            $this->validation->setRuleGroup('pedidoInicial');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                $this->session->set('mensaje', 0);
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                
                //Verifico que exista el cliente, si no existe lo creo y si exiete solo inserto el id
                $clienteExiste = $this->clienteModel->where('telefono', $cliente['telefono'])->find($clienteID);
                
                if ($clienteExiste) {

                    //Actualizo los datos del cliente
                    $cliente = [
                        'nombre' => $this->request->getPostGet('nombre'),
                        'telefono' => $this->request->getPostGet('telefono'),
                        'telefono_2' => $this->request->getPostGet('telefono_2'),
                        'documento' => $this->request->getPostGet('documento'),
                        'direccion' => '',
                        'email' => strtolower($this->request->getPostGet('email')),
                    ];
                    $this->clienteModel->update($clienteID, $cliente);

                    //Inserto el nuevo pedido
                    if ($pedido) {
                        //Verifico si el código de pedido existe
                        $codPedidoExists = $this->pedidoModel->where('cod_pedido', $pedido['cod_pedido'])->findAll();

                        if ($codPedidoExists) {
                            $aleatorio = rand(0, 100);
                            $pedido['cod_pedido'] = $pedido['cod_pedido'] + $aleatorio;
                        }

                        foreach ($pedidos as $p) {
                            // $pedido['orden'] = $pedido['orden']+1;
                            if ($p->orden != 0) {
                                $datos = [
                                    'orden' => $p->orden + 1
                                ];
    
                                $this->pedidoModel->update($p->id, $datos);
                            }
                        }
                        $idPedidoInsertado = $this->pedidoModel->_insert($pedido);

                        //Inserto el detalle
                        if ($detalleTemporal) {
                            $this->detallePedidoModel->_insert($detalleTemporal);
                            $this->detallePedidoTempModel->_delete($detalleTemporal);
                            
                            $mensaje = 1;

                        }else{
                            $mensaje = 'SIN DETALLE';
                        }
                    }else{
                        $mensaje = 0;
                    }

                    $this->session->set('mensaje', $mensaje);
                    return redirect()->to('pedidos');

                }else{

                    $cliente = [
                        'nombre' => $this->request->getPostGet('nombre'),
                        'telefono' => $this->request->getPostGet('telefono'),
                        'telefono_2' => $this->request->getPostGet('telefono2'),
                        'documento' => $this->request->getPostGet('documento'),
                        'direccion' => '',
                        'email' => strtolower($this->request->getPostGet('email')),
                    ];


                    //Inserto el cliente nuevo
                    $pedido['idcliente'] = $this->clienteModel->insert($cliente);

                    //Inserto el nuevo pedido
                    if ($pedido) {
                        
                        //Verifico si el código de pedido existe 
                        //PABLO PROBABLEMENTE DEBO PONER ESTO EN UNA FUNCIÓN APARTE
                        $codPedidoExists = $this->pedidoModel->where('cod_pedido', $pedido['cod_pedido'])->findAll();

                        if ($codPedidoExists) {
                            $aleatorio = rand(0, 100);
                            $pedido['cod_pedido'] = $pedido['cod_pedido'] + $aleatorio;
                        }

                        foreach ($pedidos as $p) {
                            // $pedido['orden'] = $pedido['orden']+1;
                            if ($p->orden != 0) {
                                $datos = [
                                    'orden' => $p->orden + 1
                                ];
    
                                $this->pedidoModel->update($p->id, $datos);
                            }
                        }
                        $this->pedidoModel->_insert($pedido);

                        //Inserto el detalle
                        if ($detalleTemporal) {
                            $this->detallePedidoModel->_insert($detalleTemporal);
                            $this->detallePedidoTempModel->_delete($detalleTemporal);

                            $mensaje = 1;
                        }else{
                            $mensaje = 'SIN DETALLE';
                        }
                    }else{
                        $mensaje = 0;
                    }

                    $this->session->set('mensaje', $mensaje);
                    return redirect()->to('pedidos');
                }
            }
        }else{

            return redirect()->to('logout');
        }
    }

    public function pedido_update(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            $cod_pedido = $this->request->getPostGet('cod_pedido');
            $detalleTemporal = $this->detallePedidoTempModel->_getDetallePedido($cod_pedido);
            $detallePedido = $detalle = $this->detallePedidoModel->where('cod_pedido', $cod_pedido)->find();

            $pedido = [
                'id' => $this->request->getPostGet('idpedido'),
                'cod_pedido' => $cod_pedido,
                'idusuario' => $data['id'],
                'fecha' => date('Y-m-d'),
                'idcliente' => $this->request->getPostGet('idcliente'),
                'sin_remitente' => $this->request->getPostGet('sin_remitente'),

                'fecha_entrega' => $this->request->getPostGet('fecha_entrega'),
                'horario_entrega' => $this->request->getPostGet('horario_entrega'),
                'sector' => $this->request->getPostGet('sectores'),
                'procedencia' => $this->request->getPostGet('procedencia'),
                'dir_entrega' => $this->request->getPostGet('dir_entrega'),
                'ubicacion' => $this->request->getPostGet('ubicacion'),
                'observaciones' => $this->request->getPostGet('observaciones'),
                          
                'vendedor' => $this->request->getPostGet('vendedor'),
                'mensajero' => $this->request->getPostGet('mensajero'),
                'mensajero_extra' => $this->request->getPostGet('mensajero_extra'),
                'venta_extra' => $this->request->getPostGet('venta_extra'),

                'formas_pago' => $this->request->getPostGet('formas_pago'),
                'banco' => $this->request->getPostGet('banco'),
                'ref_pago' => $this->request->getPostGet('ref_pago'),
               
                //TOTALES
                'valor_neto' => $this->request->getPostGet('valor_neto'),
                'descuento' => $this->request->getPostGet('descuento'),
                'transporte' => $this->request->getPostGet('transporte'),
                'horario_extra' => $this->request->getPostGet('horario_extra'),
                'rango_entrega_desde' => $this->request->getPostGet('rango_entrega_desde'),
                'rango_entrega_hasta' => $this->request->getPostGet('rango_entrega_hasta'),
                'cargo_domingo' => $this->request->getPostGet('cargo_domingo'),
                'valor_mensajero_edit' => $this->request->getPostGet('valor_mensajero_edit'),
                'valor_mensajero' => $this->request->getPostGet('valor_mensajero'),
                'valor_mensajero_extra' => $this->request->getPostGet('valor_mensajero_extra'),
                'total' => $this->request->getPostGet('total'),
                'idnegocio' => 1,
            ];
            
            $pedidoProcedencia = $this->pedidoProcedenciaModel->where('idpedidos', $pedido['id'])->first();
            
            $clienteID = $this->request->getPostGet('idcliente');
            $cliente = [
                'nombre' => $this->request->getPostGet('nombre'),
                'telefono' => $this->request->getPostGet('telefono'),
                'telefono_2' => $this->request->getPostGet('telefono_2'),
                'documento' => $this->request->getPostGet('documento'),
                'direccion' => '',
                'email' => strtolower($this->request->getPostGet('email')),
            ];
            
            //VALIDACIONES
            $this->validation->setRuleGroup('pedidoUpdate');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                $this->session->set('mensaje', 0);
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                
                //Verifico que exista el cliente, si no existe lo creo y si existe solo inserto el id
                $clienteExiste = $this->clienteModel->where('telefono', $cliente['telefono'])->find($clienteID);
                
                if ($clienteExiste) {

                    //Actualizo los datos del cliente
                    $cliente = [
                        'nombre' => $this->request->getPostGet('nombre'),
                        'telefono' => $this->request->getPostGet('telefono'),
                        'telefono_2' => $this->request->getPostGet('telefono_2'),
                        'documento' => $this->request->getPostGet('documento'),
                        'direccion' => '',
                        'email' => strtolower($this->request->getPostGet('email')),
                    ];
                    $this->clienteModel->update($clienteID, $cliente);

                    //Actualizo el nuevo pedido y la procedencia
                    if ($pedido) {
                        $this->pedidoModel->_update($pedido);

                        //Procedencia
                        if (isset($pedido['procedencia']) && $pedido['procedencia'] != '' && $pedido['procedencia'] != '0') {
                            $this->actualizoProcedenciaPedido($pedido);
                        }

                        $mensaje = 1;
                    }else{
                        $mensaje = 0;
                    }

                    //Inserto el detalle actualizado (MODIFICAR ESTA FUNCION PARA USAR EL MODELO Y TENER HISTORIAL DE CAMBIOS)
                    if ($detalleTemporal) {

                        //Borro los items que están en la tabla detalle y que fueron borrados de la temporal
                        foreach ($detallePedido as $key => $value) {
                            $existe = $this->detallePedidoTempModel->where('cod_pedido', $value->cod_pedido)->where('idproducto', $value->idproducto)->find();

                            if (!$existe) {
                                //Borro ese item de la tala detalle pedido
                                $this->detallePedidoModel->where('cod_pedido', $value->cod_pedido)->where('idproducto', $value->idproducto)->delete();
                            }
                        }
                        
                        //Hago update o Insert de los detalles
                        foreach ($detalleTemporal as $key => $value) {
                            $detalle = $this->detallePedidoModel->where('cod_pedido', $value->cod_pedido)->where('idproducto', $value->idproducto)->find();
                            
                            //VERIFICO SI EL ARREGLO EXISTE EN LA TABLA
                            if ($detalle) {
                                //Si existe ACTUALIZA
                                $registro = [
                                    'cantidad' => $value->cantidad,
                                    'precio' => $value->precio,
                                    'pvp' =>  $value->pvp,
                                    'subtotal' => $value->subtotal,
                                    'observacion' => $value->observacion,
                                ];
                                $this->detallePedidoModel->update($detalle[0]->id, $registro);
                            } else {
                                //Si no existe INSERTA
                                $registro = [
                                    'cod_pedido' => $value->cod_pedido,
                                    'idproducto' => $value->idproducto,
                                    'cantidad' => $value->cantidad,
                                    'precio' => $value->precio,
                                    'pvp' =>  $value->pvp,
                                    'subtotal' => $value->subtotal,
                                    'observacion' => $value->observacion,
                                ];
                                $this->detallePedidoModel->insert($registro);
                            }

                        }

                        //Borro el detalle temporal de la tabla temporal
                        $this->detallePedidoTempModel->where('cod_pedido', $cod_pedido)->delete();

                        //Actualizo el mensaje
                        $mensaje = 1;

                    }else{
                        $mensaje = 0;
                    }
                    $this->session->set('mensaje', $mensaje);
                    return redirect()->to('pedidos');
                }else{

                    $cliente = [
                        'nombre' => $this->request->getPostGet('nombre'),
                        'telefono' => $this->request->getPostGet('telefono'),
                        'telefono_2' => $this->request->getPostGet('telefono2'),
                        'documento' => $this->request->getPostGet('documento'),
                        'direccion' => '',
                        'email' => strtolower($this->request->getPostGet('email')),
                    ];

                    //Inserto el cliente nuevo
                    $pedido['idcliente'] = $this->clienteModel->insert($cliente);

                    //Actualizo el nuevo pedido y la procedencia
                    if ($pedido) {
                        $this->pedidoModel->_update($pedido);

                        //Procedencia
                        if (isset($pedido['procedencia']) && $pedido['procedencia'] != '' && $pedido['procedencia'] != '0') {
                            $this->actualizoProcedenciaPedido($pedido);
                        }

                        $mensaje = 1;
                    }else{
                        $mensaje = 0;
                    }

                    //Inserto el detalle actualizado (MODIFICAR ESTA FUNCION PARA USAR EL MODELO Y TENER HISTORIAL DE CAMBIOS)
                    if ($detalleTemporal) {

                        //Elimino el detalle anterior antes de insertar el detalle actualizado
                        $this->detallePedidoModel->where('cod_pedido', $cod_pedido)->delete();
                        
                        //Inserto el detalle editado
                        $this->detallePedidoModel->_insert($detalleTemporal);

                        //Borro el detalle temporal de la tabla temporal
                        $this->detallePedidoTempModel->where('cod_pedido', $cod_pedido)->delete();

                        //Actualizo el mensaje
                        $mensaje = 1;

                    }else{
                        $mensaje = 0;
                    }

                    //Actualizo el mensaje
                    $mensaje = 1;

                    $this->session->set('mensaje', $mensaje);
                    return redirect()->to('pedidos');
                }
                
            }
            
        }else{

            return redirect()->to('logout');
        }
    }

    function actualizoProcedenciaPedido($pedido){

        //Verifico si el pedido tiene una procedencia asignada
        $procedencia = $this->pedidoProcedenciaModel->where('idpedidos', $pedido['id'])->first();
        
        $data = [
            'idpedidos' => $pedido['id'],
            'idprocedencia' => $pedido['procedencia']
        ];

        if ($procedencia) {
            //Actualizo
            $this->pedidoProcedenciaModel->update($procedencia->id, $data);
            
        } else {
            //Inserto
            $this->pedidoProcedenciaModel->insert($data);echo $this->db->getLastQuery();
        }
    }

    function getEstadosPedido(){
        $estadosPedido = $this->estadoPedidoModel->findAll();

        echo json_encode($estadosPedido);
    }

    function getMensajeros(){
        
        $mensajeros = $this->usuarioModel->where('idroles', 5)->where('estado', 1)->orderBy('nombre', 'asc')->findAll();

        echo json_encode($mensajeros);
    }

    function getHorasEntrega(){
        $horasEntrega = $this->horariosEntregaModel->findAll();

        echo json_encode($horasEntrega);
    }

    function guardaOrden(){
        $pedidos = $this->request->getPostGet('pedidos');
        foreach ($pedidos as $key => $pedido) {
            //echo ($key+1).'-'.$pedido.'<br>';
            $data = [
                'orden' => ($key+1)
            ];
            $this->pedidoModel->update($pedido, $data);
        }

        //echo json_encode($estadosPedido);
    }

    public function pedidos() {
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->where('estado', '1')->findAll();
            
            $data['pedidos'] = $this->pedidoModel->_getPedidos();
            $data['horariosEntrega'] = $this->horariosEntregaModel->findAll();
            $data['estadosPedido'] = $this->estadoPedidoModel->findAll();
            $data['mensajeros'] = $this->usuarioModel->where('idroles', 5)->where('estado', 1)->orderBy('nombre', 'asc')->findAll();

            $data['title']='Pedidos';
            $data['subtitle']='Listado de pedidos';
            $data['main_content']='ventas/grid-pedidos';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function pedido_edit($idpedido) {
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['pedido'] = $this->pedidoModel->_getDatosPedido($idpedido);
            // $data['detalle'] = $this->detallePedidoModel
            //                 ->where('cod_pedido', $data['pedido']->cod_pedido)
            //                 ->join('productos','productos.id=detalle_pedido.idproducto')
            //                 ->findAll();

            //echo '<pre>'.var_export($data['pedido'], true).'</pre>';exit;

            //Traigo el detalle del pedido
            $data['detalle'] = $this->detallePedidoModel->_getDetallePedido($data['pedido']->cod_pedido);

            //Elimino el detalle del pedido en la tabla temporal en caso de que exista
            $this->detallePedidoTempModel->where('cod_pedido', $data['pedido']->cod_pedido)->delete();
            
            //Inserto el detalle del pedido en la tabla temporal para poder editarlo
            if (isset($data['detalle'])) {
                foreach ($data['detalle'] as $key => $detalle) {
                    $datos = [
                        'cod_pedido' => $detalle->cod_pedido,
                        'idproducto' => $detalle->idproducto,
                        'cantidad' => $detalle->cantidad,
                        'precio' => $detalle->precio,
                        'pvp' => $detalle->pvp,
                        'subtotal' => $detalle->subtotal,
                        'observacion' => $detalle->observacion,
                    ];
    
                    $this->detallePedidoTempModel->insert($datos);
                }
            }

            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['mensajeros'] = $this->usuarioModel->where('idroles', 5)->where('estado', 1)->orderBy('nombre', 'asc')->findAll();
            $data['formas_pago'] = $this->formaPagoModel->where('estado',1)->orderBy('forma_pago', 'asc')->findAll();
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['productos'] = $this->productoModel->findAll();
            $data['sectores'] = $this->sectoresEntregaModel->orderBy('sector', 'asc')->findAll();
            $data['horariosEntrega'] = $this->horariosEntregaModel->findAll();
            $data['bancos'] = $this->bancoModel->where('estado',1)->orderBy('banco', 'asc')->findAll();
            $data['procedencias'] = $this->procedenciaModel->orderBy('procedencia', 'asc')->findAll();
            $data['variablesSistema'] = $this->variablesSistemaModel->findAll();
            $data['pedidoProcedencia'] = $this->pedidoProcedenciaModel->where('idpedidos', $data['pedido']->id)->first();

            //echo '<pre>'.var_export($data['pedidoProcedencia'], true).'</pre>';exit;
            $data['title']='Ventas';
            $data['subtitle']='Editar Pedido';
            $data['main_content']='ventas/form-pedido-edit';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function pedidos_ventana() {
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['vendedores'] = $this->usuarioModel->_getUsuariosRol(4);
            $data['formas_pago'] = $this->formaPagoModel->findAll();
            $data['pedidos'] = $this->pedidoModel->_getPedidos();
            $data['mensajeros'] = $this->usuarioModel->where('idroles', 5)->where('estado', 1)->orderBy('nombre', 'asc')->findAll();
            //echo '<pre>'.var_export($data['mensajeros'], true).'</pre>';exit;
            $data['title']='Ventas';
            $data['subtitle']='Pedidos';
            $data['main_content']='ventas/grid-pedidos';
            return view('dashboard/index_ventana', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function cotizador(){

        $data = $this->acl();
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['categorias'] = $this->categoriaModel->orderBy('categoria', 'asc')->findAll();
            $data['productos'] = $this->productoModel->orderBy('producto', 'asc')->findAll();

            //delete de los items de la tabla temporal de hace un día
            $this->itemsProductoTempModel->_deleteItemsTempOld();

            //echo '<pre>'.var_export($data['productos'] , true).'</pre>';exit;
            $data['title']='Ventas';
            $data['subtitle']='Cotizar producto';
            $data['main_content']='ventas/form-cotizador';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }    
}
