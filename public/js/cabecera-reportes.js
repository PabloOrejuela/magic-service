let selectSugest = document.getElementById('sugest')
let fechaInicio = document.getElementById('fecha_inicio')
let fechaFinal = document.getElementById('fecha_final')
let btnReporteProcedenciaExcel = document.getElementById('btnGeneraReporteExcel')
let fecha = new Date();


const meses = new Array ("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
const diasAnio = {
    "1" : 31, 
    "2" : 28, 
    "3" : 31, 
    "4" : 30, 
    "5" : 31, 
    "6" : 30, 
    "7": 31, 
    "8" : 31, 
    "9" : 30, 
    "10" : 31, 
    "11": 30, 
    "12" : 31
}
const diasSemana = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
let mesActual = fecha.getMonth()+1
let anioActual = fecha.getFullYear()

let cadenafecha = anioActual + '-' + (mesActual > 9 ? mesActual : '0'+mesActual)

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

        let diaActual = fecha.getDate()
        let diaSemana = fecha.getDay()
        let diasMes = daysInMonth(anioActual, mesActual)
            
        //Semana actual
        if (fecha.getDay() == 1) {
            inicioSemana = fecha.getDate()
            finSemana = fecha.getDate() + 6

            fechaInicio.value = cadenafecha + '-' + (inicioSemana > 9 ? inicioSemana : '0'+inicioSemana)
            
            if (finSemana >= diasMes) {
                
                cadenafecha = anioActual + '-' + ((mesActual+1) > 9 ? (mesActual+1) : '0'+(mesActual+1))
                fechaFinal.value = cadenafecha + '-0' + parseInt(finSemana-diasMes)
            }else{
                fechaFinal.value = cadenafecha + '-' + (finSemana > 9 ? finSemana : '0'+parseInt(finSemana))
            }
            
        }else{
            
            if (diaActual < 7) {
                inicioSemana = (diaActual - (diaSemana - 1))
                cadenafechaInicio = anioActual + '-' + (mesActual-1 > 9 ? mesActual-1 : '0'+(parseInt(mesActual)-1))

                for (let i = 0; i <= 6; i++) {
                    if (inicioSemana == i) {
                        inicioSemana = diasAnio[mesActual-1] - i
                        finSemana = (fecha.getDate() + (7 - fecha.getDay()))
    
                        fechaInicio.value = cadenafechaInicio + '-' + (inicioSemana > 9 ? inicioSemana : '0'+inicioSemana)

                        if (finSemana >= diasMes) {
                
                            cadenafecha = anioActual + '-' + ((mesActual+1) > 9 ? (mesActual+1) : '0'+(mesActual+1))
                            fechaFinal.value = cadenafecha + '-0' + parseInt(finSemana-diasMes)
                        }else{
                            fechaFinal.value = cadenafecha + '-' + (finSemana > 9 ? finSemana : '0'+parseInt(finSemana))
                        }
                    }
                }
            }else{
                inicioSemana = getInicioSemana(diaSemana, diaActual)
                cadenafechaInicio = anioActual + '-' + (mesActual > 9 ? mesActual : '0'+(parseInt(mesActual)))
                console.log(inicioSemana);

                fechaInicio.value = cadenafechaInicio + '-' + (inicioSemana > 9 ? inicioSemana : '0'+inicioSemana)
                if (finSemana >= diasMes) {
                
                    cadenafecha = anioActual + '-' + ((mesActual+1) > 9 ? (mesActual+1) : '0'+(mesActual+1))
                    fechaFinal.value = cadenafecha + '-0' + parseInt(finSemana-diasMes)
                }else{
                    fechaFinal.value = cadenafecha + '-' + (finSemana > 9 ? finSemana : '0'+parseInt(finSemana))
                }
            }
        }
    }

})

const daysInMonth = (year, month) => new Date(year, month, 0).getDate();

const getInicioSemana = (diaSemana, diaActual) => {
    
    if (diaSemana == 1) {
        
        return diaActual
    }else if(diaSemana == 2){
        
        return diaActual - 1
    }else if(diaSemana == 3){
        
        return diaActual - 2
    }else if(diaSemana == 4){
        
        return (parseInt(diaActual) - 3)
    }else if(diaSemana == 5){
        
        return diaActual - 4
    }else if(diaSemana == 6){
        
        return diaActual - 5
    }else if(diaSemana == 7){
        
        return diaActual - 6
    }
}

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


