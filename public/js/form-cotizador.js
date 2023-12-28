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
                    let tablaItemsBody = document.getElementById('tablaItemsBody')
                    tablaItemsBody.innerHTML = ''
                    for(let item of items){
                        
                        tablaItemsBody.innerHTML += `<tr>
                            <td>${item.id}</td><td>${item.item}</td>
                            <td><input type="text" class="form-control cant" name="porcentaje_${item.id}" value="0"></td>
                            <td><input type="text" class="form-control cant" name="cantidad_${item.id}" value="${item.cantidad}"></td>
                            <td><input type="text" class="form-control cant" name="cantidad_${item.id}" value="${item.precio}"></td>
                            </tr>`
                    }
                },
                error: function(resultado){
                    console.log('El producto no tiene items');
                }
            });
        }
    });
  });