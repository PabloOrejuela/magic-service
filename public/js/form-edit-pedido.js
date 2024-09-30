let telefono = document.querySelector("#telefono");
let telefono_2 = document.querySelector("#telefono");
let formaPago = document.querySelector("#formas_pago");
let divBancos = document.querySelector("#div-bancos")
let divDocPago = document.querySelector("#div-doc-pago")


telefono.addEventListener("change", function () {
  if ($("#telefono").val() != "") {
    let valor = $("#telefono").val();
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "../ventas/clientes_select_telefono",
      data: "telefono=" + valor,
      beforeSend: function (f) {
        alertProcesando("Procesando...", "warning");
      },
      success: function (data) {
        // limpiarClienteDocumento();
        let cliente = JSON.parse(data);

        if (cliente) {
          //console.log(data);
          document.getElementById("nombre").value = cliente.nombre;
          document.getElementById("telefono").value = cliente.telefono;
          document.getElementById("telefono_2").value = cliente.telefono_2;
          document.getElementById("documento").value = cliente.documento;
          document.getElementById("email").value = cliente.email;
          document.getElementById("idcliente").value = cliente.id;
        } else {
          console.log("No hay, debo buscar en el 1 también");
          searchPhones(valor, 2);
        }
      },
      error: function (data) {
        alertProcesando(
          "No se ha encontrado un cliente con esos datos!",
          "error"
        );
      },
    });
  }
});

telefono_2.addEventListener("change", function () {
  if ($("#telefono_2").val() != "") {
    let valor = $("#telefono_2").val();
    //console.log(valor);
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "../ventas/clientes_select_telefono_2",
      data: "telefono=" + valor,
      beforeSend: function (f) {
        //$('#cliente').html('Cargando ...');
      },
      success: function (data) {
        let cliente = JSON.parse(data);

        if (cliente) {
          document.getElementById("nombre").value = cliente.nombre;
          document.getElementById("telefono").value = cliente.telefono;
          document.getElementById("telefono_2").value = cliente.telefono_2;
          document.getElementById("documento").value = cliente.documento;
          document.getElementById("email").value = cliente.email;
          document.getElementById("idcliente").value = cliente.id;
        } else {
          //console.log('No hay, debo buscar en el 1 también');
          searchPhones(valor, 1);
        }
      },
      error: function (data) {
        console.log("No hay");
      },
    });
  }
});

formaPago.addEventListener("change", function () {
  let valor = formaPago.value;
  console.log("Forma de pago");
  if (valor > 0 && valor <= 2) {
    divBancos.style.display = "block";
  }else{
    divBancos.style.display = "none";
  }
});

function searchPhones(valor, phone) {
  if (phone == 1) {
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "../ventas/clientes_select_telefono",
      data: "telefono=" + valor,
      beforeSend: function (f) {
        $("#cliente").html("Buscando ...");
      },
      success: function (data) {
        let cliente = JSON.parse(data);
        //console.log(cliente);
        if (cliente) {
          document.getElementById("nombre").value = cliente.nombre;
          document.getElementById("telefono").value = cliente.telefono;
          document.getElementById("telefono_2").value = cliente.telefono_2;
          document.getElementById("documento").value = cliente.documento;
          document.getElementById("email").value = cliente.email;
          document.getElementById("idcliente").value = cliente.id;
        }
      },
      error: function (data) {
        console.log("No hay");
      },
    });
  } else {
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "../ventas/clientes_select_telefono_2",
      data: "telefono=" + valor,
      beforeSend: function (f) {
        //$('#cliente').html('Cargando ...');
      },
      success: function (data) {
        let cliente = JSON.parse(data);

        if (cliente) {
          document.getElementById("nombre").value = cliente.nombre;
          document.getElementById("telefono").value = cliente.telefono;
          document.getElementById("telefono_2").value = cliente.telefono_2;
          document.getElementById("documento").value = cliente.documento;
          document.getElementById("email").value = cliente.email;
          document.getElementById("idcliente").value = cliente.id;
        }
      },
      error: function (data) {
        console.log("No hay");
      },
    });
  }
}

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
  let subtotal = 0;
  let porcentajeDescuento = 0;
  let transporte = 0;
  let cargoDomingo = 0;
  let horarioExtra = 0;
  let valorMensajeroEdit = 0;
  let valorMensajero = 0;
  let codigoPedido = document.getElementById("cod_pedido").value;

  //Obtengo todos los valores de las casillas
  subtotal = document.getElementById("valor_neto").value;
  impTotal = document.getElementById("total");
  porcentajeDescuento = document.getElementById("descuento").value;
  transporte = document.getElementById("transporte").value;
  cargoDomingo = document.getElementById("cargo_domingo").value;
  horarioExtra = document.getElementById("horario_extra").value;
  valorMensajero = document.getElementById("valor_mensajero").value;
  valorMensajeroEdit = document.getElementById("valor_mensajero_edit").value;

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

  total =
    subtotal +
    parseFloat(transporte) +
    parseFloat(cargoDomingo) +
    parseFloat(horarioExtra) -
    descuento;
  //console.log(total);

  //Hago el cálculo del mensajero
  calcularMensajero();

  impTotal.value = total.toFixed(2);
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
