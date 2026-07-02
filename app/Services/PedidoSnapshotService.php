<?php 

namespace App\Services;

use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;
use App\Models\AttrExtArregModel;

class PedidoSnapshotService {

    

    public function generar($idpedido, $datos, $detalle) {

        //Dependencias
        $this->pedidoModel = new PedidoModel();
        $this->detallePedidoModel = new DetallePedidoModel();
        $this->attrExtArregModel = new AttrExtArregModel();

        // 1. Pedido
        $pedido = $this->pedidoModel->find($idpedido);
        $pedido->procedencia = $datos['procedencia'];
        $pedido->horario_extra = $datos['horario_extra'];
        $pedido->cargo_domingo = $datos['cargo_domingo'];

        // 3. IDs detalle
        $idsDetalle = array_column($detalle, 'id');

        // 4. Atributos (si hay)
        $atributosPorDetalle = [];

        if (!empty($idsDetalle)) {
            $atributos = $this->attrExtArregModel
                ->whereIn('iddetalle', $idsDetalle)
                ->findAll();

            foreach ($atributos as $attr) {
                $atributosPorDetalle[$attr->iddetalle] = $attr;
            }
        }

        // 5. Inyectar atributos en detalle
        foreach ($detalle as $item) {
            $item->atributos = $atributosPorDetalle[$item->id] ?? null;
        }

        // 6. Estructura final
        $snapshot = [
            'pedido'  => $pedido,
            'detalle' => $detalle
        ];

        // 7. JSON
        return json_encode(
            $snapshot,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}