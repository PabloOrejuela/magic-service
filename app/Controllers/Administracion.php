<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VariablesSistemaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Administracion extends BaseController {

    public function index() {

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            //echo '<pre>'.var_export($data['vendedores'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Administración';
            $data['main_content']='administracion/admin_home';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function desactivar() {

        $this->logout();
        $this->configuracionModel->_desactivar();
        $data['mensaje'] = "El sistema se encuentra en desarrollo, por favor vuelva mas tarde";
        $data['title']='Magic Service';
        $data['main_content']='home/mantenimiento_view';
        return view('includes/template_login', $data);
    }

    public function user_delete() {

        $id = $this->request->getPostGet('id');
         $data = [
            'logged' => 0,
            'ip' => null,
            'estado' => 0
         ];
        $res = $this->usuarioModel->update($id, $data);
        
        echo json_encode($res);
    }

    public function sign_off() {

        $res = $this->usuarioModel->_signOff($this->request->getPostGet('id'));
        
        echo json_encode($res);
    }

    public function user_cambia_estado() {

        $id = $this->request->getPostGet('id');
        $estado = $this->request->getPostGet('estado');

        if ($estado == 0) {
            $data = [
                'estado' => 1
            ];

        } else {
            $data = [
                'estado' => 0
            ];
        }
        
        $res = $this->usuarioModel->update($id, $data);
        
        echo json_encode($res);
    }

    public function user_estado_ventas() {

        $id = $this->request->getPostGet('id');
        $esVendedor = $this->request->getPostGet('es_vendedor');

        if ($esVendedor == 0) {
            $data = [
                'es_vendedor' => 1
            ];

        } else {
            $data = [
                'es_vendedor' => 0
            ];
        }
        
        $res = $this->usuarioModel->update($id, $data);
        
        echo json_encode($res);
    }

    public function asigna_rol_2() {

        $id = $this->request->getPostGet('id');
        $idrol_2 = $this->request->getPostGet('idrol_2');
        $noAsignar = $this->request->getPostGet('noAsignar');

        //Si está asignado no asignar le quitarmos el segundo rol
        if ($noAsignar == 'true') {

            if (isset($idrol_2) && $idrol_2 == 4) {
                $data = [
                    'idrol_2' => 0,
                    'es_vendedor' => 0
                ];
            }else {
                $data = [
                    'idrol_2' => 0,
                ];
            }
            
        }else{
            if (isset($idrol_2) && $idrol_2 == 4) {
                $data = [
                    'idrol_2' => $idrol_2,
                    'es_vendedor' => 1
                ];
            }else {
                $data = [
                    'idrol_2' => $idrol_2,
                ];
            }
        }
        
        $res = $this->usuarioModel->update($id, $data);
        
        echo json_encode($res);
    }

    public function productos() {

        if ($this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['productos'] = $this->productoModel->_getProductos();

            //delete de los items de la tabla temporal de hace un día
            $this->itemsProductoTempModel->_deleteItemsTempOld();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Productos';
            $data['main_content']='administracion/grid_productos';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function getProductosCategoria($categoria){
        
        //$productos = $this->productoModel->_getProductosCategoria($categoria );
        $productos = $this->productoModel->where('idcategoria', $categoria)->orderBy('producto', 'asc')->find();
        echo json_encode($productos);
    }

    public function getItemsProducto($producto){
        
        $items = $this->itemsProductoModel->_getItemsProducto($producto );
        echo json_encode($items);
    }

    public function getSucursales(){
        
        $sucursales = $this->sucursalModel->findAll();
        echo json_encode($sucursales);
    }

    public function itemSensibleUpdate($item, $sensible){
        
        if ($sensible == 1) {
            $data = [
                'sensible_temporada' => 0
            ];
            
        } else {
            $data = [
                'sensible_temporada' => 1
            ];
        }

        $this->itemModel->update($item, $data);

        $data['session'] = $this->session;

        return redirect()->to('items');
    }

    public function productosRelacionados($item){
        
        if ($this->session->admin == 1) {

            $data['session'] = $this->session;

            $data['productos'] = $this->itemsProductoModel
                ->select('items_productos.id as idItemProducto,idproducto,producto,image')
                ->where('item', $item)
                ->join('productos', 'productos.id=items_productos.idproducto')
                ->orderBy('producto', 'asc')
                ->findAll();

            $data['title']='Administración';
            $data['subtitle']='Productos relacionados';
            $data['main_content']='administracion/productos_relacionados_item';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function sucursales() {
        
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['sucursales'] = $this->sucursalModel->orderBy('sucursal', 'asc')->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Sucursales';
            $data['main_content']='administracion/grid_sucursales';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Formulario para registrar un nuevo sector de entrega
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function form_sestor_entrega_create() {

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['sucursales'] = $this->sucursalModel->findAll();
            // $data['items'] = $this->itemModel->findAll();

            //echo '<pre>'.var_export($data, true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Registrar sector de entrega';
            $data['main_content']='administracion/form_sector_entrega_new';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function sectoresEntrega() {

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['sectores'] = $this->sectoresEntregaModel->_getSectores();
            $data['sucursales'] = $this->sucursalModel->orderBy('sucursal', 'asc')->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Sectores de entrega';
            $data['main_content']='administracion/grid_sectores_entrega';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function variablesSistema() {

        
        $this->variablesSistemaModel = new VariablesSistemaModel($this->db);

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['variables'] = $this->variablesSistemaModel->orderBy('variable', 'asc')->findAll();

            //echo '<pre>'.var_export($data['variables'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Editar variables del Sistema';
            $data['main_content']='administracion/frm_edit_variables_sistema';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function items() {

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['items'] = $this->itemModel->findAll();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Items';
            $data['main_content']='administracion/grid_items';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function gestion_inventario() {

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['items'] = $this->itemModel->_getItemsCuantificables();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Items';
            $data['main_content']='administracion/grid_items';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Formulario para editar información de los items que conforman los productos
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function form_item_edit($id) {

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['item'] = $this->itemModel->find($id);

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Editar Item';
            $data['main_content']='administracion/form-item-edit';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }
    
    /*
    * Recibe info del form de edit Item y actualiza
    *
    * @param Type var post
    * @return void
    * @throws conditon
    * @date 10-10-2023
    */
    public function item_update() {
    
        if ($this->session->admin == 1) {
            $id = $this->request->getPostGet('id');
            $item = [
                'item' => strtoupper($this->request->getPostGet('item')),
                'precio' => strtoupper($this->request->getPostGet('precio')),

            ];
            //echo '<pre>'.var_export($item, true).'</pre>';exit;
            $this->itemModel->update($id, $item);
            //echo $this->db->getLastQuery();exit;

            return redirect()->to('items');
        }else{

            $this->logout();
        }
        
    }

    public function actualizaPrecioItem() {

        $id = $this->request->getPostGet('id');
        $item = [
            'precio' => strtoupper($this->request->getPostGet('precio')),

        ];
        //echo '<pre>'.var_export($item, true).'</pre>';exit;
        $id = $this->itemModel->update($id, $item);
        return $id;
    }

    public function actualizaPermiso() {

        $id = $this->request->getPostGet('id');
        $campo = $this->request->getPostGet('campo');

        //Obtengo el permiso actual
        $permisoActual = $this->rolModel->find($id);

        $permisoActualArray = get_object_vars( $permisoActual );
        
        if ($permisoActualArray[''.$campo.''] == 1) {
            $permiso = 0;
        }else if($permisoActualArray[''.$campo.''] == 0){
            $permiso = 1;
        }
        
        $id = $this->rolModel->_updatePermiso($id, $permiso, $campo);

        return $id;
    }

    public function cambia_attr_temp_producto() {

        $id = $this->request->getPostGet('id');
        $producto = [
            'attr_temporal' => 0,
            'estado' => 1
        ];
        
        $this->productoModel->update($id, $producto);
        $data['id'] = $id;
        return json_encode($data);
    }

    public function set_arreg_temp_definitivo($idproducto) {

        $producto = [
            'attr_temporal' => 0,
            'estado' => 1
        ];
        
        $id = $this->productoModel->update($idproducto, $producto);
        $data['id'] = $id;
        return json_encode($data);
    }

    public function updateVariableSistema() {
    
        $this->variablesSistemaModel = new VariablesSistemaModel($this->db);

        if ($this->session->admin == 1) {
            $id = $this->request->getPostGet('id');

            $variable = [
                'valor' => $this->request->getPostGet('value'),

            ];
            //echo '<pre>'.var_export($variable, true).'</pre>';exit;
            $this->variablesSistemaModel->update($id, $variable);
            //echo $this->db->getLastQuery();exit;

            return redirect()->to('variables-sistema');
        }else{

            $this->logout();
        }
    }

    public function item_cuantificable_update($id, $valor) {

        $data = [
            'cuantificable' => $valor
        ];
    
        $this->itemModel->update($id, $data);
        
        return redirect()->to('items');
    }

    /*
    * Recibe info del form y cambia el estado
    *
    * @param Type var post
    * @return void
    * @throws conditon
    * @date 10-10-2023
    */
    public function item_delete($id) {
    
        if ($this->session->admin == 1) {

            $item = [
                'id' => $id,
            ];
            //echo '<pre>'.var_export($item, true).'</pre>';exit;
            $this->itemModel->_itemDelete($item);
            return redirect()->to('items');
        }else{

            $this->logout();
        }
    }

    /*
    * undocumented function summary
    *
    * @param Type var Description
    * @return object
    * @throws conditon
    * @date fecha
    */
    public function formas_pago() {
    
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['formas_pago'] = $this->formaPagoModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Formas de pago';
            $data['main_content']='administracion/grid_formas_pago';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
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
    public function forma_pago_delete($id, $estado) {
    
        if ($this->session->admin == 1) {

            if ($estado == 1) {
                $dato = [
                    'estado' => 0,
                ];
            } else {
                $dato = [
                    'estado' => 1,
                ];
            }

            $this->formaPagoModel->update($id, $dato);

            return redirect()->to('formas-pago');
        }else{

            return redirect()->to('logout');
        }
    }

    /*
    * undocumented function summary
    *
    * @param Type var Description
    * @return object
    * @throws conditon
    * @date fecha
    */
    public function instituciones_financieras() {
    
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['institucionesFinancieras'] = $this->bancoModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Instituciones Financieras';
            $data['main_content']='administracion/grid_instituciones_finacieras';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    
    }

    public function institucion_financiera_new(){
        
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->orderBy('rol', 'asc')->findAll();

            //echo '<pre>'.var_export($data['roles'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Nueva Institucion Financiera';
            $data['main_content']='administracion/institucion-financiera-create';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /*
    * Recibe info del form y cambia el estado de la IF
    *
    * @param Type var get
    * @return void
    * @throws conditon
    * @date 08-10-2024
    */
    public function institucion_financiera_delete($id, $estado) {
    
        if ($this->session->admin == 1) {

            if ($estado == 1) {
                $dato = [
                    'estado' => 0,
                ];
            } else {
                $dato = [
                    'estado' => 1,
                ];
            }

            $this->bancoModel->update($id, $dato);

            return redirect()->to('institucion-financiera');
        }else{

            return redirect()->to('logout');
        }
    }

    public function institucion_financiera_create(){

        if ($this->session->admin == 1) {

            $institucion = [
                'banco' => $this->request->getPostGet('banco'),
            ];
            
            $this->validation->setRuleGroup('inst_financiera');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                //echo '<pre>'.var_export($item, true).'</pre>';exit;
                $this->bancoModel->insert($institucion);

                return redirect()->to('institucion-financiera');
            }
            
        }else{

            return redirect()->to('logout');
        }
    }

    /*
    * undocumented function summary
    *
    * @param Type var Description
    * @return object
    * @throws conditon
    * @date fecha
    */
    public function usuarios() {
    
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['usuarios'] = $this->usuarioModel->_getAllUsers();

            //echo '<pre>'.var_export($data['usuarios'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Usuarios';
            $data['main_content']='administracion/grid_usuarios';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    
    }

    public function estado(){

        if ($this->session->admin == 1) {

            $data['session'] = $this->session;
            $data['estado'] = $this->estadoSistema();
            
            $data['title']='Administración';
            $data['subtitle']='Estado del sistema';
            $data['main_content']='administracion/frm_estado';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function estadoSistema(){
        return $this->configuracionModel->findAll();
    }

    /*
    * undocumented function summary
    *
    * @param Type var Description
    * @return object
    * @throws conditon
    * @date fecha
    */
    public function roles() {
    
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['roles'] = $this->rolModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Roles y permisos';
            $data['main_content']='administracion/grid_roles';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    
    }

    function getRoles(){
        $data['roles'] = $this->rolModel->findAll();

        echo json_encode($data);
    }

    function getCantidadItemsSensibles(){
        $fechaInicio= $this->request->getPostGet('fechaInicio');
        $fechaFinal= $this->request->getPostGet('fechaFinal');

        $itemsArray = NULL;
        $consolidadoArray = NULL;
        $data['error'] = '';

        //Hago la consulta
        $pedidos = $this->pedidoModel->_getPedidosRangoFechas($fechaInicio, $fechaFinal);
        $itemsSensibles = $this->itemModel->select('id,item')->where('sensible_temporada', 1)->findAll();
        foreach ($itemsSensibles as $its) {
            $itemSensibleArray[] = $its->id;
        }

        if ($pedidos) {
            
            foreach ($pedidos as $key => $pedido) {
                //extraigo el detalle de cada pedido
                $detalles = $this->detallePedidoModel->select('id,cod_pedido,idproducto,cantidad')->where('cod_pedido', $pedido->cod_pedido)->findAll();
                foreach ($detalles as $key => $detalle) {
                    //echo $detalle->idproducto.'<br>';
                    $itemsProductos = $this->itemsProductoModel->select('items_productos.item as item,items.item as nombre_item, idproducto,porcentaje')
                                                                ->join('items','items.id=items_productos.item')
                                                                ->where('idproducto', $detalle->idproducto)->findAll();
                    //echo '<pre>'.var_export($itemsProductos, true).'</pre>';exit;
                    foreach ($itemsProductos as $key => $item) {
                        if (in_array($item->item, $itemSensibleArray)) {
                            $itemsArray[] = [
                                'idproducto' => $detalle->idproducto,
                                'cod_pedido' => $detalle->cod_pedido,
                                'item' => $item->item,
                                'nombreItem' => $item->nombre_item,
                                'cantidad' => $detalle->cantidad,
                                'porcentaje' => $item->porcentaje
                            ];
                        }
                    }
                }
            }
        }else{
            $data['error'] = "ERROR";
        }
        $data['itemsSensibles'] = $itemsSensibles;
        $data['resultado'] = $itemsArray;
        echo json_encode($data);
    }     

    /**
     * Formulario para crear un nuevo producto
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function form_producto_create() {

        if ($this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['categorias'] = $this->categoriaModel->orderBy('categoria', 'asc')->findAll();
            $data['productos'] = $this->productoModel->findAll();

            //delete de los items de la tabla temporal de hace un día
            //$this->itemsProductoTempModel->_deleteItemsTempOld();
            $this->itemsProductoTempModel->_deleteItemsTempOld();
            $data['lastId'] = $this->productoModel->_getLastId();

            $data['newId'] = $data['lastId'].(rand(0, 9999));

            //En caso de haber items temporales asignados a ese id los borro
            $this->itemsProductoTempModel->_deleteItems($data['newId']);

            $data['title']='Administración';
            $data['subtitle']='Nuevo producto';
            $data['main_content']='administracion/form-new-product';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function product_insert(){

        if ($this->session->ventas == 1) {

            $producto = [
                'idusuario' => $this->session->id,
                'producto' => strtoupper($this->request->getPostGet('producto')),
                'categoria' => strtoupper($this->request->getPostGet('categoria')),
                'precio' => strtoupper($this->request->getPostGet('precio')),
                'items' => $this->request->getPostGet('items'),
                'elementos' => $this->request->getPostGet('elementos'),
                'cantidad' => $this->request->getPostGet('cantidad'),
                'imagen' => 'nombre de la imagen'
            ];
            
            //Creo la ruta alas imágenes
            $ruta = './public/images/productos/'.$producto['imagen'].'/';

            //Recibo la imagen
            $imagen = $this->request->getFile('imagen');
            $img_name = '';

            if (!$imagen->isValid()) {
                //SI NO ES VÁLIDO PASO VACÍO AL NOMBRE
                $img_name = '';

            }else{
                //AQUI DEBERÍA CORRER LA VALIDACION de tipo, verificar si ya hay una imagen borrarla y cargar la nueva, etc
                
                //Muevo el archivo del temporal a la carpeta
                $img_name = $producto['imagen']."_prod.jpg";
                $imagen->move($ruta, $img_name, true);
                

                $this->image->withFile($ruta.$img_name)
                    ->convert(IMAGETYPE_JPEG)
                    ->save($ruta.$img_name);

                if ($imagen->hasMoved()) {
                    //Si se copió al server obtengo el nombre del archivo, lo renombro y mando el nombre para que sea guardado
                    $img_name = $img_name;
                }else{
                    //Si NO se copió le asigno vacío al nombre
                    $img_name = '';
                }
            }

            //echo '<pre>'.var_export($producto, true).'</pre>';exit;
            //Inserto el nuevo producto
            $idproducto = $this->productoModel->_insert($producto);
            
            //Recibo el id insertado y hago el insert de los items del producto
            $this->itemsProductoModel->_insert($idproducto, $producto['elementos']);

            return redirect()->to('productos');
        }else{

            return redirect()->to('logout');
        }
    }

    public function product_new_insert(){

        //PABLO Poner las validaciones de categoria, producto,

        if ($this->session->ventas == 1) {

            $producto = [
                'idusuario' => $this->session->id,
                'producto' => strtoupper(trim($this->request->getPostGet('nombreArregloNuevo'))),
                'idcategoria' => $this->request->getPostGet('categoria'),
                'new_id' => $this->request->getPostGet('new_id'),
                'observaciones' => strtoupper($this->request->getPostGet('observaciones')),
                'precio' => strtoupper($this->request->getPostGet('total')),
            ];
            
            //Creo la ruta alas imágenes
            $ruta = './public/images/productos/';

            //Recibo la imagen
            $imagen = $this->request->getFile('file-img');
            $producto['image'] = '';
            
            if (!$imagen->isValid()) {
                //SI NO ES VÁLIDO PASO VACÍO AL NOMBRE
                $producto['image'] = '';

            }else{
                //AQUI DEBERÍA CORRER LA VALIDACION de tipo, verificar si ya hay una imagen borrarla y cargar la nueva, etc
                
                //Muevo el archivo del temporal a la carpeta
                $producto['image'] = $producto['producto'];
                $imagen->move($ruta, $producto['image'], true);
                
                $this->image->withFile($ruta.$producto['image'])
                    ->convert(IMAGETYPE_JPEG)
                    ->resize(450, 450, false, 'height')
                    ->save($ruta.$producto['image'].'.jpg');

                if (!$imagen->hasMoved()) {
                    //Si la imágen NO se copió al server el nombre del archivo va vacío
                    $producto['image'] = '';
                }
            }

            //Inserto el nuevo producto
            $idproducto = $this->productoModel->_insertNewProduct($producto);

            //Obtengo los items del producto que estoy creando
            $items = $this->itemsProductoTempModel->_getItemsNewProducto($producto['new_id']);
            
            //Recibo el id insertado y hago el insert de los items del producto
            $this->itemsProductoModel->_insertItemsPersonalizado($idproducto, $items);

            //Borro los items del producto de la tabla temporal
            $this->itemsProductoTempModel->_deleteItems($producto['new_id']);

            return redirect()->to('productos');
        }else{
            return redirect()->to('logout');
        }
    }

    public function prod_historial_changes($idproducto){

        if ($this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['producto'] = $this->productoModel->find($idproducto);
            $data['historial'] = $this->productoCambiosModel->_getCambiosProducto($idproducto);
        
            $data['title']='Administración';
            $data['subtitle']='Historial de cambios del producto: '. $data['producto']->producto;
            $data['main_content']='administracion/report_cambios_product';
            
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function product_edit($idproducto){

        if ($this->session->ventas == 1) {
            
            $data['session'] = $this->session;
            $data['categorias'] = $this->categoriaModel->orderBy('categoria', 'asc')->findAll();
            $data['producto'] = $this->productoModel->_getProducto($idproducto);
            $items = $this->itemsProductoModel->_getItemsProducto($idproducto);
            $newId = $idproducto;
            //Verifico si ya están en la tabla sino están los guardo
            if ($items) {
                foreach ($items as $key => $item) {
                
                    $verifica = $this->itemsProductoTempModel->_verificaItem($newId, $item->id);
                    //echo '<pre>'.var_export($verifica, true).'</pre>';exit;
                    if (!isset($verifica) || $verifica == 0 || $verifica == NULL) {
                        $this->itemsProductoTempModel->_insertNewItemTemp($idproducto, $newId, $item);
                    }
                }
            }
            //Traigo los items de la tabla temporal, el idproducto y el idnew son el mismo
            $data['items'] = $this->itemsProductoTempModel->_getItemsNewProducto($newId);
            //echo '<pre>'.var_export($data['producto'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Editar producto';
            $data['main_content']='administracion/form-product-edit';
            
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function product_update(){

        if ($this->session->ventas == 1) {

            //Creo la ruta a las imágenes
            $ruta = './public/images/productos/';
            
            //Recibo la imagen
            $imagen = $this->request->getFile('file-img');
            $producto = [
                'idusuario' => $this->session->id,
                'idcategoria' => $this->request->getPostGet('categoria'),
                'producto' => strtoupper(trim($this->request->getPostGet('producto'))),
                'idproducto' => $this->request->getPostGet('idproducto'),
                'observaciones' => strtoupper($this->request->getPostGet('observaciones')),
                'precio' => $this->request->getPostGet('total'),
                'image' => $this->request->getPostGet('image'),
                'imagenNew' => $imagen->getName()
            ];
            
            //Obtengo los datos actuales del producto
            $datosProducto = $this->productoModel->find($producto['idproducto']);

            //Creo el objeto de cambios
            $cambios = [
                'idusuario' => $this->session->id,
                'idproducto' => $this->request->getPostGet('idproducto'),
                'descripcion' => '',
                'detalle' => ''
            ];
            
            //Verifico si se sube otra imagen o no
            if ($producto['imagenNew'] != '') {

                //Se ha elegido una nueva imágen entonces procedo a cambiar la imagen
                $producto['image'] = '';
                
                if (!$imagen->isValid()) {
                    //SI NO ES VÁLIDO PASO VACÍO AL NOMBRE O LA IMAGEN DEFAULT
                    $producto['image'] = 'default-img';
    
                }else{
                    //Borro la imágen anterior
                    if (file_exists($ruta.$datosProducto->image.'.jpg')) {
                        if ($datosProducto->image) {
                            unlink($ruta.$datosProducto->image.'.jpg');
                        }
                    }

                    if (file_exists($ruta.$datosProducto->image)) {
                        if ($datosProducto->image) {
                            unlink($ruta.$datosProducto->image);
                        }
                    }

                    $numRandom = rand(100,999);

                    //Muevo el archivo del temporal a la carpeta
                    $producto['image'] = $producto['producto'].'_'.$numRandom;
                    $imagen->move($ruta, $producto['image'], true);
                    
                    $this->image->withFile($ruta.$producto['image'])
                        ->convert(IMAGETYPE_JPEG)
                        ->resize(450, 450, false, 'height')
                        ->save($ruta.$producto['image'].'.jpg');
    
                    if (!$imagen->hasMoved()) {
                        //Si la imágen NO se copió al server el nombre del archivo va vacío
                        $producto['image'] = 'default-img';
                    }

                    $cambios['descripcion'] .= 'IMAGEN: '. $producto['image'];
                }
            }else{
                //No se ha elegido una nueva imagen
                //Verifico si se ha borrado la imágen
                //echo "se borró la imagen";
                
            }

            //Actualizo el producto
            $this->productoModel->_updateProducto($producto);

            //Obtengo los items del producto que estoy editando
            $items = $this->itemsProductoTempModel->_getItemsProducto($producto['idproducto']);

            /*
            * Asigno los datos del producto al registro de cambios
            * Campos: categoria, nombre, observaciones, precio, image, imagenNew
            * Detalle: item, porcentaje, precio unitario, precio actual, pvp
            */
            $cambios['descripcion'] = $producto['idcategoria'].';'.$producto['producto'].';'.$producto['observaciones'].';'.$producto['precio'].';'.$producto['image'].';'.$producto['imagenNew'];

            //Creo el string con el detalle del producto
            foreach ($items as $key => $item) {
                $cambios['detalle'] .= $item->id.','.$item->porcentaje.','.$item->precio_unitario.','.$item->precio_actual.','.$item->pvp.';';
            }
            
            $this->productoCambiosModel->insert($cambios);

            /**
             * Borro los items que ya estaban en la tabla Items del producto pues serán reeemplazados 
             * Por los nuevos, con esto evito que sigan en la tabla elementos que ya hayan sido borrados
            */
            $this->itemsProductoModel->_deleteItemsProducto($producto['idproducto']);


            //Recorro los items y los inserto en la tabla de items del producto
            if ($items) {
                foreach ($items as $key => $item) {
                    //verifico si ya existe en la tabla de items
                    $existe = $this->itemsProductoModel->_getItemProducto($producto['idproducto'], $item->id);
                    
                    if ($existe == 1) {
                        //Si existe actualizo
                        //$this->itemsProductoModel->_updateItemProducto($producto['idproducto'], $item);
                        
                    }else if($existe == 0){
                        //Si no existe inserto
                        $this->itemsProductoModel->_insertItemProducto($producto['idproducto'], $item);
                    }
                }
            }

            //Borro los items del producto de la tabla temporal
            $this->itemsProductoTempModel->_deleteItems($producto['idproducto']);

            return redirect()->to('productos');
            
        }else{
            return redirect()->to('logout');
        }
    }

    public function product_personalize(){
        
        if ($this->session->ventas == 1) {

            $idproductoOld = $this->request->getPostGet('idproducto');
            $new_id = $this->request->getPostGet('new_id');
            
            $imagen = $this->request->getFile('file-img');
            $producto = [
                'idusuario' => $this->session->id,
                'producto' => strtoupper($this->request->getPostGet('nombreArregloNuevo')),
                'categoria' => $this->request->getPostGet('categoria'),
                'precio' => $this->request->getPostGet('total'),
                'image' => $this->request->getPostGet('image'),
                'arreglo_temporal' => $this->request->getPostGet('arreglo_temporal'),
                'observaciones' => $this->request->getPostGet('observaciones'),
                'imagenNew' => $imagen->getName(),
            ];
            
            //Verifico si se sube otra imagen o no
            if ($producto['imagenNew'] != '') {
                //Se ha elegido una nueva imágen
                //Creo la ruta a las imágenes
                $ruta = './public/images/productos/';

                $producto['image'] = '';
                
                if (!$imagen->isValid()) {
                    //SI NO ES VÁLIDO PASO VACÍO AL NOMBRE O LA IMAGEN DEFAULT
                    $producto['image'] = 'default-img';
    
                }else{
                    
                    //Muevo el archivo del temporal a la carpeta
                    $producto['image'] = $producto['producto'];
                    $imagen->move($ruta, $producto['image'], true);
                    
                    $this->image->withFile($ruta.$producto['image'])
                        ->convert(IMAGETYPE_JPEG)
                        ->resize(450, 450, false, 'height')
                        ->save($ruta.$producto['image'].'.jpg');
    
                    if (!$imagen->hasMoved()) {
                        //Si la imágen NO se copió al server el nombre del archivo va vacío
                        $producto['image'] = 'default-img';
                    }
                }
            }else{
                
                //No se ha elegido una nueva imagen
                $producto['image'] = 'default-img';
                //Verifico si se ha borrado la imágen
                
            }

            $items = $this->itemsProductoTempModel->_getItemsProducto($idproductoOld);

            if ($items) {
                //Inserto el nuevo producto
                $idproducto = $this->productoModel->_insertPersonalizado($producto);

                //Recibo el id insertado y hago el insert de los items del producto
                $this->itemsProductoModel->_insertItemsPersonalizado($idproducto, $items);
            }
            
            //Borro el temporal del producto original de la tabla items temporales
            $this->itemsProductoTempModel->where('new_id', $new_id)->delete();

            return redirect()->to('productos');
        }else{

            return redirect()->to('logout');
        }
    }

    /**
     * Formulario para registrar una nueva sucursal
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function form_sucursal_create() {

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['title']='Administración';
            $data['subtitle']='Registrar sucursal';
            $data['main_content']='administracion/form-sucursal-new';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function form_item_create(){

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['title']='Administración';
            $data['subtitle']='Nuevo Item';
            $data['main_content']='administracion/form-item-new';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function itemCreate(){

        if ($this->session->admin == 1) {

            $item = [
                'item' => strtoupper($this->request->getPostGet('item')),
                'precio' => $this->request->getPostGet('precio'),
            ];
            
            $this->validation->setRuleGroup('items');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                
                $this->itemModel->_insert($item);

                return redirect()->to('items');
            }
            
        }else{

            return redirect()->to('logout');
        }
    }

    public function forma_pago_new(){

        if ($this->session->admin == 1) {

            $forma = [
                'forma_pago' => $this->request->getPostGet('forma_pago'),
            ];
            
            $this->validation->setRuleGroup('formas_pago');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                
                $this->formaPagoModel->insert($forma);

                return redirect()->to('formas-pago');
            }
            
        }else{

            return redirect()->to('logout');
        }
    }

    public function form_formas_pago_create(){
        
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->orderBy('rol', 'asc')->findAll();

            $data['title']='Administración';
            $data['subtitle']='Nueva forma de pago';
            $data['main_content']='administracion/form-pago-create';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function form_usuario_create(){
        
        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->orderBy('rol', 'asc')->findAll();

            $data['title']='Administración';
            $data['subtitle']='Nuevo Usuario';
            $data['main_content']='administracion/form-user-new';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function user_insert(){

        if ($this->session->admin == 1) {

            // recogemos datos enviados desde el formulario de registro
            $user = filter_var(strtoupper($this->request->getPostGet('user')), FILTER_SANITIZE_STRING);
            $pass = filter_var($this->request->getPostGet('password'));

            // generamos el hash a partir de la contraseña enviada desde el formulario
            $pass_hashed = password_hash($pass, PASSWORD_BCRYPT);

            $user = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'user' => strtoupper($user),
                'password' => $pass_hashed,
                'telefono' => $this->request->getPostGet('telefono'),
                'email' => $this->request->getPostGet('email'),
                'cedula' => $this->request->getPostGet('cedula'),
                'direccion' => $this->request->getPostGet('direccion'),
                'idroles' => $this->request->getPostGet('idroles'),
            ];
            
            $this->validation->setRuleGroup('usuario');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{

                $this->usuarioModel->_insert($user);

                return redirect()->to('usuarios');
            }
            
        }else{

            return redirect()->to('logout');
        }
    }

    public function user_update(){

        if ($this->session->admin == 1) {

            $user = [
                'id' => $this->request->getPostGet('id'),
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'user' => $this->request->getPostGet('user'),
                'password' => password_hash(trim($this->request->getPostGet('password')), PASSWORD_BCRYPT),
                'password_old' => $this->request->getPostGet('password_old'),
                'telefono' => $this->request->getPostGet('telefono'),
                'email' => $this->request->getPostGet('email'),
                'cedula' => $this->request->getPostGet('cedula'),
                'direccion' => $this->request->getPostGet('direccion'),
                'idroles' => $this->request->getPostGet('idroles'),
            ];

            $this->validation->setRuleGroup('usuarioUpdate');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
                
                $this->usuarioModel->_update($user);

                return redirect()->to('usuarios');
            }
            
        }else{

            return redirect()->to('logout');
        }
    }

    public function sucursal_insert(){

        if ($this->session->admin == 1) {

            $data = [
                'sucursal' => strtoupper($this->request->getPostGet('sucursal')),
                'direccion' => strtoupper($this->request->getPostGet('direccion')),
            ];
            
            $this->validation->setRuleGroup('sucursal');

            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{
               
                $this->sucursalModel->_insert($data);

                return redirect()->to('sucursales');
            }
            
        }else{

            return redirect()->to('logout');
        }
    }

    public function sector_entrega_insert(){

        if ($this->session->admin == 1) {

            $data = [
                'sector' => strtoupper($this->request->getPostGet('sector_entrega')),
                'costo_entrega' => strtoupper($this->request->getPostGet('costo_entrega')),
                'idsucursal' => $this->request->getPostGet('idsucursal') != '' ? $this->request->getPostGet('idsucursal'): '4',
            ];
            
            $this->sectoresEntregaModel->insert($data);

            return redirect()->to('sectores-entrega');
            
        }else{

            return redirect()->to('logout');
        }
    }

    public function form_usuario_edit($id){

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->findAll();
            $data['usuario'] = $this->usuarioModel->find($id);

            $data['title']='Administración';
            $data['subtitle']='Editar Usuario';
            $data['main_content']='administracion/form-user-edit';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function sucursal_delete($id){

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->findAll();
            $data['usuario'] = $this->usuarioModel->find($id);

            //verifico si tiene sectores de entrega relacionados
            $haySectores = $this->sectoresEntregaModel->where('idsucursal', $id)->findAll();

            if ($haySectores || $id == 4) {
                //Si tiene sectores relacionados los borro
                session()->setFlashdata('mensaje', 'error');
                
            }else{
                $this->sucursalModel->delete($id);
                session()->setFlashdata('mensaje', 'success');
            }
            
            return redirect()->to('sucursales');
        }else{
            return redirect()->to('logout');
        }
    }

    function updateSucursalSector($sector, $sucursal, $costo_entrega){
        
        $mensaje = '';
        if (isset($sucursal) && $sucursal != 0) {
            $this->sectoresEntregaModel->_updateSucursalSector($sector, $sucursal, $costo_entrega);
            $mensaje = 'Se ha actualizado';

        }else{
            $mensaje = 'NO se ha actualizado';
            
        }
        return json_encode($mensaje);
    }

    public function form_sucursal_edit($id){

        if ($this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->findAll();
            $data['usuario'] = $this->usuarioModel->find($id);

            $data['sucursal'] = $this->sucursalModel->find($id);
            $data['sectores'] = $this->sectoresEntregaModel->orderBy('sector', 'ASC')->findAll();
            $data['sectoresSucursal'] = $this->sectoresEntregaModel->where('idsucursal', $id)->orderBy('sector', 'ASC')->findAll();

            $data['title']='Administración';
            $data['subtitle']='Asignar sectores';
            $data['main_content']='administracion/form-sucursal-sector';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function list_items(){
        return redirect()->to('reporte-list-items');
    }

    function asignaSectorSucursal(){
        
        $id = $this->request->getPostGet('idsector');
        
        $data = [
            'idsucursal' => $this->request->getPostGet('idsucursal')
        ];

        $this->sectoresEntregaModel->update($id, $data);

        //traer data de la tabla
        $sectoresSucursal = $this->sectoresEntregaModel->where('idsucursal', $data['idsucursal'])->orderBy('sector', 'ASC')->findAll();

        //header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'mensaje' => 'Actualizado correctamente',
            'tabla' => $sectoresSucursal,
        ]);
        exit;
    }

    function eliminarSectorSucursal(){
        
        $idsector = $this->request->getPostGet('idsector');
        $idsucursal = $this->request->getPostGet('idsucursal');

        $data = [
            'idsucursal' => 4
        ];
        $this->sectoresEntregaModel->update($idsector, $data);

        //traer data de la tabla
        $sectoresSucursal = $this->sectoresEntregaModel->where('idsucursal', $idsucursal)->orderBy('sector', 'ASC')->findAll();

        //header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'mensaje' => 'Actualizado correctamente',
            'tabla' => $sectoresSucursal,
        ]);
        exit;
    }

    function eliminaSectorSucursal($idsector, $idsucursal){

        $data = [
            'idsucursal' => 4
        ];
        $this->sectoresEntregaModel->update($idsector, $data);

        //traer data de la tabla
        // $sectoresSucursal = $this->sectoresEntregaModel->where('idsucursal', $idsucursal)->orderBy('sector', 'ASC')->findAll();

        $data['session'] = $this->session;

        return redirect()->to('sucursal-edit/'.$idsucursal);
    }

    function eliminaSector($idsector, $idsucursal){

        $this->sectoresEntregaModel->delete($idsector);

        $data['session'] = $this->session;

        return redirect()->to('sucursal-edit/'.$idsucursal);
    }
}
