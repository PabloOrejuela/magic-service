<link rel="stylesheet" href="<?= site_url(); ?>public/css/reporte-pg.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'reporte-pg';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-2">
                                    <label for="negocio">Negocio:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="negocio" 
                                        name="negocio" 
                                    >
                                        <option value="0" selected>-- Opciones --</option>
                                        <?php
                                            if (isset($negocios)) {
                                                foreach ($negocios as $key => $negocio) {
                                                    echo '<option value="'.$negocio->id.'" '.set_select('negocio', $negocio->id, false).' >'.$negocio->negocio.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <p id="error-message"><?= session('errors.negocio');?> </p>
                               </div>
                               <div class="form-group col-md-2">
                                <label for="mes">Mes *:</label>
                                    <input 
                                        type="month" 
                                        class="form-control text" 
                                        id="mes" 
                                        name="mes" 
                                        value="<?= $datos['fecha']; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.mes');?> </p>
                               </div>
                            </div>
                        </div>
                        <?php

                            $cadenaError = '
                                    <div class="card-body mt-2">
                                        <div class="row col-md-9">
                                            <table class="table table-bordered mt-3" id="table-resultados-ingresos">
                                                <thead>
                                                    <th class="col-sm-1" id="encabezado" colspan="7">Pérdidas y Ganancias del mes de '.$mes.'</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TOTAL DE INGRESOS</td>
                                                        <td>Faltan datos del mes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOTAL DE EGRESOS</td>
                                                        <td>Faltan datos del mes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOTAL DE UTILIDAD NETA</td>
                                                        <td>Faltan datos del mes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOTAL DE MARGEN BRUTO</td>
                                                        <td>Faltan datos del mes</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TOTAL DE MARGEN NETO</td>
                                                        <td>Faltan datos del mes</td>
                                                    </tr>
                                                </tbody>
                                            </table>';

                            if (isset($gastoFijo) && isset($gastoVariable) && isset($gastoInsumosProveedores) && isset($sumaImgreso)) {

                                $sumaEgresos = $gastoFijo + $gastoVariable + $gastoInsumosProveedores;

                                echo '
                                    <div class="card-body mt-2">
                                        <div class="row col-md-6">
                                            <table class="table table-bordered mt-3" id="table-resultados-ingresos">
                                                <thead>
                                                    <th class="col-sm-1" id="encabezado" colspan="7">Pérdidas y Ganancias del mes de '.$mes.'</th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td id="td-bold-left">TOTAL DE INGRESOS</td>
                                                        <td id="td-result-right">$ '.$sumaImgreso.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="td-bold-left">TOTAL DE EGRESOS</td>
                                                        <td id="td-result-right">$ '.$sumaEgresos.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="td-bold-left-result">TOTAL DE UTILIDAD NETA</td>
                                                        <td id="td-result-right">$ '.$sumaImgreso - $sumaEgresos.'</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="td-bold-left">TOTAL DE MARGEN BRUTO</td>
                                                        <td id="td-result-right">'.number_format((($sumaImgreso - $gastoInsumosProveedores)/$sumaImgreso)*100,2).'%</td>
                                                    </tr>
                                                    <tr>
                                                        <td id="td-bold-left">TOTAL DE MARGEN NETO</td>
                                                        <td id="td-result-right">'.number_format((($sumaImgreso - $sumaEgresos)/$sumaImgreso)*100,2).'%</td>
                                                    </tr>
                                                </tbody>
                                            </table>';
                            }else{

                                echo $cadenaError;

                            }
                        echo '<div class="card-footer">
                                            <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                            <a href="'.site_url().'reporte-pg" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                                        </div>
                                    </div>
                                </div>';
                            
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="<?= site_url(); ?>public/js/cabecera-reportes.js"></script>

