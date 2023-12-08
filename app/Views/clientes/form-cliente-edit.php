<style>
    #fila-form{
        padding:10px;
    }

    #error-message{
        margin-top: 4px;
    }
</style>
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?><span id="mensaje"> ESTE FORMULARIO ESTÁ EN PROCESO</span></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'cliente-update';?>" method="post">
                        <div class="form-group col-12 mb-1 mt-1" id="fila-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $cliente->nombre;?>" autofocus >
                                    <p id="error-message"><?= session('errors.nombre');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="telefono" class="form-label">Teléfono:</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?= $cliente->telefono; ?>" autofocus>
                                    <p id="error-message"><?= session('errors.telefono');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="documento" class="form-label">Documento:</label>
                                    <input type="text" class="form-control" id="documento" name="documento" placeholder="Documento" value="<?= $cliente->documento; ?>" autofocus>
                                    <p id="error-message"><?= session('errors.documento');?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-1" id="fila-form">
                            <div class="row">
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
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                            <a href="<?= site_url(); ?>clientes" class="btn btn-light" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->

