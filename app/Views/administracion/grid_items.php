<link rel="stylesheet" href="<?= site_url(); ?>/public/css/grid-items.css">
<!-- Main content -->
<section class="content mb-3">
      <div class="container-fluid">
        <div class="row">
            <section>
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <div>
                            <a type="button" href="<?= site_url().'frm-item-create/'; ?>"  class="btn btn-success mb-2" >Registrar un nuevo Item</a>
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            <thead>
                                <th class="col-md-1">Codigo</th>
                                <th>Item</th>
                                <th class="col-md-1">Precio</th>
                                <th class="col-md-1">Cuantificable</th>
                                <th class="col-md-1">Estado</th>
                                <th class="col-md-1">Borrar</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($items) && $items != NULL) {
                                        foreach ($items as $key => $value) {
                                            echo '<tr>
                                                <td>'.$value->id.'</td>
                                                <td><a href="'.site_url().'item-edit/'.$value->id.'" id="link-editar">'.$value->item.'</a></td>
                                                <td>
                                                    <input 
                                                        value="'.$value->precio.'"
                                                        class="form-control input-precio"
                                                        id="input-precio_'.$value->id.'" 
                                                        onchange="changeData('.$value->id.')" 
                                                    >
                                                </td>';
                                                if ($value->cuantificable == 1) {
                                                    echo '<td class="centrado"><input class="form-check-input" type="checkbox" name="cuantificable" value="1" id="'.$value->id.'" checked></td>';
                                                }else if($value->cuantificable == 0){
                                                    echo '<td class="centrado"><input class="form-check-input" type="checkbox" name="cuantificable" value="1" id="'.$value->id.'"></td>';
                                                }
                                                if ($value->estado == 1) {
                                                    echo '<td class="centrado">Activo</td>';
                                                }else if($value->estado == 0){
                                                    echo '<td class="centrado">Inactivo</td>';
                                                }
                                            echo '
                                                <td>
                                                    <div class="contenedor centrado">
                                                        <a type="button" id="btn-register" href="'.site_url().'item-delete/'.$value->id.'" class="edit">
                                                            <img src="'.site_url().'public/images/delete.png" width="30" >
                                                        </a>
                                                    </div>
                                                </td>
                                                </tr>';
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/grid-items.js"></script>
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
