function formatCurrency(input) {
  // Remover cualquier caracter que no sea dígito o punto
  let value = input.value.replace(/[^0-9.]/g, '');
  
  // Dividir la parte entera y decimal
  const parts = value.split('.');
  let integerPart = parts[0];
  const decimalPart = parts.length > 1 ? parts[1] : '';

  // Remover ceros a la izquierda
    integerPart = integerPart.replace(/^0+/, '');
  if (integerPart === "") {
      integerPart = "0";
  }

  // Agregar separador de miles
  integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  
  // Unir la parte entera y decimal
  value = integerPart + (decimalPart.length > 0 ? '.' + decimalPart.slice(0, 2) : '');

  // Asignar el valor formateado al input
  input.value = value;

  // Validar el patrón
    const isValid = input.validity.valid;
    if (!isValid) {
       input.setCustomValidity("Ingrese una cantidad de dinero válida (ej. 123.45)");
    } else {
        input.setCustomValidity("");
    }
}