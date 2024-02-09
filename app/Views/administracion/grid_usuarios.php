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
                        <div>
                            <a type="button" href="<?= site_url().'usuario-create/'; ?>" class="btn btn-success mb-2" >Registrar un nuevo Usuario</a>
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                <th>Dirección</th>
                                <th>Documento</th>
                                <th>Rol</th>
                                <th>Logueado</th>
                                <th>Estado</th>
                                <th>Desactivar</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($usuarios) && $usuarios != NULL) {
                                        foreach ($usuarios as $key => $value) {
                                            echo '<tr>
                                                <td><a href="'.site_url().'usuario-edit/'.$value->id.'" id="link-editar">'.$value->nombre.'</a></td>
                                                <td>'.$value->telefono.'</td>
                                                <td>'.$value->email.'</td>
                                                <td>'.$value->direccion.'</td>
                                                <td>'.$value->cedula.'</td>
                                                <td>'.$value->rol.'</td>
                                                <td>'.$value->logged.'</td>';
                                                if ($value->estado == 1) {
                                                    echo '<td>Activo</td>';
                                                }else if($value->estado == 0){
                                                    echo '<td>Inactivo</td>';
                                                }
                                            echo '
                                                <td>
                                                    <div class="contenedor">
                                                        <a type="button" id="btn-register" href="'.site_url().'item-delete/'.$value->id.'/'.$value->estado.'" class="edit">
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
        "dom": "<'row'<'col-sm-12 col-md-8'l><'col-md-12 col-md-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
    });
});
</script>
