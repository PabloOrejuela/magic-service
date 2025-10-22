<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-diario-ventas.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'reporte-devoluciones';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-10">
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
                                    <p id="error-message"><?= session('errors.negocio');?> </p>
                               </div>
                               <div class="form-group col-md-3">
                                <label for="fecha_inicio">Fecha *:</label>
                                    <input 
                                        type="month" 
                                        class="form-control text" 
                                        id="fecha" 
                                        name="fecha" 
                                        value="<?= $datos['fecha']; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha');?> </p>
                               </div>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row col-md-12">
                                <table class="table table-striped mt-3" id="table-resultados">
                                <thead >
                                    <th class="col-sm-2">No.</th>
                                    <th class="col-sm-2">CODIGO</th>
                                    <th class="col-sm-2">FECHA</th>
                                    <th class="col-sm-4">CLIENTE</th>
                                    <th class="col-sm-2">NEGOCIO</th>
                                    <th class="col-sm-2">VENDEDOR</th>
                                    <th class="col-sm-2">VALOR TOTAL</th>
                                    <th class="col-sm-2">VALOR DEVUELTO</th>
                                    <th class="col-sm-2">OBSERVACION DEVOLUCION</th>
                                </thead>
                                <tbody id='tablaReporte'>
                                    <?php

                                        use App\Models\UsuarioModel;
                                        $this->usuarioModel = new UsuarioModel();

                                        $num = 1;
                                        $suma = 0;
                                        $totalKarana = 0;
                                        $totalMagicService = 0;

                                        if ($devoluciones) {
                                            foreach ($devoluciones as $key => $result) {
                                                $vendedor = $this->usuarioModel->_getNombreUsuario($result->vendedor);
                                                echo '<tr>';
                                                echo '<td>'.$num.'</td>';
                                                echo '<td>'.$result->cod_pedido.'</td>';
                                                echo '<td>'.$result->fecha.'</td>';
                                                echo '<td>'.$result->cliente.'</td>';
                                                echo '<td>'.$result->negocio.'</td>';
                                                
                                                if ($result->idnegocio == 1) {
                                                    $totalMagicService += $result->valor_devuelto;
                                                }elseif ($result->idnegocio == 2) {
                                                    $totalKarana += $result->valor_devuelto;
                                                }

                                                echo '<td>'.$vendedor.'</td>';  
                                                echo '<td id="resultado-total">'.$result->total.'</td>';
                                                echo '<td id="resultado-total">'.$result->valor_devuelto.'</td>';
                                                echo '<td>'.$result->observacion_devolucion.'</td>';

                                                echo '</tr>';
                                                $suma += $result->total;
                                                $num++;

                                            }
                                        echo '<tr>
                                                <td colspan="5"></td>
                                                <td id="text-result-bold">TOTAL: </td>
                                                <td id="text-result-bold">$'.number_format($suma, 2).'</td>
                                                <td id="text-result-bold">'.($totalKarana + $totalMagicService).'</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered mt-3" id="table-totales">
                                        <thead>
                                            <th>Negocio</th>
                                            <th>Total</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Magic Service:</td><td id="text-result-bold">$ '.number_format($totalMagicService, 2).'</td>
                                            </tr>
                                            <tr>
                                                <td>Karana:</td><td id="text-result-bold">$ '.number_format($totalKarana, 2).'</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>  
                                <!-- /.card-body -->                        
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                    <a class="btn btn-primary" 
                                        href="'.site_url().'reporte-devoluciones-excel?negocio='.$datos['negocio']
                                        .'&fecha_inicio='.$datos['fecha_inicio']
                                        .'&fecha_final='.$datos['fecha_final'].'">Descargar reporte en excel</a>
                                    <a href="'.site_url().'reporte_diario_ventas" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                                </div>
                                            ';
                                        }else{
                                            echo '<tr>';
                                            echo '<td colspan="11">NO HAY RESULTADOS QUE MOSTRAR CON ESE CRITERIO DE BUSQUEDA</td>';
                                            echo '</tr>';

                                            echo '
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                            <a href="'.site_url().'reporte_diario_ventas" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
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


