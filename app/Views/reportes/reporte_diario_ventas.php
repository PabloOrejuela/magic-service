<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-reporte-diario-ventas.css">
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
                    <form action="<?= site_url().'reporte_diario_ventas_excel';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-10">
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
                                <label for="fecha_inicio">Fecha *:</label>
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
                               
                            </div>
                        </div>
                        <div class="card-body mt-2">
                            <div class="row col-md-12">
                                <table class="table table-striped mt-3" id="table-resultados">
                                <thead >
                                    <th class="col-sm-2">No.</th>
                                    <th class="col-sm-2">FECHA</th>
                                    <th class="col-sm-4">CLIENTE</th>
                                    <th class="col-sm-4">BANCO/PLATAFORMA</th>
                                    <th class="col-sm-2">VALOR TOTAL</th>
                                    <th class="col-sm-2">CATEGORIA</th>
                                    <th class="col-sm-2">VENDEDOR</th>
                                    <th class="col-sm-2">VENTA EXTRA</th>
                                    <th class="col-sm-2">OBSERVACION PEDIDO</th>
                                    <th class="col-sm-2">PAGO COMPROBADO</th>
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

                                                if ($resultado->banco != 0) {
                                                    $banco = $this->bancoModel->_getBanco($resultado->banco);
                                                    echo '<td>'.$banco->banco.'</td>';
                                                }else{
                                                    echo '<td>No definido</td>';
                                                }
                                                
                                                echo '<td>'.$resultado->total.'</td>';
                                                echo '<td>Categoria</td>';

                                                echo '<td>'.$vendedor.'</td>';  

                                                if ($resultado->venta_extra == 1) {
                                                    echo '<td>SI</td>';
                                                } else {
                                                    echo '<td>NO</td>';
                                                }
                                                
                                                
                                                echo '<td>'.$resultado->observaciones.'</td>';

                                                if ($resultado->estado == 3 || $resultado->estado == 4) {
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
                            <a href="<?= site_url(); ?>reporte_diario_ventas" class="btn btn-light cancelar" id="btn-cancela" target="_self">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/frm-reporte-diario-ventas.js"></script>

