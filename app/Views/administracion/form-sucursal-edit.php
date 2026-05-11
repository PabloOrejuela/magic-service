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
                    <form action="<?= site_url().'sucursal-update';?>" method="post">
                        <div class="row card-body col-12">
                            <div class="form-group col-md-3">
                                <label for="sucursal">Negocio:</label>
                                <select 
                                    class="form-select form-control-border" 
                                    id="negocio" 
                                    name="negocio" 
                                >
                                    <?php
                                        if (isset($negocios)) {
                                            foreach ($negocios as $key => $negocio) {
                                                if ($sucursal->idnegocio == $negocio->id) {
                                                    echo '<option value="'.$negocio->id.'" selected>'.$negocio->negocio.'</option>';
                                                } else {
                                                    echo '<option value="'.$negocio->id.'">'.$negocio->negocio.'</option>';
                                                }
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
                                    value="<?= $sucursal->sucursal ? $sucursal->sucursal : esc(old('sucursal')); ?>"
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
                                    value="<?= $sucursal->direccion ? $sucursal->direccion : esc(old('direccion')); ?>"
                                    required
                                >
                                <p id="error-message"><?= session('errors.direccion');?> </p>
                            </div>
                        </div>
                        <?=  form_hidden('id', $sucursal->id); ?>
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

