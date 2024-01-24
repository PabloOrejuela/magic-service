$(document).ready(function(){
    $("#categoria").on('change',function(){
        if($("#categoria").val() !=""){
            valor = $("#categoria").val();
            //console.log(valor);
            $.ajax({
                type:"GET",
                dataType:"html",
                url: "getProductosCategoria"+'/'+valor,
                beforeSend: function (f) {
                    //$('#cliente').html('Cargando ...');
                },
                success: function(resultado){
                  
                    let productos = JSON.parse(resultado);
                    $("#productos").prop('disabled', false);

                    let selectProductos = document.getElementById('productos')
                    selectProductos.innerHTML = ''
                    selectProductos.innerHTML += `<option value="0">--Seleccionar producto--</option>`
                    for(let producto of productos){
                        
                        selectProductos.innerHTML += `<option value="${producto.id}">${producto.producto}</option>`
                    }
                },
                error: function(resultado){
                  console.log('No hay productos de esa categoría');
                }
            });
        }
    });
  });



  $(document).ready(function(){
    $("#productos").on('change',function(){
        if($("#productos").val() !=""){
            valor = $("#productos").val();
            getDatosProducto(valor)
            
            $.ajax({
                type:"GET",
                dataType:"html",
                url: "ventas-getItemsProducto"+'/'+valor,
                beforeSend: function (f) {
                    //$('#cliente').html('Cargando ...');
            },
                success: function(resultado){
                  
                    let items = JSON.parse(resultado);
                    let total = 0

                    let tablaItemsBody = document.getElementById('tablaItemsBody')
                    tablaItemsBody.innerHTML = ''
                    document.getElementById("idproducto").value = valor
                    for(let item of items){
                        
                        tablaItemsBody.innerHTML += `<tr>
                            <td>${item.id}</td><td>${item.item}</td>
                            <td>
                                <input 
                                    type="text" 
                                    class="form-control cant porcentaje" 
                                    name="porcentaje_${item.id}"
                                    value = ${item.porcentaje}
                                    placeholder="0"
                                    id="porcentaje_${item.id}" 
                                    onchange="calculaPorcentaje(${item.id})"
                                >
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    class="form-control cant" 
                                    name="cantidad_${item.id}" 
                                    value="${item.cantidad}" 
                                    id="cantidad_${item.id}"
                                    onchange="calculaPorcentaje(${item.id})"
                                    disabled
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
                                    class="form-control cant pvp" 
                                    name="pvp_${item.id}" 
                                    value="${item.precio}" 
                                    id="pvp_${item.id}"
                                    onchange="calculaPorcentaje(${item.id})"
                                >
                            </td>
                            <td>
                                <a onclick="eliminaItem(${item.id})" class="btn btn-borrar">
                                    <img src="./public/images/delete.png" width="25" >
                                </a>
                            </td>
                            </tr>`
                        total += parseFloat(item.precio)
                    }
                    
                    document.getElementById("input-total").value = parseFloat(total).toFixed(2)
                    document.getElementById("nombreArregloNuevo").removeAttribute('disabled')
                },
                error: function(resultado){
                    console.log('El producto no tiene items');
                }
            });
        }
    });
  });
  //onchange="observacion('.$row->idproducto. ','.$cod_pedido.')"
function calculaPorcentaje(idItem){
    console.log("calcula porcentaje");
    let costo = 0
    let unidades = document.getElementById("cantidad_"+idItem).value
    let porcentaje = document.getElementById("porcentaje_"+idItem).value
    let precio = document.getElementById("precio_"+idItem).value
    
    costo = (parseFloat(porcentaje) * parseFloat(precio) * parseInt(unidades))
    document.getElementById("pvp_"+idItem).value = '0'
    document.getElementById("pvp_"+idItem).value = parseFloat(costo).toFixed(2)

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
        url: "getProducto"+'/'+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let res = JSON.parse(resultado);
            let image = document.getElementById("image-product")
            let divImg = document.querySelector(".div-img")

            divImg.setAttribute("style", "display:block")
            document.getElementById("lbl-image").innerHTML = res.producto.image
            image.setAttribute("src", "public/images/productos/"+res.producto.image+'.jpg');
            
            //console.log(res.producto.image);
        }
    })
}

function cancelar(){
    
    location.replace('cotizador');
}

function agregarItem(idproducto, item){
    //console.log(idproducto+' / '+item);
    
    if (idproducto != null && idproducto != 0 && idproducto > 0) {
        
        $.ajax({
            url: 'detalle-prod-insert_temp',
            method: 'get',
            data: {
                idproducto: idproducto,
                item: item,
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
                                        type="text" 
                                        class="form-control cant porcentaje" 
                                        name="porcentaje_${element.id}"
                                        value = "${element.porcentaje}"
                                        placeholder="0"
                                        id="porcentaje_${element.id}" 
                                        onchange="calculaPorcentaje(${element.id})"
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant" 
                                        name="cantidad_${element.id}" 
                                        value="${element.cantidad}" 
                                        id="cantidad_${element.id}"
                                        onchange="calculaPorcentaje(${element.id})"
                                        disabled
                                    >
                                </td>
                                <td>
                                    <input 
                                        type="text" 
                                        class="form-control cant precio" 
                                        name="precio_${element.id}" 
                                        value="${element.precio}" 
                                        id="precio_${element.id}"
                                        onchange="calculaPorcentaje(${element.id})"
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
                                        onchange="calculaPorcentaje(${element.id})"
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