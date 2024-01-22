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
    #input-item{
        width: 80%;
        margin-right: 5px;
    }
    .cant{
        width: 50px;
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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?><span id="mensaje"> Sección en proceso de programación</span></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'product-update';?>" method="post">
                        <div class="card-body">
                            <div class="form-group col-md-5 mb-3">
                                <label for="categoria">Categoría:</label>
                                <select class="custom-select form-control" id="categoria" name="categoria">
                                    <option value="" selected>--Seleccionar categoría--</option>
                                    <?php
                                        if (isset($categorias)) {
                                            foreach ($categorias as $key => $value) {
                                                echo '<option value="'.$value->id.'">'.$value->categoria.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-5 mb-3">
                                <label for="productos">Productos:</label>
                                <select class="custom-select form-control" id="productos" name="productos" disabled>
                                    <option value="" selected>--Seleccionar Producto--</option>
                                </select>
                            </div>
                            <div class="form-group col-md-1 mb-3">
                                <label for="productos">Id:</label>
                                <input 
                                    type="text" 
                                    class="form-control cant" 
                                    name="idproducto" 
                                    value="0" 
                                    id="idproducto"
                                >
                            </div>
                            <div class="form-group col-sm-12 mb-3" width:="100%">
                                <table id="tablaItems" class="table  table-stripped  table-responsive tablaItems" >
                                    <thead >
                                        <th>#</th>
                                        <th class="col-sm-6">Item</th>
                                        <th class="col-sm-2">Porcentaje</th>
                                        <th class="col-sm-2">Unidades</th>
                                        <th class="col-sm-2">Precio</th>
                                    </thead>
                                    <tbody id='tablaItemsBody'></tbody>
                                </table>
                                <table id="tablaCostos" class="table  table-stripped  table-responsive tablaItems" >
                                    <tbody id='tablaCostosBody'>
                                        <tr>
                                            <td class="col-sm-10">TOTAL:</td>
                                            <td class="col-sm-2">
                                                <input 
                                                    type="text" 
                                                    class="form-control cant" 
                                                    name="total" 
                                                    value="0.00" 
                                                    id="input-total"
                                                >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <?= form_hidden('id', ); ?>
                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar</button>
                            <a href="<?= site_url(); ?>productos" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="<?= site_url(); ?>public/js/form-cotizador.js"></script>
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
                console.log(128);
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


    

</script>

