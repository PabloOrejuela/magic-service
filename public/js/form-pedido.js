aData = {}
let imptEmail = document.getElementById("email")

imptEmail.addEventListener('input', function(e){
    e.stopPropagation()
    let email = imptEmail.value
    imptEmail.value = email.toLowerCase()
    
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

$(document).ready(function(){
  $("#sectores").on('change',function(){
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

                  if (valor != 0) {
                      alertCambioValor()
                      document.getElementById("transporte").value = parseFloat(dato.sector.costo_entrega)
                  }else{
                      alertCambioValor()
                      document.getElementById("transporte").value = 0
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
  });
});

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
