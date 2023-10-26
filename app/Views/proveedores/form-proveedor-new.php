<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?><span id="mensaje"> ESTE FORMULARIO ESTÁ EN PROCESO</span></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'proveedor-insert';?>" method="post">
                        <div class="card-body">
                            <div class="form-group col-md-7">
                                <label for="producto">Nombre:</label>
                                <input type="text" class="form-control" id="producto" name="producto" placeholder="Producto" value="<?= old('idcliente'); ?>" required>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <?= form_hidden('id', 0); ?>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" disabled="true" id="btnGuardar">Guardar</button>
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

