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


const daysInMonth = (year, month) => new Date(year, month, 0).getDate();

const getInicioSemana = (diaSemana, diaActual) => {
    
    if (diaSemana == 1) {
        //lunes
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
    }else if(diaSemana == 0){
        
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


