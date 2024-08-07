<style>
    #error-message{
        color: red;
    }
    .content{
        margin-bottom: 100px;
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
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'user-insert';?>" method="post" id="form-usuario">
                        <div class="card-body col-md-12">
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= old('nombre'); ?>" >
                                    <p id="error-message"><?= session('errors.nombre');?> </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="user">Usuario:</label>
                                    <input type="text" class="form-control" id="user" name="user" placeholder="Nombre de usuario" value="<?= old('user'); ?>">
                                    <p id="error-message"><?= session('errors.user');?> </p>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="password">Contraseña:</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="<?= old('password'); ?>" >
                                    <p id="error-message"><?= session('errors.password');?> </p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cedula">Cédula/Documento:</label>
                                    <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Documento" value="<?= old('cedula'); ?>">
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label for="telefono">Teléfono:</label>
                                    <input type="text" class="form-control number" id="telefono" name="telefono" placeholder="Teléfono" value="<?= old('telefono'); ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="email@email.com" value="<?= old('email'); ?>">
                                </div>
                            </div>
                            
                            <div class="row col-md-12">
                                <div class="form-group col-md-9">
                                    <label for="direccion">Dirección:</label>
                                    <textarea class="form-control" id="taDireccion" name="direccion" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label for="idroles">Rol:</label>
                                <select class="custom-select form-control" id="idroles" name="idroles">
                                    <option value="" selected>--Seleccionar rol--</option>
                                    <?php
                                        if (isset($roles)) {
                                            foreach ($roles as $key => $rol) {
                                                echo '<option value="'.$rol->id.'">'.$rol->rol.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <p id="error-message"><?= session('errors.idroles');?> </p>
                            </div>
                            
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"  id="btnGuardar">Guardar</button>
                            <a href="<?= site_url(); ?>usuarios" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/form-user-new.js"></script>