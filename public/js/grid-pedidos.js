const lista = document.getElementById('lista')
actualizaMensaje()

Sortable.create(lista, {
    animation: 150,
    chosenClass: "seleccionado",
    ghostClass: "fantasma",
    dragClass: "drag",
    onEnd: (sortable) => {
        
    },
    group: "lista-pedidos-grid",
    handle: ".handle",
    store: {
        //Guarda el orden de la lista
        set: (sortable) => {
            const orden = sortable.toArray()
            
            //Pasamos el areglo a cadena y guardamos en localstorage y base de datos
            localStorage.setItem(sortable.options.group.name, orden.join(','))
            _guardaOrdenEnDb(orden)
            alertaMensaje("Se ha actualizado el órden", 500, "success")
        },

        //Obtenemos el óden de la lista
        // get: (sortable) => {
        //     const orden = localStorage.getItem(sortable.options.group.name)
        //     return orden ? orden.split(',') : []
        // }
    }
})

function _guardaOrdenEnDb (orden){
    // orden.forEach(function(num) {
    //     console.log(num);
    // });
    $.ajax({
        method: 'get',
        dataType:"html",
        url: "guarda-orden",
        data: {
            pedidos: orden,
        },
        beforeSend: function (f) {
            alertaMensaje("Procesando", 500, "info")
        },
        success: function(data){
            let datos = JSON.parse(data)
            alertaMensaje("Se ha actualizado el órden", 500, "success")
        },
        error: function(){
            alertaMensaje("No se ha podido actualizar el órden", 500, "success")
        },
    });
}


let botonesMensajero = document.querySelectorAll('[data-bs-target="#mensajeroModal"]');
let botonesHorariosEntrega = document.querySelectorAll('[data-bs-target="#horaEntregaModal"]');
let botonesEstadoPedido = document.querySelectorAll('[data-bs-target="#estadoPedidoModal"]');
let botonesHoraSalidaPedido = document.querySelectorAll('[data-bs-target="#horaSalidaModal"]');
let btnObservacionPedido = document.querySelectorAll('[data-bs-target="#observacionPedidoModal"]');
let btnNombreArreglo = document.querySelectorAll('[data-bs-target="#linkArregloPedido"]');
let formAttrModal = document.querySelector('#link-borra-imagen')

/**
 * Función que actualiza el valor de un campo del formulario
 * "Campos del arreglo para el tiket"
 * 
 * @param Type variables nombre del campo, categoría, id del detalle
 * @return void
 * @throws conditon No
 * @author Pablo Orejuela
 **/
const actualiza = (campo, id, valor) => {
    //console.log(id);
    //llamo a la funcion AJAX que hace la actualización
    $.ajax({
        method:"GET",
        dataType:"json",
        url: "./actualizaValorCampoTicket",
        data: {
            id: id,
            campo: campo,
            valor: valor
        },
        beforeSend: function (f) {
            alertaMensaje('El dato se ha actualizado', 500, "success")
            //actualizaGrid()
        },
        success: function(data){
            
        }
    });
}

const actualizaGrid = () => {
    setTimeout(function(){
        location.replace('pedidos');
    }, 500);
}

const imprimirTicket = async (id, codPedido) => {

    
    const respuestaHttp = await fetch("http://localhost:8000/imprimir",
    {
        method: "POST",
        serial: "",
        nombreImpresora: "POS-58-Series",
        operaciones: [
          {
            nombre: "Iniciar",
            argumentos: []
          },{
            nombre: "GenerarImagenAPartirDePaginaWebEImprimir",
            argumentos: ["<p>Hola Mundo</p>", 380, 380, 0]
          }
        ]
    });

}

