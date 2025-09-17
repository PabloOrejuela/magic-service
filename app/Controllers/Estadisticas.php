<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Estadisticas extends BaseController {

    private $sugest = [
        1 => 'Día actual', 
        2 => 'Ultimo mes', 
        3 => 'Ultima semana', 
    ];

    private $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    /**
     * Genera la estadistica de ticket promedio de ventas
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function ticketPromedio(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Estadísticas';
            $data['subtitle']='Ticket Promedio Ventas';
            $data['main_content']='estadisticas/form_ticket_promedio_ventas';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Procedimiento ajax
     * @param Type $var Description
     * @return voidcñ
     * @throws conditon
     **/
    public function reporteTicketPromedio(){

        $datos['fecha'] = $this->request->getPostGet('mes');  
        $negocio = $this->request->getPostGet('negocio');  
        
        $cantidadPedidos = 0;
        $sumaIngreso = 0;

        $fecha = explode('-', $datos['fecha']);
        $mes = $fecha[1];
        $anio = $fecha[0];
        $data['numDias'] = cal_days_in_month(0, $mes, $anio);
        $data['res'] = NULL;
        $fechaInicio = $datos['fecha'].'-01';
        $fechaFinal = $datos['fecha'].'-'.$data['numDias'];
        
        //Obtengo la suma de los ingresos del mes
        for ($i = 1; $i <= $data['numDias']; $i++) { 
            $dia = $datos['fecha'].'-'.($i > 9 ? $i : '0'.$i);
            
            //OBTENDO EL RESULTADO DE VENTAS DE EL DÍA 
            $res[$i]['res'] = $this->pedidoModel->_getSumatoriaPedidosDia($dia, $negocio);
            $res[$i]['dia'] = date('N', strtotime($dia));
            $sumaIngreso += $res[$i]['res'];
        }
        // echo $this->db->getLastQuery();
        //Obtengo la cantidad de pedidos del mes
        $cantidadPedidos = $this->pedidoModel->_getPedidosRangoFechas($fechaInicio, $fechaFinal);

        //header('Content-Type: application/json');
        echo json_encode([
            'success' => true, 
            'negocio' => $negocio,
            'cantidad' => count($cantidadPedidos),
            'mensaje' => 'Actualizado correctamente',
            'sumaIngreso' => $sumaIngreso,
        ]);
        exit;
    }

    /**
     * Genera la estadistica de código de arreglo mas vendido
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function arregMasVendidos(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Estadísticas';
            $data['subtitle']='Código de arreglo mas vendido';
            $data['main_content']='estadisticas/form_cod_arreglo_mas_vendido';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Genera la estadistica de código de arreglo mas vendido
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function frmEstCategorias(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;

            $data['title']='Estadísticas';
            $data['subtitle']='Estadística por categorías';
            $data['main_content']='estadisticas/form_est_categorias';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Genera la estadistica de la categoría menos vendida
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function frmCategoriaMenosVendida(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Estadísticas';
            $data['subtitle']='Categoría menos vendida';
            $data['main_content']='estadisticas/form_cat_menos_vendida';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Genera la estadistica de el cliente que mas ha comprado
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function frmClientesFrecuentes(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Estadísticas';
            $data['subtitle']='Clientes que mas han comprado';
            $data['main_content']='estadisticas/form_clientes_frecuentes';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Genera la estadistica de los nuevos clientes que han realizado pedidos en un período de tiempo
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function frmNuevosClientes(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['anios'] = $this->pedidoModel
            ->select("DISTINCT YEAR(fecha) as anio")
            ->orderBy("anio", "ASC")
            ->findAll();

            //echo '<pre>'.var_export($data['anios'], true).'</pre>';exit;

            $data['title']='Estadísticas';
            $data['subtitle']='Cantidad de clientes nuevos que han realizado pedidos';
            $data['main_content']='estadisticas/form_nuevos_clientes';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function clientesFrecuentes(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
            ];
            
            $this->validation->setRuleGroup('clientesFrecuentes');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                $fecha = explode('-', $datos['fecha']);
                $mes = $fecha[1];
                $anio = $fecha[0];
                $data['numDias'] = cal_days_in_month(0, $mes, $anio);

                $datos['fecha_inicio'] = $datos['fecha'].'-01';
                $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];


                //Traigo los arreglos con mas ventas de ese mes
                $data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], 180, 'desc');

                $contadorCliente = [];
                $cliente = null;
                
                if ($data['pedidos']) { //uso un if a modo de try
                    foreach ($data['pedidos'] as $pedido) {

                        $cliente = $pedido->cliente;
                        $idcliente = $pedido->idcliente;
                        $total = $pedido->total;

                        if (!isset($contadorCliente[$cliente])) {
                            $contadorCliente[$cliente] = [
                                'idcliente' => $idcliente,
                                'cliente' => $cliente,
                                'total' => $total,
                                'cant' => 1,
                            ];
                        } else {
                            $contadorCliente[$cliente]['cant']++;
                            $contadorCliente[$cliente]['total']+=$pedido->total;
                        }
                    }
                }

                //Les ordeno de mayor a menor
                usort($contadorCliente, function($a, $b) {
                    return $b['cant'] <=> $a['cant'];
                });

                //echo '<pre>'.var_export($contadorCliente, true).'</pre>';exit;

                $data['datos'] = $datos;
                $data['res'] = $contadorCliente;
                $data['title']='Estadísticas';
                $data['subtitle']='Clientes que mas han comprado';
                $data['main_content']='estadisticas/clientes_frecuentes';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    public function nuevosClientes(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
                'anio' => $this->request->getPostGet('anio'),
            ];
            
            $this->validation->setRuleGroup('nuevosClientes');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 

                //Verifico si ha elegido año o no
                echo '<pre>'.var_export($datos['anio'], true).'</pre>';exit;

                $fecha = explode('-', $datos['fecha']);
                $mes = $fecha[1];
                $anio = $fecha[0];
                $data['numDias'] = cal_days_in_month(0, $mes, $anio);

                $datos['fecha_inicio'] = $datos['fecha'].'-01';
                $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];


                //Traigo los arreglos con mas ventas de ese mes
                $data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], 180, 'desc');

                $contadorCliente = [];
                $cliente = null;
                
                if ($data['pedidos']) { //uso un if a modo de try
                    foreach ($data['pedidos'] as $pedido) {

                        $cliente = $pedido->cliente;
                        $idcliente = $pedido->idcliente;
                        $total = $pedido->total;

                        if (!isset($contadorCliente[$cliente])) {
                            $contadorCliente[$cliente] = [
                                'idcliente' => $idcliente,
                                'cliente' => $cliente,
                                'total' => $total,
                                'cant' => 1,
                            ];
                        } else {
                            $contadorCliente[$cliente]['cant']++;
                            $contadorCliente[$cliente]['total']+=$pedido->total;
                        }
                    }
                }

                //Les ordeno de mayor a menor
                usort($contadorCliente, function($a, $b) {
                    return $b['cant'] <=> $a['cant'];
                });

                //echo '<pre>'.var_export($contadorCliente, true).'</pre>';exit;

                $data['datos'] = $datos;
                $data['res'] = $contadorCliente;
                $data['title']='Estadísticas';
                $data['subtitle']='Clientes que mas han comprado';
                $data['main_content']='estadisticas/clientes_frecuentes';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    public function estCategorias(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            
            $datos = [
                'fecha' => $this->request->getPostGet('fecha'),
                'cant' => $this->request->getPostGet('cant_arreglos'),
            ];

            $datos['negocio'] = null;

            $fecha = explode('-', $datos['fecha']);
            $mes = $fecha[1];
            $anio = $fecha[0];
            $data['numDias'] = cal_days_in_month(0, $mes, $anio);

            $datos['fecha_inicio'] = $datos['fecha'].'-01';
            $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];

            //Declaro las variables para almacenar las cantidades de las categorías
            $frutal = 0;
            $floral = 0;
            $desayuno = 0;
            $magic_box = 0;
            $bocaditos = 0;
            $complementos = 0;

            //Traigo los arreglos con mas ventas de ese mes
            $data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], 0, 'asc');

            //Recorro los pedidos y traigo el detalle de cada uno
            $data['detalle'] = [];
            
            if ($data['pedidos']) { //uso un if a modo de try
                foreach ($data['pedidos'] as $pedido) {
                
                    // Obtengo el detalle de cada pedido
                    $detalles = $this->detallePedidoModel->_getDetallePedidoEst($pedido->cod_pedido);

                    if ($detalles) {
                        foreach ($detalles as $detalle) {
                            $idProducto = $detalle->idproducto;
                            $pvp = $detalle->pvp; 
                            $idcategoria = $detalle->idcategoria; 

                            if ($idcategoria == 1) {
                                $frutal += 1;
                            }else if($idcategoria == 2){
                                $floral += 1;
                            }else if($idcategoria == 3){
                                $desayuno  += 1;
                            }else if($idcategoria == 4){
                                $magic_box += 1;
                            }else if($idcategoria == 5){
                                $bocaditos += 1;
                            }else if($idcategoria == 6){
                                $complementos += 1;
                            }
                            
                        }
                    }
                }
            }

            //Paso los valores de las categorías
            $categorias = [
                'frutal' => $frutal, 
                'floral' => $floral, 
                'desayuno' => $desayuno, 
                'magic_box' => $magic_box, 
                'bocaditos' => $bocaditos, 
                'complementos' => $complementos
            ];

            // Las ordeno de mayor a menor
            arsort($categorias);

            $data['datos'] = $datos;
            $data['res'] = $categorias;
            $data['title']='Estadísticas';
            $data['subtitle']='Codigos mas vendidos en el mes';
            $data['main_content']='estadisticas/est_categorias';
            return view('dashboard/index', $data);

        }else{
            return redirect()->to('logout');
        }
    }

    public function estCodArregloMasVendido(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
                'cant' => $this->request->getPostGet('cant_arreglos'),
            ];
            
            $this->validation->setRuleGroup('estCodArregloMasVendido');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                $fecha = explode('-', $datos['fecha']);
                $mes = $fecha[1];
                $anio = $fecha[0];
                $data['numDias'] = cal_days_in_month(0, $mes, $anio);

                $datos['fecha_inicio'] = $datos['fecha'].'-01';
                $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];
                

                //Traigo los arreglos con mas ventas de ese mes
                $data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], $datos['cant'], 'asc');

                //Recorro los pedidos y traigo el detalle de cada uno
                $data['detalle'] = [];
                $contadorProductos = [];

                foreach ($data['pedidos'] as $pedido) {
                    
                    // Obtén el detalle del pedido (ajusta el método según tu modelo)
                    $detalles = $this->detallePedidoModel->_getDetallePedidoEst($pedido->cod_pedido);

                    if ($detalles) {
                        foreach ($detalles as $detalle) {
                            $idProducto = $detalle->idproducto;
                            $pvp = $detalle->pvp; 

                            if (!isset($contadorProductos[$idProducto])) {
                                $contadorProductos[$idProducto] = [
                                    'id' => $idProducto,
                                    'cant' => 1,
                                    'pvp' => $pvp
                                ];
                            } else {
                                $contadorProductos[$idProducto]['cant']++;
                            }
                        }
                    }
                }

                // Ordenar por 'cant' de mayor a menor
                usort($contadorProductos, function($a, $b) {
                    return $b['cant'] <=> $a['cant'];
                });

                //echo '<pre>'.var_export($datos, true).'</pre>';exit;
                $data['datos'] = $datos;
                $data['res'] = $contadorProductos;
                $data['title']='Estadísticas';
                $data['subtitle']='Codigos mas vendidos en el mes';
                $data['main_content']='estadisticas/cod_arreglo_mas_vendido';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Genera la estadistica de código de arreglo menos vendido
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function arregMenosVendidos(){
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Estadísticas';
            $data['subtitle']='Código de arreglo menos vendido';
            $data['main_content']='estadisticas/form_cod_arreglo_menos_vendido';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function estCodArregloMenosVendido(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
                'cant' => $this->request->getPostGet('cant_arreglos'),
            ];
            
            $this->validation->setRuleGroup('estCodArregloMasVendido');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                $fecha = explode('-', $datos['fecha']);
                $mes = $fecha[1];
                $anio = $fecha[0];
                $data['numDias'] = cal_days_in_month(0, $mes, $anio);

                $datos['fecha_inicio'] = $datos['fecha'].'-01';
                $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];
                

                //Traigo los arreglos con mas ventas de ese mes
                $data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], $datos['cant'], 'asc');
                
                //Recorro los pedidos y traigo el detalle de cada uno
                $data['detalle'] = [];
                $contadorProductos = [];

                foreach ($data['pedidos'] as $pedido) {
                    
                    // Obtén el detalle del pedido (ajusta el método según tu modelo)
                    $detalles = $this->detallePedidoModel->_getDetallePedidoEst($pedido->cod_pedido);

                    if ($detalles) {
                        foreach ($detalles as $detalle) {
                            $idProducto = $detalle->idproducto;
                            $pvp = $detalle->pvp; 

                            if (!isset($contadorProductos[$idProducto])) {
                                $contadorProductos[$idProducto] = [
                                    'id' => $idProducto,
                                    'cant' => 1,
                                    'pvp' => $pvp
                                ];
                            } else {
                                $contadorProductos[$idProducto]['cant']++;
                            }
                        }
                    }
                }

                // Ordenar por 'cant' de mayor a menor
                usort($contadorProductos, function($a, $b) {
                    return $a['cant'] <=> $b['cant'];
                });

                //echo '<pre>'.var_export($datos, true).'</pre>';exit;
                $data['datos'] = $datos;
                $data['res'] = $contadorProductos;
                $data['title']='Estadísticas';
                $data['subtitle']='Codigos menos vendidos en el mes';
                $data['main_content']='estadisticas/cod_arreglo_menos_vendido';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }
}


