let btnSectores= document.querySelectorAll('[data-bs-target="#sucursalModal"]');

btnSectores.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let costo_entrega = this.dataset.costo_entrega;
        let sucursal = this.dataset.sucursal;
    
        document.querySelector('#sector').value = id;
        document.querySelector('#sucursal_actual').value = sucursal;
        document.querySelector('#costo_entrega').value = costo_entrega;
        selectSucursales(sucursal)
        
        $('#sucursalModal').modal();
    });
});


function actualizarSucursal(sector, sucursal, costo_entrega){

    if (sucursal != null && sucursal != 0) {
        
        $.ajax({
            url: 'updateSucursalSector/'+sector+'/'+sucursal+'/'+costo_entrega,
            success: function(resultado){
                
                location.replace('sectores-entrega');
            }
        });
        
    }
}

function selectSucursales(sucursalActual){
    $.ajax({
        url: 'getSucursales/',
        success: function(resultado){
            let sucursales = JSON.parse(resultado);
            
            let selectSucursales = document.getElementById('sucursal')
            selectSucursales.innerHTML += `<option value="0">--Seleccionar sucursal--</option>`
            
            for(let sucursal of sucursales){
                if (sucursal.id == sucursalActual) {
                    selectSucursales.innerHTML += `<option value="${sucursal.id}" selected>${sucursal.sucursal}</option>`
                }else{
                    selectSucursales.innerHTML += `<option value="${sucursal.id}">${sucursal.sucursal}</option>`
                }
                
            }
        }
    });
}

