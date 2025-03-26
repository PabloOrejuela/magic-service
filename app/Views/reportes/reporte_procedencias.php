<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-procedencia.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-7">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'reporte-procedencias-excel';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-3">
                                    <label for="negocio">Negocio:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="negocio" 
                                        name="negocio" 
                                    >
                                        <option value="0" selected>--Opciones--</option>
                                        <?php
                                            if (isset($negocios)) {
                                                foreach ($negocios as $key => $negocio) {
                                                    if ($negocio->id == $datos['negocio']) {
                                                        echo '<option value="'.$negocio->id.'" selected>'.$negocio->negocio.'</option>';
                                                    }else{
                                                        echo '<option value="'.$negocio->id.'">'.$negocio->negocio.'</option>';
                                                    }
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                               </div>
                               <div class="form-group col-md-3">
                                <label for="fecha_inicio">Fecha inicio *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_inicio" 
                                        name="fecha_inicio" 
                                        value="<?= $datos['fecha_inicio']; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha_inicio');?> </p>
                               </div>
                               <div class="form-group col-md-3">
                                <label for="fecha_final">Fecha final *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_final" 
                                        name="fecha_final" 
                                        value="<?= $datos['fecha_final']; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha_final');?> </p>
                               </div>
                               <div class="form-group col-md-3">
                                    <label for="sugest">Opciones:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="sugest" 
                                        name="sugest" 
                                    >
                                        <option value="0" selected>--Opciones--</option>
                                        <?php
                                            if (isset($sugest)) {
                                                foreach ($sugest as $key => $value) {
                                                    if ($key == $datos['sugest']) {
                                                        echo '<option value="'.$key.'" selected>'.$value.'</option>';
                                                    }else{
                                                        echo '<option value="'.$key.'" >'.$value.'</option>';
                                                    }
                                                    
                                                }
                                            }
                                        ?>
                                    </select>
                               </div>
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row col-md-12">
                                <table class="table table-striped mt-3" id="table-resultados">
                                <thead >
                                    <th class="col-sm-2">FECHA</th>
                                    <th class="col-sm-4">CLIENTE</th>
                                    <th class="col-sm-2">VALOR TOTAL</th>
                                    <th class="col-sm-2">PROCEDENCIA</th>
                                    <th class="col-sm-2">NEGOCIO</th>
                                </thead>
                                <tbody id='tablaReporte'>
                                    <?php
                                        if ($res) {
                                            foreach ($res as $key => $resultado) {
                                                echo '<tr>';
                                                echo '<td>'.$resultado->fecha.'</td>';
                                                echo '<td>'.$resultado->cliente.'</td>';
                                                echo '<td>'.$resultado->total.'</td>';

                                                if ($resultado->procedencia == 'Seleccionar procedencia') {
                                                    echo '<td>Indeterminada</td>';
                                                }else{
                                                    echo '<td>'.$resultado->procedencia.'</td>';
                                                }
                                                
                                                echo '<td>'.$resultado->negocio.'</td>';
                                                echo '</tr>';
                                            }
                                        }

                                        //echo form_hidden('my_array', 5);
                                    ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar" target="_self">Descargar reporte en excel</button>
                            <a href="<?= site_url(); ?>reporte-procedencias" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/frm-reporte-procedencias.js"></script>

