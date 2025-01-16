<h3>Cambios</h3>
<ul>
    <li>Se eliminó la función "logout" que tenían todos los controladores, ahora siempre se llama a la función logout del controlador "home"</li>
    <li>La función logout del controlador home ahora verifica si aún existe la sesión antes de actualizarla, en caso de que ya haya expirado solo destruye y sale del sistema</li>
    <li>Se hizo un cambio en los modelos que traen los items, ahora los traen en órden alfabético</li>
</ul>

<h5>Fixes</h5>
<ul>

</ul> 