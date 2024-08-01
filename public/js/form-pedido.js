aData = {}
let imptEmail = document.getElementById("email")
let sectores = document.getElementById("sectores")
let sliderEntregaDesde = document.getElementById("sliderEntregaDesde")
let rangoEntregaDesde = document.getElementById("rango-entrega-desde")
let sliderEntregaHasta = document.getElementById("sliderEntregaHasta")
let rangoEntregaHasta = document.getElementById("rango-entrega-hasta")


imptEmail.addEventListener('input', function(e){
    e.stopPropagation()
    let email = imptEmail.value
    imptEmail.value = email.toLowerCase()
    
})

sliderEntregaDesde.addEventListener('input', function(e){
    let caracterMinutos = ":"
    let cadenaDesde = ""
    let cadenaTexto = sliderEntregaDesde.value
    
    if (cadenaTexto.length < 4) {
        let minutosCadena = cadenaTexto.slice(1)
        let minutos = parseInt(minutosCadena)
        
        if(minutos >= 0 && minutos < 60){

            cadenaDesde = cadenaTexto.slice(0, 1) + caracterMinutos + minutos
            if (cadenaDesde.length == 3) {
                rangoEntregaDesde.value = cadenaDesde+"0"
            }else{
                rangoEntregaDesde.value = cadenaDesde
            }
            
        }

    }

    if (cadenaTexto.length == 4) {
        let minutosCadena = cadenaTexto.slice(2)
        let minutos = parseInt(minutosCadena)
        if(minutos >= 0 && minutos < 60){

            cadenaDesde = cadenaTexto.slice(0, 2) + caracterMinutos + minutos
            if (cadenaDesde.length == 4) {
                rangoEntregaDesde.value = cadenaDesde+"0"
            }else{
                rangoEntregaDesde.value = cadenaDesde
            }
        }
    }
    
})

sliderEntregaHasta.addEventListener('input', function(e){
    let min = rangoEntregaDesde.value
    let minimo = parseInt(min.replace(":",""))
    let caracterMinutos = ":"
    let cadenaDesde = ""
    let cadenaTexto = sliderEntregaHasta.value
    
    console.log(minimo);

    if (cadenaTexto.length < 4) {
        let minutosCadena = cadenaTexto.slice(1)
        let minutos = parseInt(minutosCadena)

        if (parseInt(cadenaTexto) >= minimo) {
            if(minutos >= 0 && minutos < 60){

                cadenaDesde = cadenaTexto.slice(0, 1) + caracterMinutos + minutos
                if (cadenaDesde.length == 3) {
                    rangoEntregaHasta.value = cadenaDesde+"0"
                }else{
                    rangoEntregaHasta.value = cadenaDesde
                }
            }
    
        } 
    }

    if (cadenaTexto.length == 4) {
        let minutosCadena = cadenaTexto.slice(2)
        let minutos = parseInt(minutosCadena)

        if (parseInt(cadenaTexto) >= minimo) {
            if(minutos >= 0 && minutos < 60){

                cadenaDesde = cadenaTexto.slice(0, 2) + caracterMinutos + minutos
                if (cadenaDesde.length == 4) {
                    rangoEntregaHasta.value = cadenaDesde+"0"
                }else{
                    rangoEntregaHasta.value = cadenaDesde
                }
            }
        }
    }
    
})

$('#idproducto').autocomplete({
  source: function(request, response){
    
      $.ajax({
          url: 'getProductosAutocomplete',
          method: 'GET',
          dataType: 'json',
          data: {
              producto: request.term
          },
          success: function(res) {

              aData = $.map(res, function(value, key){
                  return{
                      id: value.id,
                      label: value.producto + ' - ' + value.precio
                  };
              });
              let results = $.ui.autocomplete.filter(aData, request.term);
              response(results)
          }
      });
  },
  select: function(event, ui){
      //document.getElementById('idp').value = 10
      document.getElementById("idp").value = ui.item.id
      //console.log(ui.item.id);
  }
});

function limpiarClienteTelefono() {
  document.getElementById("nombre").value = "";
  document.getElementById("documento").value = "";
  document.getElementById("email").value = "";
  document.getElementById("idcliente").value = "";
  document.getElementById("telefono_2").value = "";
}

function limpiarClienteDocumento() {
  document.getElementById("nombre").value = "";
  document.getElementById("telefono").value = "";
  document.getElementById("email").value = "";
  document.getElementById("idcliente").value = "";
  document.getElementById("telefono_2").value = "";
}

function limpiaCamposCliente() {
  document.getElementById("nombre").value = "";
  document.getElementById("documento").value = "";
  document.getElementById("telefono").value = "";
  document.getElementById("email").value = "";
  document.getElementById("idcliente").value = "";
  document.getElementById("telefono_2").value = "";
}

