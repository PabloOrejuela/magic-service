let imptEmail = document.getElementById("email")

imptEmail.addEventListener('input', function(e){
    e.stopPropagation()
    let email = imptEmail.value
    imptEmail.value = email.toLowerCase()
    
})