const lista = document.getElementById('lista')

Sortable.create(lista, {
    animation: 150,
    chosenClass: "seleccionado",
    ghostClass: "fantasma",
    dragClass: "drag",
    onEnd: (sortable) => {
        
    },
    group: "lista-pedidos-grid",
    handle: ".handle",
    store: {
        //Guarda el orden de la lista
        set: (sortable) => {
            const orden = sortable.toArray()
            
            //Pasamos el areglo a cadena y guardamos en localstorage y base de datos
            localStorage.setItem(sortable.options.group.name, orden.join(','))
            _guardaOrdenEnDb(orden)
            alertaMensaje("Se ha actualizado el órden", 500, "success")
        },

        //Obtenemos el óden de la lista
        // get: (sortable) => {
        //     const orden = localStorage.getItem(sortable.options.group.name)
        //     return orden ? orden.split(',') : []
        // }
    }
})

function _guardaOrdenEnDb (orden){
    // orden.forEach(function(num) {
    //     console.log(num);
    // });
    $.ajax({
        method: 'get',
        dataType:"html",
        url: "guarda-orden",
        data: {
            pedidos: orden,
        },
        beforeSend: function (f) {
            alertaMensaje("Procesando", 500, "info")
        },
        success: function(data){
            let datos = JSON.parse(data)
            alertaMensaje("Se ha actualizado el órden", 500, "success")
        },
        error: function(){
            alertaMensaje("No se ha podido actualizar el órden", 500, "success")
        },
    });
}


let botonesMensajero = document.querySelectorAll('[data-bs-target="#mensajeroModal"]');
let botonesHorariosEntrega = document.querySelectorAll('[data-bs-target="#horaEntregaModal"]');
let botonesEstadoPedido = document.querySelectorAll('[data-bs-target="#estadoPedidoModal"]');
let botonesHoraSalidaPedido = document.querySelectorAll('[data-bs-target="#horaSalidaModal"]');
let btnObservacionPedido = document.querySelectorAll('[data-bs-target="#observacionPedidoModal"]');
let btnNombreArreglo = document.querySelectorAll('[data-bs-target="#linkArregloPedido"]');
let formAttrModal = document.querySelector('#link-borra-imagen')


