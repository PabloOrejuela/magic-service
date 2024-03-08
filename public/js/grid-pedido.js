let botonesMensajero = document.querySelectorAll('[data-bs-target="#mensajeroModal"]');
let botonesHorariosEntrega = document.querySelectorAll('[data-bs-target="#horaEntregaModal"]');
let botonesEstadoPedido = document.querySelectorAll('[data-bs-target="#estadoPedidoModal"]');
let botonesHoraSalidaPedido = document.querySelectorAll('[data-bs-target="#horaSalidaModal"]');
let btnObservacionPedido = document.querySelectorAll('[data-bs-target="#observacionPedidoModal"]');

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
            alerta("Puede tener pedidos pedientes, por favor revisar", 5000, "warning")
        }
    }else if (hora >= 17 && hora < 18) {
        if (minutes >= 30 && minutes <= 59) {
            alerta("Puede tener pedidos pedientes, por favor revisar", 5000, "warning")
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
            console.log(data);
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

function print(id){
    alert('Imprimiendo '+id)
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
