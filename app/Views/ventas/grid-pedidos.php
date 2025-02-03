<link rel="stylesheet" href="<?= site_url(); ?>/public/css/grid-pedidos.css">
<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <div><input type="text" value="<?= session('mensaje'); ?>" id="msj" readonly></div>
                        <div><textarea class="form-control" placeholder="" id="mensaje"></textarea></div>
                        <div>
                            <a href="<?= site_url().'pedidos-ventana/'; ?>"  class="btn btn-success mb-2" target="_blank">Abrir en nueva ventana</a>
                        </div>
                        <div class="botones mb-2">
                            <a href="<?= base_url(); ?>ventas" class="btn btn-primary" id="btn-pedido-2" data-id="<?= session('id') ?>">Registrar Nuevo Pedido</a>
                            <a href="<?= base_url(); ?>cotizador" class="btn btn-primary" id="btn-cotizador">Cotizador</a>
                        </div>
                        <form action="#" method="post">
                            <table id="datatablesSimple" class="table table-bordered table-striped">
                                <thead>
                                    <th></th>
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
                                        use App\Models\PedidoModel;
                                        use App\Models\DetallePedidoModel;
                                        use App\Models\AttrExtArregModel;
                                        $this->attrExtArregModel = new AttrExtArregModel();
                                        $this->detallePedidoModel = new DetallePedidoModel();
                                        $this->pedidoModel = new PedidoModel();
                                        $pedidos = $this->pedidoModel->_getPedidos();
                                        $nombresDias = array(
                                            'Sunday'=>"Domingo", 
                                            'Monday'=>"Lunes", 
                                            'Tuesday'=>"Martes", 
                                            'Wednesday'=>"Miércoles", 
                                            'Thursday'=>"Jueves", 
                                            'Friday'=>"Viernes", 
                                            'Saturday'=>"Sábado"
                                        );

                                        if (isset($pedidos) && $pedidos != NULL) {
                                            foreach ($pedidos as $key => $value) {
                                                $nombreDia = $nombresDias[date('l', strtotime($value->fecha_entrega))];
                                                
                                                $detalle = $this->detallePedidoModel->_getDetallePedido($value->cod_pedido);
                                                $verificaCampos = $this->pedidoModel->_verificaCampos($value->id, $detalle);

                                                echo '<tr class="item-list" data-id="'.$value->id.'">
                                                        <td><i class="handle fa-solid fa-grip-lines"></i><span id="id-hidden">'.$value->id.'</span></td>
                                                        <td><a href="'.site_url().'pedido-edit/'.$value->id.'" id="link-editar">'.$value->cod_pedido.'</a></td>';
                                                    if ($value->fecha_entrega) {
                                                        echo '<td id="fechaEntrega_'.$value->id.'" class="datos-negrita">'.$nombreDia.' '.$value->fecha_entrega.'</td>';
                                                    }else{
                                                        echo '<td>Registrar fecha de entrega</td>';
                                                    }
                                                echo '<td id="cliente_'.$value->id.'" class="clipboard">'.$value->nombre.'</td>';
                                                if ($value->sector) {
                                                    echo '<td id="sector_'.$value->id.'">'.$value->sector.'</td>';
                                                }else{
                                                    echo '<td></td>';
                                                }
                                                if ($value->dir_entrega) {
                                                    
                                                    echo '<td id="direccion_'.$value->id.'" class="clipboard">'.$value->dir_entrega.' <a href="'.$value->ubicacion.'" id="link-editar" target="_blank">'.$value->ubicacion.'</a></td>';
                                                }else{
                                                    echo '<td>Registrar dirección</td>';
                                                }
                                                echo '<td id="cod_arreglo_'.$value->id.'"><ul>';
                                                if (isset($detalle)) {
                                                    foreach ($detalle as $key => $d) {
                                                        $attrExtArreg = $this->attrExtArregModel->_getAttrArreg($d->iddetalle, $d->idcategoria);
                                                        
                                                        if ($attrExtArreg) {
                                                            echo '<li>
                                                                <a 
                                                                    href="#" 
                                                                    id="link-Arreglo-Pedido" 
                                                                    data-id="'.$d->iddetalle.'"
                                                                    data-arreglo="'.$d->producto.'"
                                                                    data-pedido="'.$d->cod_pedido.'"
                                                                    data-bs-toggle="modal"
                                                                    data-category="'.$d->idcategoria.'" 
                                                                    data-bs-target="#linkArregloPedido">'.$d->producto.'</a>
                                                            </li>';
                                                            echo '<div id="observacion-detalle">'.$d->observacion.'</li></div>';
                                                        } else {
                                                            echo '<li>
                                                                <a 
                                                                    href="#" 
                                                                    id="link-Arreglo-Pedido" 
                                                                    data-id="'.$d->iddetalle.'"
                                                                    data-arreglo="'.$d->producto.'"
                                                                    data-pedido="'.$d->cod_pedido.'"
                                                                    data-bs-toggle="modal"
                                                                    data-category="'.$d->idcategoria.'" 
                                                                    style="color:#c70a0a;"
                                                                    data-bs-target="#linkArregloPedido">'.$d->producto.'</a>
                                                            </li>';
                                                            echo '<div id="observacion-detalle">'.$d->observacion.'</li></div>';
                                                        }
                                                    }
                                                }
                                                echo '</ul></td>';
                                                if ($value->hora_salida_pedido) {
                                                    echo '<td class="datos-negrita">
                                                        <a 
                                                            type="button" 
                                                            id="sector_'.$value->id.'" 
                                                            href="#" 
                                                            data-id="'.$value->cod_pedido.'"
                                                            data-hora="'.$value->hora_salida_pedido.'" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#horaSalidaModal">'.$value->hora_salida_pedido.'</a>
                                                    </td>';
                                                }else{
                                                    echo '<td class="datos-negrita">
                                                        <a 
                                                            type="button" 
                                                            id="sector_'.$value->id.'" 
                                                            href="#" 
                                                            data-id="'.$value->cod_pedido.'"
                                                            data-horaSalida="REGISTRAR" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#horaSalidaModal"
                                                        >
                                                        Registrar</a>
                                                    </td>';
                                                }

                                                if ($value->rango_entrega_desde != '' && $value->rango_entrega_hasta != '') {
                                                    echo '<td id="hora_entrega'.$value->id.'" class="datos-negrita">
                                                        <a 
                                                            type="button" 
                                                            id="horaEntrega_'.$value->id.'" 
                                                            href="#" 
                                                            data-id="'.$value->id.'"
                                                            data-codigoPedido="'.$value->cod_pedido.'"
                                                            data-value="'.$value->hora.'"
                                                            data-desde="'.$value->rango_entrega_desde.'" 
                                                            data-hasta="'.$value->rango_entrega_hasta.'" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#horaEntregaModal">Desde: '.$value->rango_entrega_desde.' Hasta: '.$value->rango_entrega_hasta.'</a>
                                                    </td>';
                                                } else {
                                                    echo '<td id="hora_entrega'.$value->id.'" class="datos-negrita">
                                                        <a 
                                                            type="button" 
                                                            id="horaEntrega_'.$value->id.'" 
                                                            href="#" 
                                                            data-id="'.$value->id.'"
                                                            data-codigoPedido="'.$value->cod_pedido.'"
                                                            data-value="'.$value->hora.'"
                                                            data-desde="'.$value->rango_entrega_desde.'" 
                                                            data-hasta="'.$value->rango_entrega_hasta.'" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#horaEntregaModal">Registrar</a>
                                                    </td>';
                                                }
                                                
                                                
                                                

                                                if ($value->mensajero) {
                                                    echo '<td id="mensajero'.$value->id.'">
                                                        <a type="button" id="'.$value->id.'" href="#" data-id="'.$value->cod_pedido.'" data-value="'.$value->mensajero.'" data-bs-toggle="modal" data-bs-target="#mensajeroModal">'.$value->mensajero.'</a>
                                                    </td>';
                                                }else{
                                                    echo '<td id="mensajero'.$value->id.'">
                                                        <a type="button" id="'.$value->id.'" href="#" data-id="'.$value->cod_pedido.'" data-value="'.$value->mensajero.'" data-bs-toggle="modal" data-bs-target="#mensajeroModal">Registrar</a>
                                                    </td>';
                                                }
                                            
                                                echo '<td >
                                                        <a type="button" id="'.$value->id.'" href="#" data-id="'.$value->cod_pedido.'" data-value="'.$value->estado.'" data-bs-toggle="modal" data-bs-target="#estadoPedidoModal">'.$value->estado.'</a>
                                                    </td>';
                                                if ($verificaCampos == 0) {
                                                    echo '<td id="informacion"><span id="span-completo">Completo</span></td>';
                                                }else{
                                                    echo '<td id="informacion"><span id="span-incompleto">Incompleto: '.$verificaCampos.'</span></td>';
                                                }
                                                // echo '<td id="observacion_'.$value->id.'">'.$value->observaciones.'</td>';
                                                if ($value->observaciones != '') {
                                                    echo '<td id="observaciones'.$value->id.'">
                                                        <a type="button" id="'.$value->id.'" href="#" data-id="'.$value->cod_pedido.'" data-bs-toggle="modal" data-bs-target="#observacionPedidoModal">'.$value->observaciones.'</a>
                                                    </td>';
                                                }else{
                                                    echo '<td id="observaciones'.$value->id.'">
                                                        <a type="button" id="'.$value->id.'" href="#" data-id="'.$value->cod_pedido.'" data-bs-toggle="modal" data-bs-target="#observacionPedidoModal">Registrar</a>
                                                    </td>';
                                                }
        
                                                
                                                echo '<td>
                                                        <div class="contenedor" id="btn-copy">
                                                            <a type="button" class="btnAction" href="javascript:copyData('.$value->id.')">
                                                                <img src="'.site_url().'public/images/copy.png" width="25" >
                                                            </a>';
                                                if ($verificaCampos == 0) {
                                                    echo '<a type="button" href="'.site_url().'imprimirTicket/'.$value->id.'/'.$value->cod_pedido.'" class="btnAction" target="_blank">
                                                            <img src="'.site_url().'public/images/btn-print.png" width="25"  >
                                                        </a>';
                                                    // echo '<a 
                                                    //         type="button"
                                                    //         class="btnAction" 
                                                    //         target="_blank" 
                                                    //         onclick="javascript:imprimirTicket('.$value->id.','.$value->cod_pedido.')"
                                                    //     >
                                                    //     <img src="'.site_url().'public/images/btn-print.png" width="25"  >
                                                    // </a>';
                                                }else{
                                                    echo '<a type="button" href="#" class="btnAction">
                                                            <img src="'.site_url().'public/images/btn-print.png" width="25">
                                                        </a>';
                                                }
                                                if (true) {
                                                    echo '<a type="button" href="'.site_url().'verHistorialPedido/'.$value->id.'/'.$value->cod_pedido.'" class="btnAction" target="_blank">
                                                            <img src="'.site_url().'public/images/note-task.png" width="25"  >
                                                        </a>';
                                                }else{
                                                    echo '<a type="button" href="#" class="btnAction">
                                                            <img src="'.site_url().'public/images/note-task.png" width="25">
                                                        </a>';
                                                }
                                                            
                                                echo    '</div></td></tr>';
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

<!-- Modal Frm Attributos extra Arreglo-->
<div class="modal fade" id="linkArregloPedido" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Campos del arreglo para el tiket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onClick="actualizaGrid()"></button>
      </div>
      <form id="form-modal-attr">
        <div class="modal-body">
            <input class="form-control" type="hidden" name="idarreglo" id="idarreglo">
            <input class="form-control" type="hidden" name="idcategoria" id="idcategoria">
            <div class="mb-0 row">
                <label for="lblPedido" class="col-sm-2 col-form-label">Pedido:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="lblPedido">
                </div>
            </div>
            <div class="mb-1 row">
                <label for="lblForm" class="col-sm-2 col-form-label">Arreglo:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="lblForm">
                </div>
            </div>
            
            <!-- Desarrollo el cuerpo de cada formulario   -->
            <div class="formulario" id="formulario">
                
            </div>
        </div>
        <div class="modal-footer">
            
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Observación -->
<div class="modal fade" id="observacionPedidoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Observación del Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" name="codigo_pedido" id="codigo_pedido">
      <input class="form-control" type="text" name="observaciones" id="observaciones">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="actualizaObservacionPedido()">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Hora Salida-->
<div class="modal fade" id="horaSalidaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar hora de salida del pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" name="codigo_pedido" id="codigo_pedido">
      <input class="form-control" type="text" name="hora_salida_pedido" id="hora_salida_pedido">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onClick="actualizarHoraSalidaPedido()">Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Estado-->
<div class="modal fade" id="estadoPedidoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar estado del pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" id="staticBackdropLabel">Estados</h5>
      <input class="form-control" type="hidden" name="codigo_pedido" id="codigo_pedido">
        <select 
                class="form-select" 
                id="select-estado_pedido" 
                name="estado_pedido"
                data-style="form-control" 
                data-live-search="true" 
            >
            <option value="0" selected>--Seleccionar un estado--</option>
        </select>    
      </div>
      <div class="modal-footer">
        <button 
            type="button" 
            class="btn btn-secondary" 
            data-bs-dismiss="modal" 
            onClick="actualizarEstadoPedido(document.getElementById('select-estado_pedido').value, document.getElementById('codigo_pedido').value)"
        >Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Hora Entrega-->
<div class="modal fade" id="horaEntregaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Hora de entrega</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" name="codigo_pedido" id="codigo_pedido">
      <input class="form-control" type="hidden" name="id" id="id">

        <div class="form-group row mb-5 mt-3" id="campo-extra">
            <div class="col-md-5 div-celular">
                <label for="rango-entrega">Desde:</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="entrega-desde" 
                    name="rango_entrega_desde" 
                    placeholder="0:00"
                    maxlength="100"
                    value="<?= old('rango_entrega_desde'); ?>"
                >
            </div>
            <div class="col-md-5 div-celular">
                <label for="rango-entrega">Hasta:</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="entrega-hasta" 
                    name="rango_entrega_hasta" 
                    placeholder="0:00"
                    maxlength="100"
                    value="<?= old('rango_entrega_hasta'); ?>"
                >
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button 
            type="button" 
            class="btn btn-secondary" 
            data-bs-dismiss="modal" 
            onClick="actualizarHorarioEntrega(
                document.getElementById('codigo_pedido').value, 
                document.getElementById('id').value, 
                document.getElementById('entrega-desde').value, 
                document.getElementById('entrega-hasta').value)"
            >Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

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
            id="select-mensajero" 
            name="mensajero"
            data-style="form-control" 
            data-live-search="true" 
        >
        </select>
      </div>
      <div class="modal-footer">
        <button 
            type="button" 
            class="btn btn-secondary" 
            data-bs-dismiss="modal" 
            onClick="actualizarMensajero(document.getElementById('select-mensajero').value, document.getElementById('codigo_pedido').value)"
        >Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/grid-pedidos.js"></script>


<!-- FONTAWESOME -->
<script src="https://kit.fontawesome.com/964a730002.js" crossorigin="anonymous"></script>
<script>

    $(document).ready(function () {
        
        let msj = document.getElementById('msj')
        
        //console.log('Mensaje: '+msj.value);
        if (msj.value == 1) {
            alertaMensaje("El pedido se ha guardado correctamente", "2500", "success")
            actualizaMensaje()
            msj.value = '3'
        }else if(msj.value == 'SIN DETALLE'){
            alertaMensaje("El pedido fue creado pero falta agregar arreglos", "2500", "warning")
            actualizaMensaje()
        }else if(msj.value == '0'){
            alertaMensaje("Hubo un problema y el pedido no se pudo guardar", "2500", "error")
            actualizaMensaje()
        }else if(msj.value == 'SIN CODIGO'){
            alertaMensaje("Hubo un problema, no se generó un código de pedido, inténtelo nuevamente", "2000", "error")
            actualizaMensaje()
        }
        
        $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
        $('#datatablesSimple').DataTable({
            "responsive": true, 
            ordering: false,
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

    const confirmSaveAlert = () => {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "El pedido ha sido guardado",
            showConfirmButton: false,
            toast: true,
            timer: 500
        });
    }

    const alertActualizaCampo = () => {
        let toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2500,
            //timerProgressBar: true,
            height: '200rem',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                // container: '...',
                popup: 'popup-class',
                }
        });
        toast.fire({
            position: "top-end",
            icon: "success",
            title: "El valor del campo se ha actualizado"
        });
    }

    const alertActualizaCampoCambio = () => {
        let toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2500,
            //timerProgressBar: true,
            height: '200rem',
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            customClass: {
                // container: '...',
                popup: 'popup-class',
                }
        });
        toast.fire({
            position: "top-end",
            icon: "warning",
            title: "ALERTA, EL VALOR FINAL HA CAMBIADO"
        });
    }
    
</script>
