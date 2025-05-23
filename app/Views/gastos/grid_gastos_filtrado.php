<link rel="stylesheet" href="<?= site_url(); ?>public/css/grid-gastos.css">
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
                            <a type="button" href="<?= site_url().'gasto-create/'; ?>"  class="btn btn-success mb-4" >Registrar un nuevo Gasto</a>
                        </div>
                        <form action="" method="post">
                            <div id="div-filtros">
                                <div class="form-group col-md-2">
                                    <label for="mes">Mes *:</label>
                                    <input 
                                        type="month" 
                                        class="form-control text" 
                                        id="mes" 
                                        name="mes" 
                                        value="<?= $mes; ?>" 
                                        required
                                    >
                                    <p id="error-message"><?= session('errors.mes');?> </p>
                                </div>
                            </div>
                            <div class="form-group col-md-5 mb-5">
                                <button type="submit" class="btn btn-primary" id="btnFiltro">Filtrar</button>
                                <a href="<?= site_url(); ?>gastos" class="btn btn-light cancelar" id="btn-cancela" target="_self">Ver todos</a>
                            </div>
                            
                        </form>
                        <table id="datatablesSimple" class="table table-bordered table-striped grid">
                            
                            <thead>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Sucursal</th>
                                <th>Negocio</th>
                                <th>Proveedor</th>
                                <th>Detalle gasto variable</th>
                                <th>Tipo Gasto fijo</th>
                                <th>Tipo gasto</th>
                                <th>Documento</th>
                                <th>Valor</th>
                            </thead>
                            <tbody>
                                <?php
                                    if (isset($gastos) && $gastos != NULL) {
                                        foreach ($gastos as $key => $value) {
                                            $ceros = 5 - strlen($value->id);
                                            $cadena = '';
                                            switch($ceros){
                                                case 2: 
                                                    $cadena = '00';
                                                    break;
                                                case 3: 
                                                    $cadena = '000';
                                                    break;
                                                case 4:
                                                    $cadena = '0000';
                                                    break;
                                                default:
                                                    $cadena = '0';
                                            }
                                            echo '<tr>
                                                <td><a href="'.site_url().'gasto-edit/'.$value->id.'" id="link-editar">'.$cadena.$value->id.'</a></td>
                                                <td>'.$value->fecha.'</td>
                                                <td>'.$value->sucursal.'</td>
                                                <td>'.$value->negocio.'</td>
                                                <td>'.$value->proveedor.'</td>
                                                <td>'.$value->detalleGastoVariable.'</td>
                                                <td>'.$value->gasto_fijo.'</td>
                                                <td>'.$value->tipo_gasto.'</td>
                                                <td>'.$value->documento.'</td>
                                                <td>'.$value->valor.'</td>
                                            ';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
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
        "dom": "<'row'<'col-md-12 col-md-4'l><'col-md-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
    });
});
</script>
