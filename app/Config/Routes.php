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
$routes->get('guarda-orden', 'Ventas::guardaOrden');
$routes->get('pedidos-ventana', 'Ventas::pedidos_ventana');
$routes->post('ventas/clientes_select', 'Ventas::clientes_select');
$routes->get('clientes_select_telefono', 'Ventas::clientes_select_telefono');
$routes->get('ventas/get_valor_producto/(:num)', 'Ventas::get_valor_producto/$1');
$routes->get('ventas/get_valor_sector/(:num)', 'Ventas::get_valor_sector/$1');
$routes->get('ventas/get_costo_horario/(:num)', 'Ventas::get_costo_horario/$1');
$routes->get('get_costo_horario', 'Ventas::get_costo_horario');
$routes->get('get_valor_sector', 'Ventas::get_valor_sector');
$routes->post('pedido-insert', 'Ventas::pedido_insert');
$routes->post('pedido-update', 'Ventas::pedido_update');
$routes->get('pedido-edit/(:num)', 'Ventas::pedido_edit/$1');
$routes->get('getDatosPedido/(:num)', 'Ventas::getDatosPedido/$1');
$routes->get('ventas/detalle_pedido_insert/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert/$1/$2/$3');
$routes->get('ventas/detalle_pedido_insert_observacion/(:num)/(:num)/(:any)', 'Ventas::detalle_pedido_insert_observacion/$1/$2/$3');
$routes->get('ventas/detalle_pedido_delete_producto/(:num)/(:any)', 'Ventas::detalle_pedido_delete_producto/$1/$2');
$routes->get('ventas/getDetallePedido/(:num)', 'Ventas::getDetallePedido/$1');
$routes->get('ventas/actualizaMensajero/(:num)/(:num)', 'Ventas::actualizaMensajero/$1/$2');
$routes->get('actualizarHorarioEntrega', 'Ventas::actualizarHorarioEntrega');
$routes->get('ventas/actualizarEstadoPedido/(:num)/(:num)', 'Ventas::actualizarEstadoPedido/$1/$2');
$routes->post('actualizarHoraSalidaPedido', 'Ventas::actualizarHoraSalidaPedido');
$routes->post('actualizaObservacionPedido', 'Ventas::actualizaObservacionPedido');
$routes->get('insertAttrArreglo', 'Ventas::insertAttrArreglo');
$routes->get('ventas/getEstadosPedido', 'Ventas::getEstadosPedido');
$routes->get('ventas/getMensajeros', 'Ventas::getMensajeros');
$routes->get('getHorasEntrega', 'Ventas::getHorasEntrega');
$routes->get('imprimirTicket/(:num)/(:any)', 'Tickets::imprimirTicket/$1/$2');
//$routes->get('imprimirTicket', 'Tickets::imprimirTicket');
$routes->get('ventas/getDetallePedido_temp/(:num)', 'Ventas::getDetallePedido_temp/$1');
$routes->get('detalle_pedido_insert_temp', 'Ventas::detalle_pedido_insert_temp');
$routes->get('ventas/detalle_pedido_delete_producto_temp/(:num)/(:any)', 'Ventas::detalle_pedido_delete_producto_temp/$1/$2');
$routes->get('detalle_pedido_update_precio_temp', 'Ventas::detalle_pedido_update_precio_temp');
$routes->get('detalle_pedido_insert_observacion_temp', 'Ventas::detalle_pedido_insert_observacion_temp');
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
$routes->get('deleteItemsTempProductCotizador', 'Ventas::deleteItemsTempProductCotizador');
$routes->get('updatePrecioActualTempProduct', 'Ventas::updatePrecioActualTempProduct');
$routes->get('get_detallle', 'Ventas::getDetallle');
$routes->get('genera-codigo-pedido', 'Ventas::generaCodigoPedido');
$routes->get('actualizaMensajeSession', 'Ventas::actualizaMensajeSession');
$routes->get('actualizaValorCampoTicket', 'Ventas::actualizaValorCampoTicket');
$routes->get('getAttrExtraTicket', 'Ventas::getAttrExtraTicket');
$routes->get('deleteDetalleTemporal', 'Ventas::deleteDetalleTemporal');
$routes->get('updateDevolucion', 'Ventas::updateDevolucion');

