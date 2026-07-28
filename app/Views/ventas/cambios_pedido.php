<link rel="stylesheet" href="<?= site_url(); ?>public/css/cambios-pedido.css">

<?php
    $diff = [];
    if (!empty($detalleCambio->diff)) {
        $diffDecodificado = json_decode($detalleCambio->diff, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($diffDecodificado)) {
            $diff = $diffDecodificado;
        }
    }

    $formatearEtiqueta = static function ($clave): string {
        return ucwords(str_replace(['_', '-'], ' ', (string) $clave));
    };

    $formatearValor = static function ($valor): string {
        if ($valor === null) {
            return 'Eliminado';
        }

        if (is_bool($valor)) {
            return $valor ? 'Sí' : 'No';
        }

        return (string) $valor;
    };

    $renderizarCampos = static function ($datos, $ruta = '', $identificador = '') use (&$renderizarCampos, $formatearEtiqueta, $formatearValor): string {
    $html = '';

    foreach ($datos as $clave => $valor) {

        // Mostrar "Atributos" como subsección
        if ($clave === 'atributos' && is_array($valor)) {

            $html .= '<div class="col-12 mt-3">';
            $html .= '<h6 class="cambios-pedido-subseccion">Atributos</h6>';
            $html .= '</div>';

            $indice = 1;

            foreach ($valor as $atributo) {

                $html .= '<div class="col-12">';
                $html .= '<div class="cambio-atributo">';

                if (count($valor) > 1) {
                    $html .= '<strong class="mb-3">Atributo ' . $indice . '</strong>';
                }

                $html .= '<div class="row g-3 cambios-pedido-formulario">';
                $html .= $renderizarCampos(
                    is_array($atributo) ? $atributo : ['valor' => $atributo],
                    '',
                    $identificador . '-atributo-' . $indice
                );
                $html .= '</div>';

                $html .= '</div>';
                $html .= '</div>';

                $indice++;
            }

            continue;
        }

        $nombreCampo = $ruta === '' ? $formatearEtiqueta($clave) : $ruta . ' / ' . $formatearEtiqueta($clave);

        if (is_array($valor)) {
            $html .= $renderizarCampos($valor, $nombreCampo, $identificador);
            continue;
        }

        $idCampo = 'diff-' . str_replace([' ', '/'], '-', strtolower(trim($identificador . '-' . $nombreCampo, '-')));

        $html .= '<div class="col-12">';
        $html .= '<div class="row align-items-center">';
        $html .= '<label class="col-md-4 col-form-label" for="' . esc($idCampo) . '">' . esc($nombreCampo) . '</label>';
        $html .= '<div class="col-md-8">';
        $html .= '<input type="text" class="form-control" id="' . esc($idCampo) . '" value="' . esc($formatearValor($valor)) . '" readonly>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }

    return $html;
};
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <div class="card cambios-pedido-card">
                    <div class="card-body p-4">
                        <div class="mb-4 pb-3 border-bottom">
                            <h3 class="mb-1"><?= esc($subtitle); ?></h3>
                            <p class="text-muted mb-0">Información modificada en el pedido.</p>
                        </div>

                        <?php if ($detalleCambio): ?>
                            <h4 class="cambios-pedido-seccion">PEDIDO</h4>
                            <div class="cambios-pedido-cabecera mb-4">
                                <div class="row g-3">
                                    <div class="col-12 col-md-4">
                                        <span class="cambio-meta-label">Código del pedido</span>
                                        <div class="cambio-meta-value"><?= esc($pedido->cod_pedido ?? ''); ?></div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <span class="cambio-meta-label">Fecha del cambio</span>
                                        <div class="cambio-meta-value"><?= esc($detalleCambio->fecha ?? ''); ?></div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <span class="cambio-meta-label">Usuario</span>
                                        <div class="cambio-meta-value"><?= esc($detalleCambio->nombre ?? ''); ?></div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($diff): ?>
                                <?php if (!empty($diff['pedido'])): ?>
                                    <div class="row g-3 cambios-pedido-formulario mb-4">
                                        <?= $renderizarCampos($diff['pedido']); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($diff['cliente'])): ?>
                                    <h4 class="cambios-pedido-seccion">CLIENTE</h4>
                                    <div class="row g-3 cambios-pedido-formulario mb-4">
                                        <?= $renderizarCampos($diff['cliente']); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($diff['detalle'])): ?>
                                    <h4 class="cambios-pedido-seccion">DETALLE</h4>
                                    <div class="cambios-pedido-detalle">
                                        <?php $indiceDetalle = 1; ?>
                                        <?php foreach ($diff['detalle'] as $cambioDetalle): ?>
                                            <article class="cambio-detalle-item">
                                                <h5 class="cambio-detalle-titulo">Ítem <?= esc($indiceDetalle); ?></h5>
                                                <div class="row g-3 cambios-pedido-formulario">
                                                    <?= $renderizarCampos(is_array($cambioDetalle) ? $cambioDetalle : ['valor' => $cambioDetalle], '', 'detalle-'.$indiceDetalle); ?>
                                                </div>
                                            </article>
                                            <?php $indiceDetalle++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="alert alert-info mb-4" role="alert">
                                    No se registraron diferencias para este cambio.
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-warning" role="alert">
                                No se encontró el cambio solicitado.
                            </div>
                        <?php endif; ?>

                        <div class="mt-4 pt-3 border-top">
                            <a href="<?= site_url('grid-historial-pedido/'.($pedido ? $pedido->id : 0)); ?>" class="btn btn-outline-secondary">
                                Volver al historial
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
