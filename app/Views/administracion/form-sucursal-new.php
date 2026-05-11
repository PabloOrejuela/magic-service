<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-sucursal-new.css">
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
                        <div class="row card-body col-12">
                            <div class="form-group col-md-3">
                                <label for="sucursal">Negocio:</label>
                                <select 
                                    class="form-select form-control-border" 
                                    id="negocio" 
                                    name="negocio" 
                                >
                                    <option value="0" selected>-- Opciones --</option>
                                    <?php
                                        if (isset($negocios)) {
                                            foreach ($negocios as $key => $negocio) {
                                                echo '<option value="'.$negocio->id.'" '.set_select('negocio', $negocio->id, false).' >'.$negocio->negocio.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <p id="error-message"><?= session('errors.negocio');?> </p>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sucursal">Sucursal:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="sucursal" 
                                    name="sucursal" 
                                    placeholder="Sucursal" 
                                    value="<?= esc(old('sucursal')) ?>"
                                    required
                                >
                                <p id="error-message"><?= session('errors.sucursal');?> </p>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="direccion">Dirección:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="direccion" 
                                    name="direccion" 
                                    placeholder="Direccion" 
                                    value="<?= esc(old('direccion')) ?>"
                                    required
                                >
                                <p id="error-message"><?= session('errors.direccion');?> </p>
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

