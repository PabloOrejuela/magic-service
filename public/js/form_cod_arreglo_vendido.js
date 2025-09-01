let btnGenerarReporte = document.getElementById('btnGenerarReporte')
let negocio= document.getElementById('negocio')
let mes= document.getElementById('mes')


btnGenerarReporte.addEventListener('click', (e) => {

    if (negocio.value == "0") {
        alertaMensaje('Debe seleccionar un negocio', 2000, 'warning');
        return;
    }

    if (mes.value == "0") {
        alertaMensaje('Debe seleccionar un mes', 2000, 'warning');
        return;
    }

})
