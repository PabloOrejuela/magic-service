function copyData(id){
    let cliente = ''
    let sector = ''
    let direccion = ''
    let ubicacion = ''
    let cod_arreglo = ''
    //let fechaEntrega = document.getElementById("fechaEntrega_"+id)
    let horaEntrega = ''
    let observacion = ''
    let mensaje = ''
    //alert(id)
    cadenaQuitar = ''
    //cadenaDireccion = direccion.innerHTML

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
            observacion = pedido.datos.observaciones

            console.log(pedido.detalle);
            //detalle
            if (pedido.detalle) {
                for (const cod of pedido.detalle) {
                    cod_arreglo += cod.producto + ' / '
                }
            }  

            if (window.isSecureContext) {
                // console.log(
                //   'The context is secure, can use navigator.clipboard',
                // );
                    navigator.clipboard.writeText("Cliente: "+ cliente + "\nSector: " 
                    + sector + "\nDirección: " + direccion  + "\nUbicacion: " + ubicacion 
                    + "\nCódigos: " + cod_arreglo 
                    + "\nHora de entrega: " + horaEntrega + "\nObservación: " + observacion)
                    alert('La información se ha copiado!!!')
                } else {
                    
                    mensaje.innerHTML = "Cliente: "+cliente + "\nSector: " 
                    + sector + "\nDirección: " + direccion + "\nUbicacion: " + ubicacion 
                    + "\nCódigo: " + cod_arreglo 
                    + "\nHora de entrega: " + horaEntrega + "\nObservación: " + observacion
            
                    mensaje.select()
                    mensaje.setSelectionRange(0, 9999999)
                    document.execCommand('copy')
                    alert('La información se ha copiado!!!')
                }
        }
    });
}


function actualizarHoraSalidaPedido(hora_salida_pedido, codigo_pedido){
    // console.log(mensajero);
    // console.log(codigo_pedido);
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "<?php echo site_url(); ?>ventas/actualizarHoraSalidaPedido/"+hora_salida_pedido+'/'+codigo_pedido,
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