<style>
    .inputValor{
        text-align: right;
    }
    #inputfecha{
        text-align: right;
    }
    #form-pedido{
        width:500px;
    }

    #inputProducto{
        width:50%;
    }

    .link-editar{
        color: blue;
    }
    
</style>
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="col-lg-10 connectedSortable">
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
                                        <label for="fecha" class="col-sm-5 col-form-label">Fecha:</label>
                                        <div class="col-sm-7">
                                            <input type="date" class="form-control" id="inputFecha" name="fecha" value="<?php echo date('Y-m-d');?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre cliente:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre cliente">
                                    </div>
                                    <div class="form-group">
                                        <label for="documento">Documento:</label>
                                        <input type="text" class="form-control" id="documento" name="documento" placeholder="documento">
                                    </div>
                                    <div id="cliente"> </div>
                                    <div class="form-group">
                                        <label for="telefono">Celular:</label>
                                        <input type="text" class="form-control number" id="telefono" name="telefono" placeholder="Celular">
                                    </div>
                                    <div class="form-group">
                                        <label for="telefono">Vendedor:</label>
                                        <select class="custom-select form-control-border" id="producto" name="producto">
                                            <option selected>--Seleccionar vendedor--</option>
                                            <?php
                                                if (isset($vendedores)) {
                                                    foreach ($vendedores as $key => $value) {
                                                        echo '<option value="'.$value->id.'">'.$value->nombre.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="producto">Producto:</label> 
                                        <select class="custom-select form-control-border" id="inputProducto" name="producto">
                                            <option selected>--Seleccionar producto--</option>
                                            <?php
                                                if (isset($productos)) {
                                                    foreach ($productos as $key => $value) {
                                                        echo '<option value="'.$value->id.'">'.$value->producto.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                        <a href="pages/charts/chartjs.html" class="nav-link mb-3 link-editar">Editar producto</a>
                                    </div>
                                    <div class="form-group">
                                        <label for="formas_pago">Forma de pago:</label>
                                        <select class="custom-select form-control-border" id="formas_pago" name="formas_pago">
                                            <option selected>--Seleccionar forma de pago--</option>
                                            <?php
                                                if (isset($formas_pago)) {
                                                    foreach ($formas_pago as $key => $value) {
                                                        echo '<option value="'.$value->id.'">'.$value->forma_pago.'</option>';
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-8 col-form-label">Valor neto:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control inputValor" id="valor_neto" placeholder="0.00" onchange="sumarTotal(this.value);" name="valor_neto">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-8 col-form-label">Descuento (%):</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control inputValor" id="descuento" placeholder="0" onchange="descontar(this.value);" name="descuento">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-8 col-form-label">Transporte:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control inputValor" id="transporte" placeholder="0.00" onchange="sumar(this.value);" name="transporte">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-8 col-form-label">Total:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control inputValor" id="total" placeholder="0.00" onchange="sumar(this.value);" name="total">
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="venta_extra">
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
        $("#inputProducto").on('input',function(){
            if($("#inputProducto").val() !=""){
                valor = $("#inputProducto").val();
                //console.log(valor);
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url: "<?php echo site_url(); ?>ventas/get-valor-producto",
                    data:"producto="+valor,
                    beforeSend: function (f) {
                        //$('#cliente').html('Cargando ...');
                    },
                    success: function(data){
                        console.log(data);
                        $('#valor_neto').html(data);
                    }
                });
            }
        })
    })

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

</script>