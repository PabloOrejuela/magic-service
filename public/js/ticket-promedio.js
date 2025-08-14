let btnGenerarReporte = document.getElementById('btnGenerarReporte')
let divResult = document.getElementById('result')
let negocio= document.getElementById('negocio')
let mes= document.getElementById('mes')

btnGenerarReporte.addEventListener('click', (e) => {
    let fecha = mes.value
    divResult.innerHTML = ''

    if (negocio.value == "0") {
        alertaMensaje('Debe seleccionar un negocio', 2000, 'warning');
        return;
    }
    //Petición AJAX
    fetch('est_ticket_promedio?mes='+fecha+'&negocio='+negocio.value, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la respuesta del servidor');
        }
        return response.json()
        
    })
    .then(data => {
        //Hago uso de los valores devueltos por la petición
        let cantidadPedidos = data.cantidad
        let sumaIngreso = data.sumaIngreso
        let ticketPromedio = 0

        try {
            if (cantidadPedidos == 0) {
                throw new Error('No hay pedidos en el periodo seleccionado')
                //alertaMensaje('No hay pedidos en este mes', 2000, 'error');
            }
            ticketPromedio = sumaIngreso / cantidadPedidos;

            //Recargo el div de resultados
            let negocio = ''
            if (data.negocio == 1) {
                negocio = 'Magic service'
            } else if(data.negocio == 2) {
                negocio = 'Karana'
            }else{
                negocio = "Seleccione un negocio"
            }

            // Actualiza el campo "mes" al mes actual
            const hoy = new Date();
            const mesActual = hoy.toISOString().slice(0, 7); // formato 'YYYY-MM'
            mes.value = mesActual;

            
            divResult.innerHTML = '<div class="row"><div class="col-md-6"><h5>Ticket promedio de venta <strong>'
                                +negocio+'</strong> en el mes de <strong>'+fecha+':</strong></h5></div><div class="col-md-1"> $'+ticketPromedio.toFixed(2)+'</div></div>'
            
            alertaMensaje('Reporte generado exitosamente', 2000, 'success');

        } catch (error) {
            ticketPromedio = 0;
            alertaMensaje(error.message, 2000, 'warning');
        }
    })
    .catch(error => {
        alertaMensaje('El reporte no se ha podido generar', 2000, 'error');
        console.error(error);
    });
    alertaMensaje('Reporte generado exitosamente', 2000, 'success')

})
