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
        
        //echo '<pre>'.var_export($datosPedido, true).'</pre>';exit;

        //Si solo es un arreglo llamo al ticket dependiendo de la categoría

    }

    function ticketPdf($datosPedido){
        //require __DIR__ . '/vendor/autoload.php';
        $width = 57;
        $height = 150;

        //Traigo los arreglo del pedido
        $arreglos = $this->detallePedidoModel->_getDetallePedido($datosPedido->cod_pedido);

        $pageLayout = array($width, $height); //  or array($height, $width) 
        
        //$pdf = new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
        $pdf = new TCPDF('P', 'mm', $pageLayout, true, 'UTF-8', 'false');                 // create TCPDF object with default constructor args
        $pdf->SetMargins(PDF_MARGIN_LEFT, "10", PDF_MARGIN_RIGHT); 

        //IMPORTANTE ESTA LÍNEA
        $this->response->setHeader('Content-Type', 'application/pdf'); 
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Colors, line width and bold font
        $pdf->SetFillColor(255, 0, 0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(128, 0, 0);
        $pdf->SetLineWidth(0.2);

        $width = 30;
        $fill = 0;
        $posY = 0;

        $pdf->AddPage(); 

        $pdf->SetFont('helvetica', 'B', 7, '', false);

        $html = '';
        $html .= '
            <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.7em;"
                    >No. Pedido: </td>
                    <td 
                        style="font-weight: bold;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;"
                    >'.$datosPedido->cod_pedido.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.7em;"
                    >Fecha: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;"
                    >'.$datosPedido->fecha_entrega.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.7em;"
                    >Cliente: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;"
                    >'.$datosPedido->cliente.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.7em;"
                    >Hora de entrega: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;"
                    >'.$datosPedido->hora.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.7em;"
                    >Dirección: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;"
                    >'.$datosPedido->dir_entrega.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.7em;"
                    >Sector: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;"
                    >'.$datosPedido->sector.'</td>
                </tr>
                <tr>
                    <td 
                        style="font-weight:bold;
                        border: 0.5px solid #000;
                        width:35%;
                        font-size: 0.7em;"
                    >Observación del pedido: </td>
                    <td 
                        style="font-weight: normal;
                        border: 0.5px solid #000;
                        width:65%;
                        font-size: 0.7em;"
                    >'.$datosPedido->observaciones.'</td>
                </tr>
            </table>
        ';
        
        $pdf->writeHTMLCell($w=55, $h=2, $x='1', $y='4', $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
        //$pdf->Ln();
        $posY += 35;

        //Para cada arreglo traigo los atributos de cada arreglo
        //echo '<pre>'.var_export($arreglos, true).'</pre>';exit;

        foreach ($arreglos as $key => $arreglo) {
            //echo $arreglo->iddetalle;
            if ($arreglo->idcategoria == 1 || $arreglo->idcategoria == 2) {
                //Traigo los attr extra
                $atributos = $this->attrExtArregModel->_getAttrArreg($arreglo->iddetalle);
                if ($atributos) {
                    //Form Attr extra Frutales y florales
                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Observación del arreglo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=55, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                }
                $posY += 30;

            } else if($arreglo->idcategoria == 3) {
                //Form Attr extra Frutales y florales
                $atributos = $this->attrExtArregModel->_getAttrArreg($arreglo->iddetalle);
                if ($atributos) {
                    //Form Attr Desayunos
                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Bebida del desayuno: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->bebida.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Huevo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->huevo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Observación del desayuno: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=55, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 35;
                }
            } else if($arreglo->idcategoria == 4) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrArreg($arreglo->iddetalle);
                if ($atributos) {
                    //Form Attr extra Frutales y florales
                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Para: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Mensaje Fresas: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->mensaje_fresas.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Peluche: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->peluche.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Globo: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->globo.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Frases paredes: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->frases_paredes.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Fotos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->fotos.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Observación de la Magic Box: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=55, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 35;
                }
            } else if($arreglo->idcategoria == 5) {
                //Form Attr Magic Box
                $atributos = $this->attrExtArregModel->_getAttrArreg($arreglo->iddetalle);
                if ($atributos) {
                    //Form Bocaditos
                    $html = '';
                    $html .= '
                        <table style="border: 0.5px solid rgb(0,0,0);padding: 2px;">
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Producto: </td>
                                <td 
                                    style="font-weight: bold;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->producto.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Recibe: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->para.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Celular: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->celular.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Opciones: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$atributos->opciones.'</td>
                            </tr>
                            <tr>
                                <td 
                                    style="font-weight:bold;
                                    border: 0.5px solid #000;
                                    width:40%;
                                    font-size: 0.7em;"
                                >Observación de Bocaditos: </td>
                                <td 
                                    style="font-weight: normal;
                                    border: 0.5px solid #000;
                                    width:60%;
                                    font-size: 0.6em;"
                                >'.$arreglo->observacion.'</td>
                            </tr>
                        </table>
                    ';
                    $pdf->writeHTMLCell($w=55, $h=2, $x='1', $y=$posY, $html, $border=0, $ln=0, $fill=0, $reseth=false, $align='L', $autopadding=true);
                    $posY += 35;
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
        $pdf->writeHTMLCell($w=55, $h=2, $x='1', $y='1', $html, $border=1, $ln=1, $fill=0, $reseth=false, $align='C', $autopadding=true);
        $pdf->Output("Ticket.pdf", 'I');
    }
}
