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
            //console.log(valor);
                $.ajax({
                type:"GET",
                dataType:"html",
                url: "getItemsProducto"+'/'+valor,
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
                                    value = 1
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
                                >
                            </td>
                            <td>
                                <input 
                                    type="text" 
                                    class="form-control cant" 
                                    name="precio_${item.id}" 
                                    value="${item.precio}" 
                                    id="precio_${item.id}"
                                    onchange="calculaPorcentaje(${item.id})"
                                >
                            </td>
                            </tr>`
                        total += parseFloat(item.precio)
                    }
                    
                    document.getElementById("input-total").value = parseFloat(total).toFixed(2)
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
    let precio = 0
    let unidades = document.getElementById("cantidad_"+idItem).value
    let porcentaje = document.getElementById("porcentaje_"+idItem).value
    let idproducto = document.getElementById("idproducto").value
    
    precio = porcentaje * unidades
    document.getElementById("precio_"+idItem).value = parseFloat(precio).toFixed(2)
    calculaTotal(idproducto)
}

function calculaTotal(valor){
    $.ajax({
        type:"GET",
        dataType:"html",
        url: "getItemsProducto"+'/'+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let items = JSON.parse(resultado);
            let total = 0
            let precio = 0
            
            for(let item of items){
                precio = document.getElementById("precio_"+item.id).value 
                total += parseFloat(precio)
                
            }
            document.getElementById("input-total").value = parseFloat(total).toFixed(2)
        }
    })
}