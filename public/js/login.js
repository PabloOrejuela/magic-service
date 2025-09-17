let verPassword = document.getElementById("verPassword")
let password = document.getElementById("password")

verPassword.addEventListener('click', function(e) {
    if (password.type == "password") {
        password.type = "text"
    } else {
        password.type = "password"
    }
})