<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Administracion extends BaseController {
    public function index() {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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

    public function Sucursales() {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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

    public function items() {
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;

            $data['items'] = $this->itemModel->findAll();

            //echo '<pre>'.var_export($data['productos'], true).'</pre>';exit;
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

        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
    
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

        if ($data['logged'] == 1 && $this->session->admin == 1) {

            $item = [
                'id' => $this->request->getPostGet('id'),
                'item' => strtoupper($this->request->getPostGet('item')),
                'precio' => strtoupper($this->request->getPostGet('precio')),

            ];
            //echo '<pre>'.var_export($item, true).'</pre>';exit;
            $this->itemModel->_update($item);
            //echo $this->db->getLastQuery();exit;

            return redirect()->to('items');
        }else{

            $this->logout();
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
    public function item_delete($id) {
    
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

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
    
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
    
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

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
    
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($data, true).'</pre>';exit;
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
    
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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

        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            echo 'sección en construcción';
            // $data['session'] = $this->session;
            // $data['categorias'] = $this->categoriaModel->findAll();
            // $data['items'] = $this->itemModel->findAll();

            // //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            // $data['title']='Administración';
            // $data['subtitle']='Crear producto';
            // $data['main_content']='administracion/form-product-new';
            // return view('dashboard/index', $data);
        }else{
            $this->logout();
            return redirect()->to('/');
        }
    }

    public function product_insert(){
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

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
            //echo '<pre>'.var_export($producto, true).'</pre>';exit;
            //Inserto el nuevo producto
            $idproducto = $this->productoModel->_insert($producto);
            
            //Recibo el id insertado y hago el insert de los items del producto
            $this->itemsProductoModel->_insert($idproducto, $producto['elementos']);

            return redirect()->to('productos');
        }else{

            $this->logout();
        }
    }

    public function product_edit($idproducto){
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
        if ($data['logged'] == 1 && $this->session->admin == 1) {
            
            $data['session'] = $this->session;
            $data['categorias'] = $this->categoriaModel->findAll();
            $data['producto'] = $this->productoModel->_getProducto($idproducto);
            $data['elementos'] = $this->itemsProductoModel->_getItemsproducto($idproducto);

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
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

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

    /**
     * Formulario para registrar una nueva sucursal
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function form_sucursal_create() {

        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

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
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

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

    public function sucursal_insert(){
        //echo '<pre>'.var_export($this->session->idusuario, true).'</pre>';
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;

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
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        //echo '<pre>'.var_export($this->session->admin, true).'</pre>';exit;
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
