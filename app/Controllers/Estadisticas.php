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
}


