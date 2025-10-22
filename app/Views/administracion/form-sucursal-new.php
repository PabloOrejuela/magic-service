<style>
    #precio{
        text-align: right;
    }
    #item-grid{
        margin-left: 20px;
        /*float: left;*/
    }
    #items{
        text-align: left;
    }
    a:hover{
        text-decoration: none;
    }
    #input-item{
        width: 65%;
        margin-right: 5px;
    }
    .cant{
        /* width: 20%; */
        text-align: right;
        margin-left: 1px;
    }

    #ion-delete{
        
        margin-left: 7px;
        padding: 2px;
        padding-top: 3px;
        font-size: 1.5em;
        color: red;
    }
</style>
<script>
    $(document).ready( 
        
    );
</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'sucursal-insert';?>" method="post">
                        <div class="card-body">
                            <div class="form-group col-md-7">
                                <label for="sucursal">Sucursal:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="sucursal" 
                                    name="sucursal" 
                                    placeholder="Sucursal" 
                                    required
                                >
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="direccion">Dirección:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="direccion" 
                                    name="direccion" 
                                    placeholder="Direccion" 
                                    required
                                >
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Registrar</button>
                            <a href="<?= site_url(); ?>sucursales" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->

