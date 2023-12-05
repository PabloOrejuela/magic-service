function copyData(id){
    let sector = document.getElementById("sector_"+id)
    let direccion = document.getElementById("direccion_"+id)
    let fechaEntrega = document.getElementById("fechaEntrega_"+id)
    let horaEntrega = document.getElementById("horaEntrega_"+id)

    console.log(horaEntrega.innerHTML);

    navigator.clipboard.writeText(sector.innerHTML + " \n" + direccion.innerHTML + " \n" + fechaEntrega.innerHTML + " \n" + horaEntrega.innerHTML)

    alert('El texto "' + sector.innerHTML + ' ' + direccion.innerHTML + '" se ha copiado!!!')
}

