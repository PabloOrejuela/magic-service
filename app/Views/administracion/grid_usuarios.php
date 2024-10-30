<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-usuarios.css">
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
                                <th>Segundo Rol</th>
                                <th>Ventas</th>
                                <th>Logueado</th>
                                <th>Sesión</th>
                                <th>Estado</th>
                                <th>Desactivar</th>
                            </thead>
                            <tbody>
                                <?php
                                    use App\Models\rolModel;
                                    $this->rolModel = new rolModel();

                                    if (isset($usuarios) && $usuarios != NULL) {
                                        //echo '<pre>'.var_export($usuarios, true).'</pre>';exit;

                                        foreach ($usuarios as $key => $value) {
                                            $rol_2 = $this->rolModel->select('rol')->find($value->idrol_2);
                                            $roles = $this->rolModel->findAll();
                                            echo '<tr>
                                                <td><a href="'.site_url().'usuario-edit/'.$value->id.'" id="link-editar">'.$value->nombre.'</a></td>
                                                <td>'.$value->telefono.'</td>
                                                <td>'.$value->email.'</td>
                                                <td>'.$value->direccion.'</td>
                                                <td>'.$value->cedula.'</td>
                                                <td>'.$value->rol.'</td>';

                                                if ($value->idrol_2 == 0) {
                                                    echo '<td id="td-ventas">
                                                        <a
                                                            id="btn-register_'.$value->id.'"
                                                            data-id="'.$value->id.'"
                                                            data-idrol="'.$value->idroles.'"
                                                            data-rol2="ASIGNAR"
                                                            data-idrol_2="'.$value->idrol_2.'"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#asignaSegundoRolModal"
                                                            href="#" 
                                                            class="edit"
                                                        >ASIGNAR</a>
                                                    </td>';
                                                } else {
                                                    echo '<td id="td-ventas">
                                                        <a
                                                            id="btn-register_'.$value->id.'"
                                                            data-id="'.$value->id.'"
                                                            data-idrol="'.$value->idroles.'"
                                                            data-rol2="'.$rol_2->rol.'"
                                                            data-idrol_2="'.$value->idrol_2.'"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#asignaSegundoRolModal"
                                                            href="#" 
                                                            class="edit"
                                                        >'.$rol_2->rol.'</a>
                                                    </td>';
                                                }
                                                
                                                

                                                if ($value->es_vendedor == 0 && $value->rol != 'VENDEDOR') {
                                                    echo '<td id="td-ventas">
                                                            <a
                                                                id="btn-register" 
                                                                href="#" 
                                                                class="edit"
                                                                onclick="javascript:estadoVentas('.$value->id.','.$value->es_vendedor.')"
                                                            >
                                                            NO</a>
                                                        </td>';
                                                } else {
                                                    echo '<td id="td-ventas">
                                                            <a 
                                                                id="btn-register" 
                                                                href="#" 
                                                                class="edit"
                                                                onclick="javascript:estadoVentas('.$value->id.','.$value->es_vendedor.')"
                                                            >SI</a>
                                                        </td>';
                                                }
                                            
                                                if ($value->logged == 1) {
                                                    echo '<td id="td-online" >ONLINE</td>';
                                                    echo '
                                                        <td>
                                                            <div class="contenedor button">
                                                                <a 
                                                                    type="button" 
                                                                    id="btn-register" 
                                                                    href="#" 
                                                                    class="edit"
                                                                    onclick="javascript:sessionClose('.$value->id.')"
                                                                >
                                                                    <img src="'.site_url().'public/images/salir-sesion.png" width="30" >
                                                                </a>
                                                            </div>
                                                        </td>';
                                                }else if($value->logged == 0){
                                                    echo '<td id="td-offline" >OFFLINE</td>';
                                                    echo '
                                                        <td>
                                                        </td>';
                                                }

                                                if ($value->estado == 1) {
                                                    echo '<td>Activo</td>';
                                                }else if($value->estado == 0){
                                                    echo '<td>Inactivo</td>';
                                                }
                                            
                                            echo '
                                                <td>
                                                    <div class="contenedor button">
                                                        <a 
                                                            type="button" 
                                                            id="btn-register" 
                                                            href="#" 
                                                            class="edit"
                                                            onclick="javascript:userDelete('.$value->id.')"
                                                        >
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

<!-- Asigna segundo rol-->
<div class="modal fade" id="asignaSegundoRolModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar un segundo rol</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" id="staticBackdropLabel">Roles</h5>
      <input class="form-control" type="hidden" name="idusuario" id="idusuario">
      <input class="form-control" type="hidden" name="idrol" id="idrol">
        <select 
            class="form-select" 
            id="select-roles" 
            name="idrol_2"
            data-style="form-control" 
            data-live-search="true" 
        >
        </select>
      </div>
      <div class="modal-footer">
        <button 
            type="button" 
            class="btn btn-secondary" 
            data-bs-dismiss="modal" 
            onClick="asignaRol(document.getElementById('idusuario').value, document.getElementById('idrol').value, document.getElementById('select-roles').value)"
        >Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= site_url(); ?>public/js/grid-usuarios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
