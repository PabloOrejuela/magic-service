<?php

namespace App\Controllers;
use TCPDF;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tickets extends BaseController {

    function imprimirTicket($id, $cod_pedido){

        //Traigo los datos del pedido para la cabecera
        $datosPedido = $this->pedidoModel->_getDatosPedidoTicket($id);

        $idcategoría = null;

        //Traigo los arreglo del pedido
        $arreglos = $this->detallePedidoModel->_getDetallePedido($datosPedido->cod_pedido);

        //Verifico la categoría de el arreglo
        foreach ($arreglos as $key => $arreglo) {

            if ($arreglo->idcategoria == 5) {
                $idcategoría = $arreglo->idcategoria;
            }else{
                continue;
            }
            
        }

        if ($idcategoría == 5) {
            $this->ticketPdfBocaditos($datosPedido);
        }else{
            $this->ticketPdf($datosPedido);
        }
        
    }

    function ticketPdfBocaditos($datosPedido){
        //require __DIR__ . '/vendor/autoload.php';
        $width = 58.1;
        $height = 400;

        $nombresDias = array(
            'Sunday'=>"Domingo", 
            'Monday'=>"Lunes", 
            'Tuesday'=>"Martes", 
            'Wednesday'=>"Miércoles", 
            'Thursday'=>"Jueves", 
            'Friday'=>"Viernes", 
            'Saturday'=>"Sábado"
        );

        //VALIDACION DE SIN REMITENTE
        $datosPedido->sin_remitente != 1 ? $cliente = $datosPedido->cliente : $cliente = 'Sin Remitente';

        //ESTABLEZCO EL NOMBRE DEL DÍA DE LA SEMANA        
        $nombreDia = $nombresDias[date('l', strtotime($datosPedido->fecha_entrega))];

        //Traigo los arreglo del pedido
        $arreglos = $this->detallePedidoModel->_getDetallePedido($datosPedido->cod_pedido);

        $pageLayout = array($width, $height); //  or array($height, $width) 
        
        //$pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
        $pdf = new TCPDF('P', 'mm', $pageLayout, true, 'UTF-8', 'false');  // create TCPDF object with default constructor args
        //$pdf->SetMargins(1, 1, 0, $keepmargins = true); 
        $pdf->setLeftMargin(2);

        //IMPORTANTE ESTA LÍNEA
        $this->response->setHeader('Content-Type', 'application/pdf'); 
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Colors, line width and bold font
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.2);

        //$width = 0;
        $fill = 0;
        $posY = 0;
        $fontSize = 0.9;
        
        //Campo dirección de entrega
        $numCaracterDir = strlen($datosPedido->dir_entrega);
        if ($numCaracterDir >= 80 && $numCaracterDir < 150) {
            $fontSize = 0.7;
        } else if($numCaracterDir >= 150){
            $fontSize = 0.7;
        }else{
            $fontSize = 0.7;
        }

        //Campo observación del pedido
        $numCaracterObservaPedido = strlen($datosPedido->observaciones);
        if ($numCaracterObservaPedido >= 80 && $numCaracterObservaPedido < 150) {
            $fontSizeObservaPedido = 0.7;
        } else if($numCaracterObservaPedido >= 150){
            $fontSizeObservaPedido = 0.7;
        }else{
            $fontSizeObservaPedido = 0.7;
        }
        
        $pdf->AddPage(); 

        //$pdf->SetFont('helvetica', 'B', 9, '', false);

        //Cabecera del ticket
        $html = '';
        $html .= '
            <table style="border: 0.1px solid rgb(0, 0, 0);padding: 2px;margin: top 0px;">
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.6em;
                        height: auto"
                    >No. Pedido: </td>
                    <td 
                        style="font-weight: bold;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;
                        height: auto"
                    >'.$datosPedido->cod_pedido.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.6em;
                        height: auto"
                    >Fecha: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;
                        height: auto"
                    >'.$nombreDia.' '.date('d-m-Y', strtotime($datosPedido->fecha_entrega)).'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.6em;
                        height: 25px"
                    >Cliente: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;
                        height: 25px"
                        
                    >'.$cliente.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.6em;
                        height: 25px"
                    >Hora de entrega: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;
                        height: 25px"
                    >Desde:'.$datosPedido->rango_entrega_desde.' | Hasta: '.$datosPedido->rango_entrega_hasta.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.6em;
                        height: auto"
                    >Dirección: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: '.$fontSize.'em;
                        height: auto"
                    >'.$datosPedido->dir_entrega.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.6em;
                        overflow: hidden;
                        height: auto"
                    >Sector: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;
                        height: auto"
                    >'.$datosPedido->sector.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.5em;
                        text-align: left;
                        word-break: break-word;
                        word-wrap: break-word;
                        height: auto;"
                    >Observación del pedido: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: '.$fontSizeObservaPedido.'em;
                        text-align: justify;
                        height: auto"
                    >'.$datosPedido->observaciones.'</td>
                </tr>
            
        ';
        
        $productosBocaditos = [];
        $atributosBocaditos = null;
        $textoBocadito = '';
        $textoObservacion = '';
        $textoRecibe = '';
        $textoCelular = '';
        $textoOpciones = '';
        

        //Para consolidar bocaditos
        foreach ($arreglos as $key => $arreglo) {
            $productosBocaditos[] = $arreglo->producto;
            $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);
            $textoRecibe .= $atributos ? $atributos->para : '';
            $textoOpciones .= $atributos ? $atributos->opciones : '';
            $textoCelular .= $atributos ? $atributos->celular : '';
            $textoObservacion .= $arreglo ? $arreglo->observacion.',' : '';
            
        }

        if (count($productosBocaditos) >= 1) {
            foreach ($productosBocaditos as $key => $bocadito) {
                $textoBocadito .= $key.'-'.$bocadito.',';                    
            }
        }

        $fontSizeObservaArreglo = 0.8;
        $bocaditos = str_replace(",", "<br/>", $textoBocadito);
        $observacion = str_replace(",", "<br/>", $textoObservacion);

        $html .= '<tr><td></td><td></td></tr>';
        $html .= '<tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        height: auto;
                        font-size: 0.6em;"
                    >Producto: </td>
                    <td 
                        style="font-weight: bold;
                        border: 0.5px solid #000;
                        width:65%;
                        height: auto;
                        font-size: 0.7em;"
                    >'.$bocaditos.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        height: auto;
                        font-size: 0.5em;
                        text-align: left;"
                    >Observación de Bocaditos: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        height: auto;
                        font-size: '.$fontSizeObservaArreglo.'em;
                        text-align: justify;"
                    >'.$observacion.'</td>
                </tr>';

        //Form Bocaditos              
        $recibe = str_replace(",", "<br/>", $textoRecibe);
        $opciones = str_replace(",", "<br/>", $textoOpciones);
        $celular = str_replace(",", "<br/>", $textoCelular);
        
        $html .= '<tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        height: 20px;
                        font-size: 0.6em;"
                    >Recibe: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        height: 20px;
                        font-size: 0.7em;"
                    >'.$recibe.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        height: 20px;
                        font-size: 0.6em;"
                    >Celular: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        height: 20px;
                        font-size: 0.7em;"
                    >'.$celular.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        height: auto;
                        font-size: 0.6em;"
                    >Opciones: </td>
                    
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        height: auto;
                        font-size: 0.7em;"
                    >'.$opciones.'</td>
                </tr>';

        $html .= '</table>';
        $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y='1', $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
        $pdf->Output('Ticket.pdf');    // send the file inline to the browser (default).
    }

    function ticketPdf($datosPedido){
        //require __DIR__ . '/vendor/autoload.php';
        $width = 58.1;
        $height = 400;

        $nombresDias = array(
            'Sunday'=>"Domingo", 
            'Monday'=>"Lunes", 
            'Tuesday'=>"Martes", 
            'Wednesday'=>"Miércoles", 
            'Thursday'=>"Jueves", 
            'Friday'=>"Viernes", 
            'Saturday'=>"Sábado"
        );

        //VALIDACION DE SIN REMITENTE
        $datosPedido->sin_remitente != 1 ? $cliente = $datosPedido->cliente : $cliente = 'Sin Remitente';

        //ESTABLEZCO EL NOMBRE DEL DÍA DE LA SEMANA        
        $nombreDia = $nombresDias[date('l', strtotime($datosPedido->fecha_entrega))];

        //Traigo los arreglo del pedido
        $arreglos = $this->detallePedidoModel->_getDetallePedido($datosPedido->cod_pedido);

        $pageLayout = array($width, $height); //  or array($height, $width) 
        
        //$pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
        $pdf = new TCPDF('P', 'mm', $pageLayout, true, 'UTF-8', 'false');  // create TCPDF object with default constructor args
        //$pdf->SetMargins(1, 1, 0, $keepmargins = true); 
        $pdf->setLeftMargin(2);

        //IMPORTANTE ESTA LÍNEA
        $this->response->setHeader('Content-Type', 'application/pdf'); 
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Colors, line width and bold font
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetLineWidth(0.2);

        //$width = 0;
        $fill = 0;
        $posY = 0;
        $fontSize = 0.9;
        
        //Campo dirección de entrega
        $numCaracterDir = strlen($datosPedido->dir_entrega);
        if ($numCaracterDir >= 80 && $numCaracterDir < 150) {
            $fontSize = 0.9;
        } else if($numCaracterDir >= 150){
            $fontSize = 0.8;
        }else{
            $fontSize = 0.9;
        }

        //Campo observación del pedido
        $numCaracterObservaPedido = strlen($datosPedido->observaciones);
        if ($numCaracterObservaPedido >= 80 && $numCaracterObservaPedido < 150) {
            $fontSizeObservaPedido = 0.9;
        } else if($numCaracterObservaPedido >= 150){
            $fontSizeObservaPedido = 0.8;
        }else{
            $fontSizeObservaPedido = 0.9;
        }
        
        $pdf->AddPage(); 

        //$pdf->SetFont('helvetica', 'B', 9, '', false);

        //Cabecera del ticket
        $html = '';
        $html .= '
            <table style="border: 0.1px solid rgb(0, 0, 0);padding: 2px;margin: top 0px;">
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        height: auto"
                    >No. Pedido: </td>
                    <td 
                        style="font-weight: bold;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: auto"
                    >'.$datosPedido->cod_pedido.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        height: auto"
                    >Fecha: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: auto"
                    >'.$nombreDia.' '.date('d-m-Y', strtotime($datosPedido->fecha_entrega)).'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        height: 25px"
                    >Cliente: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: 25px"
                        
                    >'.$cliente.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        height: 25px"
                    >Hora de entrega: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: 25px"
                    >Desde:'.$datosPedido->rango_entrega_desde.' | Hasta: '.$datosPedido->rango_entrega_hasta.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        height: auto"
                    >Dirección: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: '.$fontSize.'em;
                        height: auto"
                    >'.$datosPedido->dir_entrega.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        height: auto"
                    >Sector: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: auto"
                    >'.$datosPedido->sector.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        text-align: left;
                        height: auto;
                        overflow: hidden;
                        word-break: break-word;
                        word-wrap: break-word;"
                    >Observación del pedido: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: '.$fontSizeObservaPedido.'em;
                        text-align: justify;
                        height: auto"
                    >'.$datosPedido->observaciones.'</td>
                </tr>
            
        ';

        foreach ($arreglos as $key => $arreglo) {

            if ($arreglo->idcategoria == 1 || $arreglo->idcategoria == 2) {
                //Traigo los attr extra
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);

                //Campo Mensaje fresas

                //Campo Observación del arreglo
                $numCaracterObservaArreglo = strlen($arreglo->observacion);
                if ($numCaracterObservaArreglo >= 80 && $numCaracterObservaArreglo < 150) {
                    $fontSizeObservaArreglo = 0.9;
                } else if($numCaracterObservaArreglo >= 150){
                    $fontSizeObservaArreglo = 0.8;
                }else{
                    $fontSizeObservaArreglo = 0.9;
                }

                $html .= '<tr><td></td><td></td></tr>';
                $html .= '<tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;"
                            >Producto: </td>
                            <td 
                                style="font-weight: bold;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: 0.8em;"
                            >'.$arreglo->producto.'</td>
                        </tr>
                        <tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;
                                text-align: justify;"
                            >Observación del arreglo: </td>
                            <td 
                                style="font-weight: normal;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: '.$fontSizeObservaArreglo.'em;
                                text-align: justify;"
                            >'.$arreglo->observacion.'</td>
                        </tr>';

                if ($atributos) {
                    //Form Attr extra Frutales y florales

                    //Campo Mensaje fresas
                    $numCaracterMensajeFresas = strlen($atributos->mensaje_fresas);
                    if ($numCaracterMensajeFresas >= 80 && $numCaracterMensajeFresas < 150) {
                        $fontSizeMensajeFresas = 0.9;
                    } else if($numCaracterMensajeFresas >= 150){
                        $fontSizeMensajeFresas = 0.8;
                    }else{
                        $fontSizeMensajeFresas = 0.9;
                    }

                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: 25px"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: 25px"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: 25px"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: 25px"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: auto"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeMensajeFresas.'em;
                                    height: auto"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: auto"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                    height: auto
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: auto"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: auto"
                                >'.$atributos->globo.'</td>
                            </tr>
                        
                    ';
                    
                }else{

                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: 25px"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: 25px"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: 25px"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: 25px"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: auto"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: auto"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: auto"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                    height: auto
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.8em;
                                    height: auto"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: auto"
                                ></td>
                            </tr>
                        
                    ';
                }

            } else if($arreglo->idcategoria == 3) {
                //Form Attr Desayunos
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);

                //Campo Observación del arreglo
                if ($atributos) {
                    $numCaracterComplementos = strlen($atributos->complementos);
                    if ($numCaracterComplementos >= 80 && $numCaracterComplementos < 150) {
                        $fontSizeComplementos = 0.9;
                    } else if($numCaracterComplementos >= 150){
                        $fontSizeComplementos = 0.8;
                    }else{
                        $fontSizeComplementos = 0.9;
                    }

                    //Campo Mensaje fresas
                    $numCaracterMensajeFresas = strlen($atributos->mensaje_fresas);
                    if ($numCaracterMensajeFresas >= 80 && $numCaracterMensajeFresas < 150) {
                        $fontSizeMensajeFresas = 0.9;
                    } else if($numCaracterMensajeFresas >= 150){
                        $fontSizeMensajeFresas = 0.8;
                    }else{
                        $fontSizeMensajeFresas = 0.9;
                    }

                }else{
                    $fontSizeComplementos = 0.9;
                    $fontSizeMensajeFresas = 0.9;
                }

                
                $html .= '<tr><td></td><td></td></tr>';
                $html .= '
                    
                        <tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;"
                            >Producto: </td>
                            <td 
                                style="font-weight: bold;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: 0.9em;"
                            >'.$arreglo->producto.'</td>
                        </tr>
                        <tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;
                                text-align: justify;"
                            >Observación del desayuno: </td>
                            <td 
                                style="font-weight: normal;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: '.$fontSizeComplementos.'em;
                                text-align: justify;"
                            >'.$arreglo->observacion.'</td>
                        </tr>';
                
                if ($atributos) {

                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: '.$fontSizeMensajeFresas.'em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Bebida del desayuno: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->bebida.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Huevo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->huevo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.65em;
                                    text-align: left;"
                                >Información complementaria</td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: '.$fontSizeComplementos.'em;
                                    text-align: left;"
                                >'.$atributos->complementos.'</td>
                            </tr>
                        
                    ';
                    
                }else{
                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Bebida del desayuno: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Huevo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.65em;
                                    text-align: left;"
                                >Información complementaria</td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;
                                    text-align: left;"
                                ></td>
                            </tr>
                        
                    ';
                }
            } else if($arreglo->idcategoria == 4) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);

                //Campo Observación del arreglo
                $numCaracterObservaArreglo = strlen($arreglo->observacion);
                if ($numCaracterObservaArreglo >= 80 && $numCaracterObservaArreglo < 150) {
                    $fontSizeObservaArreglo = 0.9;
                } else if($numCaracterObservaArreglo >= 150){
                    $fontSizeObservaArreglo = 0.8;
                }else{
                    $fontSizeObservaArreglo = 0.9;
                }

                $html .= '<tr><td></td><td></td></tr>';
                $html .= '<tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;"
                            >Producto: </td>
                            <td 
                                style="font-weight: bold;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: 0.9em;"
                            >'.$arreglo->producto.'</td>
                        </tr>
                        <tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;
                                text-align: justify;"
                            >Observación de la Magic Box: </td>
                            <td 
                                style="font-weight: normal;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: '.$fontSizeObservaArreglo.'em;
                                text-align: justify;"
                            >'.$arreglo->observacion.'</td>
                        </tr>';

                if ($atributos) {
                    //Form Attr extra Frutales y florales

                    //Campo Mensaje fresas
                    $numCaracterMensajeFresas = strlen($atributos->mensaje_fresas);
                    if ($numCaracterMensajeFresas >= 80 && $numCaracterMensajeFresas < 150) {
                        $fontSizeMensajeFresas = 0.9;
                    } else if($numCaracterMensajeFresas >= 150){
                        $fontSizeMensajeFresas = 0.8;
                    }else{
                        $fontSizeMensajeFresas = 0.9;
                    }

                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: '.$fontSizeMensajeFresas.'em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Frases paredes: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->frases_paredes.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Fotos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->fotos.'</td>
                            </tr>';
                    
                }else{
                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Frases paredes: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Fotos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>';
                }
            } else if($arreglo->idcategoria == 6) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);

                //Campo Observación del arreglo
                $numCaracterObservaArreglo = strlen($arreglo->observacion);
                if ($numCaracterObservaArreglo >= 80 && $numCaracterObservaArreglo < 150) {
                    $fontSizeObservaArreglo = 0.9;
                } else if($numCaracterObservaArreglo >= 150){
                    $fontSizeObservaArreglo = 0.8;
                }else{
                    $fontSizeObservaArreglo = 0.9;
                }

                $html .= '<tr><td></td><td></td></tr>';
                $html .= '<tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;"
                            >Producto: </td>
                            <td 
                                style="font-weight: bold;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: 0.9em;"
                            >'.$arreglo->producto.'</td>
                        </tr>
                        <tr>
                            <td 
                                style="font-weight:bold;
                                border: 0.5px solid #000;
                                width:35%;
                                height: auto;
                                font-size: 0.8em;
                                text-align: justify;"
                            >Observación del producto: </td>
                            <td 
                                style="font-weight: normal;
                                border: 0.5px solid #000;
                                width:65%;
                                height: auto;
                                font-size: '.$fontSizeObservaArreglo.'em;
                                text-align: justify;"
                            >'.$arreglo->observacion.'</td>
                        </tr>';

                if ($atributos) {
                    //Form Attr extra Frutales y florales

                    //Campo Mensaje fresas
                    $numCaracterMensajeFresas = strlen($atributos->mensaje_fresas);
                    if ($numCaracterMensajeFresas >= 80 && $numCaracterMensajeFresas < 150) {
                        $fontSizeMensajeFresas = 0.9;
                    } else if($numCaracterMensajeFresas >= 150){
                        $fontSizeMensajeFresas = 0.8;
                    }else{
                        $fontSizeMensajeFresas = 0.9;
                    }

                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: '.$fontSizeMensajeFresas.'em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Frases paredes: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->frases_paredes.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Fotos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                >'.$atributos->fotos.'</td>
                            </tr>';
                    
                }else{
                    $html .= '<tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: 25px;
                                    font-size: 0.8em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: 25px;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Frases paredes: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    height: auto;
                                    font-size: 0.8em;"
                                >Fotos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    height: auto;
                                    font-size: 0.9em;"
                                ></td>
                            </tr>';
                }
            }
        }
        $html .= '</table>';
        $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y='1', $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
        $pdf->Output('Ticket.pdf');    // send the file inline to the browser (default).
    }
}
