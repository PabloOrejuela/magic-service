<!-- Modal Hora Entrega-->
<div class="modal fade" id="horaEntregaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Hora de entrega</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input class="form-control" type="hidden" name="idpedido" id="idpedido">

        <div class="form-group row mb-5 mt-3" id="campo-extra">
            <div class="col-md-5 div-celular">
                <label for="rango-entrega">Desde:</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="entrega-desde" 
                    name="rango_entrega_desde" 
                    placeholder="0:00"
                    maxlength="100"
                    value="<?= old('rango_entrega_desde'); ?>"
                >
            </div>
            <div class="col-md-5 div-celular">
                <label for="rango-entrega">Hasta:</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="entrega-hasta" 
                    name="rango_entrega_hasta" 
                    placeholder="0:00"
                    maxlength="100"
                    value="<?= old('rango_entrega_hasta'); ?>"
                >
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button 
            type="button" 
            class="btn btn-secondary" 
            data-bs-dismiss="modal" 
            onClick="actualizarHorarioEntrega(
                document.getElementById('idpedido').value, 
                document.getElementById('entrega-desde').value, 
                document.getElementById('entrega-hasta').value)"
            >Actualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>