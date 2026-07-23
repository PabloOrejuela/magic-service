<?php 

namespace App\Services;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\AttrExtArregModel;

class PedidoSnapshotService {

    protected $pedidoModel;
    protected $detallePedidoModel;
    protected $attrExtArregModel;


    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->detallePedidoModel = new DetallePedidoModel();
        $this->attrExtArregModel = new AttrExtArregModel();
    }


    /**
     * Genera snapshot completo del estado actual del pedido
     */
    public function generar($idpedido, $datos, $detalle, $clienteActual = null)
    {

        /*
         * Pedido actual
         */
        $pedidoActual = $this->pedidoModel->find($idpedido);


        if (!$pedidoActual) {
            return json_encode([]);
        }


        /*
         * Campos que vienen del formulario y todavía
         * no están persistidos en el modelo
         */
        $pedidoActual->procedencia = $datos['procedencia'] ?? null;
        $pedidoActual->horario_extra = $datos['horario_extra'] ?? null;
        $pedidoActual->cargo_domingo = $datos['cargo_domingo'] ?? null;


        /*
         * Detalle actual con atributos
         */
        $detalleActual = $this->normalizarDetalle($detalle);


        foreach ($detalleActual as &$item) {

            $idDetalle = null;

            if (isset($item->iddetalle)) {
                $idDetalle = $item->iddetalle;
            } elseif(isset($item->id)) {
                $idDetalle = $item->id;
            }


            if ($idDetalle) {

                $atributos = $this->attrExtArregModel
                    ->where('iddetalle', $idDetalle)
                    ->findAll();

                $item->atributos = $atributos;
            } else {

                $item->atributos = [];

            }
        }


        /*
         * Snapshot final
         */
        $snapshot = [
            'pedido' => $pedidoActual,
            'cliente' => $clienteActual,
            'detalle' => $detalleActual
        ];


        return json_encode(
            $snapshot,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }



    private function normalizarDetalle($detalle)
    {
        $resultado = [];


        if (empty($detalle)) {
            return $resultado;
        }


        foreach ($detalle as $item) {

            if (is_array($item)) {

                $resultado[] = (object)$item;

            } elseif(is_object($item)) {

                $resultado[] = $item;

            }

        }


        return $resultado;
    }

}