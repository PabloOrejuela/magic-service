<h3>Cambios</h3>
<ul>
    <li></li>
    <li>El campo de valor neto se lo hizo solo de lectura y con fondo color celeste bajito</li>
    <li>Se quitó los controles de rango para los campos entrega desde y hasta, además se eliminó la funcionalidad de estos controles</li>
    <li>Lis inputs desde y hasta ahora son alfanuméricos</li>
    <li>Se eliminó las variables del sistema que ya no se utilizaban, el cambio también se hizo a nivel de DB</li>
    <li>Se eliminó la función que insertaba el detalle temporal del pedido y en lugar se usa la función insert del modelo</li>
    <li>Se implementó en todas las funciones de actualización del modelo de detalle temporal el que actualice el updated at</li>
</ul>

</br>

<h3>Correcciones:</h3>

<h5>Formulario nuevo pedido</h5>
<ul>
    <li>se corrigió la recarga del grid de pedidos, estaba cada 20 segundos, ahora está cada 2 minutos</li>
</ul>