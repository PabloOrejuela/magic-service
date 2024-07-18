let imptEmail = document.getElementById("email")

imptEmail.addEventListener('input', function(e){
    e.stopPropagation()
    let email = imptEmail.value
    imptEmail.value = email.toLowerCase()
    
})

$(document).ready(function(){
    $("#telefono").on("change", function() {
        let string = $("#telefono").val();
        
        $("#telefono").val(string.replace(/[^\w]/gi, ''));
    });
});

$(document).ready(function(){
    $("#telefono_2").on("change", function() {
        let string = $("#telefono_2").val();
       
        $("#telefono_2").val(string.replace(/[^\w]/gi, ''));
    });
});