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
                                <th>Rol</th>
                                <th>Administración</th>
                                <th>Ventas</th>
                                <th>Proveedores</th>
                                <th>Reportes</th>
                                <th>Editar</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($roles) && $roles != NULL) {
                                        foreach ($roles as $key => $value) {
                                            echo '<tr>
                                                    <td>'.$value->rol.'</td>
                                                    <td>'.$value->admin.'</td>
                                                    <td>'.$value->ventas.'</td>
                                                    <td>'.$value->proveedores.'</td>
                                                    <td>'.$value->reportes.'</td>
                                                    <td>
                                                        <div class="contenedor">
                                                            <a type="button" id="btn-register" href="'.site_url().'rol-edit/'.$value->id.'" class="edit">
                                                                <img src="'.site_url().'public/images/edit.png" width="30" >
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
        "dom": "<'row'<'col-sm-12 col-md-10'><'col-sm-12 col-md-2'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'><'col-sm-12 col-md-6'>>"
    });
});
</script>
