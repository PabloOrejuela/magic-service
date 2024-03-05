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

  total = subtotal + parseFloat(transporte) + parseFloat(cargoDomingo) + parseFloat(horarioExtra) - descuento;
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
