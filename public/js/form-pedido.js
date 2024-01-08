$(document).ready(function(){
  $("#telefono").on('change',function(){
      if($("#telefono").val() !=""){

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
                // limpiarClienteDocumento();
                let cliente = JSON.parse(data);

                if (cliente) {
                  //console.log(data);
                  document.getElementById('nombre').value = cliente.nombre
                  document.getElementById('telefono').value = cliente.telefono
                  document.getElementById('telefono_2').value = cliente.telefono_2
                  document.getElementById('documento').value = cliente.documento
                  document.getElementById('email').value = cliente.email
                  document.getElementById('idcliente').value = cliente.id
                }else {
                  console.log('No hay, debo buscar en el 1 también');
                  searchPhones(valor, 2)
                }
              },
              error: function(data){
                console.log("No hay");
              }
          });
      }
  });
});

function searchPhones(valor, phone) {
    if (phone == 1) {
      $.ajax({
        type:"POST",
        dataType:"html",
        url: "ventas/clientes_select_telefono",
        data:"telefono="+valor,
        beforeSend: function (f) {
            $('#cliente').html('Buscando ...');
        },
        success: function(data){
          let cliente = JSON.parse(data);
          //console.log(cliente);
          if (cliente) {
            
            document.getElementById('nombre').value = cliente.nombre
            document.getElementById('telefono').value = cliente.telefono
            document.getElementById('telefono_2').value = cliente.telefono_2
            document.getElementById('documento').value = cliente.documento
            document.getElementById('email').value = cliente.email
            document.getElementById('idcliente').value = cliente.id
          } 
          
        },
        error: function(data){
          console.log("No hay");
        }
      });
    } else {
      $.ajax({
        type:"POST",
        dataType:"html",
        url: "ventas/clientes_select_telefono_2",
        data:"telefono="+valor,
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
          let cliente = JSON.parse(data);
          //console.log(cliente);
          if (cliente) {
            
            document.getElementById('nombre').value = cliente.nombre
            document.getElementById('telefono').value = cliente.telefono
            document.getElementById('telefono_2').value = cliente.telefono_2
            document.getElementById('documento').value = cliente.documento
            document.getElementById('email').value = cliente.email
            document.getElementById('idcliente').value = cliente.id
          } 
          
          
        },
        error: function(data){
          console.log("No hay");
        }
    });
    }
}

$(document).ready(function(){
  $("#telefono_2").on('change',function(){
      if($("#telefono_2").val() !=""){

          valor = $("#telefono_2").val();
          $.ajax({
              type:"POST",
              dataType:"html",
              url: "ventas/clientes_select_telefono_2",
              data:"telefono="+valor,
              beforeSend: function (f) {
                  //$('#cliente').html('Cargando ...');
              },
              success: function(data){
                let cliente = JSON.parse(data);
                //console.log(cliente);
                if (cliente) {
                  
                  document.getElementById('nombre').value = cliente.nombre
                  document.getElementById('telefono').value = cliente.telefono
                  document.getElementById('telefono_2').value = cliente.telefono_2
                  document.getElementById('documento').value = cliente.documento
                  document.getElementById('email').value = cliente.email
                  document.getElementById('idcliente').value = cliente.id
                } else {
                  //console.log('No hay, debo buscar en el 1 también');
                  searchPhones(valor, 1)
                }
                
                
              },
              error: function(data){
                console.log("No hay");
              }
          });
      }
  });
});

$(document).ready(function(){
  $("#documento").on('change',function(){
      if($("#documento").val() !=""){
          
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
                //console.log(data);
                document.getElementById('nombre').value = cliente.nombre
                document.getElementById('telefono').value = cliente.telefono
                document.getElementById('documento').value = cliente.documento
                document.getElementById('email').value = cliente.email
                document.getElementById('idcliente').value = cliente.id
              },
              error: function(data){
                console.log("No existe el cliente");
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
