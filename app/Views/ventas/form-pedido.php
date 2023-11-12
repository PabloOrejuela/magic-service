<style>
    .inputValor{
        text-align: right;
    }
    #inputfecha{
        text-align: right;
    }
    #form-pedido{
        width:600px;
    }

    #inputProducto{
        width:50%;
    }

    #link-edita-producto{
        margin-left:10px;
    }

    #sectores{
        width:40%;
        font-size: 1.2em;
    }

    #formas_pago{
        width:60%;
        font-size: 1.2em;
    }

    #vendedor{
        width:50%;
        font-size: 1.2em;
    }

    #horario_entrega{
        width:100%;
        font-size: 1.1em;
    }

    #error-message{
        color:red;
        font-size: 0.7em;
    }

    .link-editar{
        color: blue;
    }

    #div-cant{
        margin-left: 6px;
    }

    #campo-extra{
        display: none;
    }
    
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="col-lg-12 connectedSortable">
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
                            <form action="<?= site_url().'/pedido-insert';?>" method="post">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="fecha" class="col-sm-5 col-form-label">Fecha de entrega:</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="inputFecha" name="fecha_entrega" value="">
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
                                                            if ($hora->id < 5) {
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
                                        <input type="email" class="form-control number" id="email" name="email" placeholder="cliente@email.com" value="<?= old('email'); ?>">
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
                                    <div class="row form-group mb-3">
                                        <label for="producto">Producto:</label> 
                                        <!-- <select class="custom-select form-control-border" id="inputProducto" name="producto"> -->
                                        <select 
                                            class="selectpicker show-menu-arrow col-md-8" 
                                            id="inputProducto" 
                                            name="producto"
                                            data-style="form-control" 
                                            data-live-search="true" 
                                            title="-- Seleccionar Item --"
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
                                        <div style="width: 60px;margin-left:7px;"><input type="text" class="form-control inputValor number" id="cant" name="cant"  value="1"></div>
                                        
                                        <!-- <a href="#" class="nav-link mb-3 link-editar" id="link-edita-producto">Editar producto</a> -->
                                    </div>
                                    <p id="error-message"><?= session('errors.producto');?> </p>
                                    <div class="form-group mb-3" id="campo-extra">
                                        <label for="formas_pago" >Forma de pago:</label>
                                        <select class="form-select form-control" id="formas_pago" name="formas_pago" value="">
                                            <option value="0" selected>--Seleccionar forma de pago--</option>
                                            <?php
                                                if (isset($formas_pago)) {
                                                    foreach ($formas_pago as $key => $value) {
                                                        echo '<option value="'.$value->id.'" '.set_select('formas_pago', $value->id, false).' >'.$value->forma_pago.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <p id="error-message"><?= session('errors.formas_pago');?> </p>
                                    <div class="form-group row">
                                        <label for="valor_neto" class="col-sm-8 col-form-label">Valor neto:</label>
                                        <div class="col-sm-4">
                                            <input 
                                                type="text" 
                                                class="form-control inputValor number" 
                                                id="valor_neto" 
                                                placeholder="0.00" 
                                                onchange="sumarTotal(this.value);" 
                                                name="valor_neto"
                                                value="<?= old('valor_neto'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="descuento" class="col-sm-8 col-form-label">Descuento (%):</label>
                                        <div class="col-sm-4">
                                            <input 
                                                type="text" 
                                                class="form-control inputValor number" 
                                                id="descuento" 
                                                placeholder="0" 
                                                onchange="descontar(this.value);" 
                                                name="descuento"
                                                value="<?= old('descuento'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sectores" class="col-md-3 col-form-label">Transporte:</label>
                                        <select class="form-select form-control-border" id="sectores" name="sectores">
                                            <option value="0" selected>--Seleccionar sector--</option>
                                            <?php
                                                if (isset($sectores)) {
                                                    foreach ($sectores as $key => $value) {
                                                        echo '<option value="'.$value->id.'" '.set_select('sectores', $value->id, false).' >'.$value->sector.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <div class="col-md-4" id="div-cant">
                                            <input 
                                                type="text" 
                                                class="form-control inputValor number" 
                                                id="transporte" 
                                                placeholder="0.00" 
                                                onchange="sumar(this.value);" 
                                                name="transporte"
                                                value="<?= old('transporte'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="total" class="col-sm-8 col-form-label">Total:</label>
                                        <div class="col-sm-4">
                                            <input 
                                                type="text" 
                                                class="form-control inputValor number" 
                                                id="total" 
                                                placeholder="0.00" 
                                                onchange="sumar(this.value);" 
                                                name="total"
                                                value="<?= old('total'); ?>"
                                            >
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="venta_extra" name="venta_extra" value="1" <?php echo set_checkbox('venta_extra', '0'); ?> >
                                        <label class="form-check-label" for="venta_extra">Venta extra</label>
                                    </div>
                                    </div>
                                    <!-- /.card-body -->

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
        $("#inputProducto").on('change',function(){
            if($("#inputProducto").val() !=""){
                valor = $("#inputProducto").val();
                //console.log(valor);
                $.ajax({
                    type:"GET",
                    dataType:"html",
                    url: "<?php echo site_url(); ?>ventas/get_valor_producto/"+valor,
                    data:"producto="+valor,
                    beforeSend: function (f) {
                        //$('#cliente').html('Cargando ...');
                    },
                    success: function(data){
                        //console.log(data);
                        $('#valor_neto').html(data);
                        //document.getElementById("valor_neto").value = "0.01"
                    }
                });
            }
        });
    });

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

    function sumar(valor) {

        var total = 0;	
        valor = valor.replace(/,/g, '.')
        valor = parseFloat(valor); // Convertir el valor a un float (número).

        total = document.getElementById('total').value;
        
        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
        total = (total == null || total == undefined || total == "") ? 0 : total;
        
        /* Este es el cálculo. */
        total = (parseFloat(total) + parseFloat(valor));
        

        document.getElementById('total').value = total.toFixed(2);
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
    }

    function sumarTotal(valor) {

        limpiarValores()

        var total = 0;	
        valor = valor.replace(/,/g, '.')
        valor = parseFloat(valor); // Convertir el valor a un float (número).

        total = document.getElementById('total').value;

        // Aquí valido si hay un valor previo, si no hay datos, le pongo un cero "0".
        total = (total == null || total == undefined || total == "") ? 0 : total;

        /* Este es el cálculo. */
        total = (parseFloat(total) + parseFloat(valor));


        document.getElementById('total').value = total.toFixed(2);
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