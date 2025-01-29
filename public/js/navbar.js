let btnPedidonuevo = document.getElementById('btn-pedido');

btnPedidonuevo.addEventListener('click', function(e) {
    //e.stopPropagation()
    //console.log("CLICK");
    let fecha = new Date();
    let tiempo = (fecha.getYear()-100).toString() 
        + (fecha.getMonth() + 1).toString() 
        + fecha.getDate().toString() 
        + fecha.getHours().toString() 
        + fecha.getMinutes().toString() 
        + addZero(fecha.getSeconds()).toString()

    //Aquí creo el nuevo código
    let id = this.dataset.id;
    let codigoPedido = id+tiempo;

    //Inserto el nuevo codigo de pedido

    $.ajax({
        method:"GET",
        dataType:"html",
        url: "genera-codigo-pedido",
        data: {
            codigo: codigoPedido,
            id: id
        },
        beforeSend: function (f) {
            
        },
        success: function(resultado){
            let res = JSON.parse(resultado)
        }
    });
    
});

function addZero(i) {
    if (i < 10) {i = "0" + i}
    return i;
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min);
  }