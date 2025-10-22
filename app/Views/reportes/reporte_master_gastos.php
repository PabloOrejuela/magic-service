<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-master-gastos.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'reporte-master-gastos';?>" method="post">
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
                        <div class="card-body mt-1">
                            <div class="row col-md-12">
                                <div class="row col-md-4">
                                    <table class="table table-bordered mt-3" id="table-resultados-ingresos">
                                        <thead>
                                            <th class="col-sm-1">FECHA</th>
                                            <th class="col-sm-1">GASTOS FIJOS</th>
                                            <?php
                                                $totalEgresos = 0;
                                                $totalGastosFijos = 0;
                                                $totalGastoVariable = 0;
                                                $totalGastoInsumosProveedores = 0;
                                            ///echo '<pre>'.var_export($gastoFijo, true).'</pre>';exit;
                                                if ($gastoFijo) {
                                                    
                                                    foreach ($gastoFijo as $key => $gasto) {
                                                        $totalGastosFijos += $gasto->valor;
                                                    }

                                                }
                                                echo '<th class="col-sm-1" id="text-result-bold">'.number_format($totalGastosFijos, 2).'</th>';
                                            ?>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($gastoFijo) {
                                                    foreach ($gastoFijo as $key => $gasto) {
                                                        echo '<tr>
                                                            <td>'.$gasto->fecha.'</td>
                                                            <td>'.$gasto->gasto_fijo.'</td>
                                                            <td id="resultado-total">'.$gasto->valor.'</td>
                                                        </tr>';
                                                    }
                                                } else {
                                                    echo '<tr>
                                                            <td>No hay datos que mostrar</td>
                                                        </tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row col-md-1" id="div-separador"></div>
                                <div class="row col-md-4">
                                    <table class="table table-bordered mt-3" id="table-resultados-ingresos">
                                        <thead>
                                            <th class="col-sm-1">FECHA</th>
                                            <th class="col-sm-1">GASTOS VARIABLES</th>
                                            <?php
                                                if ($gastoVariable) {

                                                    foreach ($gastoVariable as $key => $gasto) {
                                                        $totalGastoVariable += $gasto->valor;
                                                    }
                                                }
                                                echo '<th class="col-sm-1" id="text-result-bold">'.number_format($totalGastoVariable, 2).'</th>';
                                            ?>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($gastoVariable) {
                                                    foreach ($gastoVariable as $key => $gasto) {
                                                        echo '<tr>
                                                            <td>'.$gasto->fecha.'</td>
                                                            <td>'.$gasto->detalleGastoVariable.'</td>
                                                            <td id="resultado-total">'.$gasto->valor.'</td>
                                                        </tr>';
                                                    }
                                                } else {
                                                    echo '<tr>
                                                            <td>No hay datos que mostrar</td>
                                                        </tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row col-md-1" id="div-separador"></div>
                                <div class="row col-md-4">
                                    <table class="table table-bordered mt-3" id="table-resultados-ingresos">
                                        <thead>
                                            <th class="col-sm-1">FECHA</th>
                                            <th class="col-sm-1">INSUMOS PROVEEDORES</th>
                                            <?php
                                                if ($gastoInsumosProveedores) {
                                                    
                                                    foreach ($gastoInsumosProveedores as $key => $gasto) {
                                                        $totalGastoInsumosProveedores += $gasto->valor;
                                                    }
                                                    
                                                }
                                                echo '<th class="col-sm-1" id="text-result-bold">'.number_format($totalGastoInsumosProveedores, 2).'</th>';
                                            ?>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if ($gastoInsumosProveedores) {
                                                    foreach ($gastoInsumosProveedores as $key => $gasto) {
                                                        echo '<tr>
                                                            <td>'.$gasto->fecha.'</td>
                                                            <td>'.$gasto->proveedor.'</td>
                                                            <td id="resultado-total">'.$gasto->valor.'</td>
                                                        </tr>';
                                                    }
                                                } else {
                                                    echo '<tr>
                                                            <td>No hay datos que mostrar</td>
                                                        </tr>';
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row col-md-3">
                                <table class="table table-bordered mt-3" id="table-resultados-ingresos">
                                    <tbody>
                                        <tr><td id="td-totales-bold">TOTAL DE EGRESOS POR GASTOS: </td>
                                        <?php
                                            if ($gastoFijo) {
                                                $totalEgresos = $totalGastosFijos + $totalGastoVariable + $totalGastoInsumosProveedores;

                                                echo '<td id="result-bold">'.number_format($totalEgresos, 2).'</td>';
                                            }else{
                                                echo '<td id="result-bold">'.number_format("0", 2).'</td>';
                                            }
                                        ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                                
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                <a 
                                    class="btn btn-primary" 
                                    href="<?= site_url();?>reporte-master-gastos-excel?negocio=<?=$datos['negocio']?>&mes=<?= $datos['fecha']?>"
                                    id="btn-reporte-excel-res"
                                >Descargar reporte en excel</a>
                                <a href="<?= site_url();?>reporte-master-gastos" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/cabecera-reportes.js"></script>
