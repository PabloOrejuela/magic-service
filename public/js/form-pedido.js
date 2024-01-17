



function limpiarClienteTelefono() {
  document.getElementById('nombre').value = ''
  document.getElementById('documento').value = ''
  document.getElementById('email').value = ''
  document.getElementById('idcliente').value = ''
  document.getElementById('telefono_2').value = ''
}

function limpiarClienteDocumento() {
  document.getElementById('nombre').value = ''
  document.getElementById('telefono').value = ''
  document.getElementById('email').value = ''
  document.getElementById('idcliente').value = ''
  document.getElementById('telefono_2').value = ''
}

function limpiaCamposCliente(){
  document.getElementById('nombre').value = ''
  document.getElementById('documento').value = ''
  document.getElementById('telefono').value = ''
  document.getElementById('email').value = ''
  document.getElementById('idcliente').value = ''
  document.getElementById('telefono_2').value = ''
}

const confirmSaveAlert = () => {
  Swal.fire({
    position: "center",
    icon: "success",
    title: "El pedido ha sido guardado",
    showConfirmButton: false,
    timer: 1500
  });
}

const alertCambio = () => {
  Swal.fire({
    position: "center",
    icon: "success",
    title: "El cambio se ha realizado",
    showConfirmButton: false,
    timer: 500
  });
}
