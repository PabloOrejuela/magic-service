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
                                <th>No.</th>
                                <th>Sector</th>
                                <th>Sucursal que procesa los pedidos</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($sectores) && $sectores != NULL) {
                                        foreach ($sectores as $key => $value) {
                                            echo '<tr>
                                                <td>'.$value->idsector.'</td>
                                                <td><a type="button" id="'.$value->idsector.'" href="#"  data-id="'.$value->idsector.'" data-bs-toggle="modal" data-bs-target="#sucursalModal">'.$value->sector.'</a></td>
                                                <td>'.$value->sucursal.'</td>
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
        <select 
            class="form-select" 
            id="sucursal" 
            name="sucursal"
            data-style="form-control" 
            data-live-search="true" 
        >
        <option value="0" selected>--Seleccionar una sucursal--</option>
        <?php 
            $defaultvalue = 1;
            if (isset($sucursales)) {
                foreach ($sucursales as $key => $sucursal) {
                    echo '<option value="'.$sucursal->id.'" >'.$sucursal->sucursal.'</option>';
                }
            }
        ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="actualizarSucursal(document.getElementById('sector').value, document.getElementById('sucursal').value)">Actualizar</button>
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
