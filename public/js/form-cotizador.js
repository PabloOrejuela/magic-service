//Variables
let linkBorraImagen = document.querySelector('#link-borra-imagen')

$(document).ready(function(){
    $("#categoria").on('change',function(){
        if($("#categoria").val() !=""){
            valor = $("#categoria").val();
            $.ajax({
                type:"GET",
                dataType:"html",
                url: "getProductosCategoria"+'/'+valor,
                beforeSend: function (f) {
                    alertProcesando("Procesando", "info")
                },
                success: function(resultado){
                  
                    let productos = JSON.parse(resultado);
                    let selectProductos = document.getElementById('productos')
                    if (productos) {
                        $("#productos").prop('disabled', false);
                                                
                        selectProductos.innerHTML = ''
                        selectProductos.innerHTML += `<option value="0" selected>--Seleccionar producto--</option>`
                        for(let producto of productos){
                            
                            selectProductos.innerHTML += `<option value="${producto.id}">${producto.producto}</option>`
                        }
                    }else{
                        $("#productos").prop('disabled', false);
                        selectProductos.innerHTML = `<option value="0">--No hay productos en esta categoría--</option>`
                    }
                    
                },
                error: function(resultado){
                  console.log('No hay productos de esa categoría');
                }
            });
        }
    });
  });

function removeRows(table) {
    try {

        let rowCount = table.rows.length;

        for(let i=0; i<rowCount; i++) {
            let row = table.rows[i];
            table.deleteRow(i);
            rowCount--;
            i--;
                
        }
    }catch(e) {
            alert(e);
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
            alertProcesando("Procesando, eliminando item", "info")
        },
        success: function(resultado){
            return 1;
        },
        error: function(resultado){
            alertProcesando("Hubo un error, el item no pudo ser eliminado", "error")
        }
    });
    calculaTotal()
}


$(document).ready(function(){
    $("#productos").on('change',function(){
        if($("#productos").val() !=""){
            valor = $("#productos").val();
            //console.log(valor);
            getDatosProducto(valor)
            borraItemstemp(valor)
            
            $.ajax({
                type:"GET",
                dataType:"html",
                url: "ventas-getItemsProducto"+'/'+valor,
                beforeSend: function (f) {
                    alertProcesando("Procesando", "info")
            },
                success: function(resultado){
                
                    let res = JSON.parse(resultado);
                    let sumaTotal = 0
                    
                    let tablaItemsBody = document.getElementById('tablaItemsBody')
                    tablaItemsBody.innerHTML = ''
                    document.getElementById("idproducto").value = valor
                    
                    if (res.itemsTemp) {
                        for(let item of res.itemsTemp){
                            
                            document.getElementById("new_id").value = item.new_id
                            tablaItemsBody.innerHTML += `<tr>
                                <td>${item.id}</td><td>${item.item}</td>
                                <td>
                                    <input 
                                        type="numeric" 
                                        class="form-control cant number porcentaje" 
                                        name="porcentaje_${item.id}"
                                        value = ${item.porcentaje}
                                        placeholder="0"
                                        id="porcentaje_${item.id}" 
                                        onchange="calculaPorcentaje(${item.id})"
                                        oninput="validarInput2(${item.id})"
                                        min="0"
                                        
                                      
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant number precio" 
                                        name="precio_${item.id}" 
                                        value="${item.precio_unitario}" 
                                        id="precio_${item.id}"
                                        onchange="calculaPorcentaje(${item.id})"
                                        disabled
                                    >
                                    <a href="javascript:activaEditar(${item.id})">editar</a>
                                </td>
                                <td>
                                    <div class="row col-md-12">
                                        <input 
                                            type="text" 
                                            class="form-control cant number precio_final" 
                                            name="precio_final_${item.id}" 
                                            value="${item.precio_actual}" 
                                            id="precio_final_${item.id}"
                                            disabled
                                        >
                                    </div>
                                </td>
                                <td>
                                    <input 
                                        type="numeric" 
                                        class="form-control cant number pvp" 
                                        name="pvp_${item.id}" 
                                        value="${item.pvp}" 
                                        id="pvp_${item.id}"
                                        onchange="updatePvp(${item.id})"
                                        oninput="validarInputPvp(${item.id})"
                                        min="0"
                                    >
                                </td>
                                <td>
                                    <a onclick="deleteItem(${item.id})" class="btn btn-borrar">
                                        <img src="./public/images/delete.png" width="25" >
                                    </a>
                                </td>
                                </tr>`
                            sumaTotal += parseFloat(item.pvp)
                        }
                    }
                    
                    let nombreArregloNuevo = document.getElementById("nombreArregloNuevo")
                    let slctProductos = document.getElementById("productos")
                    let index = slctProductos.selectedIndex
                    
                    //Verifico si se cambió el precio total
                    if (res.precio != sumaTotal) {
                        document.getElementById("input-total").value = parseFloat(res.precio).toFixed(2)
                    }else{
                        //Si no se ha cambiado le cargo la suma total al input
                        document.getElementById("input-total").value = parseFloat(sumaTotal).toFixed(2)
                    }
                    
                    nombreArregloNuevo.removeAttribute('disabled')
                    let nombretemp = slctProductos.options[index].text
                    nombreArregloNuevo.value = nombretemp+'_temp'

                },
                error: function(resultado){
                    console.log('El producto no tiene items');
                }
            });
        }
    });
});

