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
                            <h3 id="error-message">Trabajando en los modales de los campos</h3>
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
                                    use App\Models\DetallePedidoModel;
                                    $this->detallePedidoModel = new DetallePedidoModel();

                                    if (isset($pedidos) && $pedidos != NULL) {
                                        foreach ($pedidos as $key => $value) {
                                            $detalle = $this->detallePedidoModel->_getDetallePedido($value->cod_pedido);
                                            //echo '<pre>'.var_export($detalle, true).'</pre>';exit;
                                            echo '<tr class="item-list" data-id="'.$value->id.'">
                                                <td><a href="'.site_url().'pedido-edit/'.$value->id.'" id="link-editar">'.$value->cod_pedido.'</a></td>';
                                                if ($value->fecha_entrega) {
                                                    echo '<td id="fechaEntrega_'.$value->id.'">'.$value->fecha_entrega.'</td>';
                                                }else{
                                                    echo '<td>Registrar fecha de entrega</td>';
                                                }
                                            echo '<td>'.$value->nombre.'</td>';
                                            if ($value->sector) {
                                                echo '<td id="sector_'.$value->id.'">'.$value->sector.'</td>';
                                            }else{
                                                echo '<td></td>';
                                            }
                                            if ($value->dir_entrega) {
                                                echo '<td id="direccion_'.$value->id.'">'.$value->dir_entrega.'</td>';
                                            }else{
                                                echo '<td>Registrar dirección</td>';
                                            }
                                            echo '<td>';
                                            foreach ($detalle as $key => $d) {
                                                echo $d->producto;
                                            }
                                            echo '</td>';
                                            echo '<td>H SALIDA</td>';
                                            echo '<td id="horaEntrega_'.$value->id.'">'.$value->hora.'</td>';
                                            echo '<td id="mensajero'.$value->id.'">
                                                    <a type="button" id="'.$value->id.'" href="#" data-id="'.$value->cod_pedido.'" data-bs-toggle="modal" data-bs-target="#mensajeroModal">'.$value->mensajero.'</a>
                                                </td>';
                                            if ($value->estado == 1) {
                                                echo '<td>Activo</td>';
                                            }else if($value->estado == 0){
                                                echo '<td>Inactivo</td>';
                                            }
                                            echo '<td>Información</td>';
                                            echo '<td>Observación</td>';
                                            echo '<td>
                                                    <div class="contenedor" id="btn-copy">
                                                        <a type="button" id="btn-register" href="javascript:copyData('.$value->id.')" >
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
<!-- Modal Mensajero-->
<div class="modal fade" id="mensajeroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambio de mensajero para el pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" id="staticBackdropLabel">Mensajeros</h5>
      <input class="form-control" type="hidden" name="codigo_pedido" id="codigo_pedido">
        <select 
            class="form-select" 
            id="mensajero" 
            name="mensajero"
            data-style="form-control" 
            data-live-search="true" 
        >
        <option value="0" selected>--Seleccionar un mensajero--</option>
        <?php 
            $defaultvalue = 1;
            if (isset($mensajeros)) {
                foreach ($mensajeros as $key => $m) {
                    if ($m->id == $defaultvalue) {
                        echo "<option value='$m->id' " . set_select('producto', $m->id, false). " selected>". $m->nombre."</option>";
                    }else{
                        echo "<option value='$m->id' " . set_select('producto', $m->id, false). " >". $m->nombre."</option>";
                    }
                }
            }
        ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="actualizarMensajero(document.getElementById('mensajero').value, document.getElementById('codigo_pedido').value)">Atualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
    let botones = document.querySelectorAll('[data-bs-target="#mensajeroModal"]');
        botones.forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                //console.log(id);
                document.querySelector('#codigo_pedido').value = id;
                //console.log('abrir modal');
                $('#mensajeroModal').modal();
            });
        });

        function actualizarMensajero(mensajero, codigo_pedido){
            // console.log(mensajero);
            // console.log(codigo_pedido);
            $.ajax({
                type:"GET",
                dataType:"html",
                url: "<?php echo site_url(); ?>ventas/actualizaMensajero/"+mensajero+'/'+codigo_pedido,
                //data:"codigo="+valor,
                beforeSend: function (f) {
                    //$('#cliente').html('Cargando ...');
                },
                success: function(data){
                    //console.log(data);
                    location.replace('pedidos');
                }
            });
        }
</script>





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
    
function copyData(id){
    let sector = document.getElementById("sector_"+id)
    let direccion = document.getElementById("direccion_"+id)
    let fechaEntrega = document.getElementById("fechaEntrega_"+id)
    let horaEntrega = document.getElementById("horaEntrega_"+id)

    console.log(horaEntrega.innerHTML);

    navigator.clipboard.writeText(sector.innerHTML + " \n" + direccion.innerHTML + " \n" + fechaEntrega.innerHTML + " \n" + horaEntrega.innerHTML)

    alert('El texto "' + sector.innerHTML + ' ' + direccion.innerHTML + '" se ha copiado!!!')
}

    function editar(este) {
      let ModalEdit = new bootstrap.Modal(mensajeroModal, function(este){
        let dato = este
      }).show();
    }

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
