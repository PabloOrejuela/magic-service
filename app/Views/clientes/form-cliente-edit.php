<link rel="stylesheet" href="<?= site_url(); ?>public/css/cliente-edit.css">
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
                    <form action="<?= site_url().'cliente-update';?>" method="post">
                        <div class="form-group col-12 mb-1 mt-1 px-3" id="fila-form">
                            <h4 id="mensaje-campos-requeridos">Los campos con asterisco * son obligatorios</h4>
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="nombre" class="form-label">Nombre *:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $cliente->nombre;?>" autofocus >
                                    <p id="error-message"><?= session('errors.nombre');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="telefono" class="form-label">Teléfono 1*:</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?= $cliente->telefono; ?>" autofocus>
                                    <p id="error-message"><?= session('errors.telefono');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="telefono_2" class="form-label">Teléfono 2:</label>
                                    <input type="text" class="form-control" id="telefono_2" name="telefono_2" placeholder="teléfono 2" value="<?= $cliente->telefono_2; ?>" autofocus>
                                    <p id="error-message"><?= session('errors.telefono');?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-1 px-3" id="fila-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="documento" class="form-label">Documento:</label>
                                    <input type="text" class="form-control" id="documento" name="documento" placeholder="Documento" value="<?= $cliente->documento; ?>" autofocus>
                                    <p id="error-message"><?= session('errors.documento');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="<?= $cliente->direccion ?>" autofocus>
                                    <p id="error-message"><?= session('errors.direccion');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= $cliente->email; ?>" autofocus>
                                    <p id="error-message"><?= session('errors.email');?> </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <?= form_hidden('id', $cliente->id); ?>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Actualizar</button>
                            <a href="<?= site_url(); ?>clientes" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                            <a type="button" href="<?= site_url().'print-client-historial/'.$cliente->id; ?>" class="btn btn-secondary btn-print">
                                <img src="<?= site_url(); ?>public/images/btn-print.png" width="25"> Historial de pedidos
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/form-cliente-edit.js"></script>
