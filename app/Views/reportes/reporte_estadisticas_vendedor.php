<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-estadisticas-vendedor.css">
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
                    <form action="<?= site_url().'reporte-estadisticas-vendedor';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-2">
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
                                    <label for="negocio">Vendedor:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="vendedor" 
                                        name="vendedor" 
                                    >
                                        <option value="0" selected>--Seleccionar vendedor--</option>
                                        <?php
                                            if (isset($vendedores)) {
                                                foreach ($vendedores as $key => $vendedor) {
                                                    echo '<option value="'.$vendedor->id.'" '.set_select('vendedor', $vendedor->id, false).' >'.$vendedor->nombre.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <p id="error-message"><?= session('errors.vendedor');?> </p>
                               </div>
                               <div class="form-group col-md-2">
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
                               <div class="form-group col-md-2">
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
                               <div class="form-group col-md-2">
                                    <label for="sugest">Más fechas:</label>
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
                                                    } else {
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
                                    <th class="col-sm-2">FECHA</th>
                                    <th class="col-sm-4">CLIENTE</th>
                                    <th class="col-sm-1">VALOR TOTAL</th>
                                    <th class="col-sm-2">NEGOCIO</th>
                                    <th class="col-sm-2">VENDEDOR</th>
                                    <th class="col-sm-3">VENTA EXTRA</th>
                                </thead>
                                <tbody id='tablaReporte'>
                                    <?php
                                        
                                        use App\Models\BancoModel;
                                        use App\Models\UsuarioModel;
                                        $this->bancoModel = new BancoModel();
                                        $this->usuarioModel = new UsuarioModel();

                                        $num = 1;
                                        $suma = 0;
                                        $ventasExtras = 0;

                                        if ($res) {
                                            foreach ($res as $key => $resultado) {
                                                $vendedor = $this->usuarioModel->_getNombreUsuario($resultado->vendedor);
                                                echo '<tr>';
                                                echo '<td>'.$num.'</td>';
                                                echo '<td>'.$resultado->fecha.'</td>';
                                                echo '<td>'.$resultado->cliente.'</td>';    
                                                echo '<td id="resultado-total">'.$resultado->total.'</td>';
                                                echo '<td>'.$resultado->negocio.'</td>';

                                                echo '<td>'.$vendedor.'</td>';  

                                                if ($resultado->venta_extra == 1) {
                                                    echo '<td>SI</td>';
                                                    $ventasExtras++;
                                                } else {
                                                    echo '<td>NO</td>';
                                                }
                                                echo '</tr>';
                                                $suma += $resultado->total;
                                                $num++;
                                            }
                                            echo '<tr>
                                                    <td colspan="2"></td><td id="text-result-bold">TOTAL: </td>
                                                    <td id="text-result-bold">'.number_format($suma, 2).'</td>
                                                    <td colspan="2"></td><td id="text-result-bold-centered">'.$ventasExtras.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->                        
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                                    <a 
                                        class="btn btn-primary" 
                                        href="'.site_url().'reporte-estadisticas-vendedor-excel?negocio='.$datos['negocio']
                                        .'&fecha_inicio='.$datos['fecha_inicio']
                                        .'&fecha_final='.$datos['fecha_final']
                                        .'&vendedor='.$resultado->vendedor.'">Descargar reporte en excel</a>

                                    <a href="'.site_url().'reporte-estadisticas-vendedor" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                                </div>
                                                    ';

                                        }else{
                                            echo '<tr>';
                                            echo '<td colspan="7">NO HAY RESULTADOS QUE MOSTRAR CON ESE CRITERIO DE BUSQUEDA</td>';
                                            echo '</tr>';

                                            echo '
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                            <a href="'.site_url().'reporte-estadisticas-vendedor" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
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

