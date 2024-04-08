function agregarItem(idNew, item){
    let inputItem = document.getElementById("iditem")

    if (idNew != null && idNew != 0 && idNew > 0) {        
        
        $.ajax({
            url: 'detalle-prodnew-insert-temp',
            method: 'get',
            data: {
                idproducto: idNew,
                item: item,
                idNew: idNew
            },
            success: function(resultado){
                if (resultado == 0) {
                }else{
                    
                    let detalle = JSON.parse(resultado);
                    let total = 0
                    
                    //Alerta que se ha agregado un item y limpio el input de items
                    alertAgregaItem()
                    inputItem.value = ""

                    let tablaItemsBody = document.getElementById('tablaItemsBody')
                    
                    tablaItemsBody.innerHTML = ''
                    if (detalle.error != '') {

                        for(item of detalle.datos){
                            
                            tablaItemsBody.innerHTML += `<tr>
                                <td>${item.id}</td><td>${item.item}</td>
                                <td>
                                    <input 
                                        type="number" 
                                        class="form-control cant porcentaje" 
                                        name="porcentaje_${item.id}"
                                        value = "${item.porcentaje}"
                                        placeholder="0"
                                        id="porcentaje_${item.id}" 
                                        onchange="calculaPorcentaje(${item.id})"
                                        min="0.1" step="0.1"
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant precio" 
                                        name="precio_${item.id}" 
                                        value="${item.precio_unitario}" 
                                        id="precio_${item.id}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant precio_final" 
                                        name="precio_final_${item.id}" 
                                        value="${item.precio_actual}" 
                                        id="precio_final_${item.id}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant pvp" 
                                        name="pvp_${item.id}" 
                                        value="${item.pvp}" 
                                        id="pvp_${item.id}"
                                        onchange="updatePvp(${item.id})"
                                    >
                                </td>
                                <td>
                                    <a onclick="deleteItem(${idNew}, ${item.id})" class="btn btn-borrar">
                                        <img src="./public/images/delete.png" width="25" >
                                    </a>
                                </td>
                                </tr>`
                            total += parseFloat(item.pvp)
                        }
                        document.getElementById("input-total").value = parseFloat(total).toFixed(2)
                    }else{
                        console.log('El producto no tiene items');
                    }
                }
            }
        });
        //console.log(cod_pedido);
        
    }
}

function borraItemstemp(idproducto){
    
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "deleteItemsTempProduct",
        data:{
            idproducto: idproducto,
        },
        beforeSend: function (f) {
            alertProcesando()
        },
        success: function(resultado){
            return 1;
        },
        error: function(resultado){
          console.log('Se produjo un error');
        }
    });
    calculaTotal()
}

function calculaPorcentaje(idItem){
    
    let precioVenta = 0
    let idNew = document.getElementById("new_id").value
    let porcentaje = document.getElementById("porcentaje_"+idItem).value
    let precio = document.getElementById("precio_"+idItem).value
    let precioFinal = document.getElementById("precio_final_"+idItem)
    let pvp = document.getElementById("pvp_"+idItem)
    
    precioVenta = (parseFloat(porcentaje) * parseFloat(precio))
    precioFinal.value = '0'
    precioFinal.value = parseFloat(precioVenta).toFixed(2)
    pvp.value = parseFloat(precioVenta).toFixed(2)

    //actualizo el porcentaje y el precio
    datosActualizar = {
        idproducto: idNew,
        precio: precio,
        precioFinal: precioFinal.value,
        pvp: pvp.value,
        porcentaje: porcentaje,
        idItem: idItem,
        idNew: idNew
    }
    updatePorcentaje(datosActualizar)
    //Vuelvo a calcular el total
    calculaTotal()
}

/**
 * Hace un update del nuevo porcentaje y precio
 * usando AJAX
*/

