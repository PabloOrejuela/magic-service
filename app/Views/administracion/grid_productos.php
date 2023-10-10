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
        margin-bottom: 20px;
    }
</style>
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>No.</th>
                                <th>Producto</th>
                                <th>Categoria</th>
                                <th>Estado</th>
                                <th>Borrar</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($productos) && $productos != NULL) {
                                        foreach ($productos as $key => $value) {
                                            echo '<tr>
                                                <td>'.$value->id.'</td>
                                                <td><a href="'.site_url().'prod_4_edit/'.$value->id.'" id="link-editar">'.$value->producto.'</a></td>
                                                <td>'.$value->categoria.'</td>';
                                                if ($value->estado == 1) {
                                                    echo '<td>Activo</td>';
                                                }else if($value->estado == 0){
                                                    echo '<td>Inactivo</td>';
                                                }
                                            echo '<td>
                                                    <div class="contenedor">
                                                        <a type="button" id="btn-register" href="'.site_url().'prod-delete/'.$value->id.'" class="edit">
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
<script>
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
        "dom": "<'row'<'col-sm-12 col-md-10'l><'col-sm-12 col-md-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
    });
});
</script>
