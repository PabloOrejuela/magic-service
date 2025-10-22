<link rel="stylesheet" href="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/css/gestion-inventario.css">
<section class="content mb-5">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9">
                <!-- general form elements -->
                <div class="card card-light mb-5">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <form action="registraMovimientoStock", method="get">
                            
                            <div class="form-group col-12 mb-1 px-3" id="fila-form">
                                <div class="row id">
                                    <div class="col-sm-2">
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="id" 
                                            name="id"
                                            value="<?= set_value('id'); ?>"
                                        >
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-9">
                                        <label for="item" class="form-label">Item:</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="item" 
                                            name="item" 
                                            placeholder="Item" 
                                            value="<?= set_value('item'); ?>"
                                            autofocus 
                                        >
                                    </div>
                                    
                                </div>
                                <p id="error-message"><?= session('errors.item');?> </p>
                                <div class="row" id="info-item">
                                    <div class="col-sm-3">
                                        <label for="stock_actual" class="form-label">Stock actual (unidades):</label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="stock_actual" 
                                            name="stock_actual"
                                            value="<?= old('stock_actual'); ?>"
                                            disabled
                                        >
                                    </div>
                                </div>
                                <p id="error-message"><?= session('errors.stock_actual');?> </p>
                            </div>
                            <div class="separator mb-3"></div>
                            <h5>Movimiento de inventario</h5>
                            <div class="form-group col-9 mb-1 px-3" id="fila-form">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <label for="movimiento" class="form-label">Tipo movimiento:</label>
                                        <select 
                                            class="form-select" 
                                            aria-label="Select de tipos de movimiento de inventario"
                                            name="movimiento" 
                                            id="movimiento"
                                        >
                                            <option value="0" selected>-- Seleccione un tipo de movimiento --</option>
                                            <?php
                                                if ($movimientos) {
                                                    foreach ($movimientos as $key => $m) {
                                                        echo '<option value="'.$m->id.'" '.set_select('movimiento', $m->id, false).'>'.$m->descripcion.'</option>';
                                                    }
                                                } 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <p id="error-message"><?= session('errors.movimiento');?> </p>
                                <div class="row" id="info-item">
                                    <div class="col-sm-3">
                                        <label for="unidades" class="form-label">Unidades:</label>
                                        <input 
                                            type="text" 
                                            class="form-control number" 
                                            id="unidades" 
                                            name="unidades"
                                            value="<?= old('unidades'); ?>"
                                        >
                                    </div>
                                    <p id="error-message"><?= session('errors.unidades');?> </p>
                                    <div class="col-sm-3">
                                        <label for="precio" class="form-label">Precio:</label>
                                        <input 
                                            type="text" 
                                            class="form-control number" 
                                            id="precio" 
                                            name="precio" 
                                        >
                                    </div>
                                    <p id="error-message"><?= session('errors.precio');?> </p>
                                </div>
                                <div class="row" id="info-item">
                                    <div class="col-sm-9">
                                        <label class="form-label" for="observacion">Motivo:</label>
                                        <textarea 
                                            class="form-control" 
                                            id="observacion" 
                                            name="observacion"
                                        ><?= set_value('observacion'); ?></textarea>
                                    </div>
                                </div>
                                <div class="row" id="info-item">
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-primary" id="btnActualizar">Actualizar</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script src="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
    const btnActualizar = document.getElementById("btnActualizar");

    aData = {}

    $('#item').autocomplete({
        
        source: function(request, response){
            //limpiarCampos()
            $.ajax({
                url: 'get-item-cuantificable',
                method: 'GET',
                dataType: 'json',
                data: {
                    name: request.term
                },
                success: function(res) {
                    aData = $.map(res, function(value, key){
                        return{
                            id: value.id,
                            label: value.item
                        };
                    });
                    let results = $.ui.autocomplete.filter(aData, request.term);
                    $('#stock_actual').attr('disabled', false);
                    response(results)
                }
            });
        },
        select: function(event, ui){
            //document.getElementById('id').value = 10
            document.getElementById("id").value = ui.item.id
            document.getElementById("stock_actual").value = 0
            let id = ui.item.id
            //console.log(ui.item.id);
            getStockActual(id);
        }
    });

    const getStockActual = (id) =>{
        //console.log("stockActual " + id);
        $.ajax({
            url: 'getStockActual',
            method: 'GET',
            dataType: 'json',
            data: {
                id: id
            },
            success: function(res) {
                let resultado = JSON.parse(res)
                if (resultado !== null) {
                    document.getElementById("stock_actual").value = resultado + ' unidades'
                } else {
                    document.getElementById("stock_actual").value = ''
                }
            }
        })
    }

    // btnActualizar.addEventListener('click', function(e) {
    //     //e.preventDefault()
    //     let id = document.getElementById("id").value
    //     let movimiento = document.getElementById("movimiento").selectedIndex
    //     let unidades = document.getElementById("unidades").value
    //     let observacion = document.getElementById("observacion").value
    //     let precio = document.getElementById("precio").value

    //     $.ajax({
    //         url: 'registraMovimientoStock',
    //         method: 'GET',
    //         dataType: 'json',
    //         data: {
    //             id: id,
    //             movimiento: movimiento,
    //             unidades: unidades,
    //             observacion: observacion,
    //             precio: precio,
    //         },
    //         success: function(res) {
                
    //             limpiarCampos()
    //         }
    //     });
    // })

    function limpiarCampos(){
        document.getElementById("id").value = 0
        document.getElementById("item").value = ''
        document.getElementById("movimiento").selectedIndex = 0
        document.getElementById("unidades").value = 0
        document.getElementById("observacion").value = ''
        document.getElementById("precio").value = '0.00'
    }
</script>

