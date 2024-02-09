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
                    alert('La información se ha copiado!!!')

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
                    alert('La información se ha copiado!!!')
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

function print(id){
    alert('Imprimiendo '+id)
}