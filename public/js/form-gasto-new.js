let selectTipoGasto= document.getElementById('tipo')
let divProveedores= document.getElementById('div-proveedores')
let divGastoVariable= document.getElementById('div-gastovariable')
let divGastoFijo= document.getElementById('div-gastofijo')
let selectNegocio = document.getElementById('negocio')
let selectProveedores= document.getElementById('proveedor')

selectTipoGasto.addEventListener('change', function(e) {
    //e.stopPropagation()
    
    if (selectTipoGasto.selectedIndex !== 0) {

        if (selectTipoGasto.selectedIndex == 3) {
            divProveedores.style.display = 'block'
            divGastoVariable.style.display = 'none'
            divGastoFijo.style.display = 'none'

            var idNegocio = selectNegocio.value;
            if (idNegocio != "0") {
                $.ajax({
                    url: './getProveedoresByNegocioGastos',
                    method: "GET",
                    data: { idNegocio: idNegocio },
                    dataType: "json",
                    success: function(data) {
                        // Limpiar el select antes de poblarlo
                        selectProveedores.innerHTML = '';
                        
                        // Añadir la opción por defecto
                        let defaultOption = document.createElement('option');
                        defaultOption.value = "0";
                        defaultOption.textContent = "--Seleccionar Proveedor--";
                        selectProveedores.appendChild(defaultOption);
                        
                        // Poblar el select con los datos del servidor
                        $.each(data, function(key, value) {
                            let option = document.createElement('option');
                            option.value = value.id;
                            option.textContent = value.nombre;
                            selectProveedores.appendChild(option);
                        });
                        selectProveedores.disabled = false; // Habilitar el select
                        alertaMensaje('Proveedores cargados correctamente', 3000, 'success');
                    },
                    error: function() {
                        alertaMensaje('Error al cargar proveedores', 3000, 'error');
                    }
                });
            } else {
                selectProveedores.innerHTML = ''; // Limpiar el select
                let defaultOption = document.createElement('option');
                defaultOption.value = "0";
                defaultOption.textContent = "--Seleccionar Proveedor--";
                selectProveedores.appendChild(defaultOption);
                selectProveedores.disabled = true; // Deshabilitar el select
            }

        }else if(selectTipoGasto.selectedIndex == 2){
            divProveedores.style.display = 'none'
            divGastoFijo.style.display = 'none'
            divGastoVariable.style.display = 'block'
        }else if(selectTipoGasto.selectedIndex == 1){
            divProveedores.style.display = 'none'
            divGastoVariable.style.display = 'none'
            divGastoFijo.style.display = 'block'
        }
    }else{
        divProveedores.style.display = 'none'
        divGastoVariable.style.display = 'none'
        divGastoFijo.style.display = 'none'
    }
    
});

// // AJAX para cargar sucursales por negocio
// $(document).ready(function(){
//     $("#negocio").on("change", function() {
//         var idNegocio = $(this).val();
//         var sucursalSelect = $("#sucursal");

//         if (idNegocio != "0") {
//             $.ajax({
//                 url: 'getProveedoresByNegocio',
//                 method: "POST",
//                 data: { idNegocio: idNegocio },
//                 dataType: "json",
//                 success: function(data) {
//                     sucursalSelect.empty();
//                     sucursalSelect.append('<option value="0">--Seleccionar sucursal--</option>');
//                     $.each(data, function(key, value) {
//                         sucursalSelect.append('<option value="' + value.id + '">' + value.sucursal + '</option>');
//                     });
//                     sucursalSelect.prop('disabled', false);
//                     alertaMensaje('Sucursales cargadas correctamente', 3000, 'success');
//                 },
//                 error: function() {
//                     alertaMensaje('Error al cargar sucursales', 3000, 'error');
//                 }
//             });
//         } else {
//             sucursalSelect.empty();
//             sucursalSelect.append('<option value="0">--Seleccionar sucursal--</option>');
//             sucursalSelect.prop('disabled', true);
//         }
//     });
// });

// AJAX para cargar PROVEEDORES por negocio
// AJAX para cargar SUCURSALES por negocio
$(document).ready(function(){
    $("#negocio").on("change", function() {
        var idNegocio = $(this).val();
        var sucursalSelect = $("#sucursal");

        if (idNegocio != "0") {
            $.ajax({
                url: 'getSucursalesByNegocio',
                method: "POST",
                data: { idNegocio: idNegocio },
                dataType: "json",
                success: function(data) {
                    sucursalSelect.empty();
                    sucursalSelect.append('<option value="0">--Seleccionar sucursal--</option>');
                    $.each(data, function(key, value) {
                        sucursalSelect.append('<option value="' + value.id + '">' + value.sucursal + '</option>');
                    });
                    sucursalSelect.prop('disabled', false);
                    alertaMensaje('Sucursales cargadas correctamente', 3000, 'success');
                },
                error: function() {
                    alertaMensaje('Error al cargar sucursales', 3000, 'error');
                }
            });
        } else {
            sucursalSelect.empty();
            sucursalSelect.append('<option value="0">--Seleccionar sucursal--</option>');
            sucursalSelect.prop('disabled', true);
        }
    });
});


const alertaMensaje = (msg, time, icon) => {
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
            popup: 'popup-class',
        }
    });
    toast.fire({
        position: "top-end",
        icon: icon,
        title: msg,
    });
}