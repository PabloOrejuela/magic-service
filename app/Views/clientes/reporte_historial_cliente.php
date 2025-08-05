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
                                <th>Fecha</th>
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
                                $this->detallePedidoModel = new DetallePedidoModel();

                                if ($pedidos) {
                                    foreach ($pedidos as $key => $pedido) {
                                        $detalle = $this->detallePedidoModel->_getDetallePedido($pedido->cod_pedido);
                                        //echo '<pre>'.var_export($detalle, true).'</pre>';exit;
                                        echo '<tr>
                                            <td>'.$pedido->cod_pedido.'</td>
                                            <td>'.$pedido->fecha_entrega.'</td>
                                            <td>'.$pedido->sector.'</td>
                                            <td>'.$pedido->dir_entrega.'</td>
                                            <td>'.$pedido->ubicacion.'</td>';
                                        echo '<td><ul>';
                                            if (isset($detalle)) {
                                                foreach ($detalle as $key => $d) {
                                                    
                                                    echo '<li>'.$d->producto.'</li>';
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
<script>
    $(document).ready(function () {
        $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
        $('#table-historial-pedidos').DataTable({
            "responsive": true, 
            "order": [[ 0, 'dsc' ]],
            language: {
                processing: 'Procesando...',
                lengthMenu: 'Mostrando _MENU_ registros por página',
                zeroRecords: 'No hay registros',
                info: 'Mostrando _START_ a _END_ de _MAX_',
                infoEmpty: 'No hay registros disponibles',
                infoFiltered: '(filtrando de _MAX_ total registros)',
                search: 'Buscar',
                paginate: {
                first:      "Primero",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": activar para ordenar ascendentemente",
                        sortDescending: ": activar para ordenar descendentemente"
                    }
            },
            //"lengthChange": false, 
            "autoWidth": false,
            "dom": "<'row'<'col-sm-12 col-md-8'l><'col-md-12 col-md-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-10 col-md-6'p>>"
        });
    });
</script>