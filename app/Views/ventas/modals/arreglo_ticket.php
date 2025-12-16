<!-- Modal Frm Attributos extra Arreglo-->
<div class="modal fade" id="linkArregloPedido" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo">Campos del arreglo para el tiket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onClick="actualizaGrid()"></button>
      </div>
      <form id="form-modal-attr">
        <div class="modal-body">
            <input class="form-control" type="hidden" name="idarreglo" id="idarreglo">
            <input class="form-control" type="hidden" name="idcategoria" id="idcategoria">
            <div class="mb-0 row">
                <label for="lblPedido" class="col-sm-2 col-form-label">Pedido:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="lblPedido">
                </div>
            </div>
            <div class="mb-1 row">
                <label for="lblForm" class="col-sm-2 col-form-label">Arreglo:</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="lblForm">
                </div>
            </div>
            
            <!-- Desarrollo el cuerpo de cada formulario   -->
            <div class="formulario" id="formulario">
                
            </div>
        </div>
        <div class="modal-footer">
            
        </div>
      </form>
    </div>
  </div>
</div>