function sumarTotal() {
  let descuento = 0;
  let total = 0;
  let subtotal = 0
  let impTotal = 0
  let porcentajeDescuento = 0
  let transporte = 0
  let cargoDomingo = 0
  let horarioExtra = 0

  //Obtengo todos los valores de las casillas
  impTotal = document.getElementById("total");

  subtotal = document.getElementById("valor_neto").value;
  porcentajeDescuento = document.getElementById("descuento").value;
  transporte = document.getElementById("transporte").value;
  cargoDomingo = document.getElementById("cargo_domingo").value;
  horarioExtra = document.getElementById("horario_extra").value;

  
  if (isNaN(parseFloat(subtotal)) == true) {
    subtotal = 0;
  }

  if (isNaN(parseFloat(porcentajeDescuento)) == true) {
    porcentajeDescuento = 0;
  }

  if (isNaN(parseFloat(transporte)) == true) {
    transporte = 0;
  }

  if (isNaN(parseFloat(cargoDomingo)) == true) {
    cargoDomingo = 0;
  }

  if (isNaN(parseFloat(horarioExtra)) == true) {
    horarioExtra = 0;
  }

  if (porcentajeDescuento != 0) {
    descuento = (parseFloat(subtotal) * parseFloat(porcentajeDescuento)) / 100;
  } else {
    descuento = 0;
  }

  total = parseFloat(subtotal) + parseFloat(transporte) + parseFloat(cargoDomingo) + parseFloat(horarioExtra) - descuento;

  //Hago el cálculo del mensajero
  calcularMensajero();

  impTotal.value = total.toFixed(2);
}

$(document).ready(function(){
  $("#horario_entrega").on('change',function(){
      if($("#horario_entrega").val() !=""){
          valor = $("#horario_entrega").val();
          //console.log(valor);
          $.ajax({
              method: 'get',
              dataType:"html",
              url: "get_costo_horario",
              data: {
                horario: valor,
              },
              beforeSend: function (f) {
                  //$('#cliente').html('Cargando ...');
              },
              success: function(res){
                  
                  let data = JSON.parse(res);

                  if (valor != 0) {
                      alertCambioValor()
                      document.getElementById("horario_extra").value = parseFloat(data.costo)
                  }else{
                      alertCambioValor()
                      document.getElementById("horario_extra").value = 0
                  }
                  
                  sumarTotal()
              },
              error: function(data){
                  console.log("No existe el valor de ese horario");
              }
          });
      }else{
          console.log("No existe el valor de ese horario");
      }
  });
});

//SECTOR
sectores.addEventListener("change", () => {
  if($("#sectores").val() !=""){
    valor = $("#sectores").val();
    $.ajax({
        method: 'get',
        dataType:"html",
        url: "get_valor_sector",
        data: {
          sector: valor
        },
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let dato = JSON.parse(resultado);
            console.log('Valor: ' + valor);
            if (valor != 0) {
                alertCambioValor()
                document.getElementById("transporte").value = parseFloat(dato.sector.costo_entrega)
            }else{
                alertCambioValor()
                document.getElementById("transporte").value = 0
                document.getElementById("valor_mensajero").value = 0
            }
            
            sumarTotal()

        },
        error: function(data){
            console.log("No existe el costo de entrega");
        }
    });
  }else{
      console.log("No existe el costo de entrega");
  }
})

function agregarProducto(idproducto, cantidad, cod_pedido){
  let transporte = 0
  let cargoDomingo = 0
  let horarioExtra = 0

  let total = document.getElementById("total")

  transporte = document.getElementById("transporte").value
  cargoDomingo = document.getElementById("cargo_domingo").value
  horarioExtra = document.getElementById("horario_extra").value
  

  if (isNaN(parseFloat(transporte)) == true) {
      transporte = 0;
  }

  if (isNaN(parseFloat(cargoDomingo)) == true) {
      cargoDomingo = 0;
  }

  if (isNaN(parseFloat(horarioExtra)) == true) {
      horarioExtra = 0;
  }

  let extras = parseFloat(transporte) + parseFloat(cargoDomingo) + parseFloat(horarioExtra)

  
  if (idproducto != null && idproducto != 0 && idproducto > 0) {
      
      $.ajax({
          url: 'detalle_pedido_insert_temp',
          data: {
              idproducto: idproducto,
              cantidad: cantidad,
              cod_pedido: cod_pedido,
          },
          success: function(resultado){
              if (resultado == 0) {
              }else{
                  alertAgregaProducto()

                  let detalle = JSON.parse(resultado);
                  //console.log(parseFloat(detalle.total) + parseFloat(extras));
                  if (detalle.error == '') {
                      $("#tablaProductos tbody").empty();
                      $("#tablaProductos tbody").append(detalle.datos);
                      //$("#total").val(detalle.total);
                      total.value = (parseFloat(detalle.total) + extras).toFixed(2)
                      document.getElementById('valor_neto').value = detalle.total
                      limpiaLineaProducto()
                  }
              }
          }
      });
      
  }
  calculaValorNeto(cod_pedido);
  calcularMensajero();
}

