const btnAgregar = document.getElementById('btn-agregar')
const btnEliminar = document.getElementById('btn-eliminar')
const tbSectores = document.getElementById('tb-sectores')

btnAgregar.addEventListener('click', function(e) {
    e.preventDefault() // Prevent the default form submission

    let idSucursal= document.getElementById('idsucursal')
    let idSector= document.getElementById('sector')

    if (idSector.value === '') {
        alertaMensaje('Debe seleccionar un sector', 3000, 'warning')
        return
    }else {
        //Petición AJAX
        fetch('../asignaSectorSucursal?idsucursal='+idSucursal.value+'&idsector='+idSector.selectedIndex, {
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
            //Recargo la tabla de sectores

            tbSectores.innerHTML = ''
            //tbSectores.className = 'table table-striped table-bordered table-hover table-sm'

            data.tabla.forEach(element => {
                let row = document.createElement('tr')
                row.innerHTML = `
                    <td>${element.id}</td>
                    <td>${element.sector}</td>
                    <td><button onclick="eliminarSector(${element.id})" type="button" class="btn btn-danger" id="btn-eliminar" data-id="${element.id}">Quitar</button></td>
                `
                tbSectores.appendChild(row)
            });
            alertaMensaje('El sector se ha asignado correctamente', 2000, 'success');
        })
        .catch(error => {
            alertaMensaje('El sector no se ha asignado', 2000, 'error');
            console.error(error);
        });
        alertaMensaje('Sector agregado exitosamente', 2000, 'success')
    }
    
})

btnEliminar.addEventListener('click', function(e) {
    e.preventDefault() // Prevent the default form submission

    let idSucursal= document.getElementById('idsucursal')
    let idSector = this.dataset.id;
    
    if (idSector.value === '') {
        alertaMensaje('Debe seleccionar un sector', 3000, 'warning')
        return
    }else {
        //Petición AJAX
        fetch('../eliminarSectorSucursal?idsucursal='+idSucursal.value+'&idsector='+idSector, {
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
            //Recargo la tabla de sectores

            tbSectores.innerHTML = ''
            //tbSectores.className = 'table table-striped table-bordered table-hover table-sm'

            data.tabla.forEach(element => {
                let row = document.createElement('tr')
                row.innerHTML = `
                    <td>${element.id}</td>
                    <td>${element.sector}</td>
                    <td><button onclick="eliminarSector(${element.id})" type="button" class="btn btn-danger" id="btn-eliminar" data-id="${element.id}">Quitar</button></td>
                `
                tbSectores.appendChild(row)
            });
            alertaMensaje('El sector se ha asignado correctamente', 2000, 'success');
        })
        .catch(error => {
            alertaMensaje('El sector no se ha asignado', 2000, 'error');
            console.error(error);
        });
        alertaMensaje('Sector agregado exitosamente', 2000, 'success')
    }

})


const eliminarSector = (idSector) => {

    let idSucursal= document.getElementById('idsucursal')
    
    if (idSector.value === '') {
        alertaMensaje('Debe seleccionar un sector', 3000, 'warning')
        return
    }else {
        //Petición AJAX
        fetch('../eliminarSectorSucursal?idsucursal='+idSucursal.value+'&idsector='+idSector, {
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
            //Recargo la tabla de sectores

            tbSectores.innerHTML = ''
            //tbSectores.className = 'table table-striped table-bordered table-hover table-sm'

            data.tabla.forEach(element => {
                let row = document.createElement('tr')
                row.innerHTML = `
                    <td>${element.id}</td>
                    <td>${element.sector}</td>
                    <td><button onclick="eliminarSector(${element.id})" type="button" class="btn btn-danger" id="btn-eliminar" data-id="${element.id}">Quitar</button></td>
                `
                tbSectores.appendChild(row)
            });
            alertaMensaje('El sector se ha asignado correctamente', 2000, 'success');
        })
        .catch(error => {
            alertaMensaje('El sector no se ha asignado', 2000, 'error');
            console.error(error);
        });
        alertaMensaje('Sector agregado exitosamente', 2000, 'success')
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