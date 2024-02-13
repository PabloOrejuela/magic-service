<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/css/cotizador-styles.css">

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
                    <form action="<?= site_url().'product-personalize';?>" method="post">
                        <div class="card-body">
                            <div class="row col-md-12">
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
                                <div class="form-group col-md-4 mb-3">
                                    <label for="productos">Productos:</label>
                                    <select class="custom-select form-control" id="productos" name="productos" disabled>
                                        <option value="" selected>--Seleccionar Producto--</option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-1 mb-1" style="display:none;">
                                    <label for="productos">Id:</label>
                                    <input 
                                        type="text" 
                                        class="form-control cant" 
                                        name="idproducto" 
                                        value="0" 
                                        id="idproducto"
                                    >
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input 
                                        type="text" 
                                        class="form-control cant" 
                                        name="image" 
                                        value="0" 
                                        id="image"
                                    >
                                </div>
                                <div class="form-group col-md-3 mb-3">
                                    <label for="image-product" id="lbl-image">Imagen</label>
                                    <div id="div-img">
                                        <img 
                                            src="public/images/default-img.png" 
                                            alt="producto" 
                                            class="rounded mx-auto d-block image-arreglo" 
                                            id="image-product"
                                        >
                                    </div>
                                    <input class="form-control" type="file" id="formFileImg" name="file-img" disabled>
                                </div>
                            </div>

                            <div class="row col-md-12 mt-3">
                                <div class="form-group col-md-4 mb-3">
                                    <label for="categoria">Nombre del nuevo arreglo:</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="nombreArregloNuevo" 
                                        placeholder="Nombre" 
                                        id="nombreArregloNuevo"
                                        disabled
                                    >
                                    <input 
                                        type="text" 
                                        class="form-control col-md-2 mt-1" 
                                        name="new_id" 
                                        id="new_id"
                                        style="display:none;"
                                    >
                                </div>
                                
                            </div>
                            <div class="row col-md-9 mt-3">
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
                                        <label for="item">Items:</label>
                                        <input 
                                            type="text"
                                            class="form-control" 
                                            id="iditem" 
                                            name="item"
                                        >
                                    </div>
                                    <div class="col-md-2">
                                        <a 
                                            href="javascript:agregarItem(document.getElementById('idproducto').value, idp.value)" 
                                            class="btn btn-carrito-item" 
                                            id="btn-carrito-item"
                                        >
                                            <img src="<?= site_url(); ?>public/images/shoppingcart_add.png" alt="agregar"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-sm-12 mb-3" width:="100%">
                                    <table id="tablaItems" class="table table-stripped table-responsive tablaItems" >
                                        <thead >
                                            <th>#</th>
                                            <th class="col-sm-4">Item</th>
                                            <th class="col-sm-2" id="label-thead">Unidades</th>
                                            <th class="col-sm-2" id="label-thead">Precio unitario</th>
                                            <th class="col-sm-2" id="label-thead">Precio</th>
                                            <th class="col-sm-2" id="label-thead">PVP</th>
                                            <th></th>
                                        </thead>
                                        <tbody id='tablaItemsBody'></tbody>
                                    </table>
                                    <table id="tablaCostos" class="table table-stripped  table-responsive tablaItems" >
                                        <tbody id='tablaCostosBody'>
                                            <tr>
                                                <td class="col-sm-9">TOTAL:</td>
                                                <td class="col-sm-2" colspan="5">
                                                    <input 
                                                        type="text" 
                                                        class="form-control cant" 
                                                        name="total" 
                                                        value="0.00" 
                                                        id="input-total"
                                                    >
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-check mb-4 mx-2 form-switch">
                                    <input class="form-check-input" type="checkbox" value="1" id="chk-attr-temp" name="arreglo-temporal">
                                    <label class="form-check-label" for="chk-attr-temp" id="chk-attr-temp">
                                        Guardar como arreglo temporal
                                    </label>
                                </div>
                                <button type="button" class="btn btn-light" onclick="activarSubmit()" id="btn-activar">Estoy listo y deseo continuar</button>
                            </div>
                            
                        </div>
                        <!-- /.card-body -->
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar" disabled>Guardar nuevo Arreglo</button>
                            <a href="#" class="btn btn-light cancelar" id="btn-cancela" onclick="cancelar()">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal dialog" id="imageArregloModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Imágen del arreglo</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <script>
            let image = document.getElementById("image-product")
            let id = image.getAttribute("src");
            document.write(id)
        </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</section> <!-- /.card -->

<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous">
</script>
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= site_url(); ?>public/js/form-cotizador.js"></script>
<script src="<?= site_url(); ?>public/js/carga-imagen-cotizador.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    
    aData = {}
    
    $('#iditem').autocomplete({
        source: function(request, response){
            $.ajax({
                url: 'getItemsAutocomplete',
                method: 'GET',
                dataType: 'json',
                data: {
                    item: request.term
                },
                success: function(res) {

                    aData = $.map(res, function(value, key){
                        return{
                            id: value.id,
                            label: value.item + ' - ' + value.precio
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
            
        }
    });
</script>