function eliminaProducto(idproducto, cod_pedido){
  let transporte = 0
  let cargoDomingo = 0
  let horarioExtra = 0

  let total = document.getElementById("total")

  transporte = document.getElementById("transporte").value
  cargoDomingo = document.getElementById("cargo_domingo").value
  horarioExtra = document.getElementById("horario_extra").value

  if (isNaN(parseFloat(transporte)) == true) {
      transporte = 0;
  }

  if (isNaN(parseFloat(cargoDomingo)) == true) {
      cargoDomingo = 0;
  }

  if (isNaN(parseFloat(horarioExtra)) == true) {
      horarioExtra = 0;
  }

  let extras = parseFloat(transporte) + parseFloat(cargoDomingo) + parseFloat(horarioExtra)

  if (idproducto != null && idproducto != 0 && idproducto > 0) {

      $.ajax({
          url: 'ventas/detalle_pedido_delete_producto_temp/' + idproducto + '/' + cod_pedido,
          success: function(resultado){
              if (resultado == 0) {

              }else{
                  //Exito

                  let detalle = JSON.parse(resultado);

                  if (detalle.error == '') {
                      $("#tablaProductos tbody").empty();
                      $("#tablaProductos tbody").append(detalle.datos);
                      //$("#total").val(detalle.total);
                      //$("#valor_neto").val(detalle.subtotal);
                      total.value = (parseFloat(detalle.total) + extras).toFixed(2)
                      document.getElementById('valor_neto').value = detalle.subtotal
                      alertEliminaProducto()
                      limpiaLineaProducto()
                  }else{
                      console.log("Error");
                  }
                  
              }
          }
      });
      
  }
  calculaValorNeto(cod_pedido);
  calcularMensajero();
}

function observacion(idproducto, cod_pedido){
  let observacion = document.getElementById("observa_"+idproducto).value
  //console.log(observacion);
  if (observacion != null && observacion != '') {

      $.ajax({
          url: 'ventas/detalle_pedido_insert_observacion_temp/' + idproducto + '/' + cod_pedido+'/'+observacion,
          success: function(resultado){
              if (resultado == 0) {

              }else{
                  //Exito
                  let detalle = JSON.parse(resultado);

                  if (detalle.error == '') {
                      $("#tablaProductos tbody").empty();
                      $("#tablaProductos tbody").append(detalle.datos);
                      $("#total").val(detalle.total);
                      $("#valor_neto").val(detalle.subtotal);

                      limpiaLineaProducto()
                      calculaValorNeto(cod_pedido);
                      sumarTotal()
                  }
              }
          }
      });
      
  }
}

function actualizaPrecio(idproducto, cod_pedido){
  let precio = document.getElementById("precio_"+idproducto).value
  let cant = document.getElementById("cant_"+idproducto).innerHTML
  
  if (precio != null && precio != '') {

      $.ajax({
          url: 'detalle_pedido_update_precio_temp',
          data: {
              idproducto: idproducto,
              cod_pedido: cod_pedido,
              precio: precio,
              cant: cant
          },
          success: function(resultado){
              if (resultado == 0) {

              }else{
                  //Exito
                  let detalle = JSON.parse(resultado);
                  //console.log(detalle);
                  if (detalle.error == '') {
                      $("#tablaProductos tbody").empty();
                      $("#tablaProductos tbody").append(detalle.datos);
                      $("#total").val(detalle.total);
                      $("#valor_neto").val(detalle.subtotal);

                      limpiaLineaProducto()
                      calculaValorNeto(cod_pedido);
                      sumarTotal()
                  }
              }
          }
      });
      
  }
}

function limpiaLineaProducto() {

  document.getElementById("idproducto").value = '';
  document.getElementById('idp').value = 0;
  document.getElementById('cant').value = 1;
}

function calculaValorNeto(cod_pedido) {

  let total = 0;
  $.ajax({
      type:"GET",
      dataType:"html",
      url: "ventas/getDetallePedido_temp/"+cod_pedido,
      success: function(resultado){
          let detalle = JSON.parse(resultado);
          //console.log("Detalle: " + detalle.cantidad);
          document.getElementById('valor_neto').value = detalle.subtotal.toFixed(2);
          document.getElementById('cant_arreglos').value = detalle.cantidad;
      }
  });
}

