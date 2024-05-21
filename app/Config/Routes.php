<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

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
$routes->post('pedido-update', 'Ventas::pedido_update');
$routes->get('pedido-edit/(:num)', 'Ventas::pedido_edit/$1');
$routes->get('getDatosPedido/(:num)', 'Ventas::getDatosPedido/$1');
$routes->get('ventas/detalle_pedido_insert/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert/$1/$2/$3');
$routes->get('ventas/detalle_pedido_insert_observacion/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert_observacion/$1/$2/$3');
$routes->get('ventas/detalle_pedido_delete_producto/(:num)/(:any)', 'Ventas::detalle_pedido_delete_producto/$1/$2');
$routes->get('ventas/getDetallePedido/(:num)', 'Ventas::getDetallePedido/$1');
$routes->get('ventas/actualizaMensajero/(:num)/(:num)', 'Ventas::actualizaMensajero/$1/$2');
$routes->get('ventas/actualizarHorarioEntrega/(:num)/(:num)', 'Ventas::actualizarHorarioEntrega/$1/$2');
$routes->get('ventas/actualizarEstadoPedido/(:num)/(:num)', 'Ventas::actualizarEstadoPedido/$1/$2');
$routes->post('actualizarHoraSalidaPedido', 'Ventas::actualizarHoraSalidaPedido');
$routes->post('actualizaObservacionPedido', 'Ventas::actualizaObservacionPedido');
$routes->get('insertAttrArreglo', 'Ventas::insertAttrArreglo');
$routes->get('ventas/getEstadosPedido', 'Ventas::getEstadosPedido');
$routes->get('ventas/getMensajeros', 'Ventas::getMensajeros');
$routes->get('getHorasEntrega', 'Ventas::getHorasEntrega');
$routes->get('imprimirTicket/(:num)/(:any)', 'Tickets::imprimirTicket/$1/$2');

$routes->get('ventas/getDetallePedido_temp/(:num)', 'Ventas::getDetallePedido_temp/$1');
$routes->get('detalle_pedido_insert_temp', 'Ventas::detalle_pedido_insert_temp');
$routes->get('ventas/detalle_pedido_delete_producto_temp/(:num)/(:any)', 'Ventas::detalle_pedido_delete_producto_temp/$1/$2');
$routes->get('detalle_pedido_update_precio_temp', 'Ventas::detalle_pedido_update_precio_temp');
$routes->get('ventas/detalle_pedido_insert_observacion_temp/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert_observacion_temp/$1/$2/$3');
$routes->get('estadistica-ventas', 'Ventas::estadisticaVentas');
$routes->get('getProductosAutocomplete', 'Ventas::getProductosAutocomplete');
$routes->get('getItemsAutocomplete', 'Ventas::getItemsAutocomplete');
$routes->get('product-edit/getItemsAutocomplete', 'Ventas::getItemsAutocomplete');
$routes->get('getProducto/(:num)', 'Ventas::getProducto/$1');
$routes->get('detalle-prod-insert_temp', 'Ventas::detalle_prod_insert_temp');
$routes->get('detalle-prodnew-insert-temp', 'Ventas::detalle_prodnew_insert_temp');
$routes->get('ventas-getItemsProducto/(:num)', 'Ventas::getItemsProducto/$1');
$routes->get('updateItemsTempProduct', 'Ventas::updateItemsTempProduct');
$routes->get('updatePvpTempProduct', 'Ventas::updatePvpTempProduct');
$routes->get('deleteItemTempProduct', 'Ventas::deleteItemTempProduct');
$routes->get('cotizador', 'Ventas::cotizador');
$routes->get('deleteItemsTempProduct', 'Ventas::deleteItemsTempProduct');
$routes->get('updatePrecioActualTempProduct', 'Ventas::updatePrecioActualTempProduct');

//Administración
$routes->get('administracion', 'Administracion::index');
$routes->get('estado', 'Administracion::estado');
$routes->get('variables-sistema', 'Administracion::variablesSistema');
$routes->get('getProductosCategoria/(:num)', 'Administracion::getProductosCategoria/$1');
$routes->get('productos', 'Administracion::productos');
$routes->get('cambia-attr-temp-producto', 'Administracion::cambia_attr_temp_producto');
$routes->get('producto-create', 'Administracion::form_producto_create');
$routes->post('product-insert', 'Administracion::product_insert');
$routes->post('product-new-insert', 'Administracion::product_new_insert');
$routes->post('product-update', 'Administracion::product_update');
$routes->get('product-edit/(:num)', 'Administracion::product_edit/$1');
$routes->get('items', 'Administracion::items');
$routes->get('item-edit/(:num)', 'Administracion::form_item_edit/$1');
$routes->post('item-create', 'Administracion::itemCreate');
$routes->post('item-update', 'Administracion::item_update');
$routes->get('getItemsProducto/(:num)', 'Administracion::getItemsProducto/$1');
$routes->get('frm-item-create', 'Administracion::form_item_create');
$routes->get('item-delete/(:num)', 'Administracion::item_delete/$1');
$routes->get('item-cuantificable-update/(:num)/(:num)', 'Administracion::item_cuantificable_update/$1/$2');
$routes->get('formas-pago', 'Administracion::formas_pago');
$routes->get('form-pago-create', 'Administracion::form_formas_pago_create');
$routes->get('forma-pago-delete/(:num)/(:num)', 'Administracion::forma_pago_delete/$1/$2');
$routes->get('usuarios', 'Administracion::usuarios');
$routes->post('user-insert', 'Administracion::user_insert');
$routes->post('user-update', 'Administracion::user_update');
$routes->get('usuario-edit/(:num)', 'Administracion::form_usuario_edit/$1');
$routes->get('usuario-create', 'Administracion::form_usuario_create');
$routes->get('roles', 'Administracion::roles');
$routes->get('rol-edit/(:num)', 'Administracion::form_rol_edit/$1');
$routes->get('desactivar', 'Administracion::desactivar');
$routes->get('sectores-entrega', 'Administracion::sectoresEntrega');
$routes->post('product-personalize', 'Administracion::product_personalize');
$routes->get('updateVariableSistema', 'Administracion::updateVariableSistema');
$routes->get('actualizaPrecioItem', 'Administracion::actualizaPrecioItem');
$routes->get('list-items', 'Administracion::list_items');
$routes->get('set-arreg-temp-definitivo/(:num)', 'Administracion::set_arreg_temp_definitivo/$1');

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
$routes->get('print-client-historial/(:num)', 'Clientes::print_client_historial/$1');

//Inventario
$routes->get('inventario', 'Inventarios::index');
$routes->get('gestion-inventario', 'Inventarios::gestion_inventario');
$routes->get('get-item-cuantificable', 'Inventarios::get_item_cuantificable');
$routes->get('getStockActual', 'Inventarios::getStockActual');
$routes->get('registraMovimientoStock', 'Inventarios::registraMovimientoStock');
$routes->get('kardex-item/(:num)', 'Inventarios::kardexItem/$1');

//REPORTES
$routes->get('reporte', 'Reportes::frmReporte');
$routes->get('reporte-list-items', 'Reportes::reporteListItems');
