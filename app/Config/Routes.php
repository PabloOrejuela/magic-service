<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Login::index');
$routes->post('validate_login', 'Home::validate_login');
$routes->get('inicio', 'Home::index');
$routes->get('mantenimiento', 'Home::mantenimiento');
$routes->get('logout', 'Home::logout');
$routes->get('ventas', 'Ventas::index');
$routes->get('pedidos', 'Ventas::pedidos');
$routes->get('pedidos-ventana', 'Ventas::pedidos_ventana');
$routes->post('ventas/clientes_select', 'Ventas::clientes_select');
$routes->get('ventas/get_valor_producto/(:num)', 'Ventas::get_valor_producto/$1');
$routes->get('ventas/get_valor_sector/(:num)', 'Ventas::get_valor_sector/$1');
$routes->post('pedido-insert', 'Ventas::pedido_insert');
$routes->get('pedido-edit/(:num)', 'Ventas::pedido_edit/$1');
$routes->get('estado', 'Administracion::estado');
$routes->get('ventas/detalle_pedido_insert/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert/$1/$2/$3');
$routes->get('ventas/detalle_pedido_delete_producto/(:num)/(:any)', 'Ventas::detalle_pedido_delete_producto/$1/$2');

$routes->get('administracion', 'Administracion::index');
$routes->get('productos', 'Administracion::productos');
$routes->get('producto-create', 'Administracion::form_producto_create');
$routes->post('product-insert', 'Administracion::product_insert');
$routes->post('product-update', 'Administracion::product_update');
$routes->get('product-edit/(:num)', 'Administracion::product_edit/$1');
$routes->get('items', 'Administracion::items');
$routes->get('item-edit/(:num)', 'Administracion::form_item_edit/$1');
$routes->post('item-create', 'Administracion::itemCreate');
$routes->post('item-update', 'Administracion::item_update');
$routes->get('frm-item-create', 'Administracion::form_item_create');
$routes->get('item-delete/(:num)', 'Administracion::item_delete/$1');
$routes->get('formas-pago', 'Administracion::formas_pago');
$routes->get('form-pago-create', 'Administracion::form_formas_pago_create');
$routes->get('forma-pago-delete/(:num)/(:num)', 'Administracion::forma_pago_delete/$1/$2');
$routes->get('usuarios', 'Administracion::usuarios');
$routes->post('user-insert', 'Administracion::user_insert');
$routes->get('usuario-edit/(:num)', 'Administracion::form_usuario_edit/$1');
$routes->get('usuario-create', 'Administracion::form_usuario_create');
$routes->get('roles', 'Administracion::roles');
$routes->get('rol-edit/(:num)', 'Administracion::form_rol_edit/$1');
$routes->get('desactivar', 'Administracion::desactivar');

//Proveedores
$routes->get('proveedores', 'Proveedores::index');
$routes->get('proveedor-create', 'Proveedores::create');

//Clientes
$routes->get('clientes', 'Clientes::index');
$routes->get('cliente-delete/(:num)', 'Clientes::cliente_delete/$1');
$routes->get('cliente-create', 'Clientes::cliente_create');
$routes->get('cliente-edit/(:num)', 'Clientes::cliente_edit/$1');
$routes->post('cliente-insert', 'Clientes::cliente_insert');
$routes->post('cliente-update', 'Clientes::cliente_update');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
