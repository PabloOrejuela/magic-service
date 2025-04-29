
<?php 
  //foreach($producto as $data) { PIENSO QUE ESTE ARCHIVO NO SE ESTÁ USANDO Y DEBERÍA SER BORRADO
      echo '<script>
        document.getElementById("valor_neto").value = "'.$producto->precio.'"
        document.getElementById("total").value = "'.$producto->precio.'"
        document.getElementById("descuento").value = "0"
        document.getElementById("transporte").value = "0.00"

        var elemento = document.getElementById("link-edita-producto")
        elemento.innerHTML = "Editar y Borrar: '.$producto->producto.'";
        elemento.href = "'.site_url().'product-edit/'.$producto->id.'"
      </script>';
    
  //}PIENSO QUE ESTE ARCHIVO NO SE ESTÁ USANDO Y DEBERÍA SER BORRADO
      // echo '<script>
      //   document.getElementById("valor_neto").value = "'.$producto->precio.'"
      // </script>';

?>
