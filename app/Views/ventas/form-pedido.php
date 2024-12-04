<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/css/form-pedido.css">

<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="col-lg-8  connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card" id="form-pedido">
                    <div class="card-header">
                        <h3 class="card-title titulo-form-pedido">
                            <i class="fas fa-table mr-1"></i>
                            <?= $subtitle . ' Revisiones finales de este formulario';?>
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0" >
                            <!-- Morris chart - Sales -->
                            <h3><?= $session->cliente;?></h3>
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                                <form action="<?= site_url().'pedido-insert';?>" method="post">
                                    
                                    <div id="div-pedido">
                                        <label for="cod_pedido">Pedido: </label>
                                        <input 
                                            type="text" 
                                            class="form-control col-4" 
                                            id="cod_pedido" 
                                            name="cod_pedido"
                                            placeholder="<?= $session->codigo_pedido ?>"
                                            maxlength="5"
                                            value="<?= $cod_pedido; ?>"
                                            readonly
                                        >
                                    </div>
                                    <h4 id="mensaje-campos-requeridos">Los campos con asterisco * son obligatorios</h4>
                                    <div class="form-group row">
                                        <label for="fecha" class="col-sm-5 col-form-label">Fecha de entrega *:</label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" id="inputFecha" name="fecha_entrega"  min="<?= date('Y-m-d') ?>" value="<?= old('fecha_entrega')?>">
                                            <p id="error-message"><?= session('errors.fecha_entrega');?> </p>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row mb-5">
                                        <label for="horario_entrega" class="col-md-5 col-form-label">Horario de entrega:</label>
                                        <div class="col-md-6">
                                            <select class="form-select form-control-border" id="horario_entrega" name="horario_entrega">
                                                <?php
                                                    if (isset($horariosEntrega)) {
                                                        foreach ($horariosEntrega as $key => $hora) {
                                                            if ($hora->id == 2) {
                                                                echo '<option value="'.$hora->id.'" '.set_select('horario_entrega', $hora->id, false).' style="color:red;">'.$hora->hora.'</option>';
                                                            }else if ($hora->id == '3') {
                                                                echo '<option value="'.$hora->id.'" selected> -- '.$hora->hora.' -- </option>';
                                                            }else{
                                                                echo '<option value="'.$hora->id.'">'.$hora->hora.'</option>';
                                                            }
                                                        }
                                                    }else{
                                                        echo '<option value="3" selected>HUBO UN PROBLEMA Y NO SE CARGAN LOS HORARIOS </option>';
                                                    }
                                                ?>
                                               
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-5" id="campo-extra">
                                        <div class="col-md-5 div-celular">
                                            <label for="rango-entrega">Desde:</label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="rango-entrega-desde" 
                                                name="rango_entrega_desde" 
                                                placeholder="0:00"
                                                maxlength="100"
                                                value="<?= old('rango_entrega_desde'); ?>"
                                            >
                                        </div>
                                        <div class="col-md-5 div-celular">
                                            <label for="rango-entrega">Hasta:</label>
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="rango-entrega-hasta" 
                                                name="rango_entrega_hasta" 
                                                placeholder="0:00"
                                                maxlength="100"
                                                value="<?= old('rango_entrega_hasta'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <hr class="divider">
                                    <div class="form-group"  style="display: none;">
                                        <label for="nombre">Id Cliente:</label>
                                        <input type="txt" class="form-control" id="idcliente" name="idcliente" value="<?= old('idcliente'); ?>" readonly >
                                    </div>
                                    <div class="form-check mt-2 mb-2">
                                        <input type="checkbox" class="form-check-input" id="sin_remitente" name="sin_remitente" value="1" <?php echo set_checkbox('sin_remitente', '0'); ?> >
                                        <label class="form-check-label" for="sin_remitente">Sin remitente</label>
                                    </div>
                                    <div class="form-group row" id="campo-extra">
                                        <div class="col-md-6 div-celular">
                                            <label for="telefono">Celular 1 *:</label>
                                            <input 
                                                type="text" 
                                                class="form-control number" 
                                                id="telefono" 
                                                name="telefono" 
                                                placeholder="Celular" 
                                                value="<?= old('telefono'); ?>"
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
                                                value="<?= old('telefono_2'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <p id="error-message"><?= session('errors.telefono');?> </p>
                                    <div class="form-group">
                                        <label for="nombre">Nombre y apellido del cliente *:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre cliente" value="<?= old('nombre'); ?>">
                                        <a href="<?= site_url(); ?>/cliente-create" class="nav-link mb-3" id="link-clear-fields" target="_blank">Registrar nuevo cliente</a>
                                    </div>
                                    <p id="error-message"><?= session('errors.nombre');?> </p>
                                    <div class="form-group">
                                        <label for="documento">Documento:</label>
                                        <input type="text" class="form-control" id="documento" name="documento" placeholder="documento" value="<?= old('documento'); ?>" >
                                    </div>
                                    <div id="cliente"> </div>
                                    <div class="form-group mb-1" id="campo-extra">
                                        <label for="email" >Email:</label>
                                        <input 
                                            type="email" 
                                            class="form-control" 
                                            id="email" 
                                            name="email" 
                                            placeholder="cliente@email.com" 
                                            value="<?= old('email'); ?>"
                                        >
                                    </div>
                                    <div class="form-group mb-5">
                                        <a href="javascript:limpiaCamposCliente()" class="nav-link mb-3" id="link-clear-fields">Limpiar campos</a>
                                    </div>
                                    <hr class="divider mt-5 mb-3">
                                    <div class="form-group mb-3 mt-2">
                                        <label for="vendedor">Vendedor *:</label>
                                        <select class="form-select form-control-border" id="vendedor" name="vendedor" required>
                                            <option value="0" selected>--Seleccionar vendedor--</option>
                                            <?php
                                                if (isset($vendedores)) {
                                                    foreach ($vendedores as $key => $value) {
                                                        echo '<option value="'.$value->id.'" '.set_select('vendedor', $value->id, false).' >'.$value->nombre.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <p id="error-message"><?= session('errors.vendedor');?> </p>
                                    <div class="form-check mb-5">
                                        <input type="checkbox" class="form-check-input" id="venta_extra" name="venta_extra" value="1" <?php echo set_checkbox('venta_extra', '0'); ?> >
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
                                            <a href="javascript:agregarProducto(idp.value, cant.value, '<?= $cod_pedido; ?>' )" class="btn btn-carrito">
                                                <img src="<?= site_url(); ?>public/images/shoppingcart_add.png" alt="agregar"/>
                                            </a>
                                        </div>
                                    </div>
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
                                                    if ($detalle) {
                                                        $numFila = 0;
                                                        //echo '<pre>'.var_export($detalle, true).'</pre>';exit;
                                                        foreach ($detalle as $row) {
                                                            $numFila++;
                                                            
                                                            echo '<tr id="fila_'.$numFila.'">';
                                                            echo '<td>'.$numFila.'</td>';
                                                            echo '<td>'.$row->id.'</td>';
                                                            echo '<td>'.$row->producto.'</td>';
                                                            echo '<td>
                                                                        <input 
                                                                            type="text" 
                                                                            class="form-control" 
                                                                            name="observacion_'.$row->idproducto.'" 
                                                                            value="'.$row->observacion.'" 
                                                                            onchange="observacion('.$row->idproducto. ','.$cod_pedido.')" 
                                                                            id="observa_'.$row->idproducto.'"
                                                                        >
                                                                    </td>';
                                                            echo '<td>
                                                                        <input 
                                                                            type="text" 
                                                                            class="form-control input-precio" 
                                                                            name="precio_'.$row->idproducto.'" 
                                                                            value="'.$row->pvp.'" 
                                                                            onchange="actualizaPrecio('.$row->idproducto. ','.$cod_pedido.')" 
                                                                            id="precio_'.$row->idproducto.'"
                                                                        >
                                                                    </td>';
                                                            
                                                            echo '<td id="cant_'.$row->idproducto.'" class="cant_arreglo">'.$row->cantidad.'</td>';
                                                            
                                                            echo '<td><a onclick="eliminaProducto('.$row->idproducto. ','.$cod_pedido.')" class="btn btn-borrar">
                                                                        <img src="'.site_url().'public/images/delete.png" width="25" >
                                                                        </a></td>';
                                                            echo '</tr>';
                                                            
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
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
                                                value="<?= old('valor_neto'); ?>"
                                                readonly
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
                                                value="<?= old('descuento'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sectores" class="col-md-3 col-form-label">Transporte *:</label>
                                        <select class="form-select col-md-4 px-2 mx-2" id="sectores" name="sectores">
                                            <option value="0" selected>--Seleccionar sector--</option>
                                            <?php
                                                if (isset($sectores)) {
                                                    foreach ($sectores as $key => $value) {
                                                        echo '<option value="'.$value->id.'" '.set_select('sectores', $value->id, false).' >'.$value->sector.'</option>';
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
                                                value="<?= old('transporte'); ?>"
                                            >
                                        </div>
                                        
                                    </div>
                                    <p id="error-message"><?= session('errors.sectores');?> </p>
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
                                                value="<?= old('horario_extra'); ?>"
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
                                                value="<?= old('cargo_domingo'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row" id="valor-mensajero-hidden">
                                        <label for="valor_mensajero" class="col-sm-8 col-form-label">Valor mensajero calculado:</label>
                                        <div class="col-sm-4">
                                            <input 
                                                type="text" 
                                                class="form-control inputValor" 
                                                id="valor_mensajero" 
                                                name="valor_mensajero"
                                                onchange="sumarTotal()" 
                                                value="<?= old('valor_mensajero'); ?>"
                                                readonly
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
                                                value="<?= old('valor_mensajero_edit'); ?>"
                                            >
                                        </div>
                                        <div class="col-sm-4">
                                            <input 
                                                type="text" 
                                                class="form-control inputValor valorImportante decimal" 
                                                id="valor_mensajero_mostrado" 
                                                placeholder="0.00" 
                                                onchange="sumarTotal()" 
                                                name="valor_mensajero_mostrado"
                                                readonly
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8">
                                            <label for="" class="col-sm-12 col-form-label" id="lbl-modificar">Modificar valor:</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="" class="col-sm-12 col-form-label" id="lbl-modificar">Verificar valor:</label>
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
                                                value="<?= old('total'); ?>"
                                            >
                                        </div>
                                        
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="form-group row">
                                        <input 
                                            type="hidden" 
                                            class="form-control inputValor" 
                                            id="cant_arreglos" 
                                            name="cant_arreglos"
                                        >
                                    </div>
                                    
                                    <div class="card-footer">
                                        <div class="row col-md-12 mb-3">
                                            <button type="button" class="btn btn-light" onclick="activarSubmit()" id="btn-activar">Estoy listo y deseo continuar</button>
                                        </div>
                                        <button type="submit" class="btn btn-primary" onclick="pedidoInsert()" id="btnEnviar" disabled>Enviar</button>
                                        <a href="<?= site_url(); ?>pedidos" class="btn btn-light" id="btn-cancela">Cancelar</a>
                                        <div class="row mt-3" id="varSistema">
                                            <div class="col-md-2">
                                                <label for="">Porcentaje de transporte</label>
                                                <input type="text" class="form-control" id="porcentTransporte" value="<?= $variablesSistema[0]->valor; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Porcentaje cargo horario</label>
                                                <input type="text" class="form-control" id="porcentCargoHorario" value="<?= $variablesSistema[1]->valor; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Porcentaje mensajero por cargo domingo</label>
                                                <input type="text" class="form-control" id="porcentCargoDomingo" value="<?= $variablesSistema[2]->valor; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Porcentaje mensajero por cargo horario extra</label>
                                                <input type="text" class="form-control" id="porcentCargoHorarioExtra" value="<?= $variablesSistema[3]->valor; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Valor de cargo en domingo</label>
                                                <input type="text" class="form-control" id="valorDomingo" value="<?= $variablesSistema[4]->valor; ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="">Valor de cargo en horario extra</label>
                                                <input type="text" class="form-control" id="valorHorarioExtra" value="<?= $variablesSistema[5]->valor; ?>">
                                            </div>
                                        </div> 
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

<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/form-pedido.js"></script>
<script>



//Traigo el detalle al cargar la página
window.addEventListener('load', function() {
    let codigoPedido = document.getElementById('cod_pedido').value

    $.ajax({
        method: 'get',
        dataType:"html",
        url: "get_detallle",
        data: {
        codigo: codigoPedido
        },
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let dato = JSON.parse(resultado);
            //console.log(dato);
            if (dato != 0) {
                //alertCambioValor()
            }else{
                //alertCambioValor()
            }
            
            sumarTotal()

        },
        error: function(data){
            console.log("No hay detalle");
        }
    });
});

window.addEventListener("keypress", function(event){
    if (event.keyCode == 13){
        event.preventDefault();
    }
}, false);

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

$(document).ready(function(){
    $(".decimal").on("input", function() {

        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
    });
});
</script>

