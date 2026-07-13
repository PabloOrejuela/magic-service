<link rel="stylesheet" href="<?= site_url(); ?>public/css/reporte-historial-clientes.css">
<section class="content1">
    <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <h3 class="card-title"><?= $subtitle ?></h3>
                        </div>
                        <!-- /.card-header -->
                        <label for="cliente"></label>
                        <table class="table table-bordered table-striped px-3" id="table-historial-pedidos">
                            <thead>
                                <th>Pedido</th>
                                <th>Usuario</th>
                                <th>Fecha del cambio</th>
                                <th>Detalle</th>
                            </thead>
                            <tbody>
                            <?php

                                use App\Models\DetallePedidoModel;
                                use App\Models\AttrExtArregModel;
                                $this->attrExtArregModel = new AttrExtArregModel();
                                $this->detallePedidoModel = new DetallePedidoModel();

                                if ($cambios) {
                                    echo '<pre>'.var_export($cambios, true).'</pre>';exit;
                                    foreach ($cambios as $key => $cambio) {
                                        $modo = 'REPORTE';
                                        
                                        //echo '<pre>'.var_export($detalle, true).'</pre>';exit;
                                        echo '<tr>
                                                <td>
                                                    <a href="'.site_url().'pedido-edit/'.$pedido->id.'/'.$modo.'" id="link-editar">'.$pedido->cod_pedido.'</a>
                                                </td>
                                                <td>'.$pedido->fecha.'</td>
                                                <td>'.$pedido->idusuario.'</td>
                                                <td>'.$pedido->fecha.'</td>
                                                <td>'.$pedido->detalle.'</td>
                                                <td>'.$pedido->ubicacion.'</td>';
                                        echo '</td></tr>';
                                    }
                                }else{
                                     echo '<tr><td colspan="11">No se ha encontrado registros de cambios de este pedido</td></tr>';
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