btnNombreArreglo.forEach(link => {
    link.addEventListener('click', function(e){
        e.stopPropagation()
        let iddetalle = this.dataset.id
        let category = this.dataset.category
        let arreglo = this.dataset.arreglo
        let pedido = this.dataset.pedido
        let formulario = document.querySelector('#formulario')
        formulario.innerHTML = ""
        // console.log(iddetalle);
        document.querySelector('#idarreglo').value = iddetalle;
        document.querySelector('#idcategoria').value = category;
        document.querySelector('#lblForm').value = arreglo;
        document.querySelector('#lblPedido').value = pedido;
    
        $('#linkArregloPedido').modal({backdrop: 'static', keyboard: false});

        $.ajax({
            method:"GET",
            dataType:"JSON",
            url: "getAttrExtraTicket",
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
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    value="${data.infoExtra.para}"
                                    onchange="actualiza('para',document.querySelector('#idarreglo').value, this.value);" 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular" 
                                    value="${data.infoExtra.celular}"
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);" 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    value="${data.infoExtra.mensaje_fresas}"
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    value="${data.infoExtra.peluche}"
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    value="${data.infoExtra.globo}"
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                        `
                    }
                    if (category == 2) {
                        //Arreglo Floral
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    value="${data.infoExtra.para}"
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);" 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    value="${data.infoExtra.celular}"
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);" 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    value="${data.infoExtra.mensaje_fresas}"
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);" 
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    value="${data.infoExtra.peluche}"
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);" 
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    value="${data.infoExtra.globo}"
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);" 
                                >
                            </div>
                        `
                    }
                    if (category == 3) {
                        //Desayuno Sorpresa
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para" 
                                    value="${data.infoExtra.para}" 
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);" 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    value="${data.infoExtra.celular}" 
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);"  
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    value="${data.infoExtra.mensaje_fresas}" 
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    value="${data.infoExtra.peluche}" 
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    value="${data.infoExtra.globo}" 
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="bebida" class="form-label">Bebida</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="bebida" 
                                    placeholder="bebida"
                                    value="${data.infoExtra.bebida}" 
                                    onchange="actualiza('bebida', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="huevo" class="form-label">Huevo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="huevo" 
                                    placeholder="huevo"
                                    value="${data.infoExtra.huevo}" 
                                    onchange="actualiza('huevo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="huevo" class="form-label">Complementos</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="complementos" 
                                    placeholder="complementos"
                                    value="${data.infoExtra.complementos}" 
                                    onchange="actualiza('complementos', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                        `
                    }
                    if (category == 4) {
                        //Magic Box
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    value="${data.infoExtra.para}" 
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    value="${data.infoExtra.celular}" 
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    value="${data.infoExtra.mensaje_fresas}" 
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    value="${data.infoExtra.peluche}" 
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    value="${data.infoExtra.globo}" 
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="frases_paredes" class="form-label">Frases paredes</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="frases_paredes" 
                                    placeholder="frases_paredes"
                                    value="${data.infoExtra.frases_paredes}" 
                                    onchange="actualiza('frases_paredes', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="fotos" class="form-label">Fotos</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="fotos" 
                                    placeholder="fotos"
                                    value="${data.infoExtra.fotos}" 
                                    onchange="actualiza('fotos', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                        `
                    }
                    if (category == 5) {
                        //Bocaditos
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Recibe:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    value="${data.infoExtra.para}" 
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    value="${data.infoExtra.celular}" 
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="opciones" class="form-label">Opciones</label>
                                <div class="form-floating">
                                    <textarea 
                                        class="form-control" 
                                        placeholder="opciones" 
                                        id="opciones" 
                                        rows="25"
                                        onchange="actualiza('opciones', document.querySelector('#idarreglo').value, this.value);"
                                    >${data.infoExtra.opciones}</textarea>
                                </div>
                            </div>
                        `
                    }
                    if (category == 6) {
                        //Complementos
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Información:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="info_cat_complementos" 
                                    placeholder="Información"
                                    value="${data.infoExtra.info_cat_complementos}" 
                                    onchange="actualiza('info_cat_complementos', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                        `
                    }
                }else{
                    if (category == 1) {
                        //Arreglo Frutal
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);" 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular" 
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);" 
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                        `
                    }
                    if (category == 2) {
                        //Arreglo Floral
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                        `
                    }
                    if (category == 3) {
                        //Desayuno Sorpresa
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="bebida" class="form-label">Bebida</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="bebida" 
                                    placeholder="bebida"
                                    onchange="actualiza('bebida', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="huevo" class="form-label">Huevo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="huevo" 
                                    placeholder="huevo"
                                    onchange="actualiza('huevo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="huevo" class="form-label">Complementos</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="complementos" 
                                    placeholder="complementos"
                                    onchange="actualiza('complementos', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                        `
                    }
                    if (category == 4) {
                        //Magic Box
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Para:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="mensaje_fresas" class="form-label">Mensaje Fresas</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="mensaje_fresas" 
                                    placeholder="mensaje"
                                    onchange="actualiza('mensaje_fresas', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="peluche" class="form-label">Peluche</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="peluche" 
                                    placeholder="peluche"
                                    onchange="actualiza('peluche', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="globo" class="form-label">Globo</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="globo" 
                                    placeholder="globo"
                                    onchange="actualiza('globo', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="frases_paredes" class="form-label">Frases paredes</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="frases_paredes" 
                                    placeholder="frases_paredes"
                                    onchange="actualiza('frases_paredes', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="fotos" class="form-label">Fotos</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="fotos" 
                                    placeholder="fotos"
                                    onchange="actualiza('fotos', document.querySelector('#idarreglo').value, this.value);"
                                >
                            </div>
                        `
                    }
                    if (category == 5) {
                        //Bocaditos
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Recibe:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="para" 
                                    placeholder="para"
                                    onchange="actualiza('para', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="celular" 
                                    placeholder="celular"
                                    onchange="actualiza('celular', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label for="opciones" class="form-label">Opciones</label>
                                <div class="form-floating">
                                    <textarea 
                                        class="form-control" 
                                        placeholder="opciones" 
                                        id="opciones" 
                                        rows="25"
                                        onchange="actualiza('opciones', document.querySelector('#idarreglo').value, this.value);"
                                    ></textarea>
                                </div>
                            </div>
                        `
                    }
                    if (category == 6) {
                        //Complementos
                        formulario.innerHTML += `
                            <div class="mb-3 mt-3">
                                <label for="para" class="form-label">Información:</label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="info_cat_complementos" 
                                    placeholder="Información"
                                    onchange="actualiza('info_cat_complementos', document.querySelector('#idarreglo').value, this.value);"
                                    required
                                >
                            </div>
                        `
                    }
                }
            }
        });

    })
})

