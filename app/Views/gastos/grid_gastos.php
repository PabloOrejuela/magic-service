<style>
    .row {
        margin-bottom: 20px;
    }

    .div.dataTables_length select{
        width: 150px; important!;
    }

    .grid{
        font-size: 0.8em;
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
                            <a type="button" href="<?= site_url().'gasto-create/'; ?>"  class="btn btn-success mb-2" >Registrar un nuevo Gasto</a>
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped grid">
                            
                            <thead>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Sucursal</th>
                                <th>Negocio</th>
                                <th>Proveedor</th>
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
                                                <td>'.$value->tipo_gasto.'</td>
                                                <td>'.$value->documento.'</td>
                                                <td>'.$value->valor.'</td>
                                            ';
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
        "dom": "<'row'<'col-md-12 col-md-4'l><'col-md-12 col-md-4'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>"
    });
});
</script>
