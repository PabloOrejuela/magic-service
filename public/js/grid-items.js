let inputPrice = document.getElementById("input-precio")

function changeData(id){
    
    let nuevoValor = document.getElementById("input-precio_"+id).value;

    $.ajax({
        type:"get",
        dataType:"html",
        url: 'actualizaPrecioItem',
        data: { 
            precio: nuevoValor,
            id: id
        },
        beforeSend: function (f) {
            alertProcesando("Procesando..." , "warning")
        },
        success: function(data){
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
        icon: icono,
        title: msg
    });
}
