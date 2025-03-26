let selectSugest = document.getElementById('sugest')
let fechaInicio = document.getElementById('fecha_inicio')
let fechaFinal = document.getElementById('fecha_final')
let fecha = new Date();

const meses = new Array ("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
const diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

const cadenafecha = fecha.getFullYear() + '-' + ((fecha.getMonth()+1) > 9 ? (fecha.getMonth()+1) : '0'+(fecha.getMonth()+1))



/*
 *  Detecta el index y modifica las fechas
*/
selectSugest.addEventListener('change', function(e) {

    if (selectSugest.selectedIndex == 1) {

        //día actual
        fechaInicio.value = cadenafecha + '-' +(parseInt(fecha.getDate()) > 9 ? parseInt(fecha.getDate()) : '0'+parseInt(fecha.getDate()))
        fechaFinal.value = cadenafecha + '-' +(parseInt(fecha.getDate()) > 9 ? parseInt(fecha.getDate()) : '0'+parseInt(fecha.getDate()))

    }else if(selectSugest.selectedIndex == 2){

        //Mes actual
        fechaInicio.value = cadenafecha + '-01'
        fechaFinal.value = cadenafecha + '-' +(parseInt(fecha.getDate()) > 9 ? parseInt(fecha.getDate()) : '0'+parseInt(fecha.getDate()))
    }else if(selectSugest.selectedIndex == 3){

        let inicioSemana = 0 
        let finSemana = 0

        if (fecha.getDay() == 1) {
            inicioSemana = fecha.getDate()
        }else{
            inicioSemana = (fecha.getDate() - (fecha.getDay() - 1))
        }

        if (fecha.getDay() == 1) {
            finSemana = fecha.getDate() + 6
        }else{
            finSemana = (fecha.getDate() + (fecha.getDay() + 1))
        }

        //Semana actual
        fechaInicio.value = cadenafecha + '-' + inicioSemana.toString()
        fechaFinal.value = cadenafecha + '-' + finSemana.toString()

    }


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


