<?php

namespace App\Controllers;
use TCPDF;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tickets extends BaseController {

    function imprimirTicket($id, $cod_pedido){
        //echo "imprimiendo";
        //Traigo los datos del pedido para la cabecera
        $datosPedido = $this->pedidoModel->_getDatosPedidoTicket($id);
        $this->ticketPdf($datosPedido);

    }

    function ticketPdf($datosPedido){
        //require __DIR__ . '/vendor/autoload.php';
        $width = 58;
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
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(0.2);

        //$width = 0;
        $fill = 0;
        $posY = 0;
        $fontSize = 1;
        
        //Campo dirección de entrega
        $numCaracterDir = strlen($datosPedido->dir_entrega);
        if ($numCaracterDir >= 80 && $numCaracterDir < 150) {
            $fontSize = 0.8;
        } else if($numCaracterDir >= 150){
            $fontSize = 0.7;
        }else{
            $fontSize = 1;
        }

        //Campo observación del pedido
        $numCaracterObservaPedido = strlen($datosPedido->observaciones);
        if ($numCaracterObservaPedido >= 80 && $numCaracterObservaPedido < 150) {
            $fontSizeObservaPedido = 0.8;
        } else if($numCaracterObservaPedido >= 150){
            $fontSizeObservaPedido = 0.7;
        }else{
            $fontSizeObservaPedido = 1;
        }
        
         
        $pdf->AddPage(); 

        $pdf->SetFont('helvetica', 'B', 8, '', false);

        $html = '';
        $html .= '
            <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;margin: top 0px;">
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.9em;
                        height: 15px"
                    >No. Pedido: </td>
                    <td 
                        style="font-weight: bold;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 1em;
                        height: 15px"
                    >'.$datosPedido->cod_pedido.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.9em;
                        height: 15px"
                    >Fecha: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: 15px"
                    >'.$nombreDia.' '.date('d-m-Y', strtotime($datosPedido->fecha_entrega)).'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.9em;
                        height: 35px"
                    >Cliente: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: 35px"
                        
                    >'.$datosPedido->cliente.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.9em;
                        height: 35px"
                    >Hora de entrega: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;
                        height: 35px"
                    >Desde:'.$datosPedido->rango_entrega_desde.' | Hasta: '.$datosPedido->rango_entrega_hasta.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.9em;
                        height: 50px"
                    >Dirección: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: '.$fontSize.'em;
                        height: 50px"
                    >'.$datosPedido->dir_entrega.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.9em;
                        height: 15px"
                    >Sector: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.8em;
                        height: 15px"
                    >'.$datosPedido->sector.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.8em;
                        text-align: left;
                        height: auto;overflow: hidden;
                        white-space: nowrap"
                    >Observación del pedido: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: '.$fontSizeObservaPedido.'em;
                        text-align: justify;
                        height: 50px"
                    >'.$datosPedido->observaciones.'</td>
                </tr>
            </table>
        ';
        /*
        writeHTMLCell(float $w, float $h, float|null $x, float|null $y[, string $html = '' ]
                [, mixed $border = 0 ][, int $ln = 0 ][, bool $fill = false ]
                [, bool $reseth = true ][, string $align = '' ][, bool $autopadding = true ]) : mixed
        */
        $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY+2, $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='L', $autopadding=false);
        
        $posY += 85;

        //Para cada arreglo traigo los atributos de cada arreglo
        //echo '<pre>'.var_export($arreglos, true).'</pre>';exit;

        foreach ($arreglos as $key => $arreglo) {
            
            if ($arreglo->idcategoria == 1 || $arreglo->idcategoria == 2) {
                //Traigo los attr extra
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);


                if ($atributos) {
                    //Form Attr extra Frutales y florales

                    //Campo Mensaje fresas
                    $numCaracterMensajeFresas = strlen($atributos->mensaje_fresas);
                    if ($numCaracterMensajeFresas >= 80 && $numCaracterMensajeFresas < 150) {
                        $fontSizeMensajeFresas = 0.8;
                    } else if($numCaracterMensajeFresas >= 150){
                        $fontSizeMensajeFresas = 0.7;
                    }else{
                        $fontSizeMensajeFresas = 1;
                    }

                    //Campo Observación del arreglo
                    $numCaracterObservaArreglo = strlen($arreglo->observacion);
                    if ($numCaracterObservaArreglo >= 80 && $numCaracterObservaArreglo < 150) {
                        $fontSizeObservaArreglo = 0.8;
                    } else if($numCaracterObservaArreglo >= 150){
                        $fontSizeObservaArreglo = 0.7;
                    }else{
                        $fontSizeObservaArreglo = 1;
                    }

                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    height: 40px"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: 40px"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    height: 40px"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    height: 40px"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    height: 60px"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeMensajeFresas.'em;
                                    height: 60px"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    height: 20px"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                    height: 20px
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    height: 20px"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.8em;
                                    height: 20px"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >Observación del arreglo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeObservaArreglo.'em;
                                    text-align: justify;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY+2, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                }
                $posY += 90;

            } else if($arreglo->idcategoria == 3) {
                //Form Attr Desayunos
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);
                
                if ($atributos) {
                    

                    //Campo Observación del arreglo
                    $numCaracterComplementos = strlen($atributos->complementos);
                    if ($numCaracterComplementos >= 80 && $numCaracterComplementos < 150) {
                        $fontSizeComplementos = 0.7;
                    } else if($numCaracterComplementos >= 150){
                        $fontSizeComplementos = 0.6;
                    }else{
                        $fontSizeComplementos = 1;
                    }

                    //Campo Mensaje fresas
                    $numCaracterMensajeFresas = strlen($atributos->mensaje_fresas);
                    if ($numCaracterMensajeFresas >= 80 && $numCaracterMensajeFresas < 150) {
                        $fontSizeMensajeFresas = 0.8;
                    } else if($numCaracterMensajeFresas >= 150){
                        $fontSizeMensajeFresas = 0.7;
                    }else{
                        $fontSizeMensajeFresas = 1;
                    }

                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeMensajeFresas.'em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Bebida del desayuno: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->bebida.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Huevo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->huevo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.65em;
                                    text-align: left;"
                                >Información complementaria</td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeComplementos.'em;
                                    text-align: left;"
                                >'.$atributos->complementos.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY+2, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 80;
                }
            } else if($arreglo->idcategoria == 4) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);

                if ($atributos) {
                    //Form Attr extra Frutales y florales

                    //Campo Observación del arreglo
                    $numCaracterObservaArreglo = strlen($arreglo->observacion);
                    if ($numCaracterObservaArreglo >= 80 && $numCaracterObservaArreglo < 150) {
                        $fontSizeObservaArreglo = 0.8;
                    } else if($numCaracterObservaArreglo >= 150){
                        $fontSizeObservaArreglo = 0.7;
                    }else{
                        $fontSizeObservaArreglo = 1;
                    }

                    //Campo Mensaje fresas
                    $numCaracterMensajeFresas = strlen($atributos->mensaje_fresas);
                    if ($numCaracterMensajeFresas >= 80 && $numCaracterMensajeFresas < 150) {
                        $fontSizeMensajeFresas = 0.8;
                    } else if($numCaracterMensajeFresas >= 150){
                        $fontSizeMensajeFresas = 0.7;
                    }else{
                        $fontSizeMensajeFresas = 1;
                    }

                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeMensajeFresas.'em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Frases paredes: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->frases_paredes.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Fotos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->fotos.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >Observación de la Magic Box: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeObservaArreglo.'em;
                                    text-align: justify;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY+2, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 80;
                }
            } else if($arreglo->idcategoria == 5) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);
                if ($atributos) {
                    //Form Bocaditos

                    //Campo Observación del arreglo
                    $numCaracterObservaArreglo = strlen($arreglo->observacion);
                    if ($numCaracterObservaArreglo >= 80 && $numCaracterObservaArreglo < 150) {
                        $fontSizeObservaArreglo = 0.8;
                    } else if($numCaracterObservaArreglo >= 150){
                        $fontSizeObservaArreglo = 0.7;
                    }else{
                        $fontSizeObservaArreglo = 1;
                    }

                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Recibe: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;"
                                >Opciones: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;"
                                >'.$atributos->opciones.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:35%;
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >Observación de Bocaditos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: '.$fontSizeObservaArreglo.'em;
                                    text-align: justify;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY+2, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 80;
                }
            }
            
        }
        $pdf->Output('Ticket.pdf');    // send the file inline to the browser (default).
    }

    function ticketPdf2($id, $cod_pedido){
        $rows = 3;
        $content_line = array("1", "2", "3", "4");
        //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //$tcpdf = new TCPDF;
        //IMPORTANTE ESTA LÍNEA
        $this->response->setHeader('Content-Type', 'application/pdf'); 

        $pdf->AddPage('L', array(57,32));
        $pdf->SetFont('dejavusans');
        $pdf->SetAutoPageBreak(true, 0);
        $html ="
                <table class='domi'>
                    <tbody >";
                    for($i=0; $i<$rows; $i++){
                        $style=' style="font-size:12px"';
                        "<tr><td".$style."><b>".$content_line[$i]."</b></td></tr>";
                    }
                    "</tbody>
                </table>";
        $pdf->writeHTMLCell($w=48, $h=2, $x='1', $y='1', $html, $border=1, $ln=1, $fill=0, $reseth=false, $align='C', $autopadding=true);
        $pdf->Output("Ticket.pdf", 'I');
    }
}
