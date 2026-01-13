<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-mensajeria.css">
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
                    <form action="<?= site_url().'reporte-mensajeria';?>" method="post">
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
                                    <label for="mensajero">Mensajero:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="mensajero" 
                                        name="mensajero" 
                                    >
                                        <option value="0" selected>--Seleccionar mensajero--</option>
                                        <?php
                                            if (isset($mensajeros)) {
                                                foreach ($mensajeros as $key => $mensajero) {

                                                    if ($session->idroles >= 5) {
                                                        echo '<option value="'.$mensajero->id.'" '.set_select('mensajero', $mensajero->id, false).' selected>'.$mensajero->nombre.'</option>';
                                                    }else{
                                                        echo '<option value="'.$mensajero->id.'" '.set_select('mensajero', $mensajero->id, false).'>'.$mensajero->nombre.'</option>';
                                                    }
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                                    <p id="error-message"><?= session('errors.mensajero');?> </p>
                               </div>
                               <div class="form-group col-md-2">
                                <label for="fecha_inicio">Fecha inicio *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_inicio" 
                                        name="fecha_inicio" 
                                        value="<?= $datos['fecha_inicio']; ?>" 
                                        
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
                        <div class="row col-md-8">
                            <div><span id="rango-title">Desde:</span> <?=  $datos['fecha_inicio']; ?></div>
                            <div><span id="rango-title">Hasta:</span> <?=   $datos['fecha_final']; ?></div>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row col-md-12">
                                <table class="table table-striped mt-3" id="table-resultados">
                                <thead >
                                    <th class="col-sm-1">No.</th>
                                    <th class="col-sm-1">NEGOCIO</th>
                                    <th class="col-sm-1">COD PEDIDO</th>
                                    <th class="col-sm-1">FECHA</th>
                                    <th class="col-sm-2">CLIENTE</th>
                                    <th class="col-sm-1">SECTOR</th>
                                    <th class="col-sm-2">DIRECCION</th>
                                    <th class="col-sm-1">VALOR ASIGNADO</th>
                                    <th class="col-sm-1">HORA ENTREGA</th>
                                    <th class="col-sm-2">MENSAJERO</th>
                                    <th class="col-sm-2">COD ARREGLO</th>
                                    <th class="col-sm-2">TIPO</th>
                                </thead>
                                <tbody id='tablaReporte'>
                                    <?php
                                        
                                        use App\Models\DetallePedidoModel;
                                        use App\Models\UsuarioModel;
                                        $this->detallePedidoModel = new DetallePedidoModel();
                                        $this->usuarioModel = new UsuarioModel();

                                        $num = 1;
                                        $suma = 0;

                                        if ($res) {
                                            
                                            foreach ($res as $key => $resultado) {
                                                $mensajero = $this->usuarioModel->_getNombreUsuario($resultado->mensajero);
                                                $detalle = $this->detallePedidoModel->_getDetallePedido($resultado->cod_pedido);

                                                echo '<tr>';
                                                echo '<td>'.$num.'</td>';
                                                echo '<td>'.$nombreNegocio->negocio.'</td>';
                                                echo '<td>'.$resultado->cod_pedido.'</td>';
                                                echo '<td>'.$resultado->fecha.'</td>';
                                                echo '<td>'.$resultado->cliente.'</td>'; 
                                                echo '<td>'.$resultado->sector.'</td>';      
                                                echo '<td>'.$resultado->dir_entrega.'</td>';
                                                if ($resultado->valor_mensajero_edit == '0.00') {
                                                    $valor_mensajero = $resultado->valor_mensajero;
                                                }else{
                                                    $valor_mensajero = $resultado->valor_mensajero_edit;
                                                }
                                                echo '<td id="resultado-total">'.$valor_mensajero.'</td>';
                                                echo '<td>'.$resultado->rango_entrega_desde.' / '.$resultado->rango_entrega_hasta.'</td>';
                                                echo '<td>'.$mensajero.'</td>';
                                                echo '<td>';
                                                    if (isset($detalle)) {
                                                        foreach ($detalle as $key => $d) {
                                                            echo '<li>'.$d->producto.'</li>';
                                                        }
                                                    }
                                                echo '</ul></td>';
                                                echo '</td>'; 
                                                echo '<td></td></tr>';
                                                $suma += $valor_mensajero;
                                                $num++;
                                            }

                                            if ($extra) {
                                                foreach ($extra as $key => $r) {
                                                    
                                                    $detalle = $this->detallePedidoModel->_getDetallePedido($r->cod_pedido);
                                                    echo '<tr>';
                                                    echo '<td>'.$num.'</td>';
                                                    echo '<td>'.$nombreNegocio->negocio.'</td>';
                                                    echo '<td>'.$r->cod_pedido.'</td>';
                                                    echo '<td>'.$r->fecha.'</td>';
                                                    echo '<td>'.$r->cliente.'</td>'; 
                                                    echo '<td>'.$r->sector.'</td>';      
                                                    echo '<td>'.$r->dir_entrega.'</td>';
                                                    echo '<td id="resultado-total">'.$r->valor_mensajero_extra.'</td>';
                                                    echo '<td>'.$r->rango_entrega_desde.' / '.$r->rango_entrega_hasta.'</td>';
                                                    echo '<td>'.$mensajero.'</td>';
                                                    echo '<td>';
                                                        if (isset($detalle)) {
                                                            foreach ($detalle as $key => $d) {
                                                                echo '<li>'.$d->producto.'</li>';
                                                            }
                                                        }
                                                    echo '</ul></td>';
                                                    echo '</td>';
                                                    echo '<td>EXTRA</td>';
                                                    echo '</tr>';
                                                    $suma += $r->valor_mensajero_extra;
                                                    $num++;
                                                }
                                            }
                                            echo '<tr>
                                                    <td colspan="4"></td><td id="text-result-bold">TOTAL: </td>
                                                    <td id="text-result-bold">'.number_format($suma, 2).'</td>
                                                    <td colspan="3"></td><td></td>
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
                                        href="'.site_url().'reporte-mensajeria-excel?negocio='.$datos['negocio']
                                        .'&fecha_inicio='.$datos['fecha_inicio']
                                        .'&fecha_final='.$datos['fecha_final']
                                        .'&vendedor='.$resultado->mensajero.'">Descargar reporte en excel</a>

                                    <a href="'.site_url().'reporte-mensajeria" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
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
                            <a href="'.site_url().'reporte-mensajeria" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
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

