let inputPrice = document.getElementById("input-precio")
let btnSensible = document.getElementById("btn-sensible")

btnSensible.addEventListener('click', function(e) {
    
})


function changeData(id){
    let inputPrecio = document.getElementById("input-precio_"+id)

    $.ajax({
        type:"get",
        dataType:"html",
        url: 'actualizaPrecioItem',
        data: { 
            precio: inputPrecio.value,
            id: id
        },
        beforeSend: function (f) {
            alertProcesando("Procesando..." , "warning")
        },
        success: function(data){

            let valor = inputPrecio.value
            inputPrecio.value = parseFloat(valor).toFixed(2)
            inputPrecio.setAttribute("style", "color:blue")
            inputPrecio.blur()
            alertProcesando("El precio se ha actualizado de manera exitosa" , "success")
        },
        error: function(data){
            alertProcesando("Hubo un error, no se pudo actualizar el valor!", "error")
        }
    });
}



const alertProcesando = (msg, icono) => {
    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
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
        icon: icono,
        title: msg
    });
}
