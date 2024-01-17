<style>
    #fila-form{
        padding:10px;
    }

    #error-message{
        margin-top: 4px;
    }
    .card-footer{
        margin-top:100px;
    }
</style>
<link rel="stylesheet" href="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <form action="#" method="post">
                            
                            <div class="form-group col-12 mb-1 mt-1 px-3" id="fila-form">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="item" class="form-label">Item:</label>
                                        <input type="text" class="form-control" id="item" name="item" placeholder="Item" autofocus >
                                    </div>
                                </div>
                                <div class="row" id="info-item">
                                    
                                </div>
                            </div>
                            
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btnActualizar">Actualizar</button>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= site_url(); ?>public/js/form-gestion-inventario.js"></script>

