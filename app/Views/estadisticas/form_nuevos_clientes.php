<link rel="stylesheet" href="<?= site_url(); ?>public/css/form_cod_arreglo_vendido.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="<?= site_url().'clientes-frecuentes';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-3">
                                    <label for="negocio">Negocio:</label>
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
                                                    echo '<pre>'.var_export(date('Y', strtotime($data['anios'][0]->fecha)), true).'</pre>';exit;
                                    </select>
                                    <p id="error-message"><?= session('errors.negocio');?> </p>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="anio">Año:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="anio" 
                                        name="anio"
                                    >
                                        <option value="0" selected>-- Opciones --</option>
                                        <?php
                                            if (isset($anios)) {
                                                foreach ($anios as $key => $anio) {
                                                    echo '<option value="'.$anio->anio.'" '.set_select('anio', $anio->anio, false).' >'.$anio->anio.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="mes">Mes:</label>
                                    <input 
                                        type="month" 
                                        class="form-control text" 
                                        id="fecha" 
                                        name="fecha" 
                                        value="<?= date('Y-m'); ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.mes');?> </p>
                                </div>
                            </div>
                            <div id="result"></div>
                        </div>
                        <!-- /.card-body -->                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGenerarReporte">Generar reporte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/cabecera-reportes-mensual.js"></script>
<script src="<?= site_url(); ?>public/js/form_cod_arreglo_vendido.js"></script>

