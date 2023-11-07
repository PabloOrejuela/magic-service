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
    /* .input {
        border-radius: 300px;
        width: 100px;
    } */
    .row {
        margin-bottom: 20px;
    }

    #datatablesSimple{
        font-size: 0.7em;
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
                            <a type="button" id="btn-ventana" href="<?= site_url().'pedidos-ventana/'; ?>" target="_blank" class="edit mb-2">
                                <img src="<?= site_url().'public/images/ventana.png'; ?>" >
                                <span id="title-link">Abrir en nueva ventana</span>
                            </a>
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Pedido</th>
                                <th>Categoría</th>
                                <th>Sector</th>
                                <th>Dir. entrega</th>
                                <th>Fecha entrega</th>
                                <th>Hora entrega</th>
                                <th>Mensajero</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    // $mensajero[0] = '--Seleccionar--';

                                    // foreach ($mensajeros as $key => $value) {
                                    //     $mensajero[$value->id] = $value->nombre;
                                    // }

                                    if (isset($pedidos) && $pedidos != NULL) {
                                        foreach ($pedidos as $key => $value) {
                                            echo '<tr>
                                                <td>'.$value->fecha.'</td>
                                                <td>'.$value->nombre.'</td>
                                                <td><a href="'.site_url().'pedido-edit/'.$value->id.'" id="link-editar">'.$value->cod_pedido.'</a></td>
                                                <td>'.$value->categoria.'</td>
                                                <td>'.$value->sector.'</td>';
                                                if ($value->dir_entrega) {
                                                    echo '<td>'.$value->dir_entrega.'</td>';
                                                }else{
                                                    echo '<td>Registrar</td>';
                                                }
                                                if ($value->fecha_entrega) {
                                                    echo '<td>'.$value->fecha_entrega.'</td>';
                                                }else{
                                                    echo '<td>Registrar fecha de entrega</td>';
                                                }
                                            echo '<td>'.$value->hora.'</td>';
                                            echo '<td>'.$value->mensajero.'</td>';
                                                if ($value->estado == 1) {
                                                    echo '<td>Activo</td>';
                                                }else if($value->estado == 0){
                                                    echo '<td>Inactivo</td>';
                                                }
                                            echo '<td>
                                                    <div class="contenedor">
                                                        <a type="button" id="btn-register" href="'.site_url().'prod-delete/'.$value->id.'" class="edit">
                                                            <img src="'.site_url().'public/images/edit.png" width="20" >
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
