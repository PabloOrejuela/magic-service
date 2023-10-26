
<?php 
  //foreach($producto as $data) {
      echo '<script>
        valorNeto = document.getElementById("valor_neto").value
        descuento = document.getElementById("descuento").value 
        transporte = '.$sector->costo_entrega.'
        total = document.getElementById("total").value 

        total = parseFloat(valorNeto) + parseFloat(transporte) - parseFloat((valorNeto*descuento)/100)

        document.getElementById("transporte").value = "'.$sector->costo_entrega.'"

        document.getElementById("total").value = total.toFixed(2)

      </script>';
    
      /*document.getElementById("total").value = "'.$producto->precio.'"
        document.getElementById("descuento").value = "0"
        document.getElementById("transporte").value = "0.00"*/

?>
