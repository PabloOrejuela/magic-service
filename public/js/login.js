let verPassword = document.getElementById("verPassword")
let password = document.getElementById("password")

verPassword.addEventListener('click', function(e) {
    if (password.type == "password") {
        password.type = "text"
    } else {
        password.type = "password"
    }
})


document.addEventListener('DOMContentLoaded', () => {
    //Si uso diferentes clases puedo tener diferentes tipo de mensajes
    const alertas = document.querySelectorAll('.alert');
    alertas.forEach(alerta => {
        // --- Efecto de entrada (fade-in) ---
        alerta.style.opacity = '0';
        alerta.style.transition = 'opacity 0.8s ease';
        setTimeout(() => {
            alerta.style.opacity = '1';
        }, 50); 

        // --- Efecto de salida (fade-out) ---
        setTimeout(() => {
            alerta.style.opacity = '0';
            setTimeout(() => alerta.remove(), 800);
        }, 4000); // visible 4 segundos antes de desvanecerse
    });
});