/**
 * Hace un update del nuevo porcentaje y precio
 * usando AJAX
*/

function updatePrecio(id){
    let precio_actual = document.getElementById("precio_final_"+id).value
    let idproducto = document.getElementById("idproducto").value
    let idNew = document.getElementById("new_id").value
    
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "updatePrecioActualTempProduct",
        data:{
            idproducto: idproducto,
            precio_actual: precio_actual,
            item: id,
            idNew: idNew
        },
        beforeSend: function (f) {
            alertProcesando("Actualizando valores", "info")
        },
        success: function(resultado){
            return 1;
        },
        error: function(resultado){
            alertProcesando("Hubo un error, no se pudo actualizar los valores totales", "error")
        }
    });
    calculaPvp(id, precio_actual)
    calculaTotal()
}

function calculaPvp(id, precio_actual){
    let porcentaje = document.getElementById("porcentaje_"+id).value
    let pvp = document.getElementById("pvp_"+id)

    pvp.value = (porcentaje * precio_actual).toFixed(2)
}


function calculaPorcentaje(idItem){
    
    let precioVenta = 0
    let idproducto = document.getElementById("idproducto").value
    let idNew = document.getElementById("new_id").value
    let porcentaje = document.getElementById("porcentaje_"+idItem).value
    let precio = document.getElementById("precio_"+idItem).value
    let precioFinal = document.getElementById("precio_final_"+idItem)
    let pvp = document.getElementById("pvp_"+idItem)


    if (porcentaje == '' || porcentaje == 0) {

        porcenteje = 1
        document.getElementById("porcentaje_"+idItem).value = 1
        precioVenta = (parseFloat('1') * parseFloat(precio))
    }else{
        precioVenta = (parseFloat(porcentaje) * parseFloat(precio))
    }
 
    precioFinal.value = '0'
    precioFinal.value = parseFloat(precioVenta).toFixed(2)
    pvp.value = parseFloat(precioVenta).toFixed(2)

    //actualizo el porcentaje y el precio
    datosActualizar = {
        idproducto: idproducto,
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
            alertProcesando("Actualizando valores", "info")
        },
        success: function(resultado){
            return 1;
        },
        error: function(resultado){
            alertProcesando("Hubo un error, no se pudo actualizar los valores totales", "error")
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
            alertProcesando("Actualizando valores", "info")
        },
        success: function(resultado){
            return 1;
        },
        error: function(resultado){
            alertProcesando("Hubo un error, no se pudo actualizar los valores", "error")
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

function getDatosProducto(idproducto){
    
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "getProducto"+'/'+idproducto,
        beforeSend: function (f) {
            alertProcesando("Procesando", "info")
        },
        success: function(resultado){
            let res = JSON.parse(resultado);

            let image = document.getElementById("image-product")
            let divImg = document.querySelector("#div-img")
            let impFileImg = document.querySelector("#formFileImg")
            document.getElementById("image").value = res.producto.image

            impFileImg.removeAttribute("disabled")
            divImg.setAttribute("style", "display:block")
            document.getElementById("lbl-image").innerHTML = res.producto.image
            image.setAttribute("src", "public/images/productos/"+res.producto.image+'.jpg');
        }
    })
}

