<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-proveedores.css">
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <div>
                            <a type="button" id="btn-register" href="<?= site_url().'proveedor-create/'; ?>"  class="btn btn-success mb-2" >Registrar un nuevo Proveedor</a>
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Contacto</th>
                                <th>Telf. contacto</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($proveedores) && $proveedores != NULL) {
                                        foreach ($proveedores as $key => $value) {
                                            echo '<tr>
                                                <td><a href="'.site_url().'proveedor-edit/'.$value->id.'" id="link-editar">'.$value->nombre.'</a></td>
                                                <td>'.$value->documento.'</td>
                                                <td>'.$value->contacto.'</td>
                                                <td>'.$value->celular_contacto.'</td>';
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
        "order": [[0, 'asc']],
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
