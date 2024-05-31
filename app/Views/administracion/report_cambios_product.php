<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-productos.css">
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
                                    <th>Detalle</th>
                                    <th>Usuario</th>
                                    <th class="centrado">Fecha</th>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($historial) && $historial != NULL) {
                                            
                                            foreach ($historial as $key => $value) {
                                                //echo '<pre>'.var_export($value, true).'</pre>';exit;
                                                echo '<tr>
                                                        <td>'.$value->id.'</td>
                                                        <td>
                                                            <a href="'.site_url().'detalle-cambio-prod/'.$value->id.'" 
                                                                id="link-editar"
                                                            >'.$value->detalle.'</a>
                                                        </td>
                                                        <td>'.$value->nombre.'</td>
                                                        <td class="centrado">'.$value->updated_at.'</td>
                                                    </tr>';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                        <a href="#" class="btn btn-light cancelar" id="btn-cancela" onclick="cancelar()">Cancelar</a>
                    </div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div><!-- /.row-->
    </div><!-- /.container-->
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/report-cambios-productos.js"></script>
<script>
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
            zeroRecords: 'No hay registros de cambios',
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
