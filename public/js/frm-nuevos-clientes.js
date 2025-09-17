let dateAnio = document.getElementById('anio')
let divFecha = document.getElementById('div-fecha')
let txtMensaje = document.getElementById('txtMensaje')

dateAnio.addEventListener('change', () => {

    if (dateAnio.selectedIndex != 0) {
        txtMensaje.style.display = 'block'
        txtMensaje.value = 'Se ha elegido todo el año '+ dateAnio.value
        divFecha.disabled = true
        divFecha.style.display = 'none'
    }else{
        txtMensaje.style.display = 'none'
        divFecha.disabled = false
        divFecha.style.display = 'block'
    }

    
})