<style>
    #precio{
        text-align: right;
    }
</style>
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
                    <form action="<?= site_url().'/item-create';?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="item">Item:</label>
                                <input type="text" class="form-control" id="item" name="item" placeholder="Item" value="<?= old('item'); ?>">
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="exampleInpupreciotPassword1">Precio:</label>
                                <input type="text" class="form-control" id="precio" name="precio" placeholder="0.00" value="<?= old('precio'); ?>">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?= site_url(); ?>items" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->