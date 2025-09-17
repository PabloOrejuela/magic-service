"use strict"
let btnAsignaSegundoRol = document.querySelectorAll('[data-bs-target="#asignaSegundoRolModal"]');

btnAsignaSegundoRol.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let idrol = this.dataset.idrol;
        let idrol_2 = this.dataset.idrol_2;
        let selectRolesModal = document.getElementById('select-roles')
        let divNoasignar = document.querySelector('#div-noasignar')

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
                        divNoasignar.style.display = "none";
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
                alertProcesando("Cerrando sesión", 1000, "info")
            },
            success: function(res){
              
                let resultado = JSON.parse(res)
                if (resultado == 1) {
                    alertProcesando("La sessión se ha cerrado", 1000, "info")
                    //PABLO luego hay que hacer que recargue la data por ajax
                    setTimeout(function(){
                        location.replace('usuarios')
                    }, 1100)
                }else{
                    alertProcesando("No se pudo cerrar la sesión", 1000, "error")
                }
            },
            error: function(resultado){
              
            }
        });
        
    }
}

const userDelete = (id, estado) => {
    //Se cambi'o esta funci'on ahora cambia el estado
   
    if (id != null && id != 0) {
        
        $.ajax({
            dataType:"html",
            url: "user-cambia-estado",
            method: 'get',
            data: {
                id: id,
                estado: estado
            },
            beforeSend: function (f) {
                alertProcesando("Inactivando usuario", 600, "info")
            },
            success: function(res){
              
                let resultado = JSON.parse(res)
                if (resultado == 1) {
                    alertProcesando("El usuario ya no está activo", 600,  "info")
                    
                    setTimeout(function(){
                        location.replace('usuarios')
                    }, 1100)
                }else{
                    alertProcesando("No se pudo desactivar el usuario", 600, "error")
                }
            },
            error: function(resultado){
             
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
                alertProcesando("Procesando", 1000,  "info")
            },
            success: function(res){
              
                let resultado = JSON.parse(res)
                if (resultado == 1) {
                    alertProcesando("Se ha cambiado el valor", 1000, "info")
                    setTimeout(function(){
                        location.replace('usuarios')
                    }, 1100)
                }else{
                    alertProcesando("No se pudo cambiar el valor", 1000, "error")
                }
            },
            error: function(resultado){
              
            }
        });
        
    }
}

const asignaRol = (id, idrol, idrol_2, noAsignar) => {
    
    if (id != null && id != 0) {
        if (idrol != idrol_2) {
            //Asigno el rol secundario
            $.ajax({
                dataType:"html",
                url: "asigna-rol-2",
                method: 'get',
                data: {
                    id: id,
                    idrol_2: idrol_2,
                    noAsignar: noAsignar
                },
                beforeSend: function (f) {
                    //alertProcesando("Procesando", "info")
                },
                success: function(res){
                
                    let resultado = JSON.parse(res)
                    
                    if (resultado == 1) {
                        
                        alertProcesando("Se ha modificado el segundo rol", 1000, "info")
                        setTimeout(function(){
                            location.replace('usuarios')
                        }, 1100)
                    }else{
                        alertProcesando("No se pudo asignar el segundo rol", 1000, "error")
                    }
                },
                error: function(resultado){
                
                }
            });
        }else{ 
            alertProcesando("El usuario ya tiene ese rol asignado", 1000, "info")
        }
    }
}

const alertProcesando = (msg, time, icono) => {
    const toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: time,
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