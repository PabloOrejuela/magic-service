function changePermisoAdmin(id){
    let input = document.getElementById('input-admin_'+id)
    cambiaPermiso(input, id)
}

function changePermisoVentas(id){
    let input = document.getElementById('input-ventas_'+id)
    cambiaPermiso(input, id)
}

function changePermisoClientes(id){
    let input = document.getElementById('input-clientes_'+id)
    cambiaPermiso(input, id)
}

function changePermisoProveedores(id){
    let input = document.getElementById('input-proveedores_'+id)
    cambiaPermiso(input, id)
}

function changePermisoReportes(id){
    let input = document.getElementById('input-reportes_'+id)
    cambiaPermiso(input, id)
}
function changePermisoGastos(id){
    let input = document.getElementById('input-gastos_'+id)
    cambiaPermiso(input, id)
}

function changePermisoEntregas(id){
    let input = document.getElementById('input-entregas_'+id)
    cambiaPermiso(input, id)
}

function changePermisoInventarios(id){
    let input = document.getElementById('input-inventarios_'+id)
    cambiaPermiso(input, id)
}

function cambiaPermiso(input, id){
    
    $.ajax({
        type:"get",
        dataType:"html",
        url: 'actualizaPermiso',
        data: { 
            id: id,
            campo: input.dataset.campo
        },
        beforeSend: function (f) {
            alertProcesando("Procesando..." , "warning")
        },
        success: function(data){

            input.setAttribute("style", "color:blue")
            input.blur()
            alertProcesando("El permiso se ha actualizado de manera exitosa" , "success")
        },
        error: function(data){
            alertProcesando("Hubo un error, no se pudo actualizar el permiso!", "error")
        }
    });
    setTimeout(function(){
        location.replace('roles');
    }, 2800);
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
