"use strict"

const sessionClose = (id) => {
    
    if (id != null && id != 0) {
        
        $.ajax({
            dataType:"html",
            url: "sign-off",
            method: 'get',
            data: {
                id: id,
            },
            beforeSend: function (f) {
                alertProcesando("Cerrando sesión", "info")
            },
            success: function(res){
              
                let resultado = JSON.parse(res)
                if (resultado == 1) {
                    alertProcesando("La sessión se ha cerrado", "info")
                    //PABLO luego hay que hacer que recargue la data por ajax
                    setTimeout(function(){
                        location.replace('usuarios')
                    }, 2000)
                }else{
                    alertProcesando("No se pudo cerrar la sesión", "error")
                }
            },
            error: function(resultado){
              console.log('No se pudo cerrar la sesión');
            }
        });
        
    }
}

const userDelete = (id) => {
    
    if (id != null && id != 0) {
        
        $.ajax({
            dataType:"html",
            url: "user-delete",
            method: 'get',
            data: {
                id: id,
            },
            beforeSend: function (f) {
                alertProcesando("Inactivando usuario", "info")
            },
            success: function(res){
              
                let resultado = JSON.parse(res)
                if (resultado == 1) {
                    alertProcesando("El usuario ya no está activo", "info")
                    //PABLO luego hay que hacer que recargue la data por ajax
                    setTimeout(function(){
                        location.replace('usuarios')
                    }, 2000)
                }else{
                    alertProcesando("No se pudo desactivar el usuario", "error")
                }
            },
            error: function(resultado){
              console.log('No se pudo desactivar el usuario');
            }
        });
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
        popup: "popup-class",
      },
    });
    toast.fire({
      position: "top-end",
      icon: icono,
      title: msg,
    });
  };