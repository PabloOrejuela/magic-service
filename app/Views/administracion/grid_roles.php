<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/plugins/jquery-ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-roles.css">
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
                                            echo '<tr>';
                                            echo '<td>'.$value->rol.'</td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-admin_'.$value->id.'" 
                                                        data-campo="admin" 
                                                    >';
                                                        if ($value->admin == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->admin == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-ventas_'.$value->id.'" 
                                                        data-campo="ventas" 
                                                    >';
                                                        if ($value->ventas == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->ventas == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-clientes_'.$value->id.'" 
                                                        data-campo="clientes" 
                                                    >';
                                                        if ($value->clientes == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->clientes == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-proveedores_'.$value->id.'" 
                                                        data-campo="proveedores" 
                                                    >';
                                                        if ($value->proveedores == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->proveedores == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-gastos_'.$value->id.'" 
                                                        data-campo="gastos" 
                                                    >';
                                                        if ($value->gastos == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->gastos == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-entregas_'.$value->id.'" 
                                                        data-campo="entregas" 
                                                    >';
                                                        if ($value->entregas == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->entregas == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-inventarios_'.$value->id.'" 
                                                        data-campo="inventarios" 
                                                    >';
                                                        if ($value->inventarios == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->inventarios == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '<td>
                                                    <a 
                                                        href="#" 
                                                        onclick="javascript:changePermisoAdmin('.$value->id.')" 
                                                        id="input-reportes_'.$value->id.'" 
                                                        data-campo="reportes" 
                                                    >';
                                                        if ($value->reportes == 1) {
                                                            echo    '<input
                                                                        value="Permitido"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-permitido"
                                                                        readonly
                                                                        
                                                                    >';
                                                        }else if($value->reportes == 0){
                                                            echo    '<input
                                                                        value="Denegado"
                                                                        class="form-control rol-permisos"
                                                                        id="rol-denegado"
                                                                        readonly
                                                                    >';
                                                        }
                                            echo '</a></td>';
                                            echo '</tr>';
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