btnNombreArreglo.forEach(link => {
    link.addEventListener('click', function(e){
        e.stopPropagation()
        let iddetalle = this.dataset.id
        let category = this.dataset.category
        let arreglo = this.dataset.arreglo
        let pedido = this.dataset.pedido
        let formulario = document.querySelector('#formulario')
        formulario.innerHTML = ""
        // console.log(iddetalle);
        document.querySelector('#idarreglo').value = iddetalle;
        document.querySelector('#idcategoria').value = category;
        document.querySelector('#lblForm').value = arreglo;
        document.querySelector('#lblPedido').value = pedido;
        
        $('#linkArregloPedido').modal();
        if (category == 1) {
            formulario.innerHTML += `
                <div class="mb-3 mt-3">
                    <label for="para" class="form-label">Para:</label>
                    <input type="text" class="form-control" id="para" placeholder="para" required>
                </div>
                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="celular" placeholder="celular" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                    <input type="text" class="form-control" id="mensaje_fresas" placeholder="mensaje">
                </div>
                <div class="mb-3">
                    <label for="peluche" class="form-label">Peluche</label>
                    <input type="text" class="form-control" id="peluche" placeholder="peluche">
                </div>
                <div class="mb-3">
                    <label for="globo" class="form-label">Globo</label>
                    <input type="text" class="form-control" id="globo" placeholder="globo">
                </div>

                <button 
                    type="button"
                    id="btnSubmit"
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal" 
                    onClick="insertAttrArreglo()"
                    disabled
                >Guardar</button>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            `
            $(document).ready(function(){
                $("#para").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                        
                    
                });

                $("#celular").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                    
                });
            });
        }
        if (category == 2) {
            formulario.innerHTML += `
                <div class="mb-3 mt-3">
                    <label for="para" class="form-label">Para:</label>
                    <input type="text" class="form-control" id="para" placeholder="para" required>
                </div>
                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="celular" placeholder="celular" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                    <input type="text" class="form-control" id="mensaje_fresas" placeholder="mensaje">
                </div>
                <div class="mb-3">
                    <label for="peluche" class="form-label">Peluche</label>
                    <input type="text" class="form-control" id="peluche" placeholder="peluche">
                </div>
                <div class="mb-3">
                    <label for="globo" class="form-label">Globo</label>
                    <input type="text" class="form-control" id="globo" placeholder="globo">
                </div>
                <div class="mb-3">
                    <label for="tarjeta" class="form-label">Tarjeta</label>
                    <input type="text" class="form-control" id="tarjeta" placeholder="tarjeta">
                </div>
                <button 
                    type="button"
                    id="btnSubmit"
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal" 
                    onClick="insertAttrArreglo()"
                    disabled
                >Guardar</button>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            `
            $(document).ready(function(){
                $("#para").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                        
                    
                });

                $("#celular").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                    
                });
            });
        }
        if (category == 3) {
            formulario.innerHTML += `
                <div class="mb-3 mt-3">
                    <label for="para" class="form-label">Para:</label>
                    <input type="text" class="form-control" id="para" placeholder="para" required>
                </div>
                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="celular" placeholder="celular" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                    <input type="text" class="form-control" id="mensaje_fresas" placeholder="mensaje">
                </div>
                <div class="mb-3">
                    <label for="peluche" class="form-label">Peluche</label>
                    <input type="text" class="form-control" id="peluche" placeholder="peluche">
                </div>
                <div class="mb-3">
                    <label for="globo" class="form-label">Globo</label>
                    <input type="text" class="form-control" id="globo" placeholder="globo">
                </div>
                <div class="mb-3">
                    <label for="bebida" class="form-label">Bebida</label>
                    <input type="text" class="form-control" id="bebida" placeholder="bebida">
                </div>
                <div class="mb-3">
                    <label for="huevo" class="form-label">Huevo</label>
                    <input type="text" class="form-control" id="huevo" placeholder="huevo">
                </div>
                <button 
                    type="button"
                    id="btnSubmit"
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal" 
                    onClick="insertAttrArreglo()"
                    disabled
                >Guardar</button>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            `
            $(document).ready(function(){
                $("#para").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                        
                    
                });

                $("#celular").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                    
                });
            });
        }
        if (category == 4) {
            formulario.innerHTML += `
                <div class="mb-3 mt-3">
                    <label for="para" class="form-label">Para:</label>
                    <input type="text" class="form-control" id="para" placeholder="para" required>
                </div>
                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="celular" placeholder="celular" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                    <input type="text" class="form-control" id="mensaje_fresas" placeholder="mensaje">
                </div>
                <div class="mb-3">
                    <label for="peluche" class="form-label">Peluche</label>
                    <input type="text" class="form-control" id="peluche" placeholder="peluche">
                </div>
                <div class="mb-3">
                    <label for="globo" class="form-label">Globo</label>
                    <input type="text" class="form-control" id="globo" placeholder="globo">
                </div>
                <div class="mb-3">
                    <label for="frases_paredes" class="form-label">Frases paredes</label>
                    <input type="text" class="form-control" id="frases_paredes" placeholder="frases_paredes">
                </div>
                <div class="mb-3">
                    <label for="fotos" class="form-label">Fotos</label>
                    <input type="text" class="form-control" id="fotos" placeholder="fotos">
                </div>
                <button 
                    type="button"
                    id="btnSubmit"
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal" 
                    onClick="insertAttrArreglo()"
                    disabled
                >Guardar</button>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            `
            $(document).ready(function(){
                $("#para").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                        
                    
                });

                $("#celular").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                    
                });
            });
        }
        if (category == 5) {
            formulario.innerHTML += `
                <div class="mb-3 mt-3">
                    <label for="para" class="form-label">Recibe:</label>
                    <input type="text" class="form-control" id="para" placeholder="para" required>
                </div>
                <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="text" class="form-control" id="celular" placeholder="celular" required>
                </div>
                <div class="mb-3">
                    <label for="opciones" class="form-label">Opciones</label>
                    <input type="text" class="form-control" id="opciones" placeholder="opciones">
                </div>
                <button 
                    type="button"
                    id="btnSubmit"
                    class="btn btn-secondary" 
                    data-bs-dismiss="modal" 
                    onClick="insertAttrArreglo()"
                    disabled
                >Guardar</button>
                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            `
            $(document).ready(function(){
                $("#para").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                        
                    
                });

                $("#celular").on('change',function(){
                    let celular = document.getElementById('celular')
                    let btnSubmit = document.querySelector('#btnSubmit')
                    let para = document.querySelector('#para')
                    // console.log(para.value);
                    // console.log(celular.value);
                    if (para.value != '' && celular.value != '') {
                        btnSubmit.removeAttribute('disabled')
                    }
                    
                });
            });
            
        }
    })
})

