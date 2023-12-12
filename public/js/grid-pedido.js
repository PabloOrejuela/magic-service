function copyData(id){
    let cliente = document.getElementById("cliente_"+id)
    let sector = document.getElementById("sector_"+id)
    let direccion = document.getElementById("direccion_"+id)
    let cod_arreglo = document.getElementById("cod_arreglo_"+id)
    let fechaEntrega = document.getElementById("fechaEntrega_"+id)
    let horaEntrega = document.getElementById("horaEntrega_"+id)
    let observacion = document.getElementById("observacion_"+id)
    let mensaje = document.getElementById("mensaje")
    //alert(id)
    //mensaje.innerHTML = ''

    //console.log(horaEntrega.innerHTML);
    if (window.isSecureContext) {
        console.log(
          'The context is secure, can use navigator.clipboard',
        );
        navigator.clipboard.writeText("Cliente: "+cliente.innerHTML + "\n Sector: " 
            + sector.innerHTML + "\n Dirección: " + direccion.innerHTML + "\n Código: " + cod_arreglo.innerHTML 
            + "\n Hora de entrega: " + horaEntrega.innerHTML + "\n Observación: " + observacion.innerHTML)
        alert('La información se ha copiado seguro!!!')
      } else {
            
            mensaje.innerHTML = "Cliente: "+cliente.innerHTML + "\n Sector: " 
            + sector.innerHTML + "\n Dirección: " + direccion.innerHTML + "\n Código: " + cod_arreglo.innerHTML 
            + "\n Hora de entrega: " + horaEntrega.innerHTML + "\n Observación: " + observacion.innerHTML

            mensaje.select()
            mensaje.setSelectionRange(0, 9999999)
            document.execCommand('copy')
            alert('La información se ha copiado inseguro!!!')
      }
}

