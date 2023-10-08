
<?php 
  foreach($clientes as $data) {

      echo '<script>
        document.getElementById("valor_neto").value = "'.$data->nombre.'"
      </script>';
      
  }
?>
