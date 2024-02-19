$(document).ready(function(){
    $("#categoria").on('change',function(){
        if($("#categoria").val() !=""){
            valor = $("#categoria").val();

            $.ajax({
                type:"GET",
                dataType:"html",
                url: "getProductosCategoria"+'/'+valor,
                beforeSend: function (f) {
                    alertProcesando()
                },
                success: function(resultado){
                  
                    let productos = JSON.parse(resultado);
                    let selectProductos = document.getElementById('productos')
                    if (productos) {
                        $("#productos").prop('disabled', false);

                        
                        selectProductos.innerHTML = ''
                        selectProductos.innerHTML += `<option value="-1" id="new-prod-option"><a href="#">--Nuevo producto--</a></option>`
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


  $(document).ready(function(){
    $("#productos").on('change',function(){
        if($("#productos").val() !=""){
            valor = $("#productos").val();
            
            if (valor == -1) {
                //Nuevo producto
                
                let nombreArregloNuevo = document.getElementById("nombreArregloNuevo")
                let inputTotal = document.querySelector("#input-total")
                let divImg = document.querySelector("#div-img")
                let tablaItemsBody = document.querySelector("#tablaItemsBody")
                let image = document.getElementById("image-product")
                let lblImage = document.getElementById("lbl-image")
                let impFileImg = document.querySelector("#formFileImg")
                let inputItems = document.querySelector("#iditem")

                lblImage.innerHTML = "Imagen"
                image.src = "./public/images/default-img.png"
                //divImg.style.display = "none"

                inputItems.value = ''
                
                impFileImg.removeAttribute('disabled')
                nombreArregloNuevo.removeAttribute('disabled')
                nombreArregloNuevo.value = "NUEVO PRODUCTO"

                
                inputTotal.value = "0.00"
                removeRows(tablaItemsBody)                

            } else {
                getDatosProducto(valor)
                
                $.ajax({
                    type:"GET",
                    dataType:"html",
                    url: "ventas-getItemsProducto"+'/'+valor,
                    beforeSend: function (f) {
                        alertProcesando()
                },
                    success: function(resultado){
                    //console.log(resultado);
                        let items = JSON.parse(resultado);
                        let total = 0

                        let tablaItemsBody = document.getElementById('tablaItemsBody')
                        tablaItemsBody.innerHTML = ''
                        document.getElementById("idproducto").value = valor
                        for(let item of items){
                            document.getElementById("new_id").value = item.new_id
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
                                        value="${item.precio}" 
                                        id="precio_${item.id}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant precio_final" 
                                        name="precio_final_${item.id}" 
                                        value="${item.precio}" 
                                        id="precio_final_${item.id}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant pvp" 
                                        name="pvp_${item.id}" 
                                        value="${item.precio}" 
                                        id="pvp_${item.id}"
                                        onchange="calculaTotal()"
                                    >
                                </td>
                                <td>
                                    <a onclick="deleteItem(${item.id})" class="btn btn-borrar">
                                        <img src="./public/images/delete.png" width="25" >
                                    </a>
                                </td>
                                </tr>`
                            total += parseFloat(item.precio)
                        }
                        let nombreArregloNuevo = document.getElementById("nombreArregloNuevo")
                        let slctProductos = document.getElementById("productos")
                        let index = slctProductos.selectedIndex
                        
                        document.getElementById("input-total").value = parseFloat(total).toFixed(2)
                        
                        nombreArregloNuevo.removeAttribute('disabled')
                        let nombretemp = slctProductos.options[index].text
                        nombreArregloNuevo.value = nombretemp+'_temp'

                    },
                    error: function(resultado){
                        console.log('El producto no tiene items');
                    }
                });
            }
        }
    });
  });
  //onchange="observacion('.$row->idproducto. ','.$cod_pedido.')"
function calculaPorcentaje(idItem){
    //limitaPorcentaje(idItem)
    
    let precioVenta = 0
    let porcentaje = document.getElementById("porcentaje_"+idItem).value
    let precio = document.getElementById("precio_"+idItem).value
    let idproducto = document.getElementById("idproducto").value
    let idNew = document.getElementById("new_id").value
    let precioFinal = document.getElementById("precio_final_"+idItem)
    let pvp = document.getElementById("pvp_"+idItem)
    
    precioVenta = (parseFloat(porcentaje) * parseFloat(precio))
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
            precio: datosActualizar.precio,
            precio: datosActualizar.precioFinal,
            pvp: datosActualizar.pvp,
            porcentaje: datosActualizar.porcentaje,
            idItem: datosActualizar.idItem,
            idNew: datosActualizar.idNew
        },
        beforeSend: function (f) {
            alertProcesando()
        },
        success: function(resultado){
            return 1;
        },
        error: function(resultado){
          console.log('No hay productos de esa categoría');
        }
    });
    calculaTotal()
}

function limitaPorcentaje(idItem){
    let porcentaje = document.getElementById("porcentaje_"+idItem).value
    if (porcentaje > 1) {
        document.getElementById("porcentaje_"+idItem).value = 1
    } else {
        document.getElementById("porcentaje_"+idItem).value = porcentaje
    }
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
            alertProcesando()
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
            alertProcesando()
        },
        success: function(resultado){
          
            let items = JSON.parse(resultado);
            let total = 0
            
            let tablaItemsBody = document.getElementById('tablaItemsBody')
            tablaItemsBody.innerHTML = ''

            document.getElementById("idproducto").value = valor
            for(let item of items.datos){
                document.getElementById("new_id").value = item.new_id
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
                            value="${item.precio}" 
                            id="precio_${item.id}"
                            onchange="calculaPorcentaje(${item.id})"
                            disabled
                        >
                    </td>
                    <td>
                        <input 
                            type="text" 
                            class="form-control cant precio_final" 
                            name="pvp_${item.id}" 
                            value="${item.precio}" 
                            id="precio_final_${item.id}"
                            onchange="calculaPorcentaje(${item.id})"
                            disabled
                        >
                    </td>
                    <td>
                        <input 
                            type="text" 
                            class="form-control cant pvp" 
                            name="pvp_${item.id}" 
                            value="${item.precio}" 
                            id="pvp_${item.id}"
                            onchange="calculaTotal()"
                        >
                    </td>
                    <td>
                        <a onclick="deleteItem(${item.id})" class="btn btn-borrar">
                            <img src="./public/images/delete.png" width="25" >
                        </a>
                    </td>
                    </tr>`
                total += parseFloat(item.precio)
            }
        },
        error: function(resultado){
            console.log(`El Item no se encontró o no se pudo eliminar`);
        }
    });
}

function cancelar(){
    
    location.replace('cotizador');
}

function activarSubmit(){
    
    let btnSubmit = document.getElementById("btnGuardar")
    btnSubmit.removeAttribute('disabled')
}

function agregarItem(idproducto, item){
    let idNew = document.getElementById("new_id").value
    
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

                    alertAgregaItem()
                    
                    let tablaItemsBody = document.getElementById('tablaItemsBody')
                    
                    tablaItemsBody.innerHTML = ''
                    if (detalle.error != '') {

                        for(element of detalle.datos){
                            
                            tablaItemsBody.innerHTML += `<tr>
                                <td>${element.id}</td><td>${element.item}</td>
                                <td>
                                    <input 
                                        type="number" 
                                        class="form-control cant porcentaje" 
                                        name="porcentaje_${element.id}"
                                        value = "${element.porcentaje}"
                                        placeholder="0"
                                        id="porcentaje_${element.id}" 
                                        onchange="calculaPorcentaje(${element.id})"
                                        min="0.1" max="1.0" step="0.1"
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant precio" 
                                        name="precio_${element.id}" 
                                        value="${element.precio}" 
                                        id="precio_${element.id}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant precio_final" 
                                        name="precio_final_${element.id}" 
                                        value="${element.precio}" 
                                        id="precio_final_${element.id}"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant pvp" 
                                        name="pvp_${element.id}" 
                                        value="${element.precio}" 
                                        id="pvp_${element.id}"
                                        onchange="calculaTotal()"
                                    >
                                </td>
                                <td>
                                    <a onclick="eliminaItem(${element.id})" class="btn btn-borrar">
                                        <img src="./public/images/delete.png" width="25" >
                                    </a>
                                </td>
                                </tr>`
                            total += parseFloat(element.precio)
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

const alertAgregaItem = () => {
    Swal.fire({
        position: "center",
        icon: "success",
        title: "El Item se ha agregado",
        showConfirmButton: false,
        timer: 1200
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