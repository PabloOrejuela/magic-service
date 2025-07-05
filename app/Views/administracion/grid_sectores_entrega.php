<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-sectores-entrega.css">
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <div><a type="button" href="<?= site_url().'sector-entrega-create/'; ?>" class="btn btn-success mb-2" >Registrar una nuevo Sector de Entrega</a></div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Sector</th>
                                <th>Costo ($)</th>
                                <th>Sucursal que procesa los pedidos</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($sectores) && $sectores != NULL) {
                                        foreach ($sectores as $key => $value) {
                                            echo '<tr>
                                                <td>'.$value->idsector.'</td>
                                                <td>
                                                    <a 
                                                        type="button" 
                                                        id="'.$value->idsector.'" 
                                                        href="#"  
                                                        data-id="'.$value->idsector.'" 
                                                        data-sucursal="'.$value->idsucursal.'" 
                                                        data-costo_entrega="'.$value->costo_entrega.'" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#sucursalModal">'.$value->sector.
                                                    '</a>
                                                </td>
                                                <td>'.number_format($value->costo_entrega+4, 2).'</td>
                                                <td>'.$value->sucursal.'</td>
                                                </tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>

<!-- Modal Hora Entrega-->
<div class="modal fade" id="sucursalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar sucursal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="modal-title" id="staticBackdropLabel">Sucursales</h5>
        <input class="form-control" type="hidden" name="sector" id="sector">
        <input class="form-control" type="hidden" name="sector" id="sucursal_actual">
        <select 
            class="form-select" 
            id="sucursal" 
            name="sucursal"
            data-style="form-control" 
            data-live-search="true" 
        >
        
        </select>
        <div class="mt-3">
            <label for="costo_entrega">Costo de la entrega:</label>
            <input class="form-control" type="text" name="costo_entrega" id="costo_entrega"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="actualizarSucursal(document.getElementById('sector').value, document.getElementById('sucursal').value,document.getElementById('costo_entrega').value)">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="<?= site_url(); ?>public/js/grid-sectores.js"></script>
<script>
  $(document).ready(function () {
    $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
    $('#datatablesSimple').DataTable({
        "responsive": true, 
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
