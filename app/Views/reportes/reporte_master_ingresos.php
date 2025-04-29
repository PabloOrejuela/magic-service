<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-master-ingresos.css">
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
                    <form action="<?= site_url().'reporte-master-ingresos';?>" method="post">
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
                        <div class="card-body mt-2">
                            <div class="row col-md-12">
                                <table class="table table-bordered mt-3" id="table-resultados-ingresos">
                                <thead>
                                    <th class="col-sm-1" id="encabezado" colspan="7">VENTAS DIARIAS DE TODO EL MES</th>
                                    <th class="col-sm-1" id="encabezado">TOTAL DE VENTAS SEMANAL</th>
                                </thead>
                                <thead>
                                    <th class="col-sm-1">LUNES</th>
                                    <th class="col-sm-1">MARTES</th>
                                    <th class="col-sm-1">MIERCOLES</th>
                                    <th class="col-sm-1">JUEVES</th>
                                    <th class="col-sm-1">VIERNES</th>
                                    <th class="col-sm-1">SABADO</th>
                                    <th class="col-sm-1">DOMINGO</th>
                                    <th class="col-sm-1"></th>
                                </thead>
                                <tbody>
                                    <?php
                                        
                                        $dia = 1;
                                        $sumaSemana = 0;
                                        $sumaTotal = 0;
                                        if ($res) {
                                            //echo '<pre>'.var_export($res, true).'</pre>';exit;
                                            echo '<tr>';
                                            echo $cadenaInicio;
                                            foreach ($res as $key => $resultado) {
                                                
                                                if ($resultado['dia'] == 7) {
                                                    if ($resultado['res']) {
                                                        echo '<td id="td-resultados">'.number_format($resultado['res'], 2).'</td>
                                                            <td id="td-suma">'.number_format($sumaSemana, 2).'</td></tr>';
                                                    }else{
                                                        echo '<td id="td-resultados">0.00</td>
                                                            <td id="td-suma">'.number_format($sumaSemana, 2).'</td></tr>';
                                                    }
                                                    $sumaTotal += $sumaSemana;
                                                    $sumaSemana = 0;
                                                }else{
                                                    $sumaSemana += $resultado['res'];
                                                    if ($resultado['res']) {
                                                        echo '<td id="td-resultados">'.number_format($resultado['res'], 2).'</td>';
                                                    }else{
                                                        echo '<td id="td-resultados">0.00</td>';
                                                    }
                                                }
                                                
                                            }
                                            if ($finMes != 0) {
                                                $sumaTotal += $sumaSemana;
                                                echo $cadenaFinal.'<td id="td-suma">'.number_format($sumaSemana, 2).'</td></tr>';
                                            }
                                            echo '<tr><td colspan="7" id="td-suma">Total del mes: </td><td id="td-suma">'.number_format($sumaTotal, 2).'</td></tr>
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                            <!-- /.card-body -->                        
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                                <a class="btn btn-primary" href="'.site_url().'reporte-master-ingresos-excel?negocio='.$datos['negocio'].'&mes='.$datos['fecha'].'">Descargar reporte en excel</a>
                                                <a href="'.site_url().'reporte-master-ingresos" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                                            </div>';
                                            
                                        }else{
                                            echo '<tr>';
                                            echo '<td colspan="6">NO HAY RESULTADOS QUE MOSTRAR CON ESE CRITERIO DE BUSQUEDA</td>';
                                            echo '</tr>';

                                            echo '</tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->                        
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                            <a href="'.site_url().'reporte-master-ingresos" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                                        </div>';
                                        }
                            
                                    ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/cabecera-reportes.js"></script>

