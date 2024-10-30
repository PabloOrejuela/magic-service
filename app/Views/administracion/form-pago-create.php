<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'/forma-pago-new';?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="forma_pago">Forma de pago:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="forma_pago" 
                                    name="forma_pago" 
                                    placeholder="Nueva forma de pago" 
                                    value="<?= old('forma_pago'); ?>"
                                >
                            </div>
                            <p id="error-message"><?= session('errors.forma_pago');?> </p>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?= site_url(); ?>formas-pago" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->