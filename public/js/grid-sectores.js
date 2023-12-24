let btnSectores= document.querySelectorAll('[data-bs-target="#sucursalModal"]');

btnSectores.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        //console.log(id);
        document.querySelector('#sector').value = id;
        //console.log('abrir modal');
        $('#sucursalModal').modal();
    });
});


function actualizarSucursal(sector, sucursal){

    if (sucursal != null && sucursal != 0) {

        $.ajax({
            url: 'updateSucursalSector/'+sector+'/'+sucursal,
            success: function(resultado){
                console.log(resultado);
                location.replace('sectores-entrega');
            }
        });
        
    }
}