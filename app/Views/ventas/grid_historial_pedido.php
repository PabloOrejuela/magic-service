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
                        <table class="table table-bordered table-striped px-3" id="table-historial-pedido">
                            <thead>
                                <th>ID del cambio</th>
                                <th>Pedido</th>
                                <th>Usuario</th>
                                <th>Fecha del cambio</th>
                            </thead>
                            <tbody>
                            <?php

                                use App\Models\UsuarioModel;
                                $this->usuarioModel = new UsuarioModel();

                                if ($cambios) {
                                    //echo '<pre>'.var_export($cambios, true).'</pre>';exit;
                                    foreach ($cambios as $key => $cambio) {

                                        $modo = 'REPORTE';
                                        
                                        //echo '<pre>'.var_export($detalle, true).'</pre>';exit;
                                        echo '<tr>
                                                <td>'.$cambio->id.'</td>
                                                <td>
                                                    <a href="'.site_url().'detalle-cambios-pedido/'.$cambio->id.'/'.$pedido->cod_pedido.'" id="link-historial-pedido">'.$pedido->cod_pedido.'</a>
                                                </td>
                                                <td>'.$cambio->nombre.'</td>
                                                <td>'.$cambio->fecha.'</td>';
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/rep-hist-cliente.js"></script>