function calcularMensajero(){
  let sectores = document.getElementById("sectores").value
  let transporte = document.getElementById('transporte').value
  let cargoDomingo = document.getElementById('cargo_domingo').value
  let horarioExtra = document.getElementById('horario_extra').value
  let valorMensajero = document.getElementById('valor_mensajero').value
  let valorMensajeroEdit = document.getElementById('valor_mensajero_edit').value
  let cantProd = document.getElementById("cant_arreglos").value;

  let porcentajeMensajeroEntregaExtra = parseFloat(document.getElementById("porcentTransporteExtra").value)/100
  let porcentajeMensajeroEntregaExtraOtro = parseFloat(document.getElementById("porcentTransporteExtraOtroSector").value)/100

  
  if (isNaN(parseFloat(transporte)) == true) {
      transporte = 0
  }

  if (isNaN(parseFloat(cargoDomingo)) == true) {
      cargoDomingo = 0
  }

  if (isNaN(parseFloat(horarioExtra)) == true) {
      horarioExtra = 0
  }
  let extraMensajero = 0
  let cantProdExtra = (cantProd - 1)
  
  if (cantProdExtra >= 1) {
      //console.log("cant: " + cantProdExtra);
      if (sectores == 1) {
          
          //Se agrega 50% de Transporte mas 50% mas de carga horario mas 50% mas de domingo por cada arreglo extra
          for (let i = 1; i <= cantProdExtra; i++) {
              extraMensajero += ((parseFloat(transporte))*porcentajeMensajeroEntregaExtra) 
                              + (parseFloat(horarioExtra)*porcentajeMensajeroEntregaExtra) 
                              + (parseFloat(cargoDomingo)*porcentajeMensajeroEntregaExtra)
          }

          valorMensajero = parseFloat(cargoDomingo/2) + parseFloat(transporte) + parseFloat(horarioExtra/2) + extraMensajero

      }else if(sectores > 1){
          
          //Se agrega 35% de Transporte mas 35% mas de carga horario mas 35% mas de domingo por arreglo
          for (let i = 1; i <= cantProdExtra; i++) {
              extraMensajero += (parseFloat(transporte) * porcentajeMensajeroEntregaExtraOtro) 
                              + (parseFloat(horarioExtra) * porcentajeMensajeroEntregaExtraOtro) 
                              + (parseFloat(cargoDomingo) * porcentajeMensajeroEntregaExtraOtro)
                              
              // console.log("Trans: " + (parseFloat(transporte) * porcentajeMensajeroEntregaExtra) );
              // console.log("Horario: " + (parseFloat(horarioExtra) * porcentajeMensajeroEntregaExtra) );
              // console.log("Domingo: " + (parseFloat(cargoDomingo) * porcentajeMensajeroEntregaExtra) );
              // console.log(extraMensajero);
          }

          valorMensajero = parseFloat(cargoDomingo/2) + parseFloat(transporte) + parseFloat(horarioExtra/2) + extraMensajero
      }else{
          console.log("No se ha elegio un sector poner una validación");
      }
  } else {
      console.log(cantProdExtra);
      //Si solo es un arreglo no hay extra hace este cálculo, el 4 se agrega pues el sector norte se supone que es gratis pero si carga 4 al valor del mensajero
      valorMensajero = parseFloat(cargoDomingo/2) + parseFloat(transporte) + 4 + parseFloat(horarioExtra/2)

  }

  // /* Este es el cálculo. */
  if (valorMensajeroEdit != 0 && valorMensajeroEdit != '') {
      total = (parseFloat(total) + parseFloat(valorMensajeroEdit));
  }else{
      total = (parseFloat(total) + parseFloat(valorMensajero));
  }

  document.getElementById('valor_mensajero').value = valorMensajero

}

$(document).ready(function(){
  $("#inputFecha").on('change',function(){
      if($("#inputFecha").val() !=""){
          valor = $("#inputFecha").val();
          
          diaSemana = getDayOfWeek(valor)
          if (diaSemana == 6) {
              document.getElementById("cargo_domingo").value = 2
          }else{
              document.getElementById("cargo_domingo").value = 0
          }
          alertCambioValor()
          sumarTotal()
      }
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

const confirmSaveAlert = () => {
  Swal.fire({
    position: "center",
    icon: "success",
    title: "El pedido ha sido guardado",
    showConfirmButton: false,
    timer: 1500,
  });
};

const alertCambio = () => {
  Swal.fire({
    position: "center",
    icon: "success",
    title: "El cambio se ha realizado",
    showConfirmButton: false,
    timer: 500,
  });
};
