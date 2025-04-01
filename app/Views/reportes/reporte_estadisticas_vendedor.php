<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-estadisticas-vendedor.css">
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
                    <!-- form start -->
                    <form action="<?= site_url().'reporte-estadisticas-vendedor-excel';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-2">
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
                                                    echo '<option value="'.$negocio->id.'" '.set_select('negocio', $negocio->id, false).' >'.$negocio->negocio.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <p id="error-message"><?= session('errors.negocio');?> </p>
                               </div>
                               <div class="form-group col-md-2">
                                <label for="fecha_inicio">Fecha inicio *:</label>
                                    <input 
                                        type="date" 
                                        class="form-control text" 
                                        id="fecha_inicio" 
                                        name="fecha_inicio" 
                                        value="<?= date('Y-m-d'); ?>" 
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
                                        value="<?= date('Y-m-d'); ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.fecha_final');?> </p>
                               </div>
                               <div class="form-group col-md-3">
                                    <label for="negocio">Vendedor:</label>
                                    <select 
                                        class="form-select form-control-border" 
                                        id="vendedor" 
                                        name="vendedor" 
                                    >
                                        <option value="0" selected>--Seleccionar vendedor--</option>
                                        <?php
                                            if (isset($vendedores)) {
                                                foreach ($vendedores as $key => $vendedor) {
                                                    echo '<option value="'.$vendedor->id.'" '.set_select('vendedor', $vendedor->id, false).' >'.$vendedor->nombre.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                    <p id="error-message"><?= session('errors.vendedor');?> </p>
                               </div>
                               <div class="form-group col-md-2">
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
                                                    } else {
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
                                    <th class="col-sm-1">No.</th>
                                    <th class="col-sm-2">FECHA</th>
                                    <th class="col-sm-4">CLIENTE</th>
                                    <th class="col-sm-1">VALOR TOTAL</th>
                                    <th class="col-sm-2">CATEGORIA</th>
                                    <th class="col-sm-2">VENDEDOR</th>
                                    <th class="col-sm-3">VENTA EXTRA</th>
                                </thead>
                                <tbody id='tablaReporte'>
                                    <?php
                                        
                                        use App\Models\BancoModel;
                                        use App\Models\UsuarioModel;
                                        $this->bancoModel = new BancoModel();
                                        $this->usuarioModel = new UsuarioModel();

                                        $num = 1;

                                        if ($res) {
                                            foreach ($res as $key => $resultado) {
                                                $vendedor = $this->usuarioModel->_getNombreUsuario($resultado->vendedor);
                                                echo '<tr>';
                                                echo '<td>'.$num.'</td>';
                                                echo '<td>'.$resultado->fecha.'</td>';
                                                echo '<td>'.$resultado->cliente.'</td>';    
                                                echo '<td>'.$resultado->total.'</td>';
                                                echo '<td>Categoria</td>';

                                                echo '<td>'.$vendedor.'</td>';  

                                                if ($resultado->venta_extra == 1) {
                                                    echo '<td>SI</td>';
                                                } else {
                                                    echo '<td>NO</td>';
                                                }

                                                echo '</tr>';
                                                $num++;
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
                            <a href="<?= site_url(); ?>reporte-estadisticas-vendedor" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/frm-reporte-estadisticas-vendedor.js"></script>

