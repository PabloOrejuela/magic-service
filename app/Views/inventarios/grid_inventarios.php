<style>
    .inputValor{
        text-align: right;
    }

    #link-editar{
        color: #00514E;
        text-decoration: none;
    }

    #link-editar:hover{
        color: #000;
        text-decoration: none;
    }
    .input {
        border-radius: 300px;
        width: 250px;
    }
    .row {
        margin-bottom: 30px;
    }

    .form-check-input{
        margin: 0 auto
    }
</style>
<!-- Main content -->
<section class="content mb-3">
      <div class="container-fluid">
        <div class="row">
            <section>
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>Codigo</th>
                                <th>Item</th>
                                <th>Ultimo precio de compra</th>
                                <th>Stock actual</th>
                            </thead>
                            <tbody>
                                <?php
                                    use App\Models\StockActualModel;
                                    use App\Models\KardexModel;
                                    $this->stockActualModel = new StockActualModel();
                                    $this->kardexModel = new KardexModel();

                                    if (isset($items) && $items != NULL) {
                                        
                                        foreach ($items as $key => $value) {
                                            $stock = $this->stockActualModel->_getStock($value->id);
                                            $precio_compra = $this->kardexModel->_getUltimoPrecio($value->id);
                                            //echo '<pre>'.var_export($precio_compra, true).'</pre>';exit;
                                            echo '<tr>
                                                <td>'.$value->id.'</td>
                                                <td><a href="'.site_url().'kardex-item/'.$value->id.'" id="link-editar">'.$value->item.'</a></td>
                                                <td>'.$precio_compra.'</td>';
                                                if (isset($stock->stock_actual) && $stock->stock_actual != null) {
                                                    echo '<td>'.$stock->stock_actual.'</td>';
                                                } else {
                                                    echo '<td>0</td>';
                                                }
                                                
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        </form>
                    </div></div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $("input:checkbox").change(function() { 
            let id = $(this).attr("id")
            let value = 0    
            if($(this).is(":checked")) { 
                value = 1
                $.ajax({
                    url: 'item-cuantificable-update'+'/'+id+'/'+value,
                    type: 'GET',
                    //data: { strID:$(this).attr("id"), strState:"1" }
                });
            } else {
                $.ajax({
                    url: 'item-cuantificable-update'+'/'+id+'/'+value,
                    type: 'GET',
                    //data: { strID:$(this).attr("id"), strState:"0" }
                });
            }
        });         
    });

    $(document).ready(function () {
        $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
        $('#datatablesSimple').DataTable({
            "responsive": true, 
            "order": [[1, 'asc']],
            lengthMenu: [
                    [25, 50, -1],
                    [25, 50, 'Todos']
            ],
            language: {
                processing: 'Procesando...',
                lengthMenu: 'Mostrando _MENU_ registros por página',
                zeroRecords: 'No hay registros',
                info: 'Mostrando _START_ a _END_ de _MAX_',
                infoEmpty: 'No hay registros disponibles',
                infoFiltered: '(filtrando de _MAX_ total registros)',
                search: 'Buscar',
                paginate: {
                first:      "Primero",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": activar para ordenar ascendentemente",
                        sortDescending: ": activar para ordenar descendentemente"
                    }
            },
            //"lengthChange": false, 
            "autoWidth": false,
            "dom": "<'row'<'col-sm-12 col-md-8'l><'col-md-12 col-md-2'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
        });
    });
</script>
