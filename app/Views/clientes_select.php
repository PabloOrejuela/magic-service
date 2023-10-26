
<?php 
  $this->session = \Config\Services::session();
  foreach($clientes as $data) {
    if (count($clientes) == 1) {

      echo '<script>
        document.getElementById("nombre").value = "'.$data->nombre.'"
        document.getElementById("telefono").value = "'.$data->telefono.'"
        document.getElementById("idcliente").value = "'.$data->id.'"
      </script>';
      
      
    } 
  }
?>
