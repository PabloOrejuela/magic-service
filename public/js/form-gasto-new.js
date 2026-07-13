let selectTipoGasto = document.getElementById('tipo')
let divProveedores = document.getElementById('div-proveedores')
let divGastoVariable = document.getElementById('div-gastovariable')
let divGastoFijo = document.getElementById('div-gastofijo')
let selectNegocio = document.getElementById('negocio')
let selectProveedores = document.getElementById('proveedor')
let selectSucursal = document.getElementById('sucursal')

const resetSelect = (select, placeholder) => {
    select.innerHTML = '';
    select.appendChild(new Option(placeholder, '0'));
    select.disabled = true;
}

const populateSelect = (select, items, valueKey, labelKey, placeholder) => {
    select.innerHTML = '';
    select.appendChild(new Option(placeholder, '0'));

    items.forEach(item => {
        select.appendChild(new Option(item[labelKey], item[valueKey]));
    });

    select.disabled = false;
}

const loadSucursales = (idNegocio, selectedSucursal = '0') => {
    if (idNegocio !== '0') {
        return fetchJson('getSucursalesByNegocio', 'POST', { idNegocio })
            .then(data => {
                populateSelect(selectSucursal, data, 'id', 'sucursal', '--Seleccionar sucursal--');
                if (selectedSucursal && selectedSucursal !== '0') {
                    selectSucursal.value = selectedSucursal;
                }
                alertaMensaje('Sucursales cargadas correctamente', 3000, 'success');
            })
            .catch(() => {
                resetSelect(selectSucursal, '--Seleccionar sucursal--');
                alertaMensaje('Error al cargar sucursales', 3000, 'error');
            });
    }

    resetSelect(selectSucursal, '--Seleccionar sucursal--');
    return Promise.resolve();
}

const loadProveedores = (idNegocio) => {
    if (idNegocio !== '0') {
        return fetchJson('./getProveedoresByNegocioGastos', 'GET', { idNegocio })
            .then(data => {
                populateSelect(selectProveedores, data, 'id', 'nombre', '--Seleccionar Proveedor--');
                alertaMensaje('Proveedores cargados correctamente', 3000, 'success');
            })
            .catch(() => {
                resetSelect(selectProveedores, '--Seleccionar Proveedor--');
                alertaMensaje('Error al cargar proveedores', 3000, 'error');
            });
    }

    resetSelect(selectProveedores, '--Seleccionar Proveedor--');
    return Promise.resolve();
}

const fetchJson = (url, method, data) => {
    const options = {
        method,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    };

    if (method === 'POST') {
        options.headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';
        options.body = new URLSearchParams(data);
    } else if (method === 'GET' && data) {
        url += `?${new URLSearchParams(data)}`;
    }

    return fetch(url, options).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    });
}

selectTipoGasto.addEventListener('change', function() {
    if (selectTipoGasto.selectedIndex !== 0) {
        if (selectTipoGasto.selectedIndex == 3) {
            divProveedores.style.display = 'block'
            divGastoVariable.style.display = 'none'
            divGastoFijo.style.display = 'none'

            const idNegocio = selectNegocio.value;

            if (idNegocio !== '0') {
                fetchJson('./getProveedoresByNegocioGastos', 'GET', { idNegocio })
                    .then(data => {
                        populateSelect(selectProveedores, data, 'id', 'nombre', '--Seleccionar Proveedor--');
                        alertaMensaje('Proveedores cargados correctamente', 3000, 'success');
                    })
                    .catch(() => {
                        alertaMensaje('Error al cargar proveedores', 3000, 'error');
                    });
            } else {
                resetSelect(selectProveedores, '--Seleccionar Proveedor--');
            }
        } else if (selectTipoGasto.selectedIndex == 2) {
            divProveedores.style.display = 'none'
            divGastoFijo.style.display = 'none'
            divGastoVariable.style.display = 'block'
        } else if (selectTipoGasto.selectedIndex == 1) {
            divProveedores.style.display = 'none'
            divGastoVariable.style.display = 'none'
            divGastoFijo.style.display = 'block'
        }
    } else {
        divProveedores.style.display = 'none'
        divGastoVariable.style.display = 'none'
        divGastoFijo.style.display = 'none'
    }
})

// AJAX para cargar SUCURSALES por negocio
document.addEventListener('DOMContentLoaded', function() {
    const negocioSelect = document.getElementById('negocio');
    const sucursalSelect = document.getElementById('sucursal');

    if (!negocioSelect || !sucursalSelect) {
        return;
    }

    const resetSucursal = () => {
        resetSelect(sucursalSelect, '--Seleccionar sucursal--');
    }

    negocioSelect.addEventListener('change', function() {
        const idNegocio = negocioSelect.value;

            if (idNegocio !== '0') {
            fetchJson('getSucursalesByNegocio', 'POST', { idNegocio })
                .then(data => {
                    populateSelect(sucursalSelect, data, 'id', 'sucursal', '--Seleccionar sucursal--');
                    alertaMensaje('Sucursales cargadas correctamente', 3000, 'success');
                })
                .catch(() => {
                    alertaMensaje('Error al cargar sucursales', 3000, 'error');
                });

            if (selectTipoGasto.selectedIndex == 3) {
                loadProveedores(idNegocio);
            }
        } else {
            resetSucursal();
            if (selectTipoGasto.selectedIndex == 3) {
                resetSelect(selectProveedores, '--Seleccionar Proveedor--');
            }
        }
    });

    const selectedSucursal = sucursalSelect.dataset.old || '0';
    const selectedProveedor = selectProveedores.dataset.old || '0';

    if (negocioSelect.value !== '0') {
        loadSucursales(negocioSelect.value, selectedSucursal).then(() => {
            if (selectTipoGasto.selectedIndex == 3) {
                loadProveedores(negocioSelect.value).then(() => {
                    if (selectedProveedor && selectedProveedor !== '0') {
                        selectProveedores.value = selectedProveedor;
                    }
                });
            }
        });
    }

    if (selectTipoGasto.selectedIndex !== 0) {
        selectTipoGasto.dispatchEvent(new Event('change'));
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