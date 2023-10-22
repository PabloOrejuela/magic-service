<style>
    #precio{
        text-align: right;
    }
    #item-grid{
        margin-left: 20px;
        /*float: left;*/
    }
    #items{
        text-align: left;
    }
    a:hover{
        text-decoration: none;
    }
    #input-item{
        width: 80%;
        margin-right: 5px;
    }
    .cant{
        /* width: 20%; */
        text-align: right;
        margin-left: 0px;
    }

    #mensaje{
        color: red;
        font-size: 2.5em;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?><span id="mensaje"> Aún trabajando esta parte</span></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'product-update';?>" method="post">
                        <div class="card-body">
                            <div class="form-group col-md-7">
                                <label for="producto">Nombre del producto:</label>
                                <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto" value="<?= $producto->producto; ?>" required>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="categoria">Categoría:</label>
                                <select class="custom-select form-control" id="categoria" name="categoria">
                                    <option value="" selected>--Seleccionar categoría--</option>
                                    <?php
                                        if (isset($categorias)) {
                                            foreach ($categorias as $key => $value) {
                                                if ($value->id == $producto->idcategoria) {
                                                    echo '<option value="'.$value->id.'" selected>'.$value->categoria.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$value->id.'">'.$value->categoria.'</option>';
                                                }
                                                
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="row form-group col-md-10 mb-3">
                                <label for="items">Items:</label>
                                <select 
                                    class="selectpicker show-menu-arrow col-md-4" 
                                    id="items" 
                                    name="items"
                                    data-style="form-control" 
                                    data-live-search="true" 
                                    title="-- Seleccionar Item --"
                                >
                                    <?php
                                        if (isset($items)) {
                                            foreach ($items as $key => $value) {
                                                echo '<option value="'.$value->id.'">'.$value->item.' $ '.$value->precio.'</option>';
                                            } 
                                        }
                                    ?>
                                </select>
                                <div for="items" class="col-md-2 col-form-label" >
                                    <a href="#" class="btn btn-secondary stretched-link" onclick="agregar();">+ Agregar</a>
                                </div>
                            </div>
                            <div class="input-group col-md-8 mb-3" id="item-grid" >
                                <?php
                                    $precio = 0;
                                    //echo '<pre>'.var_export($elementos, true).'</pre>';exit;
                                    foreach ($elementos as $key => $elemento) {
                                        $precio += $elemento->precio;
                                        echo '<input type="text" class="form-control" id="input-item" name="elementos['.$elemento->id.']" value="'.$elemento->item.'" >
                                                <input class="form-control mb-1 col-sm-2 cant" type="text"  value="'.$elemento->cantidad.'" name="cantidad[]" id="'.$elemento->id.'">';
                                    }
                                ?>
                            </div>
                            <div class="mb-3 row col-sm-8" id="elementos" hidden>
                                <ol>
                                <?php
                                    foreach ($elementos as $key => $elemento) {
                                        echo '
                                            <li><input class="form-control" type="hidden" name="'.$elemento->id.'" value="'.$elemento->cantidad.'" ></li>
                                        ';
                                    }
                                ?>
                                </ol>
                            </div>
                            <div class="mb-3 row col-sm-8">
                                <label for="precio" class="col-sm-3 col-form-label">Precio:</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" id="precio" name="precio" placeholder="0.00" value="<?= number_format($precio, 2); ?>" readonly>
                                </div>
                            </div> 
                            
                        </div>
                        <!-- /.card-body -->
                        <?= form_hidden('id', 0); ?>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" disabled="true" id="btnGuardar">Guardar</button>
                            <input type="checkbox" id="activar" value="1"> Activar
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script>


    var elementos = []
    var id = []
    var cant = []
    var precio = 0
    var total = 0.00
    var html = ''
    var html2 = ''
    var nombre = ''
    var num = 1
   
   

    function agregar(){
        
        //$("#items").change(function() {
            var valor = $("#items").val() // Capturamos el valor del select
            var texto = $("#items").find('option:selected').text(); // Capturamos el texto del option seleccionado
            
            nombre = texto.split('$')[0]
            precio = texto.split('$')[1]
            

            if (texto != "-- Seleccionar Item --") {
                
                total = total + parseFloat(precio)
                document.getElementById("precio").value = total.toFixed(2)
                

                if (elementos[valor] == undefined || elementos[valor] == NaN) {
                    //console.log("NO");
                    elementos[valor] = 1
                    // const el = document.createElement('div')
                    // el.textContent = elementos[valor]
                    // div.appendChild(el)
                    //document.getElementById("input-cant").value = num
                    html = '<input class="form-control mb-1" name="items[]" value="'+texto+'" id="input-item" readonly>'+
                            '<input class="form-control mb-1 col-sm-2 cant" type="text"  value="'+num+'" name="cantidad[]" id="'+valor+'">'+
                            '<input type="button" value="quitar" >'
                    $('#item-grid').append(html)
                
                    //console.log(elementos)
                    html2 += '<input class="form-control" type="hidden" name="elementos['+valor+']" value="'+num+'" >'+
                    '<input class="form-control mb-1 cant" type="hidden" name="cant[]" value="'+num+'"  id="input-cant">'
                    $('#elementos').html(html2)
                   
                }else{
                    elementos[valor] = parseInt(elementos[valor])+1

                    html2 += '<input class="form-control" type="hidden" name="elementos['+valor+']" value="'+elementos[valor]+'" >'+
                        '<input class="cant form-control mb-1 " type="hidden" name="cant[]" value="'+num+'"  id="input-cant">'+
                        '<input type="button" value="quitar" >'
                    $('#elementos').html(html2)
                    document.getElementById(valor).value = elementos[valor] 
                    
                    
                    
                }
                
                //console.log(elementos)
            }
            
            
            
        //});
    }


    $('#activar').click(function() {

        if ($('#categoria').val().trim() === '') {
            alert('Debe seleccionar una CATEGORÍA');

        } else {
            //console.log('Campo correcto');
            $("#activar").change(function() {
                $("#btnGuardar").prop('disabled', false)
                $("#activar").prop('disabled', true)
            });
        }
    });

</script>

<script>
/* Multiple Item Picker */
$('.selectpicker').selectpicker({
    style: 'btn-default'
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>

