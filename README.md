<h3>Cambios</h3>
<ul>
    <li>Se eliminó las variables del sistema que ya no se utilizaban, el cambio también se hizo a nivel de DB</li>
    <li>Se eliminó la función que insertaba el detalle temporal del pedido y en lugar se usa la función insert del modelo</li>
    <li>Se implementó en todas las funciones de actualización del modelo de detalle temporal el que actualice el updated at</li>
</ul>

</br>

<h3>Correcciones:</h3>

<h5>Formulario nuevo pedido</h5>
<ul>
    <li>Corregido un error, el modelo no dejaba insertare en el campo pvp y por eso siempre el pvp era 0</li>
    <li>Corregidas un error en el cotizador que no borraba la imagen cuando se le ponía borrar </li>
</ul>