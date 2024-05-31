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
                        <div>
                            <?php
                                if ($session->ventas == 1) {
                                    echo '<a type="button" href="'.site_url().'producto-create/"  class="btn btn-success mb-2" >Registrar Nuevo Producto</a>';
                                }
                            ?>
                            
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>No.</th>
                                <th>Producto</th>
                                <th>Categoria</th>
                                <th>Precio</th>
                                <th class="centrado">Estado</th>
                                <th class="centrado">Arreglo definitivo</th>
                                <th class="centrado">Habilitado hasta</th>
                                <th class="centrado">Historial</th>
                                <th class="centrado">Borrar</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($productos) && $productos != NULL) {
                                        
                                        foreach ($productos as $key => $value) {
                                            
                                            echo '<tr>
                                                <td>'.$value->id.'</td>
                                                <td>
                                                    <a href="'.site_url().'product-edit/'.$value->id.'" 
                                                        id="link-editar"
                                                    >'.$value->producto.'</a>
                                                </td>
                                                <td>'.$value->categoria.'</td>
                                                <td class="right">'.$value->precio.'</td>';
                                                if ($value->estado == 1) {
                                                    echo '<td class="centrado" id="estado_'.$value->id.'">Activo</td>';
                                                }else if($value->estado == 0){
                                                    echo '<td class="centrado" id="estado_'.$value->id.'">Inactivo</td>';
                                                }
                                                if ($value->attr_temporal == 0) {
                                                    echo '<td class="centrado" id="temp_'.$value->id.'">Definitivo</td>';
                                                }else if($value->attr_temporal == 1){
                                                    echo '<td class="centrado" id="temp_'.$value->id.'">Temporal</td>';
                                                }
                                                if ($value->attr_temporal == 0) {
                                                    echo '<td class="centrado" id="temp_'.$value->id.'"></td>';
                                                }else if($value->attr_temporal == 1){
                                                    $updatedAt = date($value->updated_at);
                                                    $timeHasta = strtotime($updatedAt."+ 30 days");
                                                    $fechaHasta = date('Y-m-d',$timeHasta);
                                                    echo '<td class="centrado">'.$fechaHasta.'</td>';
                                                }
                                            echo '<td>
                                                    <div class="contenedor centrado">
                                                        <a type="button" id="btn-register" href="'.site_url().'prod-historial-changes/'.$value->id.'" class="edit">
                                                            <img src="'.site_url().'public/images/list.png" width="30" >
                                                        </a>
                                                    </div>
                                                </td>
                                            
                                                    <td>
                                                    <div class="contenedor centrado">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/grid-productos.js"></script>
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
