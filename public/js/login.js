window.addEventListener('load', function() {
    // milisegundos que espera el navegador antes de cerrar la pagina
    
    // var x = 3000;
    // var a = (new Date()).getTime() + x;
    //console.log("Se ha iniciado la app");

    // -----------
    // Llamadas asincronas o AJAX aqui, diciendole 
    // al servidor que la ventana del cliente se va a cerrar
    // -----------

    // Aqui el navegador va a esperar el valor de X milisegundos dandole 
    // tiempo a la consulta asincrona a ser enviada. 
    // Si ese tiempo no se usa, el navegador cierra la
    // ventana desechando la llamada asincrona
    // while ((new Date()).getTime() < a) {}
}, false)

let verPassword = document.getElementById("verPassword")
let password = document.getElementById("password")

verPassword.addEventListener('click', function(e) {
    if (password.type == "password") {
        password.type = "text"
    } else {
        password.type = "password"
    }
})