//Administración
$routes->get('administracion', 'Administracion::index');
$routes->get('estado', 'Administracion::estado');
$routes->get('variables-sistema', 'Administracion::variablesSistema');
$routes->get('getProductosCategoria/(:num)', 'Administracion::getProductosCategoria/$1');
$routes->get('productos', 'Administracion::productos');
$routes->get('cambia-attr-temp-producto', 'Administracion::cambia_attr_temp_producto');
$routes->get('producto-create', 'Administracion::form_producto_create');
$routes->post('product-insert', 'Administracion::product_insert');
$routes->get('prod-historial-changes/(:num)', 'Administracion::prod_historial_changes/$1');
$routes->post('product-new-insert', 'Administracion::product_new_insert');
$routes->post('product-update', 'Administracion::product_update');
$routes->get('product-edit/(:num)', 'Administracion::product_edit/$1');
$routes->get('items', 'Administracion::items');
$routes->get('item-edit/(:num)', 'Administracion::form_item_edit/$1');
$routes->post('item-create', 'Administracion::itemCreate');
$routes->post('item-update', 'Administracion::item_update');
$routes->get('item-sensible-update/(:num)/(:num)', 'Administracion::itemSensibleUpdate/$1/$2');
$routes->get('getCantidadItemsSensibles', 'Administracion::getCantidadItemsSensibles');
$routes->get('getItemsProducto/(:num)', 'Administracion::getItemsProducto/$1');
$routes->get('frm-item-create', 'Administracion::form_item_create');
$routes->get('item-delete/(:num)', 'Administracion::item_delete/$1');
$routes->get('item-cuantificable-update/(:num)/(:num)', 'Administracion::item_cuantificable_update/$1/$2');
$routes->get('formas-pago', 'Administracion::formas_pago');
$routes->get('form-pago-create', 'Administracion::form_formas_pago_create');
$routes->post('forma-pago-new', 'Administracion::forma_pago_new');
$routes->get('forma-pago-delete/(:num)/(:num)', 'Administracion::forma_pago_delete/$1/$2');
$routes->get('institucion-financiera', 'Administracion::instituciones_financieras');
$routes->get('institucion-financiera-new', 'Administracion::institucion_financiera_new');
$routes->get('institucion-financiera-delete/(:num)/(:num)', 'Administracion::institucion_financiera_delete/$1/$2');
$routes->post('institucion-financiera-create', 'Administracion::institucion_financiera_create');
$routes->get('usuarios', 'Administracion::usuarios');
$routes->post('user-insert', 'Administracion::user_insert');
$routes->post('user-update', 'Administracion::user_update');
$routes->get('user-delete', 'Administracion::user_delete');
$routes->get('user-cambia-estado', 'Administracion::user_cambia_estado');
$routes->get('user-estado-ventas', 'Administracion::user_estado_ventas');
$routes->get('usuario-edit/(:num)', 'Administracion::form_usuario_edit/$1');
$routes->get('usuario-create', 'Administracion::form_usuario_create');
$routes->get('roles', 'Administracion::roles');
$routes->get('getRoles', 'Administracion::getRoles');
$routes->get('rol-edit/(:num)', 'Administracion::form_rol_edit/$1');
$routes->get('asigna-rol-2', 'Administracion::asigna_rol_2');
$routes->get('desactivar', 'Administracion::desactivar');
$routes->get('sign-off', 'Administracion::sign_off');
$routes->get('sectores-entrega', 'Administracion::sectoresEntrega');
$routes->post('sector-entrega-insert', 'Administracion::sector_entrega_insert');
$routes->get('sector-entrega-create', 'Administracion::form_sestor_entrega_create');
$routes->post('product-personalize', 'Administracion::product_personalize');
$routes->get('updateVariableSistema', 'Administracion::updateVariableSistema');
$routes->get('actualizaPrecioItem', 'Administracion::actualizaPrecioItem');
$routes->get('actualizaPermiso', 'Administracion::actualizaPermiso');
$routes->get('list-items', 'Administracion::list_items');
$routes->get('set-arreg-temp-definitivo/(:num)', 'Administracion::set_arreg_temp_definitivo/$1');
$routes->get('productos-relacionados/(:num)', 'Administracion::productosRelacionados/$1');
$routes->get('sucursales', 'Administracion::sucursales');
$routes->get('sucursal-create', 'Administracion::form_sucursal_create');
$routes->get('sucursal-delete/(:num)', 'Administracion::sucursal_delete/$1');
$routes->post('sucursal-insert', 'Administracion::sucursal_insert');
$routes->get('sucursal-edit/(:num)', 'Administracion::form_sucursal_edit/$1');
$routes->get('updateSucursalSector/(:num)/(:num)/(:any)', 'Administracion::updateSucursalSector/$1/$2/$3');
$routes->get('getSucursales', 'Administracion::getSucursales');
$routes->get('asignaSectorSucursal', 'Administracion::asignaSectorSucursal');
$routes->get('eliminarSectorSucursal', 'Administracion::eliminarSectorSucursal');

