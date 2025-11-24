let dateAnio = document.getElementById('anio')
let divFecha = document.getElementById('div-fecha')
let txtFecha = document.getElementById('fecha')
let txtMensaje = document.getElementById('txtMensaje')
let linkLimpiarControles = document.getElementById('txt-limpiar')
let cbNegocio = document.getElementById('negocio')


dateAnio.addEventListener('change', () => {

    if (dateAnio.selectedIndex != 0) {
        txtMensaje.style.display = 'block'
        txtMensaje.value = 'Se ha elegido todo el año '+ dateAnio.value
        
        txtFecha.value = ""
        divFecha.style.visibility = 'none'
    }else{
        txtMensaje.style.display = 'none'
        divFecha.style.display = 'block'
    }

    
})

txtFecha.addEventListener('change', () => {

    if (txtFecha.value != "") {
        txtMensaje.style.display = 'block'
        txtMensaje.value = 'Se ha elegido el mes de '+ txtFecha.value
        dateAnio.selectedIndex = 0
    }else{
        txtMensaje.style.display = 'none'
    }
})

linkLimpiarControles.addEventListener('click', () => {

    cbNegocio.selectedIndex = 0
    dateAnio.selectedIndex = 0
    txtFecha.value = ""
    txtMensaje.style.display = 'none'
})

