<link rel="stylesheet" href="<?= site_url(); ?>/public/css/form-gastos.css">
<section class="content mb-5 frm-gastos">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-7 mb-3 mt-0">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'gasto-update';?>" method="post">
                        <div class="card-body">
                            <h4 id="mensaje-campos-requeridos">Los campos con asterisco * son obligatorios</h4>
                            <div class="form-group col-md-6">
                                <label for="sucursal">Sucursal *:</label>
                                <select 
                                    class="form-select form-control-border" 
                                    id="sucursal" 
                                    name="sucursal" 
                                    required
                                >
                                    <option value="0" selected>--Seleccionar sucursal--</option>
                                    <?php
                                        if (isset($sucursales)) {
                                            foreach ($sucursales as $key => $value) {
                                                if ($gasto) {
                                                    if ($value->id == $gasto->idsucursal) {
                                                        echo '<option value="'.$value->id.'"  selected>'.$value->sucursal.'</option>';
                                                    }else{
                                                        echo '<option value="'.$value->id.'"  >'.$value->sucursal.'</option>';
                                                    }
                                                }
                                            }
                                        }else{
                                            echo '<option value="0" selected>SIN DATOS</option>';
                                        }
                                    ?>
                                </select>
                                <p id="error-message"><?= session('errors.sucursal');?> </p>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="negocio">Negocio *:</label>
                                <select 
                                    class="form-select form-control-border" 
                                    id="negocio" 
                                    name="negocio" 
                                    required
                                >
                                    <option value="0" selected>--Seleccionar negocio--</option>
                                    <?php
                                        if (isset($negocios)) {
                                            foreach ($negocios as $key => $value) {
                                                if ($gasto) {
                                                    if ($value->id == $gasto->idnegocio) {
                                                        echo '<option value="'.$value->id.'"  selected>'.$value->negocio.'</option>';
                                                    }else{
                                                        echo '<option value="'.$value->id.'"  >'.$value->negocio.'</option>';
                                                    }
                                                }
                                            }
                                        }else{
                                            echo '<option value="0" selected>SIN DATOS</option>';
                                        }
                                    ?>
                                </select>
                                <p id="error-message"><?= session('errors.negocio');?> </p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tipo">Tipo de gasto *:</label>
                                <select 
                                    class="form-select form-control-border" 
                                    id="tipo" 
                                    name="tipo" 
                                    disabled
                                >
                                    <option value="0" selected>--Seleccionar tipo de gasto--</option>
                                    <?php
                                    
                                        if (isset($tipos_gasto)) {
                                            foreach ($tipos_gasto as $key => $value) {
                                                if ($value->id == $gasto->idtipogasto) {
                                                    echo '<option value="'.$value->id.'" selected>'.$value->tipo_gasto.'</option>';
                                                }else{
                                                    echo '<option value="'.$value->id.'" >'.$value->tipo_gasto.'</option>';
                                                }
                                            }
                                        }else{
                                            echo '<option value="0" selected>SIN DATOS</option>';
                                        }
                                    ?>
                                </select>
                                <p id="error-message"><?= session('errors.tipo');?> </p>
                            </div>
                            
                            <?php 
                                
                                if ($gasto->idtipogasto == 1) {
                                    echo '
                                        <div class="form-group col-md-6" id="div-proveedores" style="display:block">
                                            <label for="proveedor" class="mb-0">Proveedor *:</label>
                                            <select 
                                                class="form-select form-control-border" 
                                                id="proveedor" 
                                                name="proveedor" 
                                                disabled
                                            >
                                                <option value="0" selected>--Seleccionar proveedor--</option>';
                                                    if (isset($proveedores)) {
                                                        foreach ($proveedores as $key => $value) {
                                                            if ($value->id == $gasto->idproveedor) {
                                                                echo '<option value="'.$value->id.'" selected>'.$value->nombre.'</option>';
                                                            }else{
                                                                echo '<option value="'.$value->id.'" >'.$value->nombre.'</option>';
                                                            }
                                                        }
                                                    }else{
                                                        echo '<option value="0" selected>SIN DATOS</option>';
                                                    }
                                        echo    '</select>
                                            <p id="error-message">'.session('errors.proveedor').'</p>
                                        </div>';
                                }

                                if ($gasto->idtipogasto == 2) {
                                    echo '
                                        <div class="form-group col-md-6" id="div-gastovariable" style="display:block">
                                            <label for="detalleGastoVariable">Gasto variable:</label>
                                            <input 
                                                type="text" 
                                                class="form-control text" 
                                                id="detalleGastoVariable" 
                                                name="detalleGastoVariable" 
                                                placeholder="Detalle gasto variable" 
                                                value="'.$gasto->detalleGastoVariable.'" 
                                                readonly
                                            >
                                            <p id="error-message">'.session('errors.detalleGastoVariable').'</p>
                                        </div>';
                                }

                                if ($gasto->idtipogasto == 3) {
                                    echo '
                                        <div class="form-group col-md-6" id="div-gastofijo" style="display:block">
                                            <label for="gastofijo">Gasto fijo *:</label>
                                            <select 
                                                class="form-select form-control-border" 
                                                id="gastofijo" 
                                                name="gastofijo" 
                                                disabled
                                            >
                                                <option value="0" selected>--Seleccionar proveedor--</option>';
                                                    if (isset($gastos_fijos)) {
                                                        foreach ($gastos_fijos as $key => $gastoFijo) {
                                                            if ($gastoFijo->id == $gasto->gastofijo) {
                                                                echo '<option value="'.$gastoFijo->id.'" selected>'.$gastoFijo->gasto_fijo.'</option>';
                                                            }else{
                                                                echo '<option value="'.$gastoFijo->id.'" >'.$gastoFijo->gasto_fijo.'</option>';
                                                            }
                                                        }
                                                    }else{
                                                        echo '<option value="0" selected>SIN DATOS</option>';
                                                    }
                                            echo    '</select>
                                                <p id="error-message">'.session('errors.gastofijo').'</p>
                                            </div>';
                                }
                            ?>
                            <div class="form-group col-md-4">
                                <label for="fecha">Fecha *:</label>
                                <input 
                                    type="date" 
                                    class="form-control text" 
                                    id="fecha" 
                                    name="fecha" 
                                    value="<?= $gasto->fecha; ?>" 
                                    required
                                >
                                <p id="error-message"><?= session('errors.fecha');?> </p>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="documento">No. Documento / Factura:</label>
                                <input 
                                    type="text" 
                                    class="form-control text" 
                                    id="documento" 
                                    name="documento" 
                                    placeholder="Número de documento" 
                                    value="<?= $gasto->documento; ?>"
                                >
                                <p id="error-message"><?= session('errors.documento');?> </p>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="valor">Valor pagado *:</label>
                                <input 
                                    type="text" 
                                    class="form-control text" 
                                    id="valor" 
                                    name="valor" 
                                    placeholder="Total pagado" 
                                    value="<?= $gasto->valor;?>" 
                                    required
                                >
                                <p id="error-message"><?= session('errors.valor');?> </p>
                            </div>
                        </div>
                        <?= form_hidden('id', $gasto->id); ?>
                        <?= form_hidden('tipo', $gasto->idtipogasto); ?>
                        <!-- /.card-body -->                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Actualizar</button>
                            <a href="<?= site_url(); ?>gastos" class="btn btn-light" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/form-gasto-new.js"></script>
<script>
    $(document).ready(function(){
        $("#celular_contacto").on( "change", function() {
            let string = $("#celular_contacto").val();
           
            $("#celular_contacto").val(string.replace(/[^\w]/gi, ''))
        })
    })

    $(document).ready(function(){
        $("#documento").on( "change", function() {
            let string = $("#documento").val();
           
            $("#documento").val(string.replace(/ /gi, ''))
        })
    })

    $(document).ready(function(){
        $("#valor").on( "change", function() {
            let cadena = $("#valor").val();
            let valor = cadena.replace(/,/g, '.')
            let cantidad = parseFloat(valor);

            $("#valor").val(cantidad.toFixed(2))
        })
    })

//+593 098 292 7991
</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script> -->

