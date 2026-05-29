<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-productos.css">
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <?php
                            $itemModel = new \App\Models\ItemModel();
                            $itemNames = [];
                            $getItemName = function($itemId) use ($itemModel, &$itemNames) {
                                if (isset($itemNames[$itemId])) {
                                    return $itemNames[$itemId];
                                }

                                $itemData = $itemModel->find($itemId);
                                $itemNames[$itemId] = $itemData ? $itemData->item : $itemId;
                                return $itemNames[$itemId];
                            };

                            $descripcion = explode(";", $detalleCambio->descripcion);
                            $descripcionAnterior = [];
                            if (isset($detalleCambioAnterior) && $detalleCambioAnterior && $detalleCambioAnterior->descripcion) {
                                $descripcionAnterior = explode(";", $detalleCambioAnterior->descripcion);
                            }

                            $itemsActuales = [];
                            if (!empty($detalleCambio->detalle)) {
                                $itemsStr = explode(";", trim($detalleCambio->detalle, ";"));
                                foreach ($itemsStr as $itemStr) {
                                    if (!empty($itemStr)) {
                                        $item = explode(",", $itemStr);
                                        if (count($item) === 5) {
                                            $itemsActuales[$item[0]] = $item;
                                        }
                                    }
                                }
                            }

                            $itemsAnterioresArray = [];
                            if (isset($detalleCambioAnterior) && $detalleCambioAnterior && $detalleCambioAnterior->detalle) {
                                $itemsStr = explode(";", trim($detalleCambioAnterior->detalle, ";"));
                                foreach ($itemsStr as $itemStr) {
                                    if (!empty($itemStr)) {
                                        $item = explode(",", $itemStr);
                                        if (count($item) === 5) {
                                            $itemsAnterioresArray[$item[0]] = $item;
                                        }
                                    }
                                }
                            }

                            $highlightIfChanged = function($actual, $anterior) {
                                if ($anterior === null) {
                                    return '<strong style="color: red;">'.esc($actual).'</strong>';
                                }

                                $actualTrimmed = trim((string) $actual);
                                $anteriorTrimmed = trim((string) $anterior);

                                if (is_numeric($actualTrimmed) && is_numeric($anteriorTrimmed)) {
                                    if ((float) $actualTrimmed !== (float) $anteriorTrimmed) {
                                        return '<strong style="color: red;">'.esc($actual).'</strong>';
                                    }
                                    return esc($actualTrimmed);
                                }

                                if ($anteriorTrimmed !== $actualTrimmed) {
                                    return '<strong style="color: red;">'.esc($actualTrimmed).'</strong>';
                                }

                                return esc($actualTrimmed);
                            };

                            $highlightIfRemoved = function($anterior, $actualExists) {
                                if (!$actualExists) {
                                    return '<strong style="color: green;">'.esc($anterior).'</strong>';
                                }
                                return esc($anterior);
                            };
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-secondary mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title">Estado anterior</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($detalleCambioAnterior) && $detalleCambioAnterior != null): ?>
                                            <?php $descripcionAnterior = explode(";", $detalleCambioAnterior->descripcion); ?>
                                            <p><strong>ID:</strong> <?= $detalleCambioAnterior->id; ?></p>
                                            <p><strong>Fecha:</strong> <?= $detalleCambioAnterior->updated_at; ?></p>
                                            <p><strong>Usuario que hizo el cambio:</strong> <?= $detalleCambioAnterior->nombre; ?></p>
                                            <table class="table">
                                                <tr><th>Observaciones:</th><td><?= esc($descripcionAnterior[2] ?? ''); ?></td></tr>
                                                <tr><th>Precio:</th><td><?= esc(number_format($descripcionAnterior[3] ?? 0, 2)); ?></td></tr>
                                            </table>

                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Porcentaje</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Precio Actual</th>
                                                        <th>PVP</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        if ($detalleCambioAnterior->detalle) {
                                                            $itemsAnteriores = explode(";", trim($detalleCambioAnterior->detalle, ";"));
                                                            foreach ($itemsAnteriores as $itemStr) {
                                                                if (!empty($itemStr)) {
                                                                    $item = explode(",", $itemStr);
                                                                    if (count($item) === 5) {
                                                                        $itemId = $item[0];
                                                                        $existsInActual = isset($itemsActuales[$itemId]);
                                                                        $itemNombre = strtoupper($getItemName($itemId));
                                                                        echo '<tr>
                                                                            <td>'.$highlightIfRemoved($itemNombre, $existsInActual).'</td>
                                                                            <td>'.$highlightIfRemoved($item[1], $existsInActual).'</td>
                                                                            <td>'.$highlightIfRemoved($item[2], $existsInActual).'</td>
                                                                            <td>'.$highlightIfRemoved($item[3], $existsInActual).'</td>
                                                                            <td>'.$highlightIfRemoved($item[4], $existsInActual).'</td>
                                                                        </tr>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p>No hay registro de cambio anterior para este producto.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card card-info mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title">Estado actual</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>ID:</strong> <?= $detalleCambio->id; ?></p>
                                        <p><strong>Fecha:</strong> <?= $detalleCambio->updated_at; ?></p>
                                        <p><strong>Usuario que hizo el cambio:</strong> <?= $detalleCambio->nombre; ?></p>
                                        <table class="table">
                                            <tr>
                                                <th>Observaciones:</th>
                                                <td><?= $highlightIfChanged($descripcion[2] ?? '', $descripcionAnterior[2] ?? null); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Precio:</th>
                                                <td><?= $highlightIfChanged($descripcion[3] ?? '', $descripcionAnterior[3] ?? null); ?></td>
                                            </tr>
                                        </table>

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Porcentaje</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Precio Actual</th>
                                                    <th>PVP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    if ($detalleCambio->detalle) {
                                                        $items = explode(";", trim($detalleCambio->detalle, ";"));
                                                        foreach ($items as $itemStr) {
                                                            if (!empty($itemStr)) {
                                                                $item = explode(",", $itemStr);
                                                                if (count($item) === 5) {
                                                                    $itemId = $item[0];
                                                                    $itemAnterior = isset($itemsAnterioresArray[$itemId]) ? $itemsAnterioresArray[$itemId] : null;
                                                                    $itemNombre = strtoupper($getItemName($itemId));
                                                                    $itemAnteriorNombre = $itemAnterior ? strtoupper($getItemName($itemAnterior[0])) : null;
                                                                    echo '<tr>
                                                                        <td>'.$highlightIfChanged($itemNombre, $itemAnteriorNombre).'</td>
                                                                        <td>'.$highlightIfChanged($item[1], $itemAnterior ? $itemAnterior[1] : null).'</td>
                                                                        <td>'.$highlightIfChanged($item[2], $itemAnterior ? $itemAnterior[2] : null).'</td>
                                                                        <td>'.$highlightIfChanged($item[3], $itemAnterior ? $itemAnterior[3] : null).'</td>
                                                                        <td>'.$highlightIfChanged($item[4], $itemAnterior ? $itemAnterior[4] : null).'</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="<?= site_url('prod-historial-changes/'.$producto->id); ?>" class="btn btn-light cancelar" id="btn-cancela">Volver al historial</a>
                    </div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div><!-- /.row-->
    </div><!-- /.container-->
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/report-cambios-productos.js"></script>
<script>
  $(document).ready(function () {
    $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
    $('#datatablesSimple').DataTable({
        "responsive": true, 
        "order": [[1, 'asc']],
            lengthMenu: [
                [25, 50, -1],
                [25, 50, 'Todos']
        ],
        language: {
            processing: 'Procesando...',
            lengthMenu: 'Mostrando _MENU_ registros por página',
            zeroRecords: 'No hay registros de cambios',
            info: 'Mostrando _START_ a _END_ de _MAX_',
            infoEmpty: 'No hay registros disponibles',
            infoFiltered: '(filtrando de _MAX_ total registros)',
            search: 'Buscar',
            paginate: {
            first:      "Primero",
            previous:   "Anterior",
            next:       "Siguiente",
            last:       "Último"
                },
                aria: {
                    sortAscending:  ": activar para ordenar ascendentemente",
                    sortDescending: ": activar para ordenar descendentemente"
                }
        },
        "autoWidth": false,
        "dom": "<'row'<'col-sm-12 col-md-8'l><'col-md-12 col-md-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
    });
});
</script>
