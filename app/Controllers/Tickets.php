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

        $width = 0;
        $fill = 0;
        $posY = 0;

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
                        font-size: 1em;"
                    >No. Pedido: </td>
                    <td 
                        style="font-weight: bold;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 1em;"
                    >'.$datosPedido->cod_pedido.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 1em;"
                    >Fecha: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.9em;"
                    >'.$datosPedido->fecha_entrega.'-'.$nombreDia.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 1em;"
                    >Cliente: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 1em;"
                    >'.$datosPedido->cliente.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 1em;"
                    >Hora de entrega: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 1em;"
                    >'.$datosPedido->hora.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 1em;"
                    >Dirección: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 1em;"
                    >'.$datosPedido->dir_entrega.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 1em;"
                    >Sector: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 1em;"
                    >'.$datosPedido->sector.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 1em;
                        text-align: justify;"
                    >Observación del pedido: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 1em;
                        text-align: justify;"
                    >'.$datosPedido->observaciones.'</td>
                </tr>
            </table>
        ';
        /*
        writeHTMLCell(float $w, float $h, float|null $x, float|null $y[, string $html = '' ]
                [, mixed $border = 0 ][, int $ln = 0 ][, bool $fill = false ]
                [, bool $reseth = true ][, string $align = '' ][, bool $autopadding = true ]) : mixed
        */
        $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y='4', $html, $border=0, $ln=0, $fill=0, $reseth=true, $align='L', $autopadding=false);
        
        $posY += 80;

        //Para cada arreglo traigo los atributos de cada arreglo
        //echo '<pre>'.var_export($arreglos, true).'</pre>';exit;

        foreach ($arreglos as $key => $arreglo) {
            
            if ($arreglo->idcategoria == 1 || $arreglo->idcategoria == 2) {
                //Traigo los attr extra
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);
                
                if ($atributos) {
                    //Form Attr extra Frutales y florales
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
                                    font-size: 0.9em;"
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
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >Observación del arreglo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                }
                $posY += 50;

            } else if($arreglo->idcategoria == 3) {
                //Form Attr extra Frutales y florales
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);
                if ($atributos) {
                    //Form Attr Desayunos
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
                                    font-size: 0.9em;"
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
                                    font-size: 0.8em;
                                    text-align: justify;"
                                >Observación del desayuno: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:65%;
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 50;
                }
            } else if($arreglo->idcategoria == 4) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);
                if ($atributos) {
                    //Form Attr extra Frutales y florales
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
                                    font-size: 0.9em;"
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
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 50;
                }
            } else if($arreglo->idcategoria == 5) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrExtArreg($arreglo->iddetalle, $arreglo->idcategoria);
                if ($atributos) {
                    //Form Bocaditos
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
                                    font-size: 0.9em;
                                    text-align: justify;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=47, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 50;
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
