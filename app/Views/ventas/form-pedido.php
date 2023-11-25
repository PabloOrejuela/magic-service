<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
<?php
    // date_default_timezone_set('America/Guayaquil');
    // $date = date('ymdHis');
    // $cod_pedido = 'P'.$session->id.$date;
    //echo '<pre>'.var_export($cod_pedido, true).'</pre>';exit;
?>
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="col-lg-8 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card" id="form-pedido">
                    <div class="card-header">
                        <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        <?= $subtitle;?>
                        
                        </h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0" >
                            <!-- Morris chart - Sales -->
                            <h3><?= $session->cliente;?></h3>
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                            <form action="<?= site_url().'pedido-insert';?>" method="post">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="fecha" class="col-sm-5 col-form-label">Fecha de entrega:</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="inputFecha" name="fecha_entrega" value ="" min="<?= date('Y-m-d') ?>">
                                        </div>
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
                                                                echo '<option value="'.$hora->id.'" '.set_select('vendedor', $hora->id, false).' style="color:red;">'.$hora->hora.' Horario extra</option>';
                                                            }else{
                                                                echo '<option value="'.$hora->id.'" '.set_select('vendedor', $hora->id, false).'>'.$hora->hora.'</option>';
                                                            }
                                                            
                                                        }
                                                    }
                                                ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group"  style="display: none;">
                                        <label for="nombre">Id Cliente:</label>
                                        <input type="hidden" class="form-control" id="idcliente" name="idcliente" value="<?= old('idcliente'); ?>" >
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre cliente:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre cliente" value="<?= old('nombre'); ?>"  required>
                                    </div>
                                    <p id="error-message"><?= session('errors.nombre');?> </p>
                                    <div class="form-group">
                                        <label for="documento">Documento:</label>
                                        <input type="text" class="form-control" id="documento" name="documento" placeholder="documento" value="<?= old('documento'); ?>" >
                                    </div>
                                    <p id="error-message"><?= session('errors.documento');?> </p>
                                    <div id="cliente"> </div>
                                    <div class="form-group" id="campo-extra">
                                        <label for="telefono">Celular:</label>
                                        <input type="text" class="form-control number" id="telefono" name="telefono" placeholder="Celular" value="<?= old('telefono'); ?>">
                                    </div>
                                    <div class="form-group" id="campo-extra">
                                        <label for="email" >Email:</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="cliente@email.com" value="<?= old('email'); ?>">
                                    </div>
                                    <p id="error-message"><?= session('errors.email');?> </p>
                                    <div class="form-group mb-3">
                                        <label for="vendedor">Vendedor:</label>
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
                                                                    echo "<option value='$value->id' " . set_select('producto', $value->id, false). " >". $value->producto."</option>";
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type="text" 
                                                            class="form-control inputValor number" 
                                                            id="cant" 
                                                            name="cant"  
                                                            value="1"
                                                        >
                                                    </td>
                                                    <td>
                                                        <a href="#" class="link-opacity-75" id="a" onclick="agregarProducto(idproducto.value, cant.value, '<?= $cod_pedido; ?>' )">
                                                            <img src="<?= site_url(); ?>public/images/btn-agregar.png" alt="agregar" id="img-agregar" />
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
                                                <th>Precio</th>
                                                <th>Cant</th>
                                                <th width="1%"></th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="form-check mb-2">
                                        <h3 id="error-message">Estoy reprogramando los cálculos, por eso no salen los subtotales y totales</h3>
                                    </div>
                                    <!-- /.card-body -->
                                    <?= form_hidden('cod_pedido', $cod_pedido); ?>
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
<script>

    function agregarProducto(idproducto, cantidad, cod_pedido){

        if (idproducto != null && idproducto != 0 && idproducto > 0) {

            $.ajax({
                url: '<?php echo base_url(); ?>ventas/detalle_pedido_insert/' + idproducto + '/' + cantidad + '/' + cod_pedido,
                success: function(resultado){
                    if (resultado == 0) {

                    }else{
                        //Exito
                        console.log("Se insertó el producto");
                        let detalle = JSON.parse(resultado);

                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);

                            document.getElementById("cant").value = 1;
                            let selectProductos = document.getElementById("idproducto");
                            selectProductos.value = 0;
                        }
                    }
                }
            });
        }
    }
    function eliminaProducto(idproducto, cod_pedido){

        if (idproducto != null && idproducto != 0 && idproducto > 0) {

            $.ajax({
                url: '<?php echo base_url(); ?>ventas/detalle_pedido_delete_producto/' + idproducto + '/' + cod_pedido,
                success: function(resultado){
                    if (resultado == 0) {

                    }else{
                        //Exito
                        console.log("Se eliminó el producto");
                        let detalle = JSON.parse(resultado);

                        if (detalle.error == '') {
                            $("#tablaProductos tbody").empty();
                            $("#tablaProductos tbody").append(detalle.datos);
                            $("#total").val(detalle.total);

                            document.getElementById("cant").value = 1;
                            let selectProductos = document.getElementById("idproducto");
                            selectProductos.value = 0;
                        }else{
                            console.log("Error");
                        }
                    }
                }
            });
        }
    }
    
    
    $(document).ready(function(){
        $("#documento").on('input',function(){
            if($("#documento").val() !=""){
                valor = $("#documento").val();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url: "<?php echo site_url(); ?>ventas/clientes_select",
                    data:"documento="+valor,
                    beforeSend: function (f) {
                        //$('#cliente').html('Cargando ...');
                    },
                    success: function(data){
                        //console.log(data);
                        $('#cliente').html(data);
                    }
                });
            }
        })
    })

    $(document).ready(function(){
        $("#sectores").on('change',function(){
            if($("#sectores").val() !=""){
                valor = $("#sectores").val();
                //console.log(valor);
                $.ajax({
                    type:"GET",
                    dataType:"html",
                    url: "<?php echo site_url(); ?>ventas/get_valor_sector/"+valor,
                    data:"sector="+valor,
                    beforeSend: function (f) {
                        //$('#cliente').html('Cargando ...');
                    },
                    success: function(data){
                        //console.log(data);
                        $('#transporte').html(data);
                        //document.getElementById("valor_neto").value = "0.01"
                    }
                });
            }
        });
    });

    function limpiarValores(valor) {
        var valor = 0
        document.getElementById('descuento').value = valor;
        document.getElementById('transporte').value = valor.toFixed(2);
        document.getElementById('total').value = valor.toFixed(2);
    }
    
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    });

    /* Multiple Item Picker */
    $('.selectpicker').selectpicker({
        style: 'btn-default'
    });

</script>




</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>