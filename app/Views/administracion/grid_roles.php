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
                                <th>Clientes</th>
                                <th>Proveedores</th>
                                <th>Gastos</th>
                                <th>Entregas</th>
                                <th>Inventarios</th>
                                <th>Reportes</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($roles) && $roles != NULL) {
                                        //echo '<pre>'.var_export($roles, true).'</pre>';exit;
                                        foreach ($roles as $key => $value) {
                                            echo '<tr>
                                                    <td>'.$value->rol.'</td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->admin.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="admin"
                                                            id="input-admin_'.$value->id.'" 
                                                            onchange="changePermisoAdmin('.$value->id.')" 
                                                        >
                                                    </td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->ventas.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="ventas"
                                                            id="input-ventas_'.$value->id.'" 
                                                            onchange="changePermisoVentas('.$value->id.')" 
                                                        >
                                                    </td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->clientes.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="clientes"
                                                            id="input-clientes_'.$value->id.'" 
                                                            onchange="changePermisoClientes('.$value->id.')" 
                                                        >
                                                    </td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->proveedores.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="proveedores"
                                                            id="input-proveedores_'.$value->id.'" 
                                                            onchange="changePermisoProveedores('.$value->id.')" 
                                                        >
                                                    </td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->gastos.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="gastos"
                                                            id="input-gastos_'.$value->id.'" 
                                                            onchange="changePermisoGastos('.$value->id.')" 
                                                        >
                                                    </td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->entregas.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="entregas"
                                                            id="input-entregas_'.$value->id.'" 
                                                            onchange="changePermisoEntregas('.$value->id.')" 
                                                        >
                                                    </td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->inventarios.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="inventarios"
                                                            id="input-inventarios_'.$value->id.'" 
                                                            onchange="changePermisoInventarios('.$value->id.')" 
                                                        >
                                                    </td>
                                                    <td>
                                                        <input 
                                                            value="'.$value->reportes.'"
                                                            class="form-control rol-permisos"
                                                            data-campo="reportes"
                                                            id="input-reportes_'.$value->id.'" 
                                                            onchange="changePermisoReportes('.$value->id.')" 
                                                        >
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
<script src="<?= site_url(); ?>public/js/grid-roles.js"></script>
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
