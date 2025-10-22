<style>
    #error-message{
        color: red;
    }
    .cancelar{
        position: absolute;
        right: 20px;
    }
</style>
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'user-update';?>" method="post">
                        <div class="card-body col-md-12">
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $usuario->nombre; ?>" >
                                    <p id="error-message"><?= session('errors.nombre');?> </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="user">Usuario:</label>
                                    <input type="text" class="form-control" id="user" name="user" placeholder="Nombre de usuario" value="<?= $usuario->user; ?>">
                                    <p id="error-message"><?= session('errors.user');?> </p>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="password">Nueva contraseña *:</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="<?= old('password'); ?>" >
                                    <p id="error-message"><?= session('errors.password');?> </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="telefono">Teléfono:</label>
                                    <input type="text" class="form-control number" id="telefono" name="telefono" placeholder="Teléfono" value="<?= $usuario->telefono; ?>">
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" value="<?= $usuario->email; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cedula">Cédula/Documento:</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Documento" value="<?= $usuario->cedula; ?>">
                                </div>
                            </div>

                            <div class="row col-md-12">
                                <div class="form-group col-md-9">
                                    <label for="direccion">Dirección:</label>
                                    <textarea class="form-control" id="taDireccion" name="direccion" rows="3"><?= $usuario->direccion; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="idroles">Rol:</label>
                                <select class="custom-select form-control" id="idroles" name="idroles">
                                    <option value="" selected>--Seleccionar rol--</option>
                                    <?php
                                        if (isset($roles)) {
                                            foreach ($roles as $key => $rol) {
                                                if ($usuario) {
                                                    if ($rol->id == $usuario->idroles) {
                                                        echo '<option value="'.$rol->id.'" selected>'.$rol->rol.'</option>';
                                                    }else{
                                                        echo '<option value="'.$rol->id.'">'.$rol->rol.'</option>';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                                <p id="error-message"><?= session('errors.idroles');?> </p>
                            </div>
                            <?= form_hidden('id', $usuario->id); ?>
                            <?= form_hidden('password_old', $usuario->password); ?>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"  id="btnGuardar">Actualizar</button>
                            <a href="<?= site_url(); ?>usuarios" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/form-user-edit.js"></script>

