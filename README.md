<h3>Cambios</h3>
<ul>
    <li>Se modificó el form pedido para que en caso de que se haya editado el valor del mensajero y luego se modifique descuento, valor del producto, sector, etc siempre se siga manteniendo el valor mostrado del mensajero en 0 y se muestre el valor editado</li>
    <li>Se implementó el check NO ASIGNAR SEGUNDO ROL, para poder quitar un segundo rol previamente asignado</li>
    <li>El grid de usuarios ahora se refresca mas rápido luego de un cambio</li>
    <li>Los usuarios inactivos ya se filtran y no pueden loguearse ni se muestran en los select de vendedores</li>
</ul>

<h5>Fixes</h5>
<ul>
    <li>Ahora cambia el nombre del archivo de imagen de cada producto, además borra la imagen anterior del servidor antes de guardar la nueva</li>
    <li>Se corrigió un error, al ingresar o cambiar info del ticket se llamaba a la función que cierra el form y refresca el grid y esto no permitía que se pueda seguir ingresando información</li>
    <li>En el modal de hora de salida de pedidos no se mostraba el dato que ya se había guardado, solo salía un campo vacío</li>
</ul>