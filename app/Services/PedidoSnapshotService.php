<?php 

namespace App\Services;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\AttrExtArregModel;
use App\Models\ProductoModel;
use App\Models\EstadoPedidoModel;
use App\Models\SectoresEntregaModel;
use App\Models\HorariosEntregaModel;
use App\Models\FormaPagoModel;
use App\Models\BancoModel;
use App\Models\ProcedenciaModel;
use App\Models\UsuarioModel;

class PedidoSnapshotService {

    protected $pedidoModel;
    protected $detallePedidoModel;
    protected $attrExtArregModel;
    protected $productoModel;
    protected $estadoPedidoModel;
    protected $sectoresEntregaModel;
    protected $horariosEntregaModel;
    protected $formaPagoModel;
    protected $bancoModel;
    protected $procedenciaModel;
    protected $usuarioModel;


    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->detallePedidoModel = new DetallePedidoModel();
        $this->attrExtArregModel = new AttrExtArregModel();
        $this->productoModel = new ProductoModel();
        $this->estadoPedidoModel = new EstadoPedidoModel();
        $this->sectoresEntregaModel = new SectoresEntregaModel();
        $this->horariosEntregaModel = new HorariosEntregaModel();
        $this->formaPagoModel = new FormaPagoModel();
        $this->bancoModel = new BancoModel();
        $this->procedenciaModel = new ProcedenciaModel();
        $this->usuarioModel = new UsuarioModel();
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
        $this->resolverValoresRelacionadosPedido($pedidoActual);


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

            $item->producto = $this->obtenerNombreProducto((array) $item);
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

        $snapshotActual = $this->omitirCamposAuditoria($snapshotActual);

        $snapshotAnterior = is_string($snapshotAnteriorJson)
            ? json_decode($snapshotAnteriorJson, true)
            : null;

        if (is_array($snapshotAnterior)) {
            $snapshotAnterior = $this->omitirCamposAuditoria($snapshotAnterior);
        }

        if (!is_array($snapshotAnterior)) {
            $snapshotActual = $this->limpiarDetalleInicial($snapshotActual);

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

    private function omitirCamposAuditoria(array $datos): array
    {
        foreach ($datos as $clave => $valor) {
            if (in_array($clave, ['created_at', 'updated_at'], true)) {
                unset($datos[$clave]);
                continue;
            }

            if (is_array($valor)) {
                $datos[$clave] = $this->omitirCamposAuditoria($valor);
            }
        }

        return $datos;
    }

    private function limpiarDetalleInicial(array $snapshot): array
    {
        if (!isset($snapshot['detalle']) || !is_array($snapshot['detalle'])) {
            return $snapshot;
        }

        foreach ($snapshot['detalle'] as $indice => $item) {
            if (is_array($item)) {
                $snapshot['detalle'][$indice] = $this->limpiarValoresVacios($item);
            }
        }

        return $snapshot;
    }

    private function limpiarValoresVacios(array $datos): array
    {
        foreach ($datos as $clave => $valor) {
            if (is_array($valor)) {
                $valor = $this->limpiarValoresVacios($valor);
            }

            if ($valor === null || (is_string($valor) && trim($valor) === '') || $valor === []) {
                unset($datos[$clave]);
                continue;
            }

            $datos[$clave] = $valor;
        }

        return $datos;
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

            $diferencia = $clave === 'detalle'
                ? $this->obtenerDiferenciasDetalle($anterior[$clave], $actual[$clave], $sinCambios)
                : $this->obtenerDiferencias($anterior[$clave], $actual[$clave], $sinCambios);

            if ($diferencia !== $sinCambios) {
                $diferencias[$clave] = $diferencia;
            }
        }

        return empty($diferencias) ? $sinCambios : $diferencias;
    }

