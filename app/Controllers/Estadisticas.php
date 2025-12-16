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

    /**
     * Genera la estadistica de ticket promedio de ventas
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function ticketPromedio(){
        
        if ($this->session->reportes == 1) {
            
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
        
        if ($this->session->reportes == 1) {
            
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
     * Form estadistica de recompras
     *
     * @param Type $var Description
     * @return void
     * @throws conditon
     **/
    public function frmRecomprasMes(){
        
        if ($this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Estadísticas';
            $data['subtitle']='Estadística de recompras';
            $data['main_content']='estadisticas/form_recompras';
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
        
        if ($this->session->reportes == 1) {
            
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
        
        if ($this->session->reportes == 1) {
            
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
        
        if ($this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            $data['anios'] = $this->pedidoModel
            ->select("DISTINCT YEAR(fecha) as anio")
            ->orderBy("anio", "ASC")
            ->findAll();

            $data['title']='Estadísticas';
            $data['subtitle']='Clientes que mas han comprado (Frecuentes)';
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
    public function frmClientesNuevos(){
        
        if ($this->session->reportes == 1) {
            
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
        
        if ($this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
                'anio' => $this->request->getPostGet('anio'),
            ];

            //$this->validation->setRuleGroup('rules');

            $rules = [
                'fecha' => [
                    'rules'  => 'yearOrMonth[anio]',
                    'errors' => [
                        'yearOrMonth' => 'Debe seleccionar un año o una fecha y elegir un negocio.',
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                //Depuración
                //dd($validation->getErrors());
                return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
                //return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 

                // echo '<pre>'.var_export($datos['fecha'], true).'</pre>';exit;
                if($datos['anio'] == '0' && $datos['fecha'] == ''){

                    $this->session->setFlashdata('mensaje', $data);
                    //$this->logout();
                    return redirect()->back()->with('mensaje', 'Es obligatorio elegir un mes o un año para poder generar el reporte');
                }else if ($datos['anio'] == '0' && $datos['fecha'] != '') {
                
                    $fecha = explode('-', $datos['fecha']);
                    $mes = $fecha[1];
                    $anio = $fecha[0];
                    $data['numDias'] = cal_days_in_month(0, $mes, $anio);

                    $datos['fecha_inicio'] = $datos['fecha'].'-01';
                    $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];
                }else if($datos['anio'] != '0' && $datos['fecha'] == ''){
                    $datos['fecha_inicio'] = $datos['anio'].'-01-01';
                    $datos['fecha_final'] = $datos['anio'].'-12-31';
                }

                //Traigo los arreglos con mas ventas de ese mes
                $data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], 0, 'desc');

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

                $data['anios'] = $this->pedidoModel
                ->select("DISTINCT YEAR(fecha) as anio")
                ->orderBy("anio", "ASC")
                ->findAll();

                $data['datos'] = $datos;
                $data['res'] = $contadorCliente;
                $data['title']='Estadísticas';
                $data['subtitle']='Clientes que mas han comprado (Frecuentes)';
                $data['main_content']='estadisticas/clientes_frecuentes';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    public function clientesNuevos(){
        
        if ($this->session->reportes == 1) {
            
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

                if ($datos['anio'] == 0) {
                
                    $fecha = explode('-', $datos['fecha']);
                    $mes = $fecha[1];
                    $anio = $fecha[0];
                    $data['numDias'] = cal_days_in_month(0, $mes, $anio);

                    $datos['fecha_inicio'] = $datos['fecha'].'-01';
                    $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];
                }else{
                    $datos['fecha_inicio'] = $datos['anio'].'-01-01';
                    $datos['fecha_final'] = $datos['anio'].'-12-31';
                }


                //Traigo los clientes que han comprado en este periodo de tiempo
                $clientesNuevos = $this->pedidoModel
                    ->select('idcliente, nombre, MIN(fecha) as primer_pedido')
                    ->where('fecha >=', $datos['fecha_inicio'])
                    ->where('fecha <=', $datos['fecha_final'])
                    ->groupBy('idcliente')
                    ->join('clientes','clientes.id=pedidos.idcliente')
                    ->having('MIN(fecha) >=', $datos['fecha_inicio'])
                    ->having('MIN(fecha) <=', $datos['fecha_final'])
                    ->orderBy('nombre', 'asc')
                    ->findAll();

                $data['datos'] = [
                    'anio' => $datos['anio'],
                    'fecha_inicio' => $datos['fecha_inicio'],
                    'fecha_final' => $datos['fecha_final'],
                    'negocio' => $datos['negocio']
                ];

                $data['anios'] = $this->pedidoModel
                ->select("DISTINCT YEAR(fecha) as anio")
                ->orderBy("anio", "ASC")
                ->findAll();

                //echo '<pre>'.var_export(count($clientesNuevos), true).'</pre>';exit;

                $data['res'] = $clientesNuevos;
                $data['title']='Estadísticas';
                $data['subtitle']='Clientes nuevos que han realizado pedidos';
                $data['main_content']='estadisticas/clientes_nuevos';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    public function recomprasMes(){
        
        if ($this->session->reportes == 1) {
            
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

                if ($datos['anio'] == 0) {
                
                    $fecha = explode('-', $datos['fecha']);
                    $mes = $fecha[1];
                    $anio = $fecha[0];
                    $data['numDias'] = cal_days_in_month(0, $mes, $anio);

                    $datos['fecha_inicio'] = $datos['fecha'].'-01';
                    $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];
                }else{
                    $datos['fecha_inicio'] = $datos['anio'].'-01-01';
                    $datos['fecha_final'] = $datos['anio'].'-12-31';
                }


                //Traigo un array de todos los pedidos
                $pedidos = $this->pedidoModel->select('pedidos.id as id,cod_pedido,idcliente,fecha,nombre,documento')
                    ->join('clientes','clientes.id=pedidos.idcliente','left')
                    ->findAll();

                $clientes = $this->obtenerClientesRecurrentes($pedidos, $mes, $anio);
                
                $data['datos'] = [
                    'fecha' => $datos['fecha'],
                    'anio' => $datos['anio'],
                    'fecha_inicio' => $datos['fecha_inicio'],
                    'fecha_final' => $datos['fecha_final'],
                    'negocio' => $datos['negocio']
                ];

                $data['anios'] = $this->pedidoModel
                ->select("DISTINCT YEAR(fecha) as anio")
                ->orderBy("anio", "ASC")
                ->findAll();

                //echo '<pre>'.var_export($data['datos'], true).'</pre>';exit;

                $data['res'] = $clientes;
                $data['title']='Estadísticas';
                $data['subtitle']='Clientes antiguos que han hecho recompras en el mes';
                $data['main_content']='estadisticas/clientes_recompras';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    function obtenerClientesRecurrentes($ventas, $mes, $anio) {

        $clientes_mes = [];
        $clientes_anteriores = [];

        foreach ($ventas as $venta) {
            $fecha = strtotime($venta->fecha);
            $m = (int)date('n', $fecha);
            $y = (int)date('Y', $fecha);
            $cliente = $venta->idcliente;

            // Clientes con compras anteriores al mes consultado
            if ($y < $anio || ($y == $anio && $m < $mes)) {
                $clientes_anteriores[$cliente] = [
                    'id' => $cliente,
                    'nombre' => $venta->nombre,
                    'num_documento' => $venta->documento,
                ];
            }

            // Clientes con compras en el mes consultado
            if ($y == $anio && $m == $mes) {
                $clientes_mes[$cliente] = [
                    'id' => $cliente,
                    'nombre' => $venta->nombre,
                    'num_documento' => $venta->documento,
                ];
            }
        }

        // Intersección: clientes que están en ambos conjuntos
        $clientes_recurrentes = array_intersect_key($clientes_mes, $clientes_anteriores);

        $recurrentes = $this->ordenarPorNombre($clientes_recurrentes);
        return ($recurrentes);
    }

    function ordenarPorNombre($clientes) {
        usort($clientes, function($a, $b) {
            return strcasecmp($a['nombre'], $b['nombre']);
        });
        return $clientes;
    }

    public function estCategorias(){
        
        if ($this->session->reportes == 1) {
            
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
        
        if ($this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
                'cant' => $this->request->getPostGet('cant_arreglos'),
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
                $data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], $datos['cant'], 'asc');

                //Recorro los pedidos y traigo el detalle de cada uno
                $data['detalle'] = [];
                $contadorProductos = [];

                if ($data['pedidos']) {
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
        
        if ($this->session->reportes == 1) {
            
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
        
        if ($this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
                'cant' => $this->request->getPostGet('cant_arreglos'),
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

                //Traigo los arreglos con menos ventas, debo traer los que no tienen ni un pedido en ese período de tiempo
                //$data['pedidos'] = $this->pedidoModel->_getPedidosMesEstadisticas($datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final'], 0, 'asc');
                
                //Traer todos los productos del negocio
                if ($datos['negocio'] == '2') {
                    $productos = $this->productoModel->where('idcategoria', 5)->findAll();
                }else{
                    $productos = $this->productoModel->where('idcategoria !=', 5)->findAll();
                }
                
                $resultado = [];

                foreach ($productos as $producto) {
                    //Contar ventas en el periodo para cada producto
                    $cant = $this->contarVentasProducto($producto->id, $datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final']);
                    $cod_pedido = $this->primerCodPedidoProducto($producto->id, $datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final']);
                    $pvp = $this->pvpProducto($producto->id, $datos['negocio'], $datos['fecha_inicio'], $datos['fecha_final']);

                    $resultado[] = (object)[
                        'id' => $producto->id,
                        'producto' => $producto->producto,
                        'cant' => $cant,
                        'cod_pedido' => $cod_pedido,
                        'pvp' => $pvp
                    ];
                }

                //Ordenar por cantidad ascendente
                usort($resultado, function($a, $b) {
                    return $a->cant <=> $b->cant;
                });
                
                $data['nombreNegocio'] = $this->negocioModel->where('id', $datos['negocio'])->first();
                $data['datos'] = $datos;
                $data['res'] = $resultado;
                $data['title']='Estadísticas';
                $data['subtitle']='Codigos menos vendidos en el mes';
                $data['main_content']='estadisticas/cod_arreglo_menos_vendido';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    // Métodos auxiliares en el controlador
    private function contarVentasProducto($id_producto, $negocio, $fecha_inicio, $fecha_final) {
        $db = \Config\Database::connect();
        $builder = $db->table('detalle_pedido');
        $builder->selectCount('detalle_pedido.id', 'cant')
            ->join('pedidos', 'detalle_pedido.cod_pedido = pedidos.cod_pedido')
            ->where('detalle_pedido.idproducto', $id_producto)
            ->where('pedidos.idnegocio', $negocio)
            ->where('pedidos.fecha >=', $fecha_inicio)
            ->where('pedidos.fecha <=', $fecha_final);

        $row = $builder->get()->getRow();
        return $row ? $row->cant : 0;
    }

    private function primerCodPedidoProducto($id_producto, $negocio, $fecha_inicio, $fecha_final){
        $db = \Config\Database::connect();
        $builder = $db->table('detalle_pedido');
        $builder->select('detalle_pedido.cod_pedido')
            ->join('pedidos', 'detalle_pedido.cod_pedido = pedidos.cod_pedido')
            ->where('detalle_pedido.idproducto', $id_producto)
            ->where('pedidos.idnegocio', $negocio)
            ->where('pedidos.fecha >=', $fecha_inicio)
            ->where('pedidos.fecha <=', $fecha_final)
            ->orderBy('pedidos.fecha', 'asc')
            ->limit(1);

        $row = $builder->get()->getRow();
        return $row ? $row->cod_pedido : null;
    }

    private function pvpProducto($id_producto, $negocio, $fecha_inicio, $fecha_final){
        $db = \Config\Database::connect();
        $builder = $db->table('detalle_pedido');
        $builder->select('pvp')
            ->join('pedidos', 'detalle_pedido.cod_pedido = pedidos.cod_pedido')
            ->where('detalle_pedido.idproducto', $id_producto)
            ->where('pedidos.idnegocio', $negocio)
            ->where('pedidos.fecha >=', $fecha_inicio)
            ->where('pedidos.fecha <=', $fecha_final)
            ->orderBy('pedidos.fecha', 'asc')
            ->limit(1);

        $row = $builder->get()->getRow();
        return $row ? $row->pvp : null;
    }
}