//Proveedores
$routes->get('proveedores', 'Proveedores::index');
$routes->get('proveedor-create', 'Proveedores::create');
$routes->post('proveedor-insert', 'Proveedores::insert');
$routes->get('proveedor-edit/(:num)', 'Proveedores::edit/$1');
$routes->post('proveedor-update', 'Proveedores::update');

//Gastos
$routes->get('gastos', 'Gastos::index');
$routes->post('gastos', 'Gastos::gridGastoFiltrado');
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
$routes->get('reporte-procedencias', 'Reportes::frmReporteProcedencias');
$routes->post('reporte-procedencias', 'Reportes::reporteProcedencias');
$routes->post('reporte-procedencias-excel', 'Reportes::reporteProcedenciasExcel');
$routes->get('reporte-procedencias-excel', 'Reportes::reporteProcedenciasExcel');

$routes->get('reporte_diario_ventas', 'Reportes::frmReporteDiarioVentas');
$routes->post('reporte_diario_ventas', 'Reportes::reporteDiarioVentas');
$routes->post('reporte_diario_ventas_excel', 'Reportes::reporteDiarioVentasExcel');
$routes->get('reporte-diario-ventas-excel', 'Reportes::reporteDiarioVentasExcel');
$routes->get('item-pagado-update', 'Reportes::item_pagado_update');

$routes->get('reporte-estadisticas-vendedor', 'Reportes::frmReporteEstadisticasVendedor');
$routes->post('reporte-estadisticas-vendedor', 'Reportes::reporteEstadisticasVendedor');
$routes->get('reporte-estadisticas-vendedor-excel', 'Reportes::reporteEstadisticasVendedorExcel');

$routes->get('reporte-master-ingresos', 'Reportes::frmReporteMasterIngresos');
$routes->post('reporte-master-ingresos', 'Reportes::reporteMasterIngresos');
$routes->get('reporte-master-ingresos-excel', 'Reportes::reporteMasterIngresosExcel');

$routes->get('reporte-master-gastos', 'Reportes::frmReporteMasterGastos');
$routes->post('reporte-master-gastos', 'Reportes::reporteMasterGastos');
$routes->get('reporte-master-gastos-excel', 'Reportes::reporteMasterGastosExcel');

$routes->get('reporte-devoluciones', 'Reportes::frmReporteDevoluciones');
$routes->post('reporte-devoluciones', 'Reportes::reporteDevoluciones');
$routes->get('reporte-devoluciones-excel', 'Reportes::reporteDevolucionesExcel');


$routes->get('reporte-list-items', 'Reportes::reporteListItems');
$routes->get('reporte-items-sensibles', 'Reportes::reporteItemsSensibles');


// $routes->group('printTicket', ['filter' => 'cors:printTicket'], static function (RouteCollection $routes): void {
//     $routes->resource('http://localhost:8000/imprimir');

//     $routes->options('http://localhost:8000/imprimir', static function () {});
// });