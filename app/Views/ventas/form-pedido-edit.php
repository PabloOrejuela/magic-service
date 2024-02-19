<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
<?php
    // date_default_timezone_set('America/Guayaquil');
    // $date = date('ymdHis');
    // $cod_pedido = 'P'.$session->id.$date;
    //echo '<pre>'.var_export($cod_pedido, true).'</pre>';exit;
?>
<style>
    #idproducto{
        width: 80px !important;
    }

    #carrito{
        margin: auto;
        padding: auto;
        width: 20px;
    }
</style>
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="col-lg-8 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card" id="form-pedido">
                    <div class="card-header">
                        <h3 class="card-title titulo-form-pedido">
                            <i class="fas fa-chart-pie mr-1"></i>
                            <?= $subtitle; ?> <span style="color:red;">EDITANDO</span>
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body edit-pedido">
                        <div class="tab-content p-0" >
                            <!-- Morris chart - Sales -->
                            <h3><?= $session->cliente;?></h3>
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                                <form action="<?= site_url().'pedido-update';?>" method="post">
                                    <div class="card-body">
                                        <div id="div-pedido">
                                            <label for="cod_pedido">Pedido: </label><span class="span-pedido"><?= $pedido->cod_pedido ?></span>
                                        </div>
                                        <h4 id="mensaje-campos-requeridos">Los campos con asterisco * son obligatorios</h4>
                                        <?= validation_list_errors() ?>
                                        <div class="form-group row">
                                            <label for="fecha" class="col-sm-5 col-form-label">Fecha de entrega *:</label>
                                            <div class="col-sm-6">
                                                <input type="date" class="form-control" id="inputFecha" name="fecha_entrega"  min="<?= date('Y-m-d') ?>" value="<?= $pedido->fecha_entrega;?>">
                                            </div>
                                            <p id="error-message"><?= session('errors.fecha_entrega');?> </p>
                                        </div>
                                        <div class="form-group row">
                                            <label for="horario_entrega" class="col-md-5 col-form-label">Horario de entrega:</label>
                                            <div class="col-md-6">
                                                <select class="form-select form-control-border" id="horario_entrega" name="horario_entrega">
                                                    <option value="0" selected>--Seleccionar horario--</option>
                                                    <?php
                                                        if (isset($horariosEntrega)) {
                                                            foreach ($horariosEntrega as $key => $hora) {
                                                                if ($hora->id < 5 || $hora->id > 24) {
                                                                    if ($hora->id == $pedido->horario_entrega) {
                                                                        echo '<option value="'.$hora->id.'"  style="color: #B82D1B;" selected>'.$hora->hora.' Horario extra</option>';
                                                                    }else{
                                                                        echo '<option value="'.$hora->id.'"  style="color: #B82D1B;">'.$hora->hora.' Horario extra</option>';
                                                                    }
                                                                    
                                                                }else{
                                                                    if ($hora->id == $pedido->horario_entrega) {
                                                                        echo '<option value="'.$hora->id.'" selected>'.$hora->hora.'</option>';
                                                                    }else{
                                                                        echo '<option value="'.$hora->id.'">'.$hora->hora.'</option>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    ?>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="form-group"  style="display: none;">
                                            <label for="nombre">Id Cliente:</label>
                                            <input type="hidden" class="form-control" id="idcliente" name="idcliente" >
                                        </div>
                                        <div class="form-group">
                                            <label for="nombre">Nombre cliente *:</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre cliente" value="<?= $pedido->nombre; ?>"  required>
                                        </div>
                                        <p id="error-message"><?= session('errors.nombre');?> </p>
                                        <div class="form-group">
                                            <label for="documento">Documento:</label>
                                            <input type="text" class="form-control" id="documento" name="documento" placeholder="documento" value="<?= $pedido->documento; ?>" >
                                        </div>
                                        <p id="error-message"><?= session('errors.documento');?> </p>
                                        <div id="cliente"> </div>
                                        <div class="form-group row" id="campo-extra">
                                            <div class="col-md-6 div-celular">
                                                <label for="telefono">Celular 1 *:</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control number" 
                                                    id="telefono" 
                                                    name="telefono" 
                                                    placeholder="Celular" 
                                                    value="<?= $pedido->telefono; ?>"
                                                >
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <label for="telefono">Celular 2:</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control number" 
                                                    id="telefono_2" 
                                                    name="telefono_2" 
                                                    placeholder="Celular" 
                                                    value="<?= $pedido->telefono_2;?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group" id="campo-extra">
                                            <label for="email" >Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="cliente@email.com" value="<?= $pedido->email; ?>">
                                        </div>
                                        <div class="form-group mb-5 mt-5">
                                            <label for="procedencia">Procedencia *:</label>
                                            <select class="form-select form-control-border" id="procedencia" name="procedencia" required>
                                                <option value="0" selected>--Seleccionar--</option>
                                                <?php
                                                    if (isset($procedencias)) {
                                                        foreach ($procedencias as $key => $procedencia) {
                                                            if ($procedencia->id == $pedido->procedencia) {
                                                                echo '<option value="'.$procedencia->id.'" selected>'.$procedencia->procedencia.'</option>';
                                                            }else{
                                                                echo '<option value="'.$procedencia->id.'">'.$procedencia->procedencia.'</option>';
                                                            }
                                                            
                                                        }
                                                    }
                                                ?>
                                                
                                            </select>
                                        </div>

                                        <div class="form-group" id="campo-extra">
                                            <label for="dir_entrega" >Dirección de entrega *:</label>
                                            <input type="dir_entrega" class="form-control" id="dir_entrega" name="dir_entrega" placeholder="Dirección" value="<?= $pedido->dir_entrega; ?>">
                                        </div>
                                        <div class="form-group" id="campo-extra">
                                            <label for="ubicacion" >Ubicación (Mapa) *:</label>
                                            <input type="ubicacion" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicación" value="<?= $pedido->ubicacion; ?>">
                                        </div>
                                        
                                        <div class="form-group mb-3 mt-5">
                                            <label for="vendedor">Vendedor *:</label>
                                            <select class="form-select form-control-border" id="vendedor" name="vendedor" required>
                                                <option value="0" selected>--Seleccionar vendedor--</option>
                                                <?php
                                                    if (isset($vendedores)) {
                                                        foreach ($vendedores as $key => $value) {
                                                            if ($value->id == $pedido->vendedor) {
                                                                echo '<option value="'.$value->id.'" selected>'.$value->nombre.'</option>';
                                                            }else{
                                                                echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
                                                            }
                                                            
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <p id="error-message"><?= session('errors.vendedor');?> </p>
                                        <div class="form-check mb-5">
                                            <?php
                                                if ($pedido->venta_extra == '1') {
                                                    echo '
                                                        <input 
                                                            type="checkbox" 
                                                            class="form-check-input" 
                                                            id="venta_extra" 
                                                            name="venta_extra" 
                                                            value="1"
                                                            checked
                                                        >
                                                    ';
                                                }else{
                                                    echo '
                                                        <input 
                                                            type="checkbox" 
                                                            class="form-check-input" 
                                                            id="venta_extra" 
                                                            name="venta_extra" 
                                                            value="1"
                                                        >
                                                    ';
                                                }
                                            ?>
                                            <label class="form-check-label" for="venta_extra">Venta extra</label>
                                        </div>
                                        <div class="row form-group mb-3 px-2">
                                            <!-- <a href="#" class="nav-link mb-3 link-editar" id="link-edita-producto">Editar producto</a> -->
                                            <table>
                                                <thead>
                                                    <th><label for="producto" class="px-3 lbl-producto">Producto: </label></th>
                                                    <th>Cantidad</th>
                                                    <th></th>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select 
                                                                class="col-md-12 selectpicker" 
                                                                id="idproducto" 
                                                                name="producto"
                                                                data-style="form-control" 
                                                                data-live-search="true" 
                                                            >
                                                            <option value="0" selected>--Seleccionar producto--</option>
                                                            <?php
                                                                if (isset($productos)) {
                                                                    $defaultvalue = 1;
                                                                    foreach ($productos as $key => $value) {
                                                                        echo "<option value='$value->id' >". $value->producto."</option>";
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        </td>
                                                        <td>
                                                            <input 
                                                                type="text" 
                                                                class="form-control inputCant number" 
                                                                id="cant" 
                                                                name="cant"  
                                                                value="1"
                                                            >
                                                        </td>
                                                        <td id="carrito">
                                                            <!-- Ejecuto la función desde href para que no se regrese al inicio de la página -->
                                                            <a href="javascript:agregarProducto(idproducto.value, cant.value, '<?= $pedido->cod_pedido; ?>' )" class="link-opacity-75" id="a">
                                                                <img src="<?= site_url(); ?>public/images/shoppingcart_add.png" alt="agregar" id="img-agregar" />
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <p id="error-message"><?= session('errors.producto');?> </p>
                                        <div class="row mb-2">
                                            <table id="tablaProductos" class="table table-hover table-stripped table-sm table-responsive tablaProductos" width:="100%">
                                                <thead class="thead-light">
                                                    <th>#</th>
                                                    <th>Código</th>
                                                    <th>Producto</th>
                                                    <th>Observación</th>
                                                    <th>Precio</th>
                                                    <th>Cant</th>
                                                    <th width="1%"></th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $numFila = 0;
                                                        if (isset($detalle)) {
                                                            foreach ($detalle as $key => $row) {
                                                                echo '
                                                                <tr id="fila_'.$numFila.'">
                                                                <td>'.$numFila.'</td>
                                                                <td>'.$row->id.'</td>
                                                                <td>'.$row->producto.'</td>
                                                                <td><input type="text" class="form-control" name="observacion_'.$row->idproducto.'" value="'.$row->observacion.'" onchange="observacion('.$row->idproducto. ','.$pedido->cod_pedido.')" id="observa_'.$row->idproducto.'"></td>
                                                                <td><input type="text" class="form-control input-precio" name="precio_'.$row->idproducto.'" value="'.$row->pvp.'" onchange="actualizaPrecio('.$row->idproducto. ','.$pedido->cod_pedido.')" id="precio_'.$row->idproducto.'"></td>
                                                                <td id="cant_'.$row->idproducto.'">'.$row->cantidad.'</td>
                                                                <td><a onclick="eliminaProducto('.$row->idproducto. ','.$pedido->cod_pedido.')" class="borrar">
                                                                            <img src="'.site_url().'public/images/delete.png" width="20" >
                                                                            </a></td>
                                                                </tr>
                                                                ';
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group">
                                            <label for="observaciones" >Observación del pedido:</label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="observaciones" 
                                                name="observaciones" 
                                                placeholder="Observación" 
                                                value="<?= $pedido->observaciones; ?>"
                                            >
                                        </div>
                                        <div class="form-group mb-3 mt-5">
                                            <label for="formas_pago">Forma de pago *:</label>
                                            <select class="form-select form-control-border" id="formas_pago" name="formas_pago" required>
                                                <option value="0" selected>--Seleccionar la forma de pago--</option>
                                                <?php
                                                    if (isset($formas_pago)) {
                                                        foreach ($formas_pago as $key => $forma) {
                                                            if ($forma->id == $pedido->formas_pago) {
                                                                echo '<option value="'.$forma->id.'" selected>'.$forma->forma_pago.'</option>';
                                                            }else{
                                                                echo '<option value="'.$forma->id.'">'.$forma->forma_pago.'</option>';
                                                            }
                                                            
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3 mt-5">
                                            <label for="banco">Institución financiera:</label>
                                            <select class="form-select form-control-border" id="select-banco" name="banco">
                                                <option value="0" selected>--Seleccionar --</option>
                                                <?php
                                                    if (isset($bancos)) {
                                                        foreach ($bancos as $key => $banco) {
                                                            if ($banco->id == $pedido->banco) {
                                                                echo '<option value="'.$banco->id.'" selected>'.$banco->banco.'</option>';
                                                            }else{
                                                                echo '<option value="'.$banco->id.'">'.$banco->banco.'</option>';
                                                            }
                                                            
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="ref_pago" >No. Documento del pago:</label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="ref_pago" 
                                                name="ref_pago" 
                                                placeholder="Número de documento" 
                                                value=""
                                            >
                                        </div>
                                        <div class="form-group row">
                                            <label for="valor_neto" class="col-sm-8 col-form-label">Valor neto:</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor" 
                                                    id="valor_neto" 
                                                    placeholder="0.00" 
                                                    onchange="sumarTotal(this.value);" 
                                                    name="valor_neto"
                                                    value="<?= number_format($pedido->valor_neto, 2) ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="descuento" class="col-sm-8 col-form-label">Descuento (%):</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor" 
                                                    id="descuento" 
                                                    placeholder="0" 
                                                    onchange="sumarTotal()" 
                                                    name="descuento"
                                                    value="<?= $pedido->descuento; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sectores" class="col-md-3 col-form-label">Transporte *:</label>
                                            <select class="form-select form-control-border" id="sectores" name="sectores">
                                                <option value="0" selected>--Seleccionar sector--</option>
                                                <?php
                                                    if (isset($sectores)) {
                                                        foreach ($sectores as $key => $value) {
                                                            if ($value->id == $pedido->idsector) {
                                                                echo '<option value="'.$value->id.'" selected>'.$value->sector.'</option>';
                                                            }else{
                                                                echo '<option value="'.$value->id.'" >'.$value->sector.'</option>';
                                                            } 
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <div class="col-md-4 px-2" id="div-cant">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor" 
                                                    id="transporte" 
                                                    placeholder="0.00" 
                                                    onchange="sumarTotal()" 
                                                    name="transporte"
                                                    value="<?= $pedido->transporte; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="horario_extra" class="col-sm-8 col-form-label">Cargo Horario:</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor"
                                                    id="horario_extra" 
                                                    placeholder="0" 
                                                    onchange="sumarTotal()" 
                                                    name="horario_extra"
                                                    value="<?= $pedido->cargo_horario; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="cargo_domingo" class="col-sm-8 col-form-label">Cargo por entrega domingo:</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor" 
                                                    id="cargo_domingo" 
                                                    placeholder="0" 
                                                    onchange="sumarTotal()" 
                                                    name="cargo_domingo"
                                                    value="<?= $pedido->domingo; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="valor_mensajero_edit" class="col-sm-4 col-form-label">Valor mensajero:</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor" 
                                                    id="valor_mensajero_edit" 
                                                    placeholder="0" 
                                                    style="color:blue;"
                                                    onchange="sumarTotal()" 
                                                    name="valor_mensajero_edit"
                                                    value="<?= $pedido->valor_mensajero_edit; ?>"
                                                >
                                            </div>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor valorImportante" 
                                                    id="valor_mensajero" 
                                                    placeholder="0" 
                                                    onchange="sumarTotal()" 
                                                    name="valor_mensajero"
                                                    value="<?= $pedido->valor_mensajero; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="total" class="col-sm-8 col-form-label">Total:</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor" 
                                                    id="total" 
                                                    placeholder="0.00" 
                                                    onchange="sumarTotal()" 
                                                    name="total"
                                                    value="<?= $pedido->total; ?>"
                                                >
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <?= form_hidden('cod_pedido', $pedido->cod_pedido); ?>
                                        <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div></div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>
<script src="<?= site_url(); ?>public/js/form-pedido.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // window.onbeforeunload = function() {
    //     return "¿Desea recargar la página web?";
    // };
    //import Swal from 'sweetalert2';

    $(document).ready(function(){
        $("#sectores").on('change',function(){
            if($("#sectores").val() !=""){
                valor = $("#sectores").val();
                //console.log(valor);
                $.ajax({
                    type:"GET",
                    dataType:"html",
                    url: "<?php echo site_url(); ?>ventas/get_valor_sector/"+valor,
                    beforeSend: function (f) {
                        //$('#cliente').html('Cargando ...');
                    },
                    success: function(resultado){
                        let dato = JSON.parse(resultado);
                        alertCambioValor()
                        document.getElementById("transporte").value = parseFloat(dato.sector.costo_entrega) + 4
                        sumarTotal()

                    }
                });
            }
        });
    });

    function observacion(idproducto, cod_pedido){
        let observacion = document.getElementById("observa_"+idproducto).value
        //console.log(observacion);
        if (observacion != null && observacion != '') {

            $.ajax({
                url: '<?php echo base_url(); ?>ventas/detalle_pedido_insert_observacion_temp/' + idproducto + '/' + cod_pedido+'/'+observacion,
                success: function(resultado){
                    if (resultado == 0) {

                    }else{
                        //Exito
                        let detalle = JSON.parse(resultado);

                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);
                            $("#valor_neto").val(detalle.subtotal);

                            document.getElementById("cant").value = 1;
                            document.getElementById("idproducto").selectedIndex = 0;
                            calculaValorNeto(cod_pedido);
                            sumarTotal()
                        }
                    }
                }
            });
            
        }
    }

    function actualizaPrecio(idproducto, cod_pedido){
        let precio = document.getElementById("precio_"+idproducto).value
        let cant = document.getElementById("cant_"+idproducto).innerHTML
        //console.log(cant);
        if (precio != null && precio != '') {

            $.ajax({
                url: '<?php echo base_url(); ?>ventas/detalle_pedido_update_precio_temp/' + idproducto + '/' + cod_pedido+'/'+precio+'/'+cant,
                success: function(resultado){
                    if (resultado == 0) {

                    }else{
                        //Exito
                        let detalle = JSON.parse(resultado);
                        //console.log(resultado);
                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);
                            $("#valor_neto").val(detalle.subtotal);

                            document.getElementById("cant").value = 1;
                            document.getElementById("idproducto").selectedIndex = 0;
                            calculaValorNeto(cod_pedido);
                            sumarTotal()
                        }
                    }
                }
            });
            
        }
    }

    $(document).ready(function(){
        $("#horario_entrega").on('change',function(){
            if($("#horario_entrega").val() !=""){
                valor = $("#horario_entrega").val();
                //console.log(valor);
                $.ajax({
                    type:"GET",
                    dataType:"html",
                    url: "<?php echo site_url(); ?>ventas/get_costo_horario/"+valor,
                    data:"horario="+valor,
                    beforeSend: function (f) {
                        //$('#cliente').html('Cargando ...');
                    },
                    success: function(res){
                        
                        let data = JSON.parse(res);
                        //console.log(data.costo);
                        alertCambioValor()
                        document.getElementById("horario_extra").value = parseFloat(data.costo)
                        sumarTotal()
                    }
                });
            }
        });
    });

    $(document).ready(function(){
        $("#valor_mensajero_edit").on('change',function(){
            if($("#valor_mensajero_edit").val() !=""){
                alertCambioValorMensajero()
            }
        });
    });

    $(document).ready(function(){
        $("#inputFecha").on('change',function(){
            if($("#inputFecha").val() !=""){
                valor = $("#inputFecha").val();
                //console.log(valor);
                diaSemana = getDayOfWeek(valor)
                if (diaSemana == 6) {
                    document.getElementById("cargo_domingo").value = 2
                }else{
                    document.getElementById("cargo_domingo").value = 0
                }
                alertCambioValor()
                sumarTotal()
            }
        });
    });

    $(document).ready(function(){
        $("#telefono").on("change", function() {
            let string = $("#telefono").val();
           
            $("#telefono").val(string.replace(/[^\w]/gi, ''));
        });
    });

    $(document).ready(function(){
        $("#telefono_2").on("change", function() {
            let string = $("#telefono_2").val();
           
            $("#telefono_2").val(string.replace(/[^\w]/gi, ''));
        });
    });

    function agregarProducto(idproducto, cantidad, cod_pedido){
        
        //let dia = getDayOfWeek();
        if (idproducto != null && idproducto != 0 && idproducto > 0) {
            
            $.ajax({
                url: '<?php echo base_url(); ?>ventas/detalle_pedido_insert_temp/' + idproducto + '/' + cantidad + '/' + cod_pedido,
                success: function(resultado){
                    if (resultado == 0) {
                    }else{
                        alertAgregaProducto()
                        //Exito
                        //console.log(`Se insertó el producto`);
                        let detalle = JSON.parse(resultado);

                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);
                            document.getElementById('valor_neto').value = detalle.total
                            document.getElementById("cant").value = 1;
                            document.getElementById("idproducto").selectedIndex = 0;
                            // let selectProductos = document.getElementById("idproducto");
                            // selectProductos.value = 0;

                        }
                        
                    }
                }
            });
            //console.log(cod_pedido);
            
        }
        calculaValorNeto(cod_pedido);
        sumarTotal()
        
    }

    function eliminaProducto(idproducto, cod_pedido){

        if (idproducto != null && idproducto != 0 && idproducto > 0) {

            $.ajax({
                url: '<?php echo base_url(); ?>ventas/detalle_pedido_delete_producto_temp/' + idproducto + '/' + cod_pedido,
                success: function(resultado){
                    if (resultado == 0) {

                    }else{
                        //Exito
                        //console.log("Se eliminó el producto");
                        let detalle = JSON.parse(resultado);

                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);
                            $("#valor_neto").val(detalle.subtotal);

                            document.getElementById("cant").value = 1;
                            let selectProductos = document.getElementById("idproducto");
                            alertEliminaProducto()
                            selectProductos.value = 0;
                        }else{
                            console.log("Error");
                        }
                        
                    }
                }
            });
            
        }
        calculaValorNeto(cod_pedido);
        sumarTotal()
    }

    
    const alertAgregaProducto = () => {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "El producto se ha agregado",
            showConfirmButton: false,
            timer: 1200
        });
    }

    const alertEliminaProducto = () => {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "El producto se ha eliminado",
            showConfirmButton: false,
            timer: 1200
        });
    }

    const alertCambioValor = () => {
        const toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2500,
            //timerProgressBar: true,
            height: '200rem',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                // container: '...',
                popup: 'popup-class',
                // header: '...',
                // title: '...',
                // closeButton: '...',
                // icon: '...',
                // image: '...',
                // htmlContainer: '...',
                // input: '...',
                // inputLabel: '...',
                // validationMessage: '...',
                // actions: '...',
                // confirmButton: '...',
                // denyButton: '...',
                // cancelButton: '...',
                // loader: '...',
                // footer: '....',
                // timerProgressBar: '....',
                }
        });
        toast.fire({
            position: "top-end",
            icon: "warning",
            title: "Se ha realizado un cambio que puede haber alterado el valor final del pedido"
        });
    }

    const alertCambioValorMensajero = () => {
        const toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            height: '200rem',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                // container: '...',
                popup: 'popup-class',
                // header: '...',
                // title: '...',
                // closeButton: '...',
                // icon: '...',
                // image: '...',
                // htmlContainer: '...',
                // input: '...',
                // inputLabel: '...',
                // validationMessage: '...',
                // actions: '...',
                // confirmButton: '...',
                // denyButton: '...',
                // cancelButton: '...',
                // loader: '...',
                // footer: '....',
                // timerProgressBar: '....',
                }
        });

        toast.fire({
            icon: "success",
            title: "Se ha cambiado el valor del mensajero"
        });
    }


    function limpiarValores(valor) {
        var valor = 0
        document.getElementById("idproducto").selectedIndex = 2;
        document.getElementById('descuento').value = valor;
        document.getElementById('transporte').value = valor.toFixed(2);
        document.getElementById('total').value = valor.toFixed(2);
    }

    function descontar(valor) {
        var total = 0;
        var descuento = 0;
        valor = valor.replace(/,/g, '.')
        valor = parseFloat(valor); // Convertir el valor a un float (número).

        total = document.getElementById('total').value;

        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
        total = (total == null || total == undefined || total == "") ? 0 : total;

        /* Este es el cálculo. */
        descuento = (parseFloat(total) * parseFloat(valor))/100
        total = (parseFloat(total) - parseFloat(descuento));
        // console.log("Valor: " + valor);
        // console.log("Descuento: " +descuento);
        document.getElementById('total').value = total.toFixed(2);
        sumarTotal()
    }

    function sumarTotal() {

        let descuento = 0
        let total = 0
        let subtotal = 0
        let porcentajeDescuento = 0
        let transporte = 0
        let cargoDomingo = 0
        let horarioExtra = 0
        let valorMensajeroEdit = 0
        let valorMensajero = 0
        //limpiarValores()
        

        //Obtengo todos los valores de las casillas
        subtotal = document.getElementById('valor_neto').value
        porcentajeDescuento = document.getElementById('descuento').value
        transporte = document.getElementById('transporte').value
        cargoDomingo = document.getElementById('cargo_domingo').value
        horarioExtra = document.getElementById('horario_extra').value
        valorMensajero = document.getElementById('valor_mensajero').value
        valorMensajeroEdit = document.getElementById('valor_mensajero_edit').value

        

        if (isNaN(parseFloat(subtotal)) == true ) {
            subtotal = 0
        }
        
        if (isNaN(parseFloat(porcentajeDescuento)) == true ) {
            porcentajeDescuento = 0
        }

        if (isNaN(parseFloat(transporte)) == true) {
            transporte = 0
        }

        if (isNaN(parseFloat(cargoDomingo)) == true) {
            cargoDomingo = 0
        }

        if (isNaN(parseFloat(horarioExtra)) == true) {
            horarioExtra = 0
        }
        
        

        if (porcentajeDescuento != 0) {
            descuento = (parseFloat(subtotal) * parseFloat(porcentajeDescuento))/100
        }else{
            descuento = 0
        }
        
        total = subtotal - descuento
        valorMensajero = parseFloat(cargoDomingo) + parseFloat(transporte) + parseFloat(horarioExtra)
        
        // /* Este es el cálculo. */
        if (valorMensajeroEdit != 0 && valorMensajeroEdit != '') {
            total = (parseFloat(total) + parseFloat(valorMensajeroEdit));
        }else{
            total = (parseFloat(total) + parseFloat(valorMensajero));
        }
        
        document.getElementById('total').value = total.toFixed(2);

        document.getElementById('valor_mensajero').value = valorMensajero

    }


    function getDayOfWeek(fechaEntrega){
        let ahora = new Date(fechaEntrega);
        let diaSemana = ahora.getDay();
        return diaSemana;
    }

    function calculaValorNeto(cod_pedido) {

        let total = 0;
        $.ajax({
            type:"GET",
            dataType:"html",
            url: "<?php echo site_url(); ?>ventas/getDetallePedido_temp/"+cod_pedido,
            success: function(resultado){
                let detalle = JSON.parse(resultado);
                //console.log("Detalle: " + detalle.subtotal);
                document.getElementById('valor_neto').value = detalle.subtotal.toFixed(2);
                sumarTotal()
            }
        });
    }
   
    /* Multiple Item Picker */
    $('.selectpicker').selectpicker({
        style: 'btn-default'
    });

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>