<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-estadisticas-vendedor.css">
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
                    <form action="<?= site_url().'reporte-mensajeria';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-2">
                                    <label for="negocio">Negocio: </label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="negocio" 
                                        name="negocio" 
                                    >
                                        <option value="0" selected>--Mostrar todos--</option>
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
                                    <label for="mensajero">Mensajero:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="mensajero" 
                                        name="mensajero" 
                                    >
                                        <option value="0" selected>--Seleccionar mensajero--</option>
                                        <?php
                                            if (isset($mensajeros)) {
                                                foreach ($mensajeros as $key => $mensajero) {

                                                    if ($session->idroles >= 5) {
                                                        echo '<option value="'.$mensajero->id.'" '.set_select('mensajero', $mensajero->id, false).' selected>'.$mensajero->nombre.'</option>';
                                                    }else{
                                                        echo '<option value="'.$mensajero->id.'" '.set_select('mensajero', $mensajero->id, false).'>'.$mensajero->nombre.'</option>';
                                                    }
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                                    <p id="error-message"><?= session('errors.mensajero');?> </p>
                               </div>
                               <div class="form-group col-md-2">
                                <label for="fecha_inicio">Fecha inicio *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_inicio" 
                                        name="fecha_inicio" 
                                        value="<?= old('fecha_inicio'); ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha_inicio');?> </p>
                               </div>
                               <div class="form-group col-md-2">
                                <label for="fecha_final">Fecha final *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_final" 
                                        name="fecha_final" 
                                        value="<?= old('fecha_final'); ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha_final');?> </p>
                               </div>
                               <div class="form-group col-md-2">
                                    <label for="sugest">Más fechas:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="sugest" 
                                        name="sugest" 
                                    >
                                        <option value="0" selected>--Opciones--</option>
                                        <?php
                                            if (isset($sugest)) {
                                                foreach ($sugest as $key => $value) {
                                                    echo '<option value="'.$key.'" >'.$value.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                               </div>
                            </div>
                        </div>
                        
                        <!-- /.card-body -->                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Generar reporte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/cabecera-reportes.js"></script>

