/*
 *  Evita que se pueda ingresar letras y símbolos en el porcentaje 
 *  Describo la funcionalidad en caso de que en un futuro haya que darle mantenimiento a la función
*/
function validarInput2(id){
    // let inputNumber = document.querySelector('.number')
    let inputPorcentaje = document.getElementById('porcentaje_'+id)
    let inputValue = inputPorcentaje.value
    let cadena = inputValue.split("");

    // Variables para contar los puntos
    let puntoCount = 0;

    let numeros = cadena.filter(function(caracter) {
        if (caracter === '.') {
            // Si encontramos un punto, incrementamos el contador
            puntoCount++;
            // Solo permitimos el punto si no hemos encontrado otro antes
            return puntoCount <= 1;
        } else {
            // Permitimos números
            return !isNaN(caracter);
        }
    });

    // Devolvemos el nuevo array con solo los números
    inputPorcentaje.value = numeros.join("");
}


function validarInputPvp(id){
    // let inputNumber = document.querySelector('.number')
    let inputPvp = document.getElementById('pvp_'+id)
    let inputValue = inputPvp.value

    let cadena = inputValue.split("");

    // Variables para contar los puntos
    let puntoCount = 0;

    let numeros = cadena.filter(function(caracter) {
        if (caracter === '.') {
            // Si encontramos un punto, incrementamos el contador
            puntoCount++;
            // Solo permitimos el punto si no hemos encontrado otro antes
            return puntoCount <= 1;
        } else {
            // Permitimos números
            return !isNaN(caracter);
        }
    });

    // Devolvemos el nuevo array con solo los números
    inputPvp.value = numeros.join("");
}