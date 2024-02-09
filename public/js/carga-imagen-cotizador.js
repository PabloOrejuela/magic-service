const file = document.getElementById("formFileImg")
const img = document.getElementById("image-product")
const defaultFile = 'public/images/default-img.png'

file.addEventListener("change", e => {
    if (e.target.files[0]) {

        const reader = new FileReader()

        reader.onload = function(e) {
            img.src = e.target.result
        }

        reader.readAsDataURL(e.target.files[0])
        
    }else{
        img.src = defaultFile
    }
})