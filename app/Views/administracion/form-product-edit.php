<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/css/form-product-edit.css">

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
                    <form action="<?= site_url().'product-update';?>" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row col-md-12">
                                <div class="form-group col-md-4 mb-3">
                                    <label for="categoria">Categoría:</label>
                                    <select class="custom-select form-control" id="categoria" name="categoria">
                                        <?php
                                            if (isset($categorias)) {
                                                foreach ($categorias as $key => $value) {
                                                    if ($value->id == $producto->idcategoria) {
                                                        echo '<option value="'.$value->id.'" selected>'.$value->categoria.'</option>';
                                                    } else {
                                                        echo '<option value="'.$value->id.'">'.$value->categoria.'</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label for="productos">Producto:</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        name="producto" 
                                        value="<?= $producto->producto; ?>" 
                                        id="producto"
                                    >
                                </div>
                                
                                <div class="form-group col-md-1 mb-1" style="display:none;">
                                    <label for="productos">Id:</label>
                                    <input 
                                        type="text" 
                                        class="form-control cant" 
                                        name="idproducto" 
                                        value="<?= $producto->id; ?>" 
                                        id="idproducto"
                                    >
                                </div>
                                <div class="form-group" style="display:none;">
                                    <input 
                                        type="text" 
                                        class="form-control cant" 
                                        name="image" 
                                        value="" 
                                        id="image"
                                    >
                                </div>
                                <div class="form-group col-md-3 mb-3">
                                    <label for="image-product" id="lbl-image">Imagen</label>
                                    <div id="div-img">
                                        <img 
                                            src="<?= site_url().'public/images/productos/'.$producto->image; ?>.jpg" 
                                            alt="producto" 
                                            class="rounded mx-auto d-block image-arreglo" 
                                            id="image-product"
                                        >
                                    </div>
                                    <input class="form-control" type="file" id="formFileImg" name="file-img">
                                    <a href="#" class="flex-shrink-0 me-3" id="link-borra-imagen"><i class="fa-solid fa-ban"></i> Borrar imágen</a>
                                </div>
                                <?php
                                    if ($producto->attr_temporal == 1) {
                                        echo '
                                            <div class="form-group col-md-2 mb-3">
                                                <label for="tipo">Tipo:</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="tipo"
                                                    value="Arreglo Temporal"
                                                    id="input-tipo"
                                                    disabled
                                                >
                                            </div>
                                        ';
                                    }else{
                                        echo '
                                            <div class="form-group col-md-2 mb-3">
                                                <label for="tipo">Tipo:</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="tipo"
                                                    value="Arreglo Definitivo"
                                                    id="input-tipo"
                                                    disabled
                                                >
                                            </div>
                                        ';
                                    }
                                ?>
                                
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
                                            href="javascript:agregarItem(<?= $producto->id; ?>,idp.value)" 
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
                                    <table id="tablaItems" class="table  table-stripped  table-responsive tablaItems" >
                                        <thead >
                                            <th>#</th>
                                            <th class="col-sm-4">Item</th>
                                            <th class="col-sm-2">Unidades</th>
                                            <th class="col-sm-2">Precio unitario</th>
                                            <th class="col-sm-2">Precio</th>
                                            <th class="col-sm-2">PVP</th>
                                            <th></th>
                                        </thead>
                                        <tbody id='tablaItemsBody'>
                                            <?php
                                                if ($items) {
                                                    foreach ($items as $key => $item) {
                                                        echo '<tr>
                                                                <td>'.$item->id.'</td><td>'.$item->item.'</td>
                                                                <td>
                                                                    <input 
                                                                        type="numeric" 
                                                                        class="form-control cant porcentaje" 
                                                                        name="porcentaje_'.$item->id.'"
                                                                        value = "'.$item->porcentaje.'"
                                                                        placeholder="0"
                                                                        id="porcentaje_'.$item->id.'" 
                                                                        onchange="calculaPorcentaje('.$item->id.')"
                                                                        oninput="validarInput2('.$item->id.')"
                                                                        onkeydown="preventDefault(porcentaje_'.$item->id.')"
                                                                        min="0"
                                                                    >
                                                                </td>
                                                                <td>
                                                                    <input 
                                                                        type="text" 
                                                                        class="form-control cant precio" 
                                                                        name="precio_'.$item->id.'" 
                                                                        value="'.$item->precio_unitario.'" 
                                                                        id="precio_'.$item->id.'"
                                                                        disabled
                                                                    >
                                                                </td>
                                                                <td>
                                                                    <input 
                                                                        type="text" 
                                                                        class="form-control cant precio_final" 
                                                                        name="precio_final_'.$item->id.'" 
                                                                        value="'.$item->precio_actual.'" 
                                                                        id="precio_final_'.$item->id.'"
                                                                        disabled
                                                                    >
                                                                </td>
                                                                <td>
                                                                    <input 
                                                                        type="numeric" 
                                                                        class="form-control cant pvp" 
                                                                        name="pvp_'.$item->id.'"
                                                                        value="'.$item->pvp.'" 
                                                                        id="pvp_'.$item->id.'"
                                                                        onchange="updatePvp('.$item->id.')"
                                                                        oninput="validarInputPvp('.$item->id.')"
                                                                        
                                                                        min="0"

                                                                    >
                                                                </td>
                                                                <td>
                                                                    <a onclick="deleteItem('.$producto->id.', '.$item->id.')" class="btn btn-borrar">
                                                                        <img src="'.site_url().'public/images/delete.png" width="25" >
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        ';
                                                    }
                                                }else{
                                                    echo '<tr><td colspan="4">El producto no tiene items, puede haber un error</td></tr>';
                                                }
                                            ?>
                                        
                                        </tbody>
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
                                                        value="<?= $producto->precio; ?>" 
                                                        id="input-total"
                                                        oninput="validarInputTotal()"
                                                        onkeydown="preventDefault('input-total')"
                                                        min="0"
                                                    >
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row col-md-12 mb-3">
                                    <label for="floatingTextarea2">Observaciones:</label>
                                    <textarea 
                                        class="form-control" 
                                        placeholder="Observaciones" 
                                        id="observaciones" 
                                        name="observaciones" 
                                        style="height: 100px; resize: none;"
                                    ><?= $producto->observaciones; ?></textarea>
                                </div>
                                <?= form_hidden('imagenOld', $producto->image); ?>
                            </div>
                            
                        </div>
                        <!-- /.card-body -->
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar" disabled>Guardar cambios</button>
                            <?php
                                if ($producto->attr_temporal == 1) {
                                    echo '<a href="#" class="btn btn-light temporal" id="btn-temporal" style="visibility: visible;">Guardar como arreglo definitivo</a>';
                                }else{
                                    echo '<a href="#" class="btn btn-light temporal" id="btn-temporal" style="display:none;">Guardar como arreglo definitivo</a>';
                                }
                            ?>
                            
                            <a href="#" class="btn btn-light cancelar" id="btn-cancela" onclick="cancelar(<?= $producto->id; ?>)">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script src="<?= site_url(); ?>public/plugins/jquery/jquery.js"></script>
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= site_url(); ?>public/js/form-product-edit.js"></script>
<script src="<?= site_url(); ?>public/js/validar-input.js"></script>
<script src="<?= site_url(); ?>public/js/form-new-product-autocomplete.js"></script>
<script src="<?= site_url(); ?>public/js/carga-imagen-cotizador.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