function updatePorcentaje(datosActualizar){
    
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "updateItemsTempProduct",
        data:{
            idproducto: datosActualizar.idproducto,
            precio_unitario: datosActualizar.precio,
            precio_actual: datosActualizar.precioFinal,
            pvp: datosActualizar.pvp,
            porcentaje: datosActualizar.porcentaje,
            idItem: datosActualizar.idItem,
            idNew: datosActualizar.idNew
        },
        beforeSend: function (f) {
            alertProcesando()
        },
        success: function(resultado){
            alertaMensaje("Se ha actualizado el porcentaje", 1000, "success")
        },
        error: function(resultado){
            alertaMensaje("Hubo un error no se pudo actualizar", 1000, "error")
        }
    });
    calculaTotal()
}

function updatePvp(idItem){
    let pvp = document.getElementById("pvp_"+idItem)
    let idNew = document.getElementById("new_id").value
    
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "updatePvpTempProduct",
        data:{
            pvp: pvp.value,
            idItem: idItem,
            idNew: idNew
        },
        beforeSend: function (f) {
            alertProcesando()
        },
        success: function(resultado){
            alertaMensaje("Se ha actualizado el porcentaje", 1000, "success")
        },
        error: function(resultado){
            alertaMensaje("Hubo un error no se pudo actualizar", 1000, "error")
        }
    });
    calculaTotal()
}

function calculaTotal(){

    let collection = document.querySelectorAll('.pvp')
    let total = 0

    //Recorro los input precio y calculo el total
    Array.from(collection).forEach(function (element) {
        total += parseFloat(element.value)
    })
    //console.log(total);
    document.getElementById("input-total").value = parseFloat(total).toFixed(2)
}

function deleteItem(idNew, idItem){
    
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "deleteItemTempProduct",
        data:{
            idproducto: idNew,
            idItem: idItem,
        },
        beforeSend: function (f) {
            alertProcesando()
        },
        success: function(resultado){
          
            let items = JSON.parse(resultado);
            let total = 0
            
            let tablaItemsBody = document.getElementById('tablaItemsBody')
            tablaItemsBody.innerHTML = ''
            
            if (items.datos) {
                for(let item of items.datos){
                
                    tablaItemsBody.innerHTML += `<tr>
                        <td>${item.id}</td><td>${item.item}</td>
                        <td>
                            <input 
                                type="number" 
                                class="form-control cant porcentaje" 
                                name="porcentaje_${item.id}"
                                value = ${item.porcentaje}
                                placeholder="0"
                                id="porcentaje_${item.id}" 
                                onchange="calculaPorcentaje(${item.id})"
                                min="0.1" step="0.1"
                            >
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control cant precio" 
                                name="precio_${item.id}" 
                                value="${item.precio_unitario}" 
                                id="precio_${item.id}"
                                onchange="calculaPorcentaje(${item.id})"
                                disabled
                            >
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control cant precio_final" 
                                name="precio_final_${item.id}" 
                                value="${item.precio_actual}" 
                                id="precio_final_${item.id}"
                                disabled
                            >
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control cant pvp" 
                                name="pvp_${item.id}" 
                                value="${item.pvp}" 
                                id="pvp_${item.id}"
                                onchange="updatePvp(${item.id})"
                            >
                        </td>
                        <td>
                            <a onclick="deleteItem(${idNew}, ${item.id})" class="btn btn-borrar">
                                <img src="./public/images/delete.png" width="25" >
                            </a>
                        </td>
                        </tr>`
                    total += parseFloat(item.pvp)
                }
                document.getElementById("input-total").value = parseFloat(total).toFixed(2)
                alertaMensaje("Se ha eliminado el item y actualizado el total", 1000, "success")
            } else {
                document.getElementById("input-total").value = "0.00"
                alertaMensaje("El producto no contiene mas items", 1000, "info")
            }
        },
        error: function(resultado){
            console.log(`El Item no se encontró o no se pudo eliminar`);
        }
    });
}

function activarSubmit(){
    
    let btnSubmit = document.getElementById("btnGuardar")
    btnSubmit.removeAttribute('disabled')
}

function cancelar(){
    
    location.replace('producto-create');
}

const alertAgregaItem = () => {
    Swal.fire({
        position: "center",
        icon: "success",
        title: "El Item se ha agregado",
        showConfirmButton: false,
        timer: 1200
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

const alertProcesando = () => {
    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 500,
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
        icon: "warning",
        title: "procesando ..."
    });
}