botonesMensajero.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation()
        let id = this.dataset.id;
        let mensajero = this.dataset.value;
        let selectMensajeroModal = document.getElementById('select-mensajero')
        $.ajax({
            type:"GET",
            dataType:"html",
            url: "ventas/getMensajeros",
            
            beforeSend: function (f) {
                //$('#cliente').html('Cargando ...');
            },
            success: function(data){
                let datos = JSON.parse(data)
                selectMensajeroModal.innerHTML = ''
                if (datos) {
                    for (const dato of datos) {
                        if (dato.nombre == mensajero) {
                            selectMensajeroModal.innerHTML += `<option value="${dato.id}" selected>${dato.nombre}</option>`
                        }else{
                            selectMensajeroModal.innerHTML += `<option value="${dato.id}">${dato.nombre}</option>`
                        }
                    }
                }
            }
        });
        //console.log(id);
        document.querySelector('#codigo_pedido').value = id;
        //console.log('abrir modal');
        $('#mensajeroModal').modal();
    });
});

botonesEstadoPedido.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation()
        let id = this.dataset.id;
        let estado = this.dataset.value;
        let selectEstadoModal = document.getElementById('select-estado_pedido')

        $.ajax({
            type:"GET",
            dataType:"html",
            url: "ventas/getEstadosPedido/",
            //data:"codigo="+valor,
            beforeSend: function (f) {
                //$('#cliente').html('Cargando ...');
            },
            success: function(data){
                let datos = JSON.parse(data)
                selectEstadoModal.innerHTML = ''
                if (datos) {
                    for (const dato of datos) {
                        if (dato.estado == estado) {
                            selectEstadoModal.innerHTML += `<option value="${dato.id}" selected>${dato.estado}</option>`
                        }else{
                            selectEstadoModal.innerHTML += `<option value="${dato.id}">${dato.estado}</option>`
                        }
                    }
                }
                
                
            }
        });
        document.querySelector('#codigo_pedido').value = id;
        $('#estadoPedidoModal').modal();
    });
});

botonesHorariosEntrega.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation()
        let id = this.dataset.id
        let hora = this.dataset.value
        let selectHoraEntrega = document.getElementById('selectHoraEntrega')

        $.ajax({
            type:"GET",
            dataType:"html",
            url: "getHorasEntrega",
            //data:"codigo="+valor,
            beforeSend: function (f) {
                //$('#cliente').html('Cargando ...');
            },
            success: function(data){
                let datos = JSON.parse(data)
                selectHoraEntrega.innerHTML = ''
                if (datos) {
                    for (let dato of datos) {
                        if (dato.id < 5 || dato.id > 24) {
                            if (dato.hora == hora) {
                                selectHoraEntrega.innerHTML += `<option value="${dato.id}" style="color:red;" selected>${dato.hora}</option>`
                            } else {
                                selectHoraEntrega.innerHTML += `<option value="${dato.id}" style="color:red;">${dato.hora}</option>`
                            }
                        }else{
                            if (dato.hora == hora) {
                                selectHoraEntrega.innerHTML += `<option value="${dato.id}" selected>${dato.hora}</option>`
                            }else{
                                selectHoraEntrega.innerHTML += `<option value="${dato.id}">${dato.hora}</option>`
                            }
                            
                        }
                    }
                }
                
            }
        });

        document.querySelector('#codigo_pedido').value = id;
        //console.log('abrir modal');
        $('#horaEntregaModal').modal();
    });
});

botonesHoraSalidaPedido.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        //console.log(id);
        document.querySelector('#codigo_pedido').value = id;
        //console.log('abrir modal');
        $('#horaSalidaModal').modal();
    });
});

