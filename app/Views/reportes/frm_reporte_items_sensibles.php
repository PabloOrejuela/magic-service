<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm_reporte_items_sensibles.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row col-md-12">
                            <h6 style="font-style: italic;font-size: 0.8em;">NOTA: En caso de no haber seleccionado fecha de incio, fecha final o las dos se toma por defecto la fecha actual como fecha final y el primer día del mes como fecha de inicio</h6>
                            <div class="form-group col-md-5 mt-3">
                            <label for="fecha_inicio">Fecha inicio *:</label>
                                <input 
                                    type="date" 
                                    class="form-control text" 
                                    id="fecha_inicio" 
                                    name="fecha_inicio" 
                                    value="<?= set_value('fecha_inicio'); ?>" 
                                    required
                                >
                                <p id="error-message"><?= session('errors.fecha_inicio');?> </p>
                            </div>
                            <div class="form-group col-md-5 mt-3">
                            <label for="fecha_final">Fecha final *:</label>
                                <input 
                                    type="date" 
                                    class="form-control text" 
                                    id="fecha_final" 
                                    name="fecha_final" 
                                    required
                                >
                                <p id="error-message"><?= session('errors.fecha_final');?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row col-md-12">
                            <table class="table table-striped mt-3" id="table-productos">
                            <thead >
                                <th class="col-sm-1">ID</th>
                                <th class="col-sm-4">Item</th>
                                <th class="col-sm-2" id="label-thead">Unidades necesarias</th>
                            </thead>
                            <tbody id='tablaItemsSensiblesBody'></tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->                        
                    <div class="card-footer">
                        <button 
                            type="submit" 
                            class="btn btn-primary" 
                            id="btnGeneraReporteItemsSensibles" 
                        >Generar reporte</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/frm_reporte_items_sensibles.js"></script>