botonesMensajero.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation()
        let id = this.dataset.id;
        let mensajero = this.dataset.value;
        let selectMensajeroModal = document.getElementById('select-mensajero')
        $.ajax({
            type:"GET",
            dataType:"html",
            url: "ventas/getMensajeros",
            
            beforeSend: function (f) {
                //$('#cliente').html('Cargando ...');
            },
            success: function(data){
                let datos = JSON.parse(data)
                selectMensajeroModal.innerHTML = ''
                if (datos) {
                    selectMensajeroModal.innerHTML += `<option value="0" selected>--Registrar mensajero--</option>`
                    for (const dato of datos) {
                        if (dato.nombre == mensajero) {
                            selectMensajeroModal.innerHTML += `<option value="${dato.id}" selected>${dato.nombre}</option>`
                        }else{
                            selectMensajeroModal.innerHTML += `<option value="${dato.id}">${dato.nombre}</option>`
                        }
                    }
                }
            }
        });
        //console.log(id);
        document.querySelector('#codigo_pedido').value = id;
        //console.log('abrir modal');
        $('#mensajeroModal').modal();
    });
});

botonesEstadoPedido.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation()
        let id = this.dataset.id;
        let estado = this.dataset.value;
        let selectEstadoModal = document.getElementById('select-estado_pedido')

        $.ajax({
            type:"GET",
            dataType:"html",
            url: "ventas/getEstadosPedido/",
            //data:"codigo="+valor,
            beforeSend: function (f) {
                //$('#cliente').html('Cargando ...');
            },
            success: function(data){
                let datos = JSON.parse(data)
                selectEstadoModal.innerHTML = ''
                if (datos) {
                    for (const dato of datos) {
                        if (dato.id != 6) {
                            if (dato.estado == estado) {
                                selectEstadoModal.innerHTML += `<option value="${dato.id}" selected>${dato.estado}</option>`
                            }else{
                                selectEstadoModal.innerHTML += `<option value="${dato.id}">${dato.estado}</option>`
                            }
                        }
                    }
                }
            }
        });
        document.querySelector('#codigo_pedido').value = id;
        $('#estadoPedidoModal').modal();
    });
});

