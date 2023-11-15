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
                    <form action="<?= site_url().'cliente-insert';?>" method="post">
                        <div class="form-group col-12 mb-1 mt-1" id="fila-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="nombre" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= set_value('nombre'); ?>" autofocus >
                                    <p id="error-message"><?= session('errors.nombre');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="telefono" class="form-label">Teléfono:</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?= set_value('telefono'); ?>" autofocus>
                                    <p id="error-message"><?= session('errors.telefono');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="documento" class="form-label">Documento:</label>
                                    <input type="text" class="form-control" id="documento" name="documento" placeholder="Documento" value="<?= set_value('documento'); ?>" autofocus>
                                    <p id="error-message"><?= session('errors.documento');?> </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-12 mb-1" id="fila-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="direccion" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección" value="<?= set_value('direccion'); ?>" autofocus>
                                    <p id="error-message"><?= session('errors.direccion');?> </p>
                                </div>
                                <div class="col-sm-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>" autofocus>
                                    <p id="error-message"><?= session('errors.email');?> </p>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->

