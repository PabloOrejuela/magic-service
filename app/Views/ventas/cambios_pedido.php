<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-productos.css">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <div class="card">
                    <div class="card-body">
                        <h3><?= esc($subtitle); ?></h3>

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
                                            <p><strong>Detalle:</strong></p>
                                            <pre class="bg-light p-2"><?= esc($detalleCambioAnterior->detalle ?? ''); ?></pre>
                                        <?php else: ?>
                                            <p>No existe un cambio anterior para este pedido.</p>
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
                                            <p><strong>Detalle:</strong></p>
                                            <pre class="bg-light p-2"><?= esc($detalleCambio->detalle ?? ''); ?></pre>
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