botonesHorariosEntrega.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation()
        let id = this.dataset.id
        let desde = this.dataset.desde
        let hasta = this.dataset.hasta
        let codigoPedido = this.dataset.codigoPedido
        //let hora = this.dataset.value

        document.querySelector('#codigo_pedido').value = codigoPedido;
        document.querySelector('#id').value = id;
        document.querySelector('#entrega-desde').value = desde;
        document.querySelector('#entrega-hasta').value = hasta;

        $('#horaEntregaModal').modal();
    });
});

botonesHoraSalidaPedido.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        let horaSalida = this.dataset.hora;

        if (horaSalida != 'REGISTRAR' && horaSalida != null) {
            document.querySelector('#hora_salida_pedido').value = horaSalida;
        } else {
            document.querySelector('#hora_salida_pedido').placeholder = 'Registrar hora de salida';
        }
        
        document.querySelector('#codigo_pedido').value = id;
        //console.log('abrir modal');
        $('#horaSalidaModal').modal();
    });
});

btnObservacionPedido.forEach(btn => {
    btn.addEventListener('click', function() {
        let id = this.dataset.id;
        //console.log(id);
        document.querySelector('#codigo_pedido').value = id;
        //console.log('abrir modal');
        $('#observacionPedidoModal').modal();
    });
});


const mensajePedidosPendientes = () => {
    let now = new Date();
    let hora = now.getHours()
    let minutes = now.getMinutes()
 
    if (hora >= 12 && hora < 13) {
        if (minutes >= 30 && minutes <= 59) {
            alerta("Puede tener pedidos pendientes, por favor revisar", 5000, "warning")
        }
    }else if (hora >= 17 && hora < 18) {
        if (minutes >= 30 && minutes <= 59) {
            alerta("Puede tener pedidos pendientes, por favor revisar", 5000, "warning")
        }
    }
}

setInterval(function(){  
    
    location.reload();

    //Limpiar el grid
    //lista.innerHTML = ''

    //Traer los pedidos con todo listo

    //mostrar todo el grid
    
}, 120000)


