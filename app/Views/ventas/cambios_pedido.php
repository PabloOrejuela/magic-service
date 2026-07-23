<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-productos.css">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <div class="card">
                    <div class="card-body">
                        <h3><?= esc($subtitle); ?></h3>

                        <?php
                            $parseDetalleJson = function($rawDetalle) {
                                if (empty($rawDetalle)) {
                                    return null;
                                }
                                if (is_array($rawDetalle) || is_object($rawDetalle)) {
                                    return $rawDetalle;
                                }

                                $decoded = json_decode($rawDetalle);
                                if (json_last_error() === JSON_ERROR_NONE) {
                                    return $decoded;
                                }

                                return $rawDetalle;
                            };

                            $renderStructuredValue = function($value, $level = 0) use (&$renderStructuredValue) {
                                if (is_array($value) || is_object($value)) {
                                    $html = '<div class="structured-block" style="margin-left:' . ($level * 10) . 'px;">';
                                    foreach ($value as $key => $child) {
                                        $label = is_string($key) ? ucwords(str_replace('_', ' ', $key)) : $key;
                                        $html .= '<div class="structured-row">';
                                        $html .= '<div class="structured-label">' . esc($label) . '</div>';
                                        $html .= '<div class="structured-content">';
                                        if (is_scalar($child) || $child === null) {
                                            $html .= '<div class="structured-value">' . esc((string) ($child ?? '—')) . '</div>';
                                        } else {
                                            $html .= $renderStructuredValue($child, $level + 1);
                                        }
                                        $html .= '</div>';
                                        $html .= '</div>';
                                    }
                                    $html .= '</div>';
                                    return $html;
                                }

                                return '<div class="structured-value">' . esc((string) ($value ?? '—')) . '</div>';
                            };

                            $renderChangeList = function($changes, $title) use (&$renderChangeList, &$renderStructuredValue) {
                                if (empty($changes)) {
                                    return '<div class="form-section-empty">No hay cambios en ' . esc($title) . '.</div>';
                                }

                                $html = '<div class="form-section">';
                                $html .= '<div class="form-section-title">' . esc(ucwords($title)) . '</div>';
                                foreach ($changes as $change) {
                                    $label = $change->campo ?? null;
                                    if ($label) {
                                        $html .= '<div class="form-row">';
                                        $html .= '<label class="form-label">' . esc(ucwords(str_replace('_', ' ', $label))) . '</label>';
                                        $html .= '<div class="form-values">';
                                        $html .= '<div class="form-value"><span class="form-value-label">Antes</span><div>' . esc((string) ($change->antes ?? '—')) . '</div></div>';
                                        $html .= '<div class="form-value"><span class="form-value-label">Después</span><div>' . esc((string) ($change->despues ?? '—')) . '</div></div>';
                                        $html .= '</div>';
                                        $html .= '</div>';
                                        continue;
                                    }

                                    $type = $change->tipo ?? 'actualizado';
                                    $html .= '<div class="form-row">';
                                    $html .= '<label class="form-label">' . esc(ucwords($type)) . '</label>';
                                    $html .= '<div class="form-values">';
                                    $html .= '<div class="form-value form-value-wide">';
                                    if (!empty($change->idproducto)) {
                                        $html .= '<div><strong>Producto:</strong> ' . esc((string) $change->idproducto) . '</div>';
                                    }
                                    if (!empty($change->datos)) {
                                        foreach ($change->datos as $key => $value) {
                                            $html .= '<div><strong>' . esc(ucwords(str_replace('_', ' ', $key))) . ':</strong> ' . esc((string) $value) . '</div>';
                                        }
                                    }
                                    if (!empty($change->cambios)) {
                                        $html .= '<div class="mt-2"><strong>Detalles:</strong></div>';
                                        foreach ($change->cambios as $detailChange) {
                                            $html .= '<div>• ' . esc(ucwords(str_replace('_', ' ', $detailChange->campo ?? ''))) . ': ' . esc((string) ($detailChange->antes ?? '—')) . ' → ' . esc((string) ($detailChange->despues ?? '—')) . '</div>';
                                        }
                                    }
                                    $html .= '</div>';
                                    $html .= '</div>';
                                    $html .= '</div>';
                                }
                                $html .= '</div>';
                                return $html;
                            };

                            $detalleAnteriorData = $detalleCambioAnterior ? $parseDetalleJson($detalleCambioAnterior->detalle ?? null) : null;
                            $detalleActualData = $detalleCambio ? $parseDetalleJson($detalleCambio->detalle ?? null) : null;
                        ?>

                        <?php if ($pedido): ?>
                            <div class="mb-4">
                                <p><strong>Pedido:</strong> <?= esc($pedido->cod_pedido); ?></p>
                                <p><strong>Cliente:</strong> <?= esc($pedido->nombre ?? ''); ?></p>
                                <p><strong>Fecha:</strong> <?= esc($pedido->fecha ?? ''); ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-secondary mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title">Cambio anterior</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($detalleCambioAnterior): ?>
                                            <p><strong>ID:</strong> <?= esc($detalleCambioAnterior->id); ?></p>
                                            <p><strong>Fecha:</strong> <?= esc($detalleCambioAnterior->fecha ?? $detalleCambioAnterior->updated_at ?? ''); ?></p>
                                            <p><strong>Usuario:</strong> <?= esc($detalleCambioAnterior->nombre ?? ''); ?></p>
                                            <?php if ($detalleAnteriorData && ((is_object($detalleAnteriorData) && isset($detalleAnteriorData->pedido) && isset($detalleAnteriorData->cliente) && isset($detalleAnteriorData->detalle)) || (is_array($detalleAnteriorData) && isset($detalleAnteriorData['pedido']) && isset($detalleAnteriorData['cliente']) && isset($detalleAnteriorData['detalle'])))): ?>
                                                <?php
                                                    $detalleAnteriorPedido = is_array($detalleAnteriorData) ? ($detalleAnteriorData['pedido'] ?? null) : $detalleAnteriorData->pedido;
                                                    $detalleAnteriorCliente = is_array($detalleAnteriorData) ? ($detalleAnteriorData['cliente'] ?? null) : $detalleAnteriorData->cliente;
                                                    $detalleAnteriorDetalle = is_array($detalleAnteriorData) ? ($detalleAnteriorData['detalle'] ?? null) : $detalleAnteriorData->detalle;
                                                ?>
                                                <h6 class="mt-3">Pedido</h6>
                                                <?= $renderChangeList(is_object($detalleAnteriorPedido) ? ($detalleAnteriorPedido->cambios ?? []) : ($detalleAnteriorPedido['cambios'] ?? []), 'pedido') ?>
                                                <h6 class="mt-3">Cliente</h6>
                                                <?= $renderChangeList(is_object($detalleAnteriorCliente) ? ($detalleAnteriorCliente->cambios ?? []) : ($detalleAnteriorCliente['cambios'] ?? []), 'cliente') ?>
                                                <h6 class="mt-3">Detalle</h6>
                                                <?= $renderChangeList(is_object($detalleAnteriorDetalle) ? ($detalleAnteriorDetalle->cambios ?? []) : ($detalleAnteriorDetalle['cambios'] ?? []), 'detalle') ?>
                                            <?php else: ?>
                                                <?= $renderStructuredValue($detalleCambioAnterior->detalle ?? null) ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p>No hay cambios anteriores para este pedido.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-info mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title">Cambio actual</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($detalleCambio): ?>
                                            <p><strong>ID:</strong> <?= esc($detalleCambio->id); ?></p>
                                            <p><strong>Fecha:</strong> <?= esc($detalleCambio->fecha ?? $detalleCambio->updated_at ?? ''); ?></p>
                                            <p><strong>Usuario:</strong> <?= esc($detalleCambio->nombre ?? ''); ?></p>
                                            <?php if ($detalleActualData && ((is_object($detalleActualData) && isset($detalleActualData->pedido) && isset($detalleActualData->cliente) && isset($detalleActualData->detalle)) || (is_array($detalleActualData) && isset($detalleActualData['pedido']) && isset($detalleActualData['cliente']) && isset($detalleActualData['detalle'])))): ?>
                                                <?php
                                                    $detalleActualPedido = is_array($detalleActualData) ? ($detalleActualData['pedido'] ?? null) : $detalleActualData->pedido;
                                                    $detalleActualCliente = is_array($detalleActualData) ? ($detalleActualData['cliente'] ?? null) : $detalleActualData->cliente;
                                                    $detalleActualDetalle = is_array($detalleActualData) ? ($detalleActualData['detalle'] ?? null) : $detalleActualData->detalle;
                                                ?>
                                                <h6 class="mt-3">Pedido</h6>
                                                <?= $renderChangeList(is_object($detalleActualPedido) ? ($detalleActualPedido->cambios ?? []) : ($detalleActualPedido['cambios'] ?? []), 'pedido') ?>
                                                <h6 class="mt-3">Cliente</h6>
                                                <?= $renderChangeList(is_object($detalleActualCliente) ? ($detalleActualCliente->cambios ?? []) : ($detalleActualCliente['cambios'] ?? []), 'cliente') ?>
                                                <h6 class="mt-3">Detalle</h6>
                                                <?= $renderChangeList(is_object($detalleActualDetalle) ? ($detalleActualDetalle->cambios ?? []) : ($detalleActualDetalle['cambios'] ?? []), 'detalle') ?>
                                            <?php else: ?>
                                                <?= $renderStructuredValue($detalleCambio->detalle ?? null) ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p>No se encontró el cambio solicitado.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="<?= site_url('grid-historial-pedido/'.($pedido ? $pedido->id : 0)); ?>" class="btn btn-light cancelar" id="btn-cancela">Volver al historial</a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
