<link rel="stylesheet" href="<?= site_url(); ?>public/css/form-sucursal-sector.css">
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
                        <div class="card-body">
                            <div class="form-group col-md-7">
                                <h3>Sucursal: <?= isset($sucursal) ? $sucursal->sucursal : ''; ?></h3>
                            </div>
                            <div class="form-group col-md-7 mb-3 row">
                                <label for="direccion">Sector:</label>
                                <div class="col-md-4"> 
                                    <select class="form-select" aria-label="Select sectores" name="sector" id="select-sector">
                                        <option value="">Seleccione un sector</option>
                                        <?php
                                            foreach ($sectores as $key => $sector) {
                                                echo '<option value="'.$sector->id.'">'.$sector->sector.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">      
                                    <a href="#" class="btn btn-agregar" id="btn-agregar">
                                        <img src="<?= site_url(); ?>public/images/btn-agregar.png" alt="agregar" id="img-agregar"/> Agregar
                                    </a>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped" id="tablaSectores">
                                <thead>
                                    <th colspan="3">Sectores asignados a la sucursal:  <?= isset($sucursal) ? $sucursal->sucursal : ''; ?></th>
                                </thead>
                                <thead>
                                    <th>Id.</th>
                                    <th>Sector</th>
                                    <th></th>
                                </thead>
                                <tbody id="tb-sectores">
                                    <?php if (isset($sectoresSucursal)): ?>
                                        <?php foreach ($sectoresSucursal as $sector): ?>
                                            <tr>
                                                <td><?= $sector->id; ?></td>
                                                <td><?= $sector->sector; ?></td>
                                                <td>
                                                    <?php
                                                        if ($sucursal->id != 4) {
                                                            echo '<a href="../eliminaSectorSucursal/'.$sector->id.'/'.$sucursal->id.'" id="link-editar">
                                                                <img src="'.site_url().'public/images/delete.png" class="img-thumbnail" alt="Quitar">
                                                            </a>';
                                                        }else{
                                                            echo '<a href="../eliminaSectorSucursal/'.$sector->id.'/'.$sucursal->id.'" id="link-editar">
                                                                <img src="'.site_url().'public/images/delete.png" class="img-thumbnail" alt="Quitar">
                                                            </a>';
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">      
                            <input type="hidden" id="idsucursal" name="idsucursal" value="<?= isset($sucursal) ? $sucursal->id : ''; ?>">
                            <a href="<?= site_url(); ?>sucursales" class="btn btn-light" id="btn-cancela">Atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/form-sucursal-sector.js"></script>