function copyData(id){
    let cod_arreglo = ''
    let observacion = ''
    let mensaje = document.getElementById('mensaje')
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "getDatosPedido/"+id,
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let pedido = JSON.parse(resultado);
            cliente = pedido.datos.nombre
            sector = pedido.datos.sector
            desde = pedido.datos.rango_entrega_desde
            hasta = pedido.datos.rango_entrega_hasta
            direccion = pedido.datos.dir_entrega
            ubicacion = pedido.datos.ubicacion
            horaEntrega = pedido.datos.hora
            if (typeof pedido.datos.observaciones != 'undefined') {
                observacion = pedido.datos.observaciones
            }
            

            //detalle
            if (pedido.detalle) {
                for (const cod of pedido.detalle) {
                    cod_arreglo += cod.producto + ' / '
                }
            }

            if (window.isSecureContext) {
                console.log('SECURE');
                    if (observacion == '') {
                        navigator.clipboard.writeText("Cliente: "+ cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion  + "\nUbicacion: " + ubicacion 
                        + "\nCódigos: " + cod_arreglo 
                        + "\nHora de entrega: " + desde + ' - ' + hasta)
                    }else{
                        navigator.clipboard.writeText("Cliente: "+ cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion  + "\nUbicacion: " + ubicacion 
                        + "\nCódigos: " + cod_arreglo 
                        + "\nHora de entrega: " + desde+' - ' + hasta + "\nObservación: " + observacion)
                    }
                    alertaMensaje("La información se ha copiado!!!", 1500, 'info')

                } else {
                    console.log('InSECURE');
                    if (observacion == '') {
                        mensaje.innerHTML = "Cliente: "+cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion + "\nUbicacion: " + ubicacion 
                        + "\nCódigo: " + cod_arreglo 
                        + "\nHora de entrega: " + desde + ' - ' + hasta
                    }else{
                        mensaje.innerHTML = "Cliente: "+cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion + "\nUbicacion: " + ubicacion 
                        + "\nCódigo: " + cod_arreglo 
                        + "\nHora de entrega: " + desde + ' - ' + hasta + "\nObservación: " + observacion
                    }
            
                    mensaje.select()
                    mensaje.setSelectionRange(0, 9999999)
                    document.execCommand('copy')
                    alertaMensaje("La información se ha copiado!!!", 1500, 'info')
                }
        }
    });
}

//ESTA FUNCIÓN ES LA QUE MANEJA LA COPIA DE DATOS DE CONFIRMACIÓN DE PEDIDO
function copyDataConfirmaPedido(id){
    let cod_arreglo = ''
    let observacion = ''
    let mensaje = document.getElementById('taDataConfirmapedido')
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "getDatosPedido/"+id,
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let pedido = JSON.parse(resultado);
            cliente = pedido.datos.nombre
            sector = pedido.datos.sector
            desde = pedido.datos.rango_entrega_desde
            hasta = pedido.datos.rango_entrega_hasta
            direccion = pedido.datos.dir_entrega
            ubicacion = pedido.datos.ubicacion
            horaEntrega = pedido.datos.hora
            if (typeof pedido.datos.observaciones != 'undefined') {
                observacion = pedido.datos.observaciones
            }
            

            //detalle
            if (pedido.detalle) {
                for (const cod of pedido.detalle) {
                    cod_arreglo += cod.producto + ' / '
                }
            }

            if (window.isSecureContext) {
                console.log('SECURE CONFIRMA PEDIDO');
                    if (observacion == '') {
                        navigator.clipboard.writeText("Cliente: "+ cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion  + "\nUbicacion: " + ubicacion 
                        + "\nCódigos: " + cod_arreglo 
                        + "\nHora de entrega: " + desde + ' - ' + hasta)
                    }else{
                        navigator.clipboard.writeText("Cliente: "+ cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion  + "\nUbicacion: " + ubicacion 
                        + "\nCódigos: " + cod_arreglo 
                        + "\nHora de entrega: " + desde+' - ' + hasta + "\nObservación: " + observacion)
                    }
                    alertaMensaje("La información DE CONFIRMACION DE PEDIDO se ha copiado!!!", 1500, 'info')

                } else {
                    console.log('InSECURE CONFIRMA PEDIDO');
                    if (observacion == '') {
                        mensaje.innerHTML = "Cliente: "+cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion + "\nUbicacion: " + ubicacion 
                        + "\nCódigo: " + cod_arreglo 
                        + "\nHora de entrega: " + desde + ' - ' + hasta
                    }else{
                        mensaje.innerHTML = "Cliente: "+cliente + "\nSector: " 
                        + sector + "\nDirección: " + direccion + "\nUbicacion: " + ubicacion 
                        + "\nCódigo: " + cod_arreglo 
                        + "\nHora de entrega: " + desde + ' - ' + hasta + "\nObservación: " + observacion
                    }
            
                    mensaje.select()
                    mensaje.setSelectionRange(0, 9999999)
                    document.execCommand('copy')
                    alertaMensaje("La información DE CONFIRMACION DE PEDIDO se ha copiado!!!", 1500, 'info')
                }
        }
    });
}

