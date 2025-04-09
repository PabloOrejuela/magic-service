let chkPagado = document.querySelectorAll('[data-codigo="#chkpagado"]');

chkPagado.forEach(chk => {

    chk.addEventListener('click', function(e){
        let idpedido = this.dataset.idpedido
        let value = 0
        console.log(idpedido);
        if($(this).is(":checked")) { 
            value = 1
            $.ajax({
                url: 'item-pagado-update',
                method: 'GET',
                data:{
                    id: idpedido,
                    value: value
                }
            });
        } else {
            $.ajax({
                url: 'item-pagado-update',
                method: 'GET',
                data:{
                    id: idpedido,
                    value: value
                }
            });
        }
    })
})

