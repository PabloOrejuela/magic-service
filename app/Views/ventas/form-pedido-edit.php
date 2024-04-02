<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/css/edit-pedido-styles.css">

<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="col-lg-8  connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card" id="form-pedido">
                    <div class="card-header">
                        <h3 class="card-title titulo-form-pedido">
                            <i class="fas fa-chart-pie mr-1"></i>
                            <?= $subtitle.' Este form está en proceso';?>
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0" >
                            <!-- Morris chart - Sales -->
                            <h3><?= $session->cliente;?></h3>
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                                <form action="<?= site_url().'pedido-update';?>" method="post">
                                    
                                        <div id="div-pedido">
                                            <label for="cod_pedido">Pedido: </label><span class="span-pedido"><?= $pedido->cod_pedido; ?></span>
                                        </div>
                                        <h4 id="mensaje-campos-requeridos">Los campos con asterisco * son obligatorios</h4>
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
                                                                if ($hora->id == $pedido->horario_entrega) {
                                                                    if ($hora->id < 5 || $hora->id > 24) {
                                                                            echo '<option 
                                                                                    value="'.$hora->id.'" 
                                                                                    '.set_select('vendedor', $hora->id, false).' 
                                                                                    id="horario-extra-red"
                                                                                    selected
                                                                                >'.$hora->hora.' Horario extra</option>';
                                                                    }else{
                                                                        echo '<option 
                                                                                    value="'.$hora->id.'" 
                                                                                    '.set_select('vendedor', $hora->id, false).' 
                                                                                    id="horario-extra-black"
                                                                                    selected
                                                                                >'.$hora->hora.' Horario extra</option>';
                                                                    }
                                        
                                                                }else{
                                                                    if ($hora->id < 5 || $hora->id > 24) {
                                                                        echo '<option 
                                                                                value="'.$hora->id.'" 
                                                                                '.set_select('vendedor', $hora->id, false).' 
                                                                                id="horario-extra-red"
                                                                                
                                                                            >'.$hora->hora.' Horario extra</option>';
                                                                    }else{
                                                                        echo '<option 
                                                                                value="'.$hora->id.'" 
                                                                                '.set_select('vendedor', $hora->id, false).' 
                                                                                id="horario-extra-black"
                                                                            >'.$hora->hora.' Horario extra</option>';
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
                                            <input type="hidden" class="form-control" id="idcliente" name="idcliente" value="<?= $pedido->idcliente; ?>"  >
                                        </div>
                                        <p id="error-message"><?= session('errors.idcliente');?> </p>
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
                                                    value="<?= $pedido->telefono_2; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group" id="campo-extra">
                                            <label for="email" >Email:</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="cliente@email.com" value="<?= $pedido->email; ?>">
                                        </div>
                                        <div class="form-group mt-2 mb-3">
                                            <a href="javascript:limpiaCamposCliente()" class="nav-link mb-3" id="link-clear-fields">Limpiar campos</a>
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
                                            <input 
                                                type="dir_entrega" 
                                                class="form-control" 
                                                id="dir_entrega" 
                                                name="dir_entrega" 
                                                placeholder="Dirección" 
                                                value="<?= $pedido->dir_entrega; ?>"
                                            >
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
                                        <div class="form-group row">
                                            <!-- <a href="#" class="nav-link mb-3 link-editar" id="link-edita-producto">Editar producto</a> -->
                                            <div class="col-md-2" style="display:none;">
                                                <input 
                                                    type="text"
                                                    class="form-control" 
                                                    id="idp" 
                                                    name="idp"
                                                >
                                            </div>
                                            <div class="col-md-8">
                                                <label for="producto">Producto:</label>
                                                <input 
                                                    type="text"
                                                    class="form-control" 
                                                    id="idproducto" 
                                                    name="producto"
                                                >
                                            </div>
                                            <div class="col-md-3">
                                                <label for="cant">Cantidad:</label> 
                                                <input 
                                                    type="text" 
                                                    class="form-control inputCant number" 
                                                    id="cant" 
                                                    name="cant"  
                                                    value="1"
                                                >
                                            </div>
                                            <div class="col-md-1">
                                                <label for="telefono"> </label> 
                                                <!-- Ejecuto la función desde href para que no se regrese al inicio de la página -->
                                                <a href="javascript:agregarProducto(idp.value, cant.value, '<?= $pedido->cod_pedido; ?>' )" class="btn btn-carrito">
                                                    <img src="<?= site_url(); ?>public/images/shoppingcart_add.png" alt="agregar"/>
                                                </a>
                                            </div>
                                        </div>
                                        <p id="error-message"><?= session('errors.producto');?> </p>
                                        <div class="row mb-2">
                                            <table id="tablaProductos" class="table table-stripped table-sm table-responsive tablaProductos" width:="100%">
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
                                                                <td>'.$row->iddetalle.'</td>
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
                                        
                                        <div class="form-group row">
                                            <label for="valor_neto" class="col-sm-8 col-form-label">Valor neto:</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor valorImportante decimal" 
                                                    id="valor_neto" 
                                                    placeholder="0.00" 
                                                    onchange="sumarTotal(this.value);" 
                                                    name="valor_neto"
                                                    value="<?= $pedido->valor_neto; ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="descuento" class="col-sm-8 col-form-label">Descuento (%):</label>
                                            <div class="col-sm-4">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor decimal" 
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
                                            <select class="form-select col-md-4 px-2 mx-2" id="sectores" name="sectores">
                                                <option value="0" selected>--Seleccionar sector--</option>
                                                <?php
                                                    if (isset($sectores)) {
                                                        foreach ($sectores as $key => $sector) {
                                                            if ($sector->id == $pedido->idsector) {
                                                                echo '<option value="'.$sector->id.'" selected>'.$sector->sector.'</option>';
                                                            }else{
                                                                echo '<option value="'.$sector->id.'">'.$sector->sector.'</option>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <div class="col-md-4" style="margin-rigth:0px;">
                                                <input 
                                                    type="text" 
                                                    class="form-control inputValor div-cant decimal" 
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
                                                    class="form-control inputValor decimal"
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
                                                    class="form-control inputValor decimal" 
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
                                                    class="form-control inputValor cant decimal" 
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
                                                    class="form-control inputValor valorImportante decimal" 
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
                                                    class="form-control inputValor decimal" 
                                                    id="total" 
                                                    placeholder="0.00" 
                                                    onchange="sumarTotal()" 
                                                    name="total"
                                                    value="<?= $pedido->total ?>"
                                                >
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 mt-2">
                                            <label for="vendedor">Mensajero *:</label>
                                            <select class="form-select form-control-border" id="vendedor" name="vendedor" required>
                                                <option value="0" selected>--Seleccionar mensajero--</option>
                                                <?php
                                                    if (isset($mensajeros)) {
                                                        foreach ($mensajeros as $key => $mensajero) {
                                                            if ($mensajero->id == $pedido->mensajero) {
                                                                echo '<option value="'.$mensajero->id.'" selected>'.$mensajero->nombre.'</option>';
                                                            }else{
                                                                echo '<option value="'.$mensajero->id.'">'.$mensajero->nombre.'</option>';
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group mb-3 mt-5">
                                            <h4 class="mt-3">Información financiera</h4>
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
                                        
                                        <div class="form-group mb-3 mt-2" id="div-bancos">
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
                                                value="<?= $pedido->ref_pago; ?>"
                                            >
                                        </div>

                                        <div class="form-group row">
                                            <p id="error-message"><?= session('errors.sectores');?> </p>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="form-group row">
                                            <input 
                                                type="hidden" 
                                                class="form-control inputValor" 
                                                id="cod_pedido" 
                                                name="cod_pedido"
                                                value="<?= $pedido->cod_pedido;; ?>"
                                            >
                                            <input 
                                                type="hidden" 
                                                class="form-control inputValor" 
                                                id="cant_arreglos" 
                                                name="cant_arreglos"
                                            >
                                        </div>
                                        <div class="card-footer mt-3">
                                            <button type="submit" class="btn btn-primary" >Enviar</button>
                                            <a href="<?= site_url(); ?>pedidos" class="btn btn-light" id="btn-cancela">Cancelar</a>
                                        </div>           
                                </form>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>
<script src="<?= site_url(); ?>public/js/form-edit-pedido.js"></script>
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    $(document).ready(function(){
        $("#documento").on('change',function(){
            if($("#documento").val() != ""){
                valor = document.querySelector("#documento").value
                //console.log(valor);
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url: "ventas/clientes_select",
                    data:"documento="+valor,
                    beforeSend: function (f) {
                        //$('#cliente').html('Cargando ...');
                    },
                    success: function(data){
                        let cliente = JSON.parse(data);
                        
                        document.getElementById('nombre').value = cliente.nombre
                        document.getElementById('telefono').value = cliente.telefono
                        document.getElementById('documento').value = cliente.documento
                        document.getElementById('email').value = cliente.email
                        document.getElementById('idcliente').value = cliente.id
                    },
                    error: function(data){
                        console.log("No existe el cliente");
                    }
                });
            }
        });
    });

    $(document).ready(function(){
        $("#sectores").on('change',function(){
            if($("#sectores").val() !=""){
                valor = $("#sectores").val();
                
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

                            limpiaLineaProducto()
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
        
        if (precio != null && precio != '') {

            $.ajax({
                url: '<?php echo base_url(); ?>detalle_pedido_update_precio_temp',
                data: {
                    idproducto: idproducto,
                    cod_pedido: cod_pedido,
                    precio: precio,
                    cant: cant
                },
                success: function(resultado){
                    if (resultado == 0) {

                    }else{
                        //Exito
                        let detalle = JSON.parse(resultado);
                        //console.log(detalle);
                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);
                            $("#valor_neto").val(detalle.subtotal);

                            limpiaLineaProducto()
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
                url: '<?php echo base_url(); ?>detalle_pedido_insert_temp',
                data: {
                    idproducto: idproducto,
                    cantidad: cantidad,
                    cod_pedido: cod_pedido
                },
                success: function(resultado){
                    if (resultado == 0) {
                    }else{
                        alertAgregaProducto()
                        //Exito

                        let detalle = JSON.parse(resultado);
                        
                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);
                            document.getElementById('valor_neto').value = detalle.total
                            limpiaLineaProducto()
                        }
                    }
                }
            });
            
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
    
                        let detalle = JSON.parse(resultado);

                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);
                            $("#valor_neto").val(detalle.subtotal);

                            alertEliminaProducto()
                            limpiaLineaProducto()
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
            //height: '200rem',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                // container: '...',
                popup: 'popup-class',

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
            //height: '200rem',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                // container: '...',
                popup: 'popup-class',

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

    function limpiaLineaProducto() {

        document.getElementById("idproducto").value = '';
        document.getElementById('idp').value = 0;
        document.getElementById('cant').value = 1;
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

        document.getElementById('total').value = total.toFixed(2);
        sumarTotal()
    }

    function calcularMensajero(){
        let sectores = document.getElementById("sectores").value
        let transporte = document.getElementById('transporte').value
        let cargoDomingo = document.getElementById('cargo_domingo').value
        let horarioExtra = document.getElementById('horario_extra').value
        let valorMensajero = document.getElementById('valor_mensajero').value
        let valorMensajeroEdit = document.getElementById('valor_mensajero_edit').value
        let cantProd = document.getElementById("cant_arreglos").value;
        if (isNaN(parseFloat(transporte)) == true) {
            transporte = 0
        }

        if (isNaN(parseFloat(cargoDomingo)) == true) {
            cargoDomingo = 0
        }

        if (isNaN(parseFloat(horarioExtra)) == true) {
            horarioExtra = 0
        }
        let extraMensajero = 0
        let cantProdExtra = (cantProd - 1)

        if (cantProdExtra >= 1) {
            console.log("cant: " + cantProdExtra);
            if (sectores == 1) {
                
                //Se agrega 50% de Transporte mas 50% mas de carga horario mas 50% mas de domingo por cada arreglo extra
                for (let i = 1; i <= cantProdExtra; i++) {
                    extraMensajero += (parseFloat(transporte)*0.5) + (parseFloat(horarioExtra)*0.5) + (parseFloat(cargoDomingo)*0.5)
                }

                valorMensajero = parseFloat(cargoDomingo/2) + parseFloat(transporte) + parseFloat(horarioExtra/2) + extraMensajero

            }else if(sectores > 1){
                
                //Se agrega 35% de Transporte mas 35% mas de carga horario mas 35% mas de domingo por arreglo
                for (let i = 1; i <= cantProdExtra; i++) {
                    extraMensajero += (parseFloat(transporte)*0.35) + (parseFloat(horarioExtra)*0.35) + (parseFloat(cargoDomingo)*0.35)
                    console.log("Trans: " + (parseFloat(transporte)*0.35) );
                    console.log("Horario: " + (parseFloat(horarioExtra)*0.35) );
                    console.log("Domingo: " + (parseFloat(cargoDomingo)*0.35) );
                    console.log(extraMensajero);
                }

                valorMensajero = parseFloat(cargoDomingo/2) + parseFloat(transporte) + parseFloat(horarioExtra/2) + extraMensajero
            }else{
                console.log("No se ha elegio un sector poner una validación");
            }
        } else {
            //Si solo es un arreglo no hay extra
            valorMensajero = parseFloat(cargoDomingo/2) + parseFloat(transporte) + parseFloat(horarioExtra/2)

        }

        // /* Este es el cálculo. */
        if (valorMensajeroEdit != 0 && valorMensajeroEdit != '') {
            total = (parseFloat(total) + parseFloat(valorMensajeroEdit));
        }else{
            total = (parseFloat(total) + parseFloat(valorMensajero));
        }

        document.getElementById('valor_mensajero').value = valorMensajero

    }


    function getDetalletemporal(codigoPedido){
        
        return $.ajax({
            type:"GET",
            dataType:"html",
            url: "ventas/getDetallePedido_temp/"+codigoPedido,
            beforeSend: function (f) {
                //$('#cliente').html('Cargando ...');
            },
            success: function(data){
                // limpiarClienteDocumento();
                let detalle = JSON.parse(data);
                let datos = detalle.datos
                let cant = 0;
                
                for (const i of datos) {
                    cant += parseInt(i.cantidad)
                }

                document.getElementById("cant_arreglos").value = cant
            },
            error: function(data){
                console.log("No hay detalle");
            }
        });
        
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
                //console.log("Detalle: " + detalle.cantidad);
                document.getElementById('valor_neto').value = detalle.subtotal.toFixed(2);
                document.getElementById('cant_arreglos').value = detalle.cantidad;
                sumarTotal()
            }
        });
    }

    aData = {}
    
    $('#idproducto').autocomplete({
        source: function(request, response){
            $.ajax({
                url: '<?php echo site_url(); ?>getProductosAutocomplete',
                method: 'GET',
                dataType: 'json',
                data: {
                    producto: request.term
                },
                success: function(res) {

                    aData = $.map(res, function(value, key){
                        return{
                            id: value.id,
                            label: value.producto + ' - ' + value.precio
                        };
                    });
                    let results = $.ui.autocomplete.filter(aData, request.term);
                    response(results)
                }
            });
        },
        select: function(event, ui){
            //document.getElementById('idp').value = 10
            document.getElementById("idp").value = ui.item.id
            //console.log(ui.item.id);
        }
    });

    $(document).ready(function(){
        $(".decimal").on("input", function() {

            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });
    });
</script>

