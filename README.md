<h1>Versión: 1.2.1</h1>
<h3>Cambios</h3>
<ul>
    
</ul>

<h5>Fixes</h5>
<ul>
    <li>Se ha corregido un error en el cual al cerrar la sesión se quedaban datos de la sesión aterior y si era otro usuarios se le asignaban pedidos al usuario anterior</li>
    <li>Se ha quitado la llamada a la función que trae los pedidos desde la vista de Grid de pedidos, ahora viene desde el controlador</li>
    <li>Se ha corregido un error en la funcionalidad que pone el grid de pedidos en una ventana nueva, la función que trae los pedidos desde el modelo pedía el id roles para segmentar la catidad de pedidos que trae</li>
    <li>Se ha  corregido un error en pedido update, no se estaba enviando el valor de registered_by desde el controlador al modelo, al actualizar el pedido no es necesario actualizar el registered_by</li>
</ul>