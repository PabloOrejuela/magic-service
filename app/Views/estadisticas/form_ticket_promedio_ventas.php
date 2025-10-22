<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-ticket-promedio-ventas.css">
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
                    <div class="card-body">
                        <div class="row col-md-12">
                            <div class="form-group col-md-4">
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
                                </select>
                                <p id="error-message"><?= session('errors.negocio');?> </p>
                            </div>
                            <div class="form-group col-md-4">
                            <label for="mes">Mes *:</label>
                                <input 
                                    type="month" 
                                    class="form-control text" 
                                    id="mes" 
                                    name="mes" 
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
                        <button type="button" class="btn btn-primary" id="btnGenerarReporte">Generar reporte</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/cabecera-reportes-mensual.js"></script>
<script src="<?= site_url(); ?>public/js/ticket-promedio.js"></script>