function deleteItem(idItem){
    
    let idNew = document.getElementById("new_id").value
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "deleteItemTempProduct",
        data:{
            idproducto: idNew,
            idItem: idItem,
        },
        beforeSend: function (f) {
            alertProcesando("Procesando, eliminando item", "info")
        },
        success: function(resultado){
          
            let items = JSON.parse(resultado);
            let total = 0
            
            let tablaItemsBody = document.getElementById('tablaItemsBody')
            tablaItemsBody.innerHTML = ''

            document.getElementById("idproducto").value = valor
            
            if (items.datos) {
                for(let item of items.datos){
                    document.getElementById("new_id").value = item.new_id
                    tablaItemsBody.innerHTML += `<tr>
                        <td>${item.id}</td><td>${item.item}</td>
                        <td>
                            <input 
                                type="numeric" 
                                class="form-control cant number porcentaje" 
                                name="porcentaje_${item.id}"
                                value = ${item.porcentaje}
                                placeholder="0"
                                id="porcentaje_${item.id}" 
                                onchange="calculaPorcentaje(${item.id})"
                                oninput="validarInput2(${item.id})"
                                min="0"
                            >
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control cant number precio" 
                                name="precio_${item.id}" 
                                value="${item.precio_unitario}" 
                                id="precio_${item.id}"
                                onchange="calculaPorcentaje(${item.id})"
                                disabled
                            >
                            <a href="javascript:activaEditar(${item.id})">editar</a>
                        </td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control cant number precio_final" 
                                name="precio_final_${item.id}" 
                                value="${item.precio_actual}" 
                                id="precio_final_${item.id}"
                                onchange="updatePrecio(${item.id})"
                                disabled
                            >
                        </td>
                        <td>
                            <input 
                                type="numeric" 
                                class="form-control cant number pvp" 
                                name="pvp_${item.id}" 
                                value="${item.pvp}" 
                                id="pvp_${item.id}"
                                onchange="updatePvp(${item.id})"
                                oninput="validarInputPvp(${item.id})"
                                min="0"
                            >
                        </td>
                        <td>
                            <a onclick="deleteItem(${item.id})" class="btn btn-borrar">
                                <img src="./public/images/delete.png" width="25" >
                            </a>
                        </td>
                        </tr>`
                    total += parseFloat(item.pvp)
                }
            }
            
            document.getElementById("input-total").value = parseFloat(total).toFixed(2)
        },
        error: function(resultado){
            alertProcesando("ERROR:  El Item no se encontró o no se pudo eliminar", "error")
        }
    });
}

function cancelar(new_id){
    //Elimino los temporales
    $.ajax({
        url: 'deleteItemsTempProductCotizador',
        method: 'get',
        data: {
            new_id: new_id,
        },
        success: function(resultado){
            console.log(new_id);
        }
    });

    location.replace('./inicio');
}

function activarSubmit(){
    
    let btnSubmit = document.getElementById("btnGuardar")
    btnSubmit.removeAttribute('disabled')
}

function agregarItem(idproducto, item){
    let idNew = document.getElementById("new_id").value
    let inputItem = document.getElementById("iditem")
    
    if (idproducto != null && idproducto != 0 && idproducto > 0) {
        
        $.ajax({
            url: 'detalle-prod-insert_temp',
            method: 'get',
            data: {
                idproducto: idproducto,
                item: item,
                idNew: idNew
            },
            success: function(resultado){
                
                if (resultado == 0) {
                }else{
                    
                    let detalle = JSON.parse(resultado);
                    let total = 0
                    //console.log(detalle);
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
                                        type="numeric" 
                                        class="form-control cant number porcentaje" 
                                        name="porcentaje_${item.id}"
                                        value = "${item.porcentaje}"
                                        placeholder="0"
                                        id="porcentaje_${item.id}" 
                                        onchange="calculaPorcentaje(${item.id})"
                                        oninput="validarInput2(${item.id})"
                                        min="0"
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant number precio" 
                                        name="precio_${item.id}" 
                                        value="${item.precio_unitario}" 
                                        id="precio_${item.id}"
                                        onchange="calculaPorcentaje(${item.id})"
                                        disabled
                                    >
                                    <a href="javascript:activaEditar(${item.id})">editar</a>
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant number precio_final" 
                                        name="precio_final_${item.id}" 
                                        value="${item.precio_actual}" 
                                        id="precio_final_${item.id}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="numeric" 
                                        class="form-control cant number pvp" 
                                        name="pvp_${item.id}" 
                                        value="${item.pvp}" 
                                        id="pvp_${item.id}"
                                        onchange="updatePvp(${item.id})"
                                        oninput="validarInputPvp(${item.id})"
                                        min="0"
                                    >
                                </td>
                                <td>
                                    <a onclick="deleteItem(${item.id})" class="btn btn-borrar">
                                        <img src="./public/images/delete.png" width="25" >
                                    </a>
                                </td>
                                </tr>`
                            total += parseFloat(item.pvp)
                        }
                        
                        document.getElementById("input-total").value = parseFloat(total).toFixed(2)
                    }else{
                        alertProcesando("ERROR: Hubo un error y el item no se pudo agregar", "error")
                    }
                }
            }
        });
        //console.log(cod_pedido);
        
    }
    
}

const activaEditar = (id) =>{
    let input = document.getElementById('precio_'+id)
    input.disabled = false
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

const alertProcesando = (msg, icono) => {
    const toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 1500,
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

linkBorraImagen.addEventListener('click', function(e) {
    e.stopPropagation()
    let divImagen = document.getElementById('image-product')
    //let imagenNew = document.querySelector('input[name="file-img"]')
    divImagen.src = "./public/images/productos/default-img.jpg"
});