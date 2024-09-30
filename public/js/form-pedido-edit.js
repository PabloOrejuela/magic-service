aData = {}
let imptEmail = document.getElementById("email")
let sectores = document.getElementById("sectores")

imptEmail.addEventListener('input', function(e){
    e.stopPropagation()
    let email = imptEmail.value
    imptEmail.value = email.toLowerCase()
    
})

$('#idproducto').autocomplete({
  source: function(request, response){
    
      $.ajax({
          url: '../getProductosAutocomplete',
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
  sector = document.getElementById("sectores");
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

  //Hago el cálculo del mensajero SOLO si se ha seleccionado un sector
  if (sector.selectedIndex != 0 && sector.selectedIndex != 13) {
    calcularMensajero();
    impTotal.value = total.toFixed(2);
  }else{
    document.getElementById('valor_mensajero').value = "0.00"
    document.getElementById('valor_mensajero_mostrado').value = "0.00"
  }
}

$(document).ready(function(){
  $("#horario_entrega").on('change',function(){
      if($("#horario_entrega").val() !=""){
          valor = $("#horario_entrega").val();
          //console.log(valor);
          $.ajax({
              method: 'get',
              dataType:"html",
              url: "../get_costo_horario",
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
        url: "../get_valor_sector",
        data: {
          sector: valor
        },
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(resultado){
            let dato = JSON.parse(resultado);
            //console.log('Valor: ' + valor);
            if (valor != 0) {
                alertCambioValor()
                document.getElementById("transporte").value = parseFloat(dato.sector.costo_entrega)
            }else{
                alertCambioValor()
                document.getElementById("transporte").value = 0
                document.getElementById("valor_mensajero").value = 0
                document.getElementById("valor_mensajero_mostrado").value = 0
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
          url: '../detalle_pedido_insert_temp',
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
          url: '../ventas/detalle_pedido_delete_producto_temp/' + idproducto + '/' + cod_pedido,
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
          url: '../ventas/detalle_pedido_insert_observacion_temp/' + idproducto + '/' + cod_pedido+'/'+observacion,
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
                      //sumarTotal()
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
          url: '../detalle_pedido_update_precio_temp',
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
      method:"GET",
      dataType:"html",
      url: "../ventas/getDetallePedido_temp/"+cod_pedido,
      data: {
        
      },
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

  //Capturo los valores del sistema
  let porcentajeHorario = parseFloat(document.getElementById("porcentCargoHorario").value)/100
  let porcentajeHorarioExtra = parseFloat(document.getElementById("porcentCargoHorarioExtra").value)/100
  let porcentajeTransporte = parseFloat(document.getElementById("porcentTransporte").value)/100
  let porcentajeDomingo = parseFloat(document.getElementById("porcentCargoDomingo").value)/100
  

  if (isNaN(parseFloat(transporte)) == true) {
      transporte = 0
  }

  if (isNaN(parseFloat(cargoDomingo)) == true) {
      cargoDomingo = 0
  }

  if (isNaN(parseFloat(horarioExtra)) == true) {
      horarioExtra = 0
  }

  if (sectores == 0 || sectores == 18) {
    valorMensajero = "0.00"
  } else {
    valorMensajero = parseFloat(cargoDomingo * porcentajeDomingo) + parseFloat(transporte) + parseFloat("4") + parseFloat(horarioExtra * porcentajeHorarioExtra)
    
  }

  // /* Este es el cálculo. */
  if (valorMensajeroEdit != 0 && valorMensajeroEdit != '') {
      total = (parseFloat(total) + parseFloat(valorMensajeroEdit));
  }else{
      total = (parseFloat(total) + parseFloat(valorMensajero));
  }

  document.getElementById('valor_mensajero').value = valorMensajero
  document.getElementById('valor_mensajero_mostrado').value = valorMensajero

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
