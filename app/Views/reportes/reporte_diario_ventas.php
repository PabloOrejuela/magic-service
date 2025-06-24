<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-diario-ventas.css">
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
                    <form action="<?= site_url().'reporte_diario_ventas';?>" method="post">
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
                                        value="<?= $datos['fecha_final'];?>" 
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
                                                    if ($session->idroles == 3) {
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
                                    <th class="col-sm-2">No.</th>
                                    <th class="col-sm-2">CODIGO</th>
                                    <th class="col-sm-2">FECHA</th>
                                    <th class="col-sm-4">CLIENTE</th>
                                    <th class="col-sm-4">BANCO/PLATAFORMA</th>
                                    <th class="col-sm-2">VALOR TOTAL</th>
                                    <th class="col-sm-2">NEGOCIO</th>
                                    <th class="col-sm-2">VENDEDOR</th>
                                    <th class="col-sm-2">VENTA EXTRA</th>
                                    <th class="col-sm-2">OBSERVACION PEDIDO</th>
                                    <th class="col-sm-2">PAGO COMPROBADO</th>
                                </thead>
                                <tbody id='tablaReporte'>
                                    <?php
                                        
                                        use App\Models\BancoModel;
                                        use App\Models\UsuarioModel;
                                        $this->bancoModel = new BancoModel();
                                        $this->usuarioModel = new UsuarioModel();

                                        $num = 1;
                                        $suma = 0;
                                        $totalKarana = 0;
                                        $totalMagicService = 0;
                                        $ventasExtras = 0;

                                        if ($res) {
                                            foreach ($res as $key => $result) {
                                                $vendedor = $this->usuarioModel->_getNombreUsuario($result->vendedor);
                                                echo '<tr>';
                                                echo '<td>'.$num.'</td>';
                                                echo '<td>'.$result->cod_pedido.'</td>';
                                                echo '<td>'.$result->fecha.'</td>';
                                                echo '<td>'.$result->cliente.'</td>';

                                                if ($result->banco != 0) {
                                                    $banco = $this->bancoModel->_getBanco($result->banco);
                                                    echo '<td>'.$banco->banco.'</td>';
                                                }else{
                                                    echo '<td>No definido</td>';
                                                }
                                                
                                                echo '<td id="resultado-total">'.$result->total.'</td>';
                                                echo '<td>'.$result->negocio.'</td>';
                                                
                                                if ($result->idnegocio == 1) {
                                                    $totalMagicService += $result->total;
                                                }elseif ($result->idnegocio == 2) {
                                                    $totalKarana += $result->total;
                                                }

                                                echo '<td>'.$vendedor.'</td>';  

                                                if ($result->venta_extra == 1) {
                                                    echo '<td>SI</td>';
                                                    $ventasExtras++;
                                                } else {
                                                    echo '<td>NO</td>';
                                                }
                                                
                                                echo '<td>'.$result->observaciones.'</td>';

                                                if ($result->pagado == 1) {
                                                    echo '<td>
                                                            <div class="form-check" id="divchkpagado">
                                                                <input class="form-check-input" type="checkbox" value="1" id="'.$result->id.'" data-codigo="'.$result->cod_pedido.'" data-idpedido="'.$result->id.'" checked>
                                                            </div>
                                                        </td>';
                                                } else {
                                                    echo '<td>
                                                            <div class="form-check" id="divchkpagado">
                                                                <input class="form-check-input" type="checkbox" value="1" id="'.$result->id.'" data-codigo="'.$result->cod_pedido.'" data-idpedido="'.$result->id.'">
                                                            </div>
                                                        </td>';
                                                }

                                                echo '</tr>';
                                                $suma += $result->total;
                                                $num++;

                                            }
                                            echo '<tr>
                                                    <td colspan="4"></td>
                                                    <td id="text-result-bold">TOTAL: </td>
                                                    <td id="text-result-bold">$'.number_format($suma, 2).'</td>
                                                    <td colspan="2"></td>
                                                    <td>'.$ventasExtras.'</td>
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
                                        href="'.site_url().'reporte-diario-ventas-excel?negocio='.$datos['negocio']
                                        .'&fecha_inicio='.$datos['fecha_inicio']
                                        .'&fecha_final='.$datos['fecha_final']
                                        .'&sugest='.$datos['sugest'].'">Descargar reporte en excel</a>
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

<script>
    $(document).ready(function(){
        $("input:checkbox").change(function() { 
            let id = $(this).attr("id")
            let pagado = 0    
            if($(this).is(":checked")) { 
                pagado = 1
                $.ajax({
                    url: 'item-pagado-update',
                    method: 'GET',
                    data: { 
                        id: id, 
                        pagado: pagado
                    }
                });
            } else {
                $.ajax({
                    url: 'item-pagado-update',
                    method: 'GET',
                    data: { 
                        id: id, 
                        pagado: pagado
                    }
                });
            }
        });         
    });
</script>


