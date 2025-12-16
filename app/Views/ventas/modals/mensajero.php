<!-- Modal Mensajero-->
<div class="modal fade" id="mensajeroModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambio de mensajero para el pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <h5 class="modal-title" id="staticBackdropLabel">Mensajeros</h5>
      <input class="form-control" type="hidden" name="codigo_pedido" id="codigo_pedido">
        <select 
            class="form-select" 
            id="select-mensajero" 
            name="mensajero"
            data-style="form-control" 
            data-live-search="true" 
        >
        </select>
      </div>
      <div class="modal-footer">
        <button 
            type="button" 
            class="btn btn-secondary" 
            data-bs-dismiss="modal" 
            onClick="actualizarMensajero(document.getElementById('select-mensajero').value, document.getElementById('codigo_pedido').value)"
        >Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>