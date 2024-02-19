"use strict"

const udpdateVariable = (id) => {
    let valor = document.getElementById(id).value
    if (valor != '' && valor != undefined) {
        $.ajax({
            type:"get",
            dataType:"html",
            url: "updateVariableSistema",
            data:{
                id: id,
                value: valor,
            },
            beforeSend: function (f) {
                alertProcesando("Procesando..." , "warning")
            },
            success: function(resultado){
                alertProcesando("Se ha actualizado de manera exitosa" , "success")
            },
            error: function(resultado){
                alertProcesando("Hubo un error, no se pudo actualizar el valor!", "error")
            }
        });
    }else{
        alertProcesando("Hubo un error, el valor no puede estar vacío!!", "error")
    }
    
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