<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-procedencia.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-7">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'reporte-procedencias';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-3">
                                    <label for="negocio">Negocio:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="negocio" 
                                        name="negocio" 
                                    >
                                    <option value="0" selected>-- Mostrar todos --</option>
                                        <?php
                                            if (isset($negocios)) {
                                                foreach ($negocios as $key => $negocio) {
                                                    if ($negocio->id == $datos['negocio']) {
                                                        echo '<option value="'.$negocio->id.'" selected>'.$negocio->negocio.'</option>';
                                                    }else{
                                                        echo '<option value="'.$negocio->id.'">'.$negocio->negocio.'</option>';
                                                    }
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                               </div>
                               <div class="form-group col-md-3">
                                <label for="fecha_inicio">Fecha inicio *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_inicio" 
                                        name="fecha_inicio" 
                                        value="<?= $datos['fecha_inicio']; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha_inicio');?> </p>
                               </div>
                               <div class="form-group col-md-3">
                                <label for="fecha_final">Fecha final *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_final" 
                                        name="fecha_final" 
                                        value="<?= $datos['fecha_final']; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha_final');?> </p>
                               </div>
                               <div class="form-group col-md-3">
                                    <label for="sugest">Opciones:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="sugest" 
                                        name="sugest" 
                                    >
                                        <option value="0" selected>--Opciones--</option>
                                        <?php
                                            if (isset($sugest)) {
                                                foreach ($sugest as $key => $value) {
                                                    if ($key == $datos['sugest']) {
                                                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                    }else{
                                                        echo '<option value="'.$key.'" >'.$value.'</option>';
                                                    }
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                               </div>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row col-md-12">
                                <table class="table table-striped mt-3" id="table-resultados">
                                <thead >
                                    <th class="col-sm-1">No.</th>
                                    <th class="col-sm-1">FECHA</th>
                                    <th class="col-sm-4">CLIENTE</th>
                                    <th class="col-sm-2">VALOR TOTAL</th>
                                    <th class="col-sm-2">PROCEDENCIA</th>
                                    <th class="col-sm-2">NEGOCIO</th>
                                </thead>
                                <tbody id='tablaReporte'>
                                    <?php
                                        $num = 1;
                                        $suma = 0;
                                        if ($res) {
                                            foreach ($res as $key => $resultado) {
                                                echo '<tr>';
                                                echo '<td>'.$num.'</td>';
                                                echo '<td>'.$resultado->fecha.'</td>';
                                                echo '<td>'.$resultado->cliente.'</td>';
                                                echo '<td id="resultado-total">'.$resultado->total.'</td>';

                                                if ($resultado->procedencia == 'Seleccionar procedencia') {
                                                    echo '<td>Indeterminada</td>';
                                                }else{
                                                    echo '<td>'.$resultado->procedencia.'</td>';
                                                }
                                                
                                                echo '<td>'.$resultado->negocio.'</td>';
                                                echo '</tr>';
                                                $suma += $resultado->total;
                                                $num++;
                                                
                                            }
                                            echo '<tr><td colspan="2"></td><td id="text-result-bold">TOTAL: </td><td id="text-result-bold">'.number_format($suma, 2).'</td><td colspan="2"></td></tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                            <!-- /.card-body -->                        
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                <a class="btn btn-primary" href="'.site_url().'reporte-procedencias-excel?negocio='.$datos['negocio'].'&fecha_inicio='.$datos['fecha_inicio'].'&fecha_final='.$datos['fecha_final'].'&sugest='.$datos['sugest'].'">Descargar reporte en excel</a>
                                <a href="'.site_url().'reporte-procedencias" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                            </div>
                                                ';
                                        }else{
                                            echo '<tr>';
                                            echo '<td colspan="6">NO HAY RESULTADOS QUE MOSTRAR CON ESE CRITERIO DE BUSQUEDA</td>';
                                            echo '</tr>';

                                            echo '
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                            <a href="'.site_url().'reporte-procedencias" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                        </div>

                                            ';
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

