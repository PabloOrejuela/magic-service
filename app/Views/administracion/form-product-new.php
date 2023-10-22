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
        width: 65%;
        margin-right: 5px;
    }
    .cant{
        /* width: 20%; */
        text-align: right;
        margin-left: 1px;
    }

    #ion-delete{
        
        margin-left: 7px;
        padding: 2px;
        padding-top: 3px;
        font-size: 1.5em;
        color: red;
    }
</style>
<script>
    $(document).ready( 
        
    );
</script>
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
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'product-insert';?>" method="post">
                        <div class="card-body">
                            <div class="form-group col-md-7">
                                <label for="producto">Nombre del producto:</label>
                                <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto" value="" required>
                            </div>
                            <div class="form-group col-md-4 mb-3">
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
                            <div class="input-group col-md-12 mb-3" id="item-grid" >
                                
                            </div>
                            <div class="mb-3 row col-sm-8" id="elementos" hidden>
                                
                            </div>
                            <div class="mb-3 row col-sm-8">
                                <label for="precio" class="col-sm-3 col-form-label">Precio:</label>
                                <div class="col-sm-4">
                                <input type="text" class="form-control" id="precio" name="precio" placeholder="0.00" value="" readonly>
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
<script type="text/javascript">

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
    //console.log(elementos)
    //$("#items").change(function() {
        var id = $("#items").val() // Capturamos el id que es el valor del select
        var texto = $("#items").find('option:selected').text(); // Capturamos el texto del option seleccionado
        
        nombre = texto.split('$')[0]
        precio = texto.split('$')[1]
        
        if (texto != "-- Seleccionar Item --") {
            
            total = total + parseFloat(precio)
            document.getElementById("precio").value = total.toFixed(2)
            
                
            if (elementos[id] == undefined || elementos[id] == NaN) {
                
                elementos[id] = 1
                // const el = document.createElement('div')
                // el.textContent = elementos[id]
                // div.appendChild(el)
                //document.getElementById("input-cant").value = num
                html = '<div class="form-group"><input class="form-control mb-1" name="items[]" value="'+id+' - '+texto+'" id="input-item" readonly><input class="form-control mb-1 col-sm-1 cant" type="text"  value="'+num+'" name="cantidad[]" id="'+id+'"><a href="#" ><i class="ion ion-android-delete" id="ion-delete"></i></a></div>'
                $('#item-grid').append(html)
            
                //console.log(elementos)
                html2 += '<input class="form-control" type="hidden" name="elementos['+id+']" value="'+num+'" >'
                        $('#elementos').html(html2)
                
            }else{
                elementos[id] = parseInt(elementos[id])+1
                //console.log(elementos[id]);
                html2 += '<div class="form-group"><input class="form-control" type="hidden" name="elementos['+id+']" value="'+elementos[id]+'" ><input class="cant form-control mb-1 " type="hidden" name="cant[]" value="'+num+'"  id="input-cant"><a href="#" onclick=""><i class="ion ion-android-delete" id="ion-delete"></i></a></div>'
                        $('#elementos').html(html2)
                //console.log(elementos)
                document.getElementById(id).value = elementos[id] 
            }

            
            //actualizaTotal(elementos, id)
        }
        
        
        
    //});
}

function quitar(valor){
    $('#'+valor).empty();
    $('#'+valor).remove();
    
    elementos.splice(valor,1);
    console.log(elementos);
}

function actualizaTotal(items, id){
    
    $(document).on("input","#"+id,function(){
        let c = document.getElementById(id).value 

        // let result = elementos.filter(e => elementos.id.find(t => t.id == 6));
        console.log(items);
        // let valor = precio*c;
        // let subtotal = document.getElementById('precio').value
        // let total = subtotal + valor
        // document.getElementById('precio').value = total.toFixed(2);

        //console.log(elementos);
    });
    
}


    

$('#activar').click(function() {
    //actualizaTotal()
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



/* Multiple Item Picker */
$('.selectpicker').selectpicker({
    style: 'btn-default'
});


</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script>


