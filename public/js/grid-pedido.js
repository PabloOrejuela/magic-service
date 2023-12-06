function copyData(id){
    let cliente = document.getElementById("cliente_"+id)
    let sector = document.getElementById("sector_"+id)
    let direccion = document.getElementById("direccion_"+id)
    let cod_arreglo = document.getElementById("cod_arreglo_"+id)
    let fechaEntrega = document.getElementById("fechaEntrega_"+id)
    let horaEntrega = document.getElementById("horaEntrega_"+id)
    let observacion = document.getElementById("observacion_"+id)
    

    //console.log(horaEntrega.innerHTML);

    navigator.clipboard.writeText("Cliente: "+cliente.innerHTML + "\n Sector: " 
            + sector.innerHTML + "\n Dirección: " + direccion.innerHTML + "\n Código: " + cod_arreglo.innerHTML 
            + "\n Hora de entrega: " + horaEntrega.innerHTML + "\n Observación: " + observacion.innerHTML)

    alert('La información se ha copiado!!!')
}

