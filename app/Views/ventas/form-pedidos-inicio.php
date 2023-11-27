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
    
    .item-list:hover{
        cursor: move;
        caret-color: red;
        box-shadow: 0px 0px 20px rgba(149, 153, 159, 0.3)
    }

    .lista .item-list.fantasma{
        border: 2px dotted #000;
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
                            <h3 id="error-message">Implementando funcionalidad Drag and Drop a las filas del grid de pedidos</h3>
                        </div>
                        <form action="#" method="post">
                        <table id="datatablesSimple" class="table table-bordered table-striped">
                            <thead>
                                <th>Pedido</th>
                                <th>Fecha entrega</th>
                                <th>Cliente</th>
                                <th>Sector</th>
                                <th>Dir. entrega</th>
                                <th>COD Arreglo</th>
                                <th>Hora salida</th>
                                <th>Hora entrega</th>
                                <th>Mensajero</th>
                                <th>Estado</th>
                                <th>Información</th>
                                <th>Observación</th>
                                <th>Copiar</th>
                            </thead>
                            <tbody id="lista">
                                <?php
                                    // $mensajero[0] = '--Seleccionar--';

                                    // foreach ($mensajeros as $key => $value) {
                                    //     $mensajero[$value->id] = $value->nombre;
                                    // }

                                    if (isset($pedidos) && $pedidos != NULL) {
                                        foreach ($pedidos as $key => $value) {
                                            echo '<tr class="item-list" data-id="'.$value->id.'">
                                                <td><a href="'.site_url().'pedido-edit/'.$value->id.'" id="link-editar">'.$value->cod_pedido.'</a></td>';
                                                if ($value->fecha_entrega) {
                                                    echo '<td>'.$value->fecha_entrega.'</td>';
                                                }else{
                                                    echo '<td>Registrar fecha de entrega</td>';
                                                }
                                            echo '<td>'.$value->nombre.'</td>';
                                            if ($value->sector) {
                                                echo '<td>'.$value->sector.'</td>';
                                            }else{
                                                echo '<td></td>';
                                            }
                                            if ($value->dir_entrega) {
                                                echo '<td>'.$value->dir_entrega.'</td>';
                                            }else{
                                                echo '<td>Registrar dirección</td>';
                                            }
                                            echo '<td></td>';
                                            echo '<td>H SALIDA</td>';
                                            echo '<td>'.$value->hora.'</td>';
                                            echo '<td>'.$value->mensajero.'</td>';
                                            if ($value->estado == 1) {
                                                echo '<td>Activo</td>';
                                            }else if($value->estado == 0){
                                                echo '<td>Inactivo</td>';
                                            }
                                            echo '<td>Información</td>';
                                            echo '<td>Observación</td>';
                                            echo '<td>
                                                    <div class="contenedor" id="btn-copy">
                                                        <a type="button" id="btn-register" href="'.site_url().'prod-delete/'.$value->id.'" >
                                                            <img src="'.site_url().'public/images/copy.png" width="30" >
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
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    const lista = document.getElementById('lista')
    Sortable.create(lista, {
        chosenClass: "seleccionado",
        ghostClass: "fantasma",
        onEnd: () => {
            //console.log('se movió el elemento')
        },
        group: "lista-pedidos-grid",
        store: {
            //Guarda el orden de la lista
            set: (sortable) => {
                const orden = sortable.toArray()
                localStorage.setItem(sortable.options.group.name, orden.join('|'))
            },

            //Obtenemos el óden de la lista
            get: (sortable) => {
                const orden = localStorage.getItem(sortable.options.group.name)
                return orden ? orden.split('|') : []
            },

        }
    })
</script>
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
