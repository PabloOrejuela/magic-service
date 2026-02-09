<link rel="stylesheet" href="<?= site_url(); ?>public/css/reporte-historial-clientes.css">
<section class="content1">
    <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"><?= $subtitle.': '.$cliente->nombre; ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <label for="cliente"></label>
                        <table class="table table-bordered table-striped px-3" id="table-historial-pedidos">
                            <thead>
                                <th>Pedido</th>
                                <th>Fecha Registro</th>
                                <th>Fecha Entrega</th>
                                <th>Sector</th>
                                <th>Dirección</th>
                                <th>Ubicación de entrega</th>
                                <th>Producto</th>
                                <th>Valor total pagado</th>
                                <th>Mensajero</th>
                                <th>Observación</th>
                                <th>Sucursal</th>
                            </thead>
                            <tbody>
                            <?php

                                use App\Models\DetallePedidoModel;
                                use App\Models\AttrExtArregModel;
                                $this->attrExtArregModel = new AttrExtArregModel();
                                $this->detallePedidoModel = new DetallePedidoModel();

                                if ($pedidos) {
                                    foreach ($pedidos as $key => $pedido) {
                                        $detalle = $this->detallePedidoModel->_getDetallePedido($pedido->cod_pedido);
                                        $modo = 'REPORTE';
                                        
                                        //echo '<pre>'.var_export($detalle, true).'</pre>';exit;
                                        echo '<tr>
                                                <td>
                                                    <a href="'.site_url().'pedido-edit/'.$pedido->id.'/'.$modo.'" id="link-editar">'.$pedido->cod_pedido.'</a>
                                                </td>
                                                <td>'.$pedido->fecha.'</td>
                                                <td>'.$pedido->fecha_entrega.'</td>
                                                <td>'.$pedido->sector.'</td>
                                                <td>'.$pedido->dir_entrega.'</td>
                                                <td>'.$pedido->ubicacion.'</td>';
                                        echo '<td><ul>';
                                            if (isset($detalle)) {
                                                foreach ($detalle as $key => $d) {
                                                    $attrExtArreg = $this->attrExtArregModel->_getAttrArreg($d->iddetalle, $d->idcategoria);
                                                        
                                                        if ($attrExtArreg) {
                                                            echo '<li>
                                                                <a 
                                                                    href="#" 
                                                                    id="link-Arreglo-Pedido" 
                                                                    data-id="'.$d->iddetalle.'"
                                                                    data-arreglo="'.$d->producto.'"
                                                                    data-pedido="'.$d->cod_pedido.'"
                                                                    data-bs-toggle="modal"
                                                                    data-category="'.$d->idcategoria.'" 
                                                                    data-bs-target="#linkArregloPedido">'.$d->producto.'</a>
                                                            </li>';
                                                            echo '<div id="observacion-detalle">'.$d->observacion.'</li></div>';
                                                        } else {
                                                            echo '<li>
                                                                <a 
                                                                    href="#" 
                                                                    id="link-Arreglo-Pedido" 
                                                                    data-id="'.$d->iddetalle.'"
                                                                    data-arreglo="'.$d->producto.'"
                                                                    data-pedido="'.$d->cod_pedido.'"
                                                                    data-bs-toggle="modal"
                                                                    data-category="'.$d->idcategoria.'" 
                                                                    style="color:#c70a0a;"
                                                                    data-bs-target="#linkArregloPedido">'.$d->producto.'</a>
                                                            </li>';
                                                            echo '<div id="observacion-detalle">'.$d->observacion.'</li></div>';
                                                        }
                                                    //echo '<li>'.$d->producto.'</li>';
                                                }
                                            }
                                        echo '</ul></td>';
                                            
                                        echo '<td id="td-result-right">'.$pedido->total.'</td>
                                            <td>'.$pedido->nombre.'</td>
                                            <td>'.$pedido->observaciones.'</td>
                                            <td>'.$pedido->sucursal.'</td>
                                        </tr>';
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                        <div class="card-footer">
                            <a href="<?= site_url(); ?>clientes" class="btn btn-light cancelar" id="btn-cancela">Cancelar y regresar a clientes</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section> <!-- /.card -->

<!-- Modal Frm Attributos extra Arreglo-->
<div class="modal fade" id="linkArregloPedido" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Campos del arreglo para el tiket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onClick="actualizaGrid()"></button>
      </div>
      <form id="form-modal-attr">
        <div class="modal-body">
            <input class="form-control" type="hidden" name="idarreglo" id="idarreglo">
            <input class="form-control" type="hidden" name="idcategoria" id="idcategoria">
            <div class="mb-0 row">
                <label for="lblPedido" class="col-sm-2 col-form-label">Pedido:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="lblPedido">
                </div>
            </div>
            <div class="mb-1 row">
                <label for="lblForm" class="col-sm-2 col-form-label">Arreglo:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="lblForm">
                </div>
            </div>
            
            <!-- Desarrollo el cuerpo de cada formulario   -->
            <div class="formulario" id="formulario">
                
            </div>
        </div>
        <div class="modal-footer">
            
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/rep-hist-cliente.js"></script>