function actualizarHoraSalidaPedido(){

    //console.log(horaSalidaPedido);
    $.ajax({
        type:"POST",
        //dataType:"html",
        data: { 
            horaSalidaPedido: document.getElementById('hora_salida_pedido').value, 
            codigoPedido: document.getElementById('codigo_pedido').value
        },
        url: "actualizarHoraSalidaPedido",
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            //console.log(data);
            alertActualizaCampo()
            setTimeout(function(){
                location.replace('pedidos');
            }, 3000);
        }
    });
}

function actualizaObservacionPedido(){

    //console.log(horaSalidaPedido);
    $.ajax({
        type:"POST",
        //dataType:"html",
        data: { 
            observacionPedido: document.getElementById('observaciones').value, 
            codigoPedido: document.getElementById('codigo_pedido').value
        },
        url: "actualizaObservacionPedido",
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            //console.log(data);
            alertActualizaCampo()
            setTimeout(function(){
                location.replace('pedidos');
            }, 2000);
            
        }
    });
}

function actualizaMensaje(){

    $.ajax({
        method:"GET",
        dataType:"html",
        url: "actualizaMensajeSession",
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(res){

            let msj = document.getElementById('msj')
            msj.value = '3'
        }
    });
}

function actualizarMensajero(mensajero, codigo_pedido){

    $.ajax({
        type:"GET",
        dataType:"html",
        url: "ventas/actualizaMensajero/"+mensajero+'/'+codigo_pedido,
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            //console.log(data);
            location.replace('pedidos');
        }
    });
}

function actualizarEstadoPedido(estado_pedido, codigo_pedido){
    
    // console.log(codigo_pedido);
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "ventas/actualizarEstadoPedido/"+estado_pedido+'/'+codigo_pedido,
        //data:"codigo="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            //console.log(data);
            location.replace('pedidos');
        }
    });
}

function actualizarHorarioEntrega(codigo_pedido, idpedido, entrega_desde, entrega_hasta){
    
    $.ajax({
        method:"GET",
        //dataType:"html",
        url: "actualizarHorarioEntrega",
        data: {
            codigoPedido: codigo_pedido,
            id: idpedido,
            entregaDesde: entrega_desde,
            entregaHasta: entrega_hasta
        },
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            let datos = JSON.parse(data);

            alertaMensaje("Se ha actualizado el horario de entrega", "500", "success")
            setTimeout(function(){
                location.replace('pedidos');
            }, 3000);
        }
            
    });
}

let btnPedidonuevo2 = document.getElementById('btn-pedido-2');

btnPedidonuevo2.addEventListener('click', function(e) {
    //e.stopPropagation()
    //console.log("CLICK");
    let fecha = new Date();
    let tiempo = fecha.getFullYear().toString() 
        + (fecha.getMonth() + 1).toString() 
        + fecha.getDate().toString() 
        + fecha.getHours().toString() 
        + fecha.getMinutes().toString() 
        + fecha.getSeconds().toString()

    //Aquí creo el nuevo código
    let id = this.dataset.id;
    let codigoPedido = id+tiempo;

    $.ajax({
        method:"GET",
        dataType:"html",
        url: "genera-codigo-pedido",
        data: {
            codigo: codigoPedido,
            id: id
        },
        beforeSend: function (f) {
            
        },
        success: function(resultado){
            let res = JSON.parse(resultado)
        }
    });
    
});

const alerta = (msg, time, icon) => {
    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        //timer: time,
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
        showCancelButton: true,
        cancelButtonText: "Cerrar"
    });
}

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

mensajePedidosPendientes()