btnObservacionPedido.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        //console.log(id);
        document.querySelector('#codigo_pedido').value = id;
        //console.log('abrir modal');
        $('#observacionPedidoModal').modal();
    });
});


const mensajePedidosPendientes = () => {
    let now = new Date();
    let hora = now.getHours()
    let minutes = now.getMinutes()
 
    if (hora >= 12 && hora < 13) {
        if (minutes >= 30 && minutes <= 59) {
            alerta("Puede tener pedidos pendientes, por favor revisar", 5000, "warning")
        }
    }else if (hora >= 17 && hora < 18) {
        if (minutes >= 30 && minutes <= 59) {
            alerta("Puede tener pedidos pendientes, por favor revisar", 5000, "warning")
        }
    }
}

setInterval(function(){   
    
    location.reload();
    
}, 100000)



function copyData(id){
    let cod_arreglo = ''
    let observacion = ''
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "getDatosPedido/"+id,
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let pedido = JSON.parse(resultado);
            cliente = pedido.datos.nombre
            sector = pedido.datos.sector
            sector = pedido.datos.sector
            direccion = pedido.datos.dir_entrega
            ubicacion = pedido.datos.ubicacion
            horaEntrega = pedido.datos.hora
            if (typeof pedido.datos.observaciones != 'undefined') {
                observacion = pedido.datos.observaciones
            }
            

            //detalle
            if (pedido.detalle) {
                for (const cod of pedido.detalle) {
                    cod_arreglo += cod.producto + ' / '
                }
            }

            if (window.isSecureContext) {

                    if (observacion == '') {
                        navigator.clipboard.writeText("Cliente: "+ cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion  + "\nUbicacion: " + ubicacion 
                        + "\nCódigos: " + cod_arreglo 
                        + "\nHora de entrega: " + horaEntrega)
                    }else{
                        navigator.clipboard.writeText("Cliente: "+ cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion  + "\nUbicacion: " + ubicacion 
                        + "\nCódigos: " + cod_arreglo 
                        + "\nHora de entrega: " + horaEntrega + "\nObservación: " + observacion)
                    }
                    alertaMensaje("La información se ha copiado!!!", 1500, 'info')

                } else {
                    if (observacion == '') {
                        mensaje.innerHTML = "Cliente: "+cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion + "\nUbicacion: " + ubicacion 
                        + "\nCódigo: " + cod_arreglo 
                        + "\nHora de entrega: " + horaEntrega
                    }else{
                        mensaje.innerHTML = "Cliente: "+cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion + "\nUbicacion: " + ubicacion 
                        + "\nCódigo: " + cod_arreglo 
                        + "\nHora de entrega: " + horaEntrega + "\nObservación: " + observacion
                    }
            
                    mensaje.select()
                    mensaje.setSelectionRange(0, 9999999)
                    document.execCommand('copy')
                    alertaMensaje("La información se ha copiado!!!", 1500, 'info')
                }
        }
    });
}

