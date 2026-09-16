<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TestsVentas extends BaseController {

    public function pedidoInsertTest(){

        if ($this->session->ventas == 1) {
            $num = random_int(100, 999);
            $cod_pedido = 'P001TEST'.$num;
            $fecha = date('Y-m-d');
            
            $pedidos = $this->pedidoModel->orderBy('orden', 'asc')->findAll();
            
            $pedido = [
                'cod_pedido' => $cod_pedido,
                'idusuario' => $this->session->id,
                'fecha' => $fecha,
                'idcliente' => 2,
                'sin_remitente' => 0,
                
                'fecha_entrega' => $fecha,
                'horario_entrega' => 1,
                'sector' => 1,
                          
                'vendedor' => 9,
                'venta_extra' => 0,
                'estado' => 1,
               
                //TOTALES
                'valor_neto' => 10.00,
                'descuento' => 0,
                'transporte' => 1, //Sector de entrega
                'horario_extra' => $this->request->getPostGet('horario_extra'),
                'rango_entrega_desde' => '9:00',
                'rango_entrega_hasta' => '9:20',
                'cargo_domingo' => 0,
                'valor_mensajero_edit' => 0,
                'valor_mensajero' => 0,
                'total' => 11.50,
                'idnegocio' => 1,
                'registered_by' => $this->session->id, 
                'orden' => 1,

                //Data de el form editar
                'dir_entrega' => '',
                'ubicacion' => '',
                'observaciones' => '',
                'mensajero' => '',
                'formas_pago' => '',
                'banco' => '',
                'ref_pago' => '',
                'mensajero_extra' => '',
                'observacion_pago' => '',
            ];
            
            $clienteID = 1;
            $res = $this->pedidoModel->_insert($pedido);
            //Inserto el nuevo pedido por que no debe existir
            if ($res) {
                

                $detalleTemporal[0] = (object)[
                    'cod_pedido' => $cod_pedido,
                    'idpedido' => $res,
                    'idproducto' => 213, //ARREGLO FRUTAL C1
                    'cantidad' => 1,
                    'precio' => 10,
                    'pvp' => 10,
                    'subtotal' => 11.50,
                    'observacion' => 'Detalle de pruebas',
                ];
                
                //Inserto el detalle
                if ($detalleTemporal) {
                    $this->detallePedidoModel->_insert($detalleTemporal);

                    //Hago el proceso de kardex
                    foreach ($detalleTemporal as $key => $detalle) {
                        $items = $this->itemsProductoModel->where('idproducto', $detalle->idproducto)->findAll();
                        foreach ($items as $key => $item) {
                            $precio_actual = $this->itemsProductoModel->select('precio_actual')->where('item', $item->item)->first();
                            $itemData = [
                                'item'=> $item->item,
                                'movimiento'=> 2, //Egreso por venta
                                'unidades'=> $detalle->cantidad, 
                                'precio_actual'=> $precio_actual->precio_actual, 
                                'observacion'=> 'COMPRA '. $fecha, 
                            ];
                            $this->kardexModel->insert($itemData);
                        }
                    }
                    
                    $mensaje = 1;

                }else{
                    $mensaje = 'SIN DETALLE';
                }

            }else{
                $mensaje = 0;
            }

            session()->setFlashdata('mensaje', $mensaje);
            //$this->session->set('mensaje', $mensaje);

            return redirect()->to('pedidos');
            
        }else{

            return redirect()->to('logout');
        }
    }
}