    private function obtenerDiferenciasDetalle($detalleAnterior, $detalleActual, $sinCambios)
    {
        if (!is_array($detalleAnterior) || !is_array($detalleActual)) {
            return $this->obtenerDiferencias($detalleAnterior, $detalleActual, $sinCambios);
        }

        $anterioresPorProducto = $this->mapearDetallePorProducto($detalleAnterior);
        $actualesPorProducto = $this->mapearDetallePorProducto($detalleActual);
        $diferencias = [];

        foreach (array_unique(array_merge(array_keys($anterioresPorProducto), array_keys($actualesPorProducto))) as $idproducto) {
            $existeAnterior = array_key_exists($idproducto, $anterioresPorProducto);
            $existeActual = array_key_exists($idproducto, $actualesPorProducto);

            if (!$existeAnterior) {
                $diferencias[$idproducto] = array_merge(
                    ['tipo' => 'Agregado'],
                    $this->completarNombreProducto($actualesPorProducto[$idproducto])
                );
                continue;
            }

            if (!$existeActual) {
                $diferencias[$idproducto] = array_merge(
                    ['tipo' => 'Eliminado'],
                    $this->completarNombreProducto($anterioresPorProducto[$idproducto])
                );
                continue;
            }

            $diferencia = $this->obtenerDiferencias(
                $anterioresPorProducto[$idproducto],
                $actualesPorProducto[$idproducto],
                $sinCambios
            );

            if ($diferencia !== $sinCambios) {
                $diferencias[$idproducto] = array_merge(
                    [
                        'tipo' => 'Modificado',
                        'idproducto' => $actualesPorProducto[$idproducto]['idproducto'] ?? $idproducto,
                        'producto' => $this->obtenerNombreProducto($actualesPorProducto[$idproducto]),
                    ],
                    $diferencia
                );
            }
        }

        return empty($diferencias) ? $sinCambios : $diferencias;
    }

    private function mapearDetallePorProducto(array $detalle): array
    {
        $resultado = [];

        foreach ($detalle as $indice => $item) {
            if (!is_array($item)) {
                continue;
            }

            $clave = isset($item['idproducto']) ? (string) $item['idproducto'] : 'indice-' . $indice;
            $resultado[$clave] = $item;
        }

        return $resultado;
    }

    private function completarNombreProducto(array $detalle): array
    {
        $detalle['producto'] = $this->obtenerNombreProducto($detalle);

        return $detalle;
    }

    private function obtenerNombreProducto(array $detalle): ?string
    {
        if (!empty($detalle['producto'])) {
            return (string) $detalle['producto'];
        }

        if (empty($detalle['idproducto'])) {
            return null;
        }

        $producto = $this->productoModel->find($detalle['idproducto']);

        return $producto->producto ?? null;
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

    private function resolverValoresRelacionadosPedido($pedido): void
    {
        $pedido->estado = $this->obtenerValorRelacionado(
            $this->estadoPedidoModel,
            $pedido->estado ?? null,
            'estado'
        );
        $pedido->sector = $this->obtenerValorRelacionado(
            $this->sectoresEntregaModel,
            $pedido->sector ?? null,
            'sector'
        );
        $pedido->horario_entrega = $this->obtenerValorRelacionado(
            $this->horariosEntregaModel,
            $pedido->horario_entrega ?? null,
            'hora'
        );
        $pedido->formas_pago = $this->obtenerValorRelacionado(
            $this->formaPagoModel,
            $pedido->formas_pago ?? null,
            'forma_pago'
        );
        $pedido->banco = $this->obtenerValorRelacionado(
            $this->bancoModel,
            $pedido->banco ?? null,
            'banco',
            'NO ASIGNADO'
        );
        $pedido->procedencia = $this->obtenerValorRelacionado(
            $this->procedenciaModel,
            $pedido->procedencia ?? null,
            'procedencia'
        );
        $pedido->vendedor = $this->obtenerValorRelacionado(
            $this->usuarioModel,
            $pedido->vendedor ?? null,
            'nombre'
        );
        $pedido->mensajero = $this->obtenerValorRelacionado(
            $this->usuarioModel,
            $pedido->mensajero ?? null,
            'nombre'
        );
    }

    private function obtenerValorRelacionado($modelo, $id, string $campo, $valorParaCero = null)
    {
        if ($id === 0 || $id === '0') {
            return $valorParaCero ?? $id;
        }

        if ($id === null || $id === '') {
            return $id;
        }

        $registro = $modelo->find($id);

        return $registro && isset($registro->{$campo}) ? $registro->{$campo} : $id;
    }

}
