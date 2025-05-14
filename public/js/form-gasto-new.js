let selectTipoGasto= document.getElementById('tipo')
let divProveedores= document.getElementById('div-proveedores')
let divGastoVariable= document.getElementById('div-gastovariable')
let divGastoFijo= document.getElementById('div-gastofijo')

selectTipoGasto.addEventListener('change', function(e) {
    //e.stopPropagation()
    
    if (selectTipoGasto.selectedIndex !== 0) {

        if (selectTipoGasto.selectedIndex == 3) {
            divProveedores.style.display = 'block'
            divGastoVariable.style.display = 'none'
            divGastoFijo.style.display = 'none'
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

    // $.ajax({
    //     method:"GET",
    //     dataType:"html",
    //     url: "genera-codigo-pedido",
    //     data: {
    //         codigo: codigoPedido,
    //         id: id
    //     },
    //     beforeSend: function (f) {
            
    //     },
    //     success: function(resultado){
    //         let res = JSON.parse(resultado)
    //     }
    // });
    
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