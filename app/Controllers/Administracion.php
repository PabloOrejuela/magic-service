<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VariablesSistemaModel;

class Administracion extends BaseController {

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function index() {
        $data = $this->acl();

        if ($data['logged'] == 1) {
            
            $data['session'] = $this->session;

            //echo '<pre>'.var_export($data['vendedores'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Administración';
            $data['main_content']='administracion/admin_home';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
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

    public function productos() {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['productos'] = $this->productoModel->_getProductos();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Productos';
            $data['main_content']='administracion/grid_productos';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function getProductosCategoria($categoria){
        
        $productos = $this->productoModel->_getProductosCategoria($categoria );
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

    public function sucursales() {
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['sucursales'] = $this->sucursalModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Sucursales';
            $data['main_content']='administracion/grid_sucursales';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function sectoresEntrega() {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['sectores'] = $this->sectoresEntregaModel->_getSectores();
            $data['sucursales'] = $this->sucursalModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Sectores de entrega';
            $data['main_content']='administracion/grid_sectores_entrega';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function variablesSistema() {

        $data = $this->acl();
        $this->variablesSistemaModel = new VariablesSistemaModel($this->db);

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['variables'] = $this->variablesSistemaModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Editar variables del Sistema';
            $data['main_content']='administracion/frm_edit_variables_sistema';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function items() {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['items'] = $this->itemModel->findAll();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Items';
            $data['main_content']='administracion/grid_items';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function gestion_inventario() {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['items'] = $this->itemModel->_getItemsCuantificables();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Items';
            $data['main_content']='administracion/grid_items';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
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

        $data = $this->acl();
        
        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['item'] = $this->itemModel->find($id);

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Editar Item';
            $data['main_content']='administracion/form-item-edit';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
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
    
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
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

    public function cambia_attr_temp_producto() {
        $id = $this->request->getPostGet('id');
        $producto = [
            'attr_temporal' => 0,
            'estado' => 1
        ];
        //echo '<pre>'.var_export($item, true).'</pre>';exit;
        $this->productoModel->update($id, $producto);
        $data['id'] = $id;
        return json_encode($data);
    }

    public function updateVariableSistema() {
    
        $data = $this->acl();
        $this->variablesSistemaModel = new VariablesSistemaModel($this->db);

        if ($data['logged'] == 1 && $this->session->admin == 1) {
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
    
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

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
    
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['formas_pago'] = $this->formaPagoModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Formas de pago';
            $data['main_content']='administracion/grid_formas_pago';
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
    public function forma_pago_delete($id, $estado) {
    
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $dato = [
                'id' => $id,
                'estado' => $estado,
            ];
            //echo '<pre>'.var_export($item, true).'</pre>';exit;
            $this->formaPagoModel->_updateEstado($dato);
            //echo $this->db->getLastQuery();exit;

            return redirect()->to('formas-pago');
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
    public function usuarios() {
    
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['usuarios'] = $this->usuarioModel->_getAllUsers();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Usuarios';
            $data['main_content']='administracion/grid_usuarios';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    
    }

    public function estado(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $data['session'] = $this->session;
            $data['estado'] = $this->estadoSistema();

            $data['title']='Administración';
            $data['subtitle']='Estado del sistema';
            $data['main_content']='administracion/frm_estado';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
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
    
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['roles'] = $this->rolModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Roles y permisos';
            $data['main_content']='administracion/grid_roles';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    
    }

    /**
     * Formulario para crear un nuevo producto
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function form_producto_create() {

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['productos'] = $this->productoModel->findAll();

            //delete de los items de la tabla temporal de hace un día
            //$this->itemsProductoTempModel->_deleteItemsTempOld();

            $data['lastId'] = $this->productoModel->_getLastId();
            $data['newId'] = $data['lastId'] + 1;

            $data['title']='Administración';
            $data['subtitle']='Nuevo producto  Trabajando en la subida de la imágen';
            $data['main_content']='administracion/form-new-product';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function product_insert(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $producto = [
                'idusuario' => $data['id'],
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

    public function product_new_insert(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $producto = [
                'idusuario' => $data['id'],
                'producto' => strtoupper($this->request->getPostGet('nombreArregloNuevo')),
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

            //echo '<pre>'.var_export($producto, true).'</pre>';exit;
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

            $this->logout();
        }
    }

    public function product_edit($idproducto){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['producto'] = $this->productoModel->_getProducto($idproducto);
            $data['elementos'] = $this->itemsProductoModel->_getItemsProducto($idproducto);

            //echo '<pre>'.var_export($data['producto'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Editar producto';
            $data['main_content']='administracion/form-product-edit';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function product_update(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

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

    public function product_personalize(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $idproductoOld = $this->request->getPostGet('idproducto');
            $newProducto = [
                'idusuario' => $data['id'],
                'producto' => strtoupper($this->request->getPostGet('nombreArregloNuevo')),
                'categoria' => $this->request->getPostGet('categoria'),
                'precio' => $this->request->getPostGet('total'),
                'image' => $this->request->getPostGet('image'),
                'arreglo_temporal' => $this->request->getPostGet('arreglo_temporal'),
                'observaciones' => $this->request->getPostGet('observaciones'),
            ];

            $items = $this->itemsProductoTempModel->_getItemsProducto($idproductoOld);
            
            //Inserto el nuevo producto
            $idproducto = $this->productoModel->_insertPersonalizado($newProducto);
            
            //Recibo el id insertado y hago el insert de los items del producto
            $this->itemsProductoModel->_insertItemsPersonalizado($idproducto, $items);

            return redirect()->to('productos');
        }else{

            $this->logout();
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

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            // $data['categorias'] = $this->categoriaModel->findAll();
            // $data['items'] = $this->itemModel->findAll();

            //echo '<pre>'.var_export($data, true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Registrar sucursal';
            $data['main_content']='administracion/form-sucursal-new';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function form_item_create(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            //echo '<pre>'.var_export($data['roles'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Nuevo Item';
            $data['main_content']='administracion/form-item-new';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function itemCreate(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

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
                //echo '<pre>'.var_export($item, true).'</pre>';exit;
                $this->itemModel->_insert($item);

                return redirect()->to('items');
            }
            
        }else{

            $this->logout();
        }
    }

    public function form_formas_pago_create(){
        echo 'Formulario para ingresar un Nueva forma de pago';
    }

    public function form_usuario_create(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->findAll();

            //echo '<pre>'.var_export($data['roles'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Nuevo Usuario';
            $data['main_content']='administracion/form-user-new';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function user_insert(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $user = [
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'user' => $this->request->getPostGet('user'),
                'password' => $this->request->getPostGet('password'),
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
                //echo '<pre>'.var_export($user, true).'</pre>';exit;
                $this->usuarioModel->_insert($user);

                return redirect()->to('usuarios');
            }
            
        }else{

            $this->logout();
        }
    }

    public function user_update(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {


            $user = [
                'id' => $this->request->getPostGet('id'),
                'nombre' => strtoupper($this->request->getPostGet('nombre')),
                'user' => $this->request->getPostGet('user'),
                'password' => trim($this->request->getPostGet('password')),
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
                //echo '<pre>'.var_export($user, true).'</pre>';exit;
                $this->usuarioModel->_update($user);

                return redirect()->to('usuarios');
            }
            
        }else{

            $this->logout();
        }
    }

    public function sucursal_insert(){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {

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
                //echo '<pre>'.var_export($user, true).'</pre>';exit;
                $this->sucursalModel->_insert($data);

                return redirect()->to('sucursales');
            }
            
        }else{

            $this->logout();
        }
    }

    public function form_usuario_edit($id){

        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['roles'] = $this->rolModel->findAll();
            $data['usuario'] = $this->usuarioModel->find($id);

            //echo '<pre>'.var_export($data['usuario'], true).'</pre>';exit;
            $data['title']='Administración';
            $data['subtitle']='Editar Usuario';
            $data['main_content']='administracion/form-user-edit';
            return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
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

    public function form_rol_edit($id){
        echo 'Formulario para crear un Nuevo usuario DESHABILITADO';
    }

    public function form_sucursal_edit($id){
        echo 'Formulario para EDITAR datos de una sucursal DESHABILITADO';
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
