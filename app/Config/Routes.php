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

//VENTAS
$routes->get('ventas', 'Ventas::index');
$routes->get('pedidos', 'Ventas::pedidos');
$routes->get('pedidos-ventana', 'Ventas::pedidos_ventana');
$routes->post('ventas/clientes_select', 'Ventas::clientes_select');
$routes->post('ventas/clientes_select_telefono', 'Ventas::clientes_select_telefono');
$routes->post('ventas/clientes_select_telefono_2', 'Ventas::clientes_select_telefono_2');
$routes->get('ventas/get_valor_producto/(:num)', 'Ventas::get_valor_producto/$1');
$routes->get('ventas/get_valor_sector/(:num)', 'Ventas::get_valor_sector/$1');
$routes->get('ventas/get_costo_horario/(:num)', 'Ventas::get_costo_horario/$1');
$routes->post('pedido-insert', 'Ventas::pedido_insert');
$routes->get('pedido-edit/(:num)', 'Ventas::pedido_edit/$1');
$routes->get('getDatosPedido/(:num)', 'Ventas::getDatosPedido/$1');
$routes->get('estado', 'Administracion::estado');
$routes->get('ventas/detalle_pedido_insert/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert/$1/$2/$3');
$routes->get('ventas/detalle_pedido_insert_observacion/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert_observacion/$1/$2/$3');
$routes->get('ventas/detalle_pedido_delete_producto/(:num)/(:any)', 'Ventas::detalle_pedido_delete_producto/$1/$2');
$routes->get('ventas/getDetallePedido/(:num)', 'Ventas::getDetallePedido/$1');
$routes->get('ventas/actualizaMensajero/(:num)/(:num)', 'Ventas::actualizaMensajero/$1/$2');
$routes->get('ventas/actualizarHorarioEntrega/(:num)/(:num)', 'Ventas::actualizarHorarioEntrega/$1/$2');
$routes->get('ventas/actualizarEstadpPedido/(:num)/(:num)', 'Ventas::actualizarEstadpPedido/$1/$2');
$routes->post('actualizarHoraSalidaPedido', 'Ventas::actualizarHoraSalidaPedido');
$routes->post('actualizaObservacionPedido', 'Ventas::actualizaObservacionPedido');

$routes->get('ventas/getDetallePedido_temp/(:num)', 'Ventas::getDetallePedido_temp/$1');
$routes->get('ventas/detalle_pedido_insert_temp/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert_temp/$1/$2/$3');
$routes->get('ventas/detalle_pedido_delete_producto_temp/(:num)/(:any)', 'Ventas::detalle_pedido_delete_producto_temp/$1/$2');
$routes->get('ventas/detalle_pedido_update_precio_temp/(:num)/(:num)/(:any)/(:num)', 'Ventas::detalle_pedido_update_precio_temp/$1/$2/$3/$4');
$routes->get('ventas/detalle_pedido_insert_observacion_temp/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert_observacion_temp/$1/$2/$3');
$routes->get('estadistica-ventas', 'Ventas::estadisticaVentas');

$routes->get('administracion', 'Administracion::index');
$routes->get('getProductosCategoria/(:num)', 'Administracion::getProductosCategoria/$1');
$routes->get('productos', 'Administracion::productos');
$routes->get('producto-create', 'Administracion::form_producto_create');
$routes->post('product-insert', 'Administracion::product_insert');
$routes->post('product-update', 'Administracion::product_update');
$routes->get('product-edit/(:num)', 'Administracion::product_edit/$1');
$routes->get('items', 'Administracion::items');
$routes->get('item-edit/(:num)', 'Administracion::form_item_edit/$1');
$routes->post('item-create', 'Administracion::itemCreate');
$routes->post('item-update', 'Administracion::item_update');
$routes->get('getItemsProducto/(:num)', 'Administracion::getItemsProducto/$1');
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
$routes->get('sectores-entrega', 'Administracion::sectoresEntrega');
$routes->get('cotizador', 'Ventas::cotizador');

$routes->get('sucursales', 'Administracion::sucursales');
$routes->get('sucursal-create', 'Administracion::form_sucursal_create');
$routes->post('sucursal-insert', 'Administracion::sucursal_insert');
$routes->get('sucursal-edit/(:num)', 'Administracion::form_sucursal_edit/$1');
$routes->get('updateSucursalSector/(:num)/(:num)/(:num)', 'Administracion::updateSucursalSector/$1/$2/$3');
$routes->get('getSucursales', 'Administracion::getSucursales');

//Proveedores
$routes->get('proveedores', 'Proveedores::index');
$routes->get('proveedor-create', 'Proveedores::create');
$routes->post('proveedor-insert', 'Proveedores::insert');
$routes->get('proveedor-edit/(:num)', 'Proveedores::edit/$1');
$routes->post('proveedor-update', 'Proveedores::update');


//Gastos
$routes->get('gastos', 'Gastos::index');
$routes->get('gasto-create', 'Gastos::create');
$routes->post('gasto-insert', 'Gastos::insert');
$routes->get('gasto-edit/(:num)', 'Gastos::edit/$1');
$routes->post('gasto-update', 'Gastos::update');

//Clientes
$routes->get('clientes', 'Clientes::index');
$routes->get('cliente-delete/(:num)', 'Clientes::cliente_delete/$1');
$routes->get('cliente-create', 'Clientes::cliente_create');
$routes->get('cliente-edit/(:num)', 'Clientes::cliente_edit/$1');
$routes->post('cliente-insert', 'Clientes::cliente_insert');
$routes->post('cliente-update', 'Clientes::cliente_update');
$routes->get('print-client-historial/(:num)', 'Clientes::pruebaPDF');

//REPORTES
$routes->get('reportes', 'Reportes::pruebaExcel');

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
