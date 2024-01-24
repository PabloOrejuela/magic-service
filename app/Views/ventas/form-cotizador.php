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

    .div-img{
        display:none;
    }

    #mensaje{
        color: #eed5d5;
        font-size: 2.5em;
    }
    #input-total{
        position: relative;
        display: inline;
        margin-left: 40px;
        width: 60%;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }

    input[type=number] { -moz-appearance:textfield; }
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
                        <h3 class="card-title"><?= $subtitle; ?><span id="mensaje"> Falta la funcionalidad de remover item</span></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'product-update';?>" method="post">
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
                                
                                <div class="form-group col-md-1 mb-3" style="display:none;">
                                    <label for="productos">Id:</label>
                                    <input 
                                        type="text" 
                                        class="form-control cant" 
                                        name="idproducto" 
                                        value="0" 
                                        id="idproducto"
                                    >
                                </div>
                                <div class="form-group col-md-3 mb-3 div-img">
                                    <label for="image-product" id="lbl-image"></label>
                                    <img 
                                        src="#" 
                                        alt="producto" 
                                        class="rounded mx-auto d-block image-arreglo" 
                                        id="image-product"
                                        onclik="abrirImagenModal()"
                                    >
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
                                        <a href="javascript:agregarItem(document.getElementById('idproducto').value, idp.value)" class="btn btn-carrito-item" id="btn-carrito-item">
                                            <img src="<?= site_url(); ?>public/images/shoppingcart_add.png" alt="agregar" onclic="verImagen()"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-sm-12 mb-3" width:="100%">
                                    <table id="tablaItems" class="table  table-stripped  table-responsive tablaItems" >
                                        <thead >
                                            <th>#</th>
                                            <th class="col-sm-4">Item</th>
                                            <th class="col-sm-2">Porcentaje</th>
                                            <th class="col-sm-2">Unidades</th>
                                            <th class="col-sm-2">Precio unitario</th>
                                            <th class="col-sm-2">Precio final</th>
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
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <?= form_hidden('id', ); ?>
                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btnGuardar" disabled>Guardar nuevo Arreglo</button>
                            <a href="#" class="btn btn-light cancelar" id="btn-cancela" onclick="cancelar()">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= site_url(); ?>public/js/form-cotizador.js"></script>
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