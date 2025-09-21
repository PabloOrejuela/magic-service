let btnNombreArreglo = document.querySelectorAll('[data-bs-target="#linkArregloPedido"]');

btnNombreArreglo.forEach(link => {
    link.addEventListener('click', function(e){
        e.stopPropagation()
        let iddetalle = this.dataset.id
        let category = this.dataset.category
        let arreglo = this.dataset.arreglo
        let pedido = this.dataset.pedido
        let formulario = document.querySelector('#formulario')
        formulario.innerHTML = ""
        
        document.querySelector('#idarreglo').value = iddetalle;
        document.querySelector('#idcategoria').value = category;
        document.querySelector('#lblForm').value = arreglo;
        document.querySelector('#lblPedido').value = pedido;
    
        $('#linkArregloPedido').modal({backdrop: 'static', keyboard: false});

        $.ajax({
            method:"GET",
            dataType:"JSON",
            url: "../getAttrExtraTicket",
            data: {
                iddetalle: iddetalle,
            },
            beforeSend: function (f) {
                //alertaMensaje('Procesando', 300, "info")
            },
            success: function(data){

                if (data.infoExtra) {
                    if (category == 1) {
                        //Arreglo Frutal
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para: </label> ${data.infoExtra.para}
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular: </label> ${data.infoExtra.celular}
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas: </label> ${data.infoExtra.mensaje_fresas}
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche: </label> ${data.infoExtra.peluche}
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo:</label> ${data.infoExtra.globo}
                            </div>
                        `
                    }
                    if (category == 2) {
                        //Arreglo Floral
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para: </label> ${data.infoExtra.para}
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label> ${data.infoExtra.celular}
                                
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label> ${data.infoExtra.mensaje_fresas}
                                
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label> ${data.infoExtra.peluche}
                                
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label> ${data.infoExtra.globo}
                                
                            </div>
                        `
                    }
                    if (category == 3) {
                        //Desayuno Sorpresa
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label> ${data.infoExtra.para}                                
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label> ${data.infoExtra.celular}                               
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label> ${data.infoExtra.mensaje_fresas}                                
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label> ${data.infoExtra.peluche}                                
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label> ${data.infoExtra.globo}                                
                            </div>
                            <div class="mb-3">
                                <label for="bebida" class="form-label">Bebida</label> ${data.infoExtra.bebida}                                
                            </div>
                            <div class="mb-3">
                                <label for="huevo" class="form-label">Huevo</label> ${data.infoExtra.huevo}                                
                            </div>
                            <div class="mb-3">
                                <label for="huevo" class="form-label">Complementos</label> ${data.infoExtra.complementos}                                
                            </div>
                        `
                    }
                    if (category == 4) {
                        //Magic Box
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para: </label> ${data.infoExtra.para}
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular: </label> ${data.infoExtra.celular}
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas: </label> ${data.infoExtra.mensaje_fresas}
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche: </label> ${data.infoExtra.peluche}
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo: </label> ${data.infoExtra.globo}
                            </div>
                            <div class="mb-3">
                                <label for="frases_paredes" class="form-label">Frases paredes: </label> ${data.infoExtra.frases_paredes}
                            </div>
                            <div class="mb-3">
                                <label for="fotos" class="form-label">Fotos: </label> ${data.infoExtra.fotos}
                            </div>
                        `
                    }
                    if (category == 5) {
                        //Bocaditos
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Recibe: </label> ${data.infoExtra.para}
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular: </label> ${data.infoExtra.celular}
                            </div>
                            <div class="mb-3">
                                <label for="opciones" class="form-label">Opciones: </label> ${data.infoExtra.opciones}
                            </div>
                        `
                    }
                    if (category == 6) {
                        //Complementos
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Información: </label> ${data.infoExtra.info_cat_complementos}
                            </div>
                        `
                    }
                }else{
                    
                    formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">No se ha encontrado información</label>
                            </div>
                        `
                }
            }
        });

    })
})

$(document).ready(function () {
    $.fn.DataTable.ext.classes.sFilterInput = "form-control form-control-sm search-input";
    $('#table-historial-pedidos').DataTable({
        "responsive": true, 
        "order": [[ 0, 'dsc' ]],
        language: {
            processing: 'Procesando...',
            lengthMenu: 'Mostrando _MENU_ registros por página',
            zeroRecords: 'No hay registros',
            info: 'Mostrando _START_ a _END_ de _MAX_',
            infoEmpty: 'No hay registros disponibles',
            infoFiltered: '(filtrando de _MAX_ total registros)',
            search: 'Buscar',
            paginate: {
            first:      "Primero",
            previous:   "Anterior",
            next:       "Siguiente",
            last:       "Último"
                },
                aria: {
                    sortAscending:  ": activar para ordenar ascendentemente",
                    sortDescending: ": activar para ordenar descendentemente"
                }
        },
        //"lengthChange": false, 
        "autoWidth": false,
        "dom": "<'row'<'col-sm-12 col-md-8'l><'col-md-12 col-md-2'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-10 col-md-6'p>>"
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