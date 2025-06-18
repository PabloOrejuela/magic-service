<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-sucursales.css">
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <div><a type="button" href="<?= site_url().'sucursal-create/'; ?>" class="btn btn-success mb-2" >Registrar una nueva Sucursal</a>
                        </div>
                        <?php 

                            if (session()->getFlashdata('mensaje')){
                                if (session()->getFlashdata('mensaje') == 'success') {
                                    echo '<div class="alert alert-success" role="alert">La sucursal se ha eliminado correctamente.</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Ha ocurrido un error al eliminar la sucursal, la sucursal tiene sectores asignados.</div>';
                                }
                            }

                        ?>
                        <form action="#" method="post">
                            <p id="mensaje-warning">* Recuerde que borrar una sucursal borra también los sectores de entrega relacionados a esa sucursal y toda la información que está relacionada con los sectores de entrega, por ejemplo los pedidos.</p>
                            <table id="datatablesSimple" class="table table-bordered table-striped">
                                <thead>
                                    <th>No.</th>
                                    <th>Sucursal</th>
                                    <th>Dirección</th>
                                    <th>Borrar</th>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($sucursales) && $sucursales != NULL) {
                                            foreach ($sucursales as $key => $value) {
                                                echo '<tr>
                                                    <td>'.$value->id.'</td>
                                                    <td><a href="'.site_url().'sucursal-edit/'.$value->id.'" id="link-editar">'.$value->sucursal.'</a></td>
                                                    <td>'.$value->direccion.'</td>';
                                                echo '<td>
                                                        <div class="contenedor">
                                                            <a type="button" id="btn-register" href="'.site_url().'sucursal-delete/'.$value->id.'" class="edit">
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
                    </div><!-- /.card-body -->
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