function insertAttrArreglo(){
    let idDetalle = document.getElementById('idarreglo').value
    let idCategoria = document.getElementById('idcategoria').value
    let para = document.getElementById('para')
    let celular = document.getElementById('celular')
    let mensajeFresas = document.getElementById('mensaje_fresas')
    let peluche = document.getElementById('peluche')
    let globo = document.getElementById('globo')
    let tarjeta = document.getElementById('tarjeta')
    let opciones = document.getElementById('opciones')
    let bebida = document.getElementById('bebida')
    let huevo = document.getElementById('huevo')
    let frasesParedes = document.getElementById('frases_paredes')
    let fotos = document.getElementById('fotos')

    if (para !== null) {
        para = document.getElementById('para').value
    } else {
        para = ''
    }

    if (celular !== null) {
        celular = document.getElementById('celular').value
    } else {
        celular = ''
    }

    if (mensajeFresas !== null) {
        mensajeFresas = document.getElementById('mensaje_fresas').value
    } else {
        mensajeFresas = ''
    }

    if (peluche !== null) {
        peluche = document.getElementById('peluche').value
    } else {
        peluche = ''
    }

    if (globo !== null) {
        globo = document.getElementById('globo').value
    } else {
        globo = ''
    }

    if (tarjeta !== null) {
        tarjeta = document.getElementById('tarjeta').value
    } else {
        tarjeta = ''
    }
    
    if (opciones !== null) {
        opciones = document.getElementById('opciones').value
    } else {
        opciones = ''
    }

    if (bebida !== null) {
        bebida = document.getElementById('bebida').value
    } else {
        bebida = ''
    }

    if (huevo !== null) {
        huevo = document.getElementById('huevo').value
    } else {
        huevo = ''
    }

    if (frasesParedes !== null) {
        frasesParedes = document.getElementById('frasesParedes').value
    } else {
        frasesParedes = ''
    }

    if (fotos !== null) {
        fotos = document.getElementById('fotos').value
    } else {
        fotos = ''
    }

    $.ajax({
        type:"get",
        dataType:"html",
        data: { 
            iddetalle: idDetalle,
            idcategoria: idCategoria,
            para: para,
            celular: celular, 
            mensaje_fresas: mensajeFresas,
            peluche: peluche, 
            globo: globo,
            tarjeta: tarjeta,
            opciones: opciones,
            bebida: bebida,
            huevo: huevo,
            frases_paredes: frasesParedes,
            fotos: fotos,
        },
        url: "insertAttrArreglo",
        
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(res){
            let respuesta = JSON.parse(res);
            if (respuesta.mensaje == 'Exito') {
                alertaMensaje("La información se ha guardado exitosamente", 3000, "success")
            }else{
                alertaMensaje("Ha habido un error. Puede que falten campos importantes, la información no se pudo guardar", 3000, "error")
            }
            setTimeout(function(){
                location.replace('pedidos');
            }, 3000);
        }
    });
}

function actualizarHoraSalidaPedido(){

    //console.log(horaSalidaPedido);
    $.ajax({
        type:"POST",
        //dataType:"html",
        data: { 
            horaSalidaPedido: document.getElementById('hora_salida_pedido').value, 
            codigoPedido: document.getElementById('codigo_pedido').value
        },
        url: "actualizarHoraSalidaPedido",
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            //console.log(data);
            alertActualizaCampo()
            setTimeout(function(){
                location.replace('pedidos');
            }, 3000);
        }
    });
}

function actualizaObservacionPedido(){

    //console.log(horaSalidaPedido);
    $.ajax({
        type:"POST",
        //dataType:"html",
        data: { 
            observacionPedido: document.getElementById('observaciones').value, 
            codigoPedido: document.getElementById('codigo_pedido').value
        },
        url: "actualizaObservacionPedido",
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            //console.log(data);
            alertActualizaCampo()
            setTimeout(function(){
                location.replace('pedidos');
            }, 3000);
            
        }
    });
}

function actualizarMensajero(mensajero, codigo_pedido){

    $.ajax({
        type:"GET",
        dataType:"html",
        url: "ventas/actualizaMensajero/"+mensajero+'/'+codigo_pedido,
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

function actualizarEstadoPedido(estado_pedido, codigo_pedido){
    
    // console.log(codigo_pedido);
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "ventas/actualizarEstadoPedido/"+estado_pedido+'/'+codigo_pedido,
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

function actualizarHorarioEntrega(horario_entrega, codigo_pedido){
    
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "ventas/actualizarHorarioEntrega/"+horario_entrega+'/'+codigo_pedido,
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            let datos = JSON.parse(data);
            //console.log(datos.horario);
            if (datos.horario < 5 || datos.horario > 24) {
                alertActualizaCampoCambio()
                setTimeout(function(){
                    location.replace('pedidos');
                }, 3000);
            }else{
                alertActualizaCampo()
                setTimeout(function(){
                    location.replace('pedidos');
                }, 3000);
            }
        }
            
    });
}

const alerta = (msg, time, icon) => {
    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        //timer: time,
        //timerProgressBar: true,
        //height: '200rem',
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
        icon: icon,
        title: msg,
        showCancelButton: true,
        cancelButtonText: "Cerrar"
    });
}

const alertaMensaje = (msg, time, icon) => {
    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: time,
        //timerProgressBar: true,
        //height: '200rem',
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
        icon: icon,
        title: msg,
    });
}

mensajePedidosPendientes()