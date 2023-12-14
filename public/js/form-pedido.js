$(document).ready(function(){
  $("#telefono").on('change',function(){
      if($("#telefono").val() !=""){
          limpiarClienteTelefono();
          valor = $("#telefono").val();
          $.ajax({
              type:"POST",
              dataType:"html",
              url: "ventas/clientes_select_telefono",
              data:"telefono="+valor,
              beforeSend: function (f) {
                  //$('#cliente').html('Cargando ...');
              },
              success: function(data){
                  let cliente = JSON.parse(data);
                  //console.log(data);
                  document.getElementById('nombre').value = cliente.nombre
                  document.getElementById('telefono').value = cliente.telefono
                  document.getElementById('documento').value = cliente.documento
                  document.getElementById('email').value = cliente.email
                  document.getElementById('idcliente').value = cliente.id
              }
          });
      }
  });
});

$(document).ready(function(){
  $("#documento").on('change',function(){
      if($("#documento").val() !=""){
          limpiarClienteDocumento();
          valor = $("#documento").val();
          $.ajax({
              type:"POST",
              dataType:"html",
              url: "ventas/clientes_select",
              data:"documento="+valor,
              beforeSend: function (f) {
                  //$('#cliente').html('Cargando ...');
              },
              success: function(data){
                  let cliente = JSON.parse(data);
                  console.log(data);
                  document.getElementById('nombre').value = cliente.nombre
                  document.getElementById('telefono').value = cliente.telefono
                  document.getElementById('documento').value = cliente.documento
                  document.getElementById('email').value = cliente.email
                  document.getElementById('idcliente').value = cliente.id
              }
          });
      }
  });
});

function limpiarClienteTelefono() {
  document.getElementById('nombre').value = ''
  document.getElementById('documento').value = ''
  document.getElementById('email').value = ''
  document.getElementById('idcliente').value = ''
}

function limpiarClienteDocumento() {
  document.getElementById('nombre').value = ''
  document.getElementById('telefono').value = ''
  document.getElementById('email').value = ''
  document.getElementById('idcliente').value = ''
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
