<link rel="stylesheet" href="<?= site_url(); ?>public/css/form_sector_entrega_new.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                     
                    <form action="<?= site_url().'sector-entrega-insert';?>" method="post">
                        <div class="card-body">
                            <div class="form-group col-md-7">
                                <label for="sucursal">Sector de entrega:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="sector-entrega" 
                                    name="sector_entrega" 
                                    placeholder="Ingrese un nuevo sector de entrega" 
                                    value="<?= old('sector_entrega'); ?>"
                                    required
                                >
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="direccion">Costo:</label>
                                <input 
                                    type="text"
                                    pattern="^\d+(\.\d{1,2})?$" 
                                    class="form-control" 
                                    id="costo-entrega" 
                                    name="costo_entrega" 
                                    placeholder="0.00"
                                    oninput="formatCurrency(this)" onblur="formatCurrency(this)"
                                    value="<?= old('costo_entrega'); ?>"
                                    required
                                >
                            </div>
                            <div class="col-md-4"> 
                                <label for="direccion">Sucursal que atenderá los pedidos de este sector:</label>
                                <select class="form-select" aria-label="Select sucursales" name="idsucursal" id="sucursal">
                                    <option value="">Seleccione una sucursal:</option>
                                    <?php 
                                        if (isset($sucursales) && $sucursales != NULL) {
                                            foreach ($sucursales as $sucursal){
                                                echo '<option value="'.$sucursal->id.'">'.$sucursal->sucursal.'</option>';
                                            } 
                                        }else{
                                            echo '<option value="0">No hay datos</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Registrar</button>
                            <a href="<?= site_url(); ?>sectores-entrega" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                            <div id="div-errors">
                                <p id="error-message"><?= session('errors.sector_entrega');?> </p>
                                <p id="error-message"><?= session('errors.costo_entrega');?> </p>
                                <p id="error-message"><?= session('errors.idsucursal');?> </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="<?= site_url(); ?>public/js/form-sector-entrega-new.js"></script>

