"use strict"
let btnAsignaSegundoRol = document.querySelectorAll('[data-bs-target="#asignaSegundoRolModal"]');

btnAsignaSegundoRol.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let idrol = this.dataset.idrol;
        let idrol_2 = this.dataset.idrol_2;
        let selectRolesModal = document.getElementById('select-roles')

        $.ajax({
            method:"GET",
            dataType:"html",
            url: "getRoles",
            beforeSend: function (f) {
                //$('#cliente').html('Cargando ...');
            },
            success: function(data){
                let roles = JSON.parse(data)
                
                selectRolesModal.innerHTML = ''
                
                if (roles.roles) { 
                    if (idrol_2 == 0) {
                        selectRolesModal.innerHTML += `<option value="0" selected>--Seleccione un rol--</option>`
                    }
                    for (const rol of roles.roles) {
                        if (idrol_2 == rol.id) {
                            selectRolesModal.innerHTML += `<option value="${rol.id}" selected>${rol.rol}</option>`
                        } else {
                            selectRolesModal.innerHTML += `<option value="${rol.id}">${rol.rol}</option>`
                        }
                    }
                }
            }
        });

        document.querySelector('#idusuario').value = id;
        document.querySelector('#idrol').value = idrol;
        $('#asignaSegundoRolModal').modal();
    });
});

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

const estadoVentas = (id, es_vendedor) => {
    
    if (id != null && id != 0) {
        
        $.ajax({
            dataType:"html",
            url: "user-estado-ventas",
            method: 'get',
            data: {
                id: id,
                es_vendedor: es_vendedor
            },
            beforeSend: function (f) {
                alertProcesando("Procesando", "info")
            },
            success: function(res){
              
                let resultado = JSON.parse(res)
                if (resultado == 1) {
                    alertProcesando("Se ha cambiado el valor", "info")
                    setTimeout(function(){
                        location.replace('usuarios')
                    }, 2000)
                }else{
                    alertProcesando("No se pudo cambiar el valor", "error")
                }
            },
            error: function(resultado){
              console.log('No se pudo cambiar el valor');
            }
        });
        
    }
}

const asignaRol = (id, idrol, idrol_2) => {
    
    if (id != null && id != 0) {
        if (idrol != idrol_2) {
            //Asigno el rol secundario
            $.ajax({
                dataType:"html",
                url: "asigna-rol-2",
                method: 'get',
                data: {
                    id: id,
                    idrol_2: idrol_2
                },
                beforeSend: function (f) {
                    //alertProcesando("Procesando", "info")
                },
                success: function(res){
                
                    let resultado = JSON.parse(res)

                    if (resultado == 1) {
                        alertProcesando("Se ha asignado el segundo rol", "info")
                        setTimeout(function(){
                            location.replace('usuarios')
                        }, 2000)
                    }else{
                        alertProcesando("No se pudo asignar el segundo rol", "error")
                    }
                },
                error: function(resultado){
                console.log('Hubo un error');
                }
            });
        }else{ console.log(181);
            alertProcesando("El usuario ya tiene ese rol asignado", "info")
        }
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