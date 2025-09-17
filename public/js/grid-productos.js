function cambiaAttrTemp(id){
    //let id = document.getElementById("#id")
    $.ajax({
        type:"GET",
        //dataType:"html",
        data: { 
            id: id,
        },
        url: 'cambia-attr-temp-producto',
        beforeSend: function (f) {
            alertProcesando("Procesando..." , "warning")
        },
        success: function(res){
            //let id =  JSON.parse(res);

            let tdtempral = document.querySelector(`#temp_${id}`)
            let tdEstado = document.querySelector(`#estado_${id}`)
            
            tdtempral.innerHTML = "Definitivo"
            tdEstado.innerHTML = "Activo"
            alertProcesando("Se ha actualizado de manera exitosa" , "success")
        },
        error: function(res){
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