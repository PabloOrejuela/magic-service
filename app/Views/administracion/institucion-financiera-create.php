<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'/institucion-financiera-create';?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="banco">Banco:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="banco" 
                                    name="banco" 
                                    placeholder="Nombre de la institución financiera" 
                                    value="<?= old('banco'); ?>"
                                >
                            </div>
                            <p id="error-message"><?= session('errors.banco');?> </p>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?= site_url(); ?>institucion-financiera" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->