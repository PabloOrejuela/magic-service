<link rel="stylesheet" href="<?= site_url(); ?>public/css/form_cod_arreglo_vendido.css">
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
                    <form action="<?= site_url().'clientes-frecuentes';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-3">
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
                               <div class="form-group col-md-3">
                                    <label for="mes">Mes *:</label>
                                    <input 
                                        type="month" 
                                        class="form-control text" 
                                        id="fecha" 
                                        name="fecha" 
                                        value="<?= $datos['fecha']; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.mes');?> </p>
                               </div>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row col-md-8">
                                <table class="table table-bordered mt-3" id="table-resultados">
                                <thead>
                                    <th id="td-id">No.</th>     
                                    <th id="td-id">Id</th>
                                    <th id="td-id">Cliente</th>
                                    <th id="td-text-center">Cantidad de pedidos</th>
                                    <th id="td-text-right">Total</th>
                                </thead>
                                <tbody>
                                    <?php
                                        use App\Models\ProductoModel;
                                        $this->productoModel = new ProductoModel;

                                        $sumaTotal = 0;
                                        $num = 1;

                                        if ($res) {
                                            //echo '<pre>'.var_export($res, true).'</pre>';exit;

                                            foreach ($res as $key => $cliente) {

                                                echo '<tr>';
                                                echo '<td>'.$num.'</td>';
                                                echo '<td>'.$cliente['idcliente'].'</td>';
                                                echo '<td>'.strtoupper($cliente['cliente']).'</td>';
                                                echo '<td id="td-text-center">'.$cliente['cant'].'</td>';
                                                echo '<td id="td-text-right">'.number_format($cliente['total'],2).'</td>';
                                                echo '</tr>';

                                                $num++;
                                            }

                                            //echo '<tr><td colspan="3" id="td-suma">Total: </td><td id="td-suma">'.number_format($sumaTotal, 2).'</td></tr>
                                            echo '</tbody>
                                                </table>
                                            </div>
                                        </div>
                                            <!-- /.card-body -->                        
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                                <a class="btn btn-primary" href="'.site_url().'est-cod-arreglo-mas_vendido-excel?negocio='.$datos['negocio'].'&mes='.$datos['fecha'].'" id="btn-report-excel">Descargar reporte en excel</a>
                                                <a href="'.site_url().'arreg-mas-vendidos" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
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
                                            <a href="'.site_url().'arreg-mas-vendidos" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
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

