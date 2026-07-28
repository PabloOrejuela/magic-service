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

    /**
     * Devuelve un JSON con los valores del snapshot actual que cambiaron con
     * respecto al snapshot anterior. Cuando no existe un snapshot anterior,
     * el snapshot actual completo representa el estado inicial.
     */
    public function generarDiff($snapshotAnteriorJson, $snapshotActualJson)
    {
        if (!is_string($snapshotActualJson)) {
            return json_encode([]);
        }

        $snapshotActual = json_decode($snapshotActualJson, true);

        if (!is_array($snapshotActual)) {
            return json_encode([]);
        }

        $snapshotAnterior = is_string($snapshotAnteriorJson)
            ? json_decode($snapshotAnteriorJson, true)
            : null;
        if (!is_array($snapshotAnterior)) {
            return json_encode(
                $snapshotActual,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        $sinCambios = new \stdClass();
        $diff = $this->obtenerDiferencias($snapshotAnterior, $snapshotActual, $sinCambios);

        return json_encode(
            $diff === $sinCambios ? [] : $diff,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }

    private function obtenerDiferencias($anterior, $actual, $sinCambios)
    {
        if (!is_array($anterior) || !is_array($actual)) {
            return $anterior === $actual ? $sinCambios : $actual;
        }

        $diferencias = [];
        $claves = array_unique(array_merge(array_keys($anterior), array_keys($actual)));

        foreach ($claves as $clave) {
            $existeAnterior = array_key_exists($clave, $anterior);
            $existeActual = array_key_exists($clave, $actual);

            if (!$existeActual) {
                // El campo existía antes y fue eliminado del snapshot actual.
                $diferencias[$clave] = null;
                continue;
            }

            if (!$existeAnterior) {
                $diferencias[$clave] = $actual[$clave];
                continue;
            }

            $diferencia = $this->obtenerDiferencias(
                $anterior[$clave],
                $actual[$clave],
                $sinCambios
            );

            if ($diferencia !== $sinCambios) {
                $diferencias[$clave] = $diferencia;
            }
        }

        return empty($diferencias) ? $sinCambios : $diferencias;
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
