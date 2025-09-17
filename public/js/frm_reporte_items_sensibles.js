let btnGeneraReporteItemsSensibles = document.getElementById('btnGeneraReporteItemsSensibles')
let dpFechaInicio = document.getElementById('fecha_inicio')
let dpFechaFinal = document.getElementById('fecha_final')

btnGeneraReporteItemsSensibles.addEventListener('click', function(e) {
    
    let dpFechaInicio = document.getElementById('fecha_inicio').value
    let dpFechaFinal = document.getElementById('fecha_final').value
    let fecha = new Date();
    
    let fechaActual = fecha.getFullYear() + '-' + ((fecha.getMonth()+1) > 9 ? (fecha.getMonth()+1) : '0'+(fecha.getMonth()+1)) + '-' + (fecha.getDate() > 9 ? fecha.getDate() : '0'+fecha.getDate());
    let fechaInicio = fecha.getFullYear() + '-' + ((fecha.getMonth()+1) > 9 ? (fecha.getMonth()+1) : '0'+(fecha.getMonth()+1)) + '-0' + (parseInt(fecha.getDate()) - parseInt(fecha.getDate())+1)

    if (dpFechaInicio == '') {
        inicio = fechaInicio
        
    }else{
        inicio = dpFechaInicio
    }

    if (dpFechaFinal == '') {
        final = fechaActual
        
    }else{
        final = dpFechaFinal
    }

    $.ajax({
        method:"GET",
        //dataType:"html",
        url: "getCantidadItemsSensibles",
        data: {
            fechaInicio: inicio,
            fechaFinal: final
        },
        beforeSend: function (f) {
            //$('#cliente').html('Cargando ...');
        },
        success: function(data){
            let datos = JSON.parse(data);
            document.getElementById('fecha_inicio').value = inicio
            document.getElementById('fecha_final').value = final

            //Preparo la tabla para agregar los datos
            let tablaItemsSensiblesBody = document.getElementById('tablaItemsSensiblesBody')        
            tablaItemsSensiblesBody.innerHTML = ''
            
            if (datos.error != '') {

            }
            let idproducto = 0
            let unidades = 0

            const arrayItemsSinDuplicados = datos.resultado.reduce((acumulador, valorActual) => {
                const elementoYaExiste = acumulador.find(elemento => elemento.item === valorActual.item);
                if (elementoYaExiste) {
                  return acumulador.map((elemento) => {
                    if (elemento.item === valorActual.item) {
                      return {
                        ...elemento,
                        unidades: (parseFloat(elemento.cantidad)*parseFloat(elemento.porcentaje)) + (parseFloat(valorActual.cantidad)*parseFloat(valorActual.porcentaje)) 
                      }
                    }
              
                    return elemento;
                  });
                }
              
                return [...acumulador, valorActual];
              }, []);


            arrayItemsSinDuplicados.forEach(function(dato) {

                if(typeof dato.unidades === 'undefined'){
                    unidades = parseFloat(dato.cantidad) * parseFloat(dato.porcentaje)
                }else{
                    unidades = parseFloat(dato.unidades)
                }

                tablaItemsSensiblesBody.innerHTML += `<tr>
                    <td>${dato.item}</td>
                    <td>${dato.nombreItem}</td>
                    <td>${unidades}</td>`
                tablaItemsSensiblesBody.innerHTML += `</tr>`
            });
        }
            
    });
})

const alertaMensaje = (msg, time, icon) => {
    const toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: time,
        //timerProgressBar: true,
        //height: '200rem',
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
        customClass: {
            // container: '...',
            popup: 'popup-class',
        }
    });
    toast.fire({
        position: "top-end",
        icon: icon,
        title: msg,
    });
}


