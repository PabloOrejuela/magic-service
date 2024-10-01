<link rel="stylesheet" href="<?= site_url(); ?>/public/css/grid-formas-pago.css">
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
                            <a type="button" href="<?= site_url().'form-pago-create/'; ?>" class="btn btn-success mb-2" >Registrar una nueva institución financiera</a>
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>Institución financiera</th>
                                <th>Estado</th>
                                <th>Desactivar</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($institucionesFinancieras) && $institucionesFinancieras != NULL) {
                                        foreach ($institucionesFinancieras as $key => $instFinanciera) {
                                            echo '<tr>
                                                <td>'.$instFinanciera->banco.'</td>';
                                                if ($instFinanciera->estado == 1) {
                                                    echo '<td>Activo</td>';
                                                }else if($instFinanciera->estado == 0){
                                                    echo '<td>Inactivo</td>';
                                                }
                                            echo '
                                                <td>
                                                    <div class="contenedor">
                                                        <a type="button" id="btn-register" href="'.site_url().'institucion-financiera-delete/'.$instFinanciera->id.'/'.$instFinanciera->estado.'" class="edit">
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
