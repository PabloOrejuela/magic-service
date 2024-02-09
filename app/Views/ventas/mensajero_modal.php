<!-- Modal Mensajero-->
<div class="modal fade" id="mensajeroModal<?= $value->id;?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog"></div>
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="staticBackdropLabel">Mensajeros</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <select 
            class="form-select" 
            id="mensajero" 
            name="mensajero"
            data-style="form-control" 
            data-live-search="true"
        >
        <option value="0" selected>--Seleccionar un mensajero--</option>
        <?php 
            $defaultvalue = 1;
            if (isset($mensajeros)) {
                foreach ($mensajeros as $key => $m) {
                    if ($m->id == $defaultvalue) {
                        echo "<option value='$m->id' " . set_select('mensajero', $m->id, false). " selected>". $m->nombre."</option>";
                    }else{
                        echo "<option value='$m->id' " . set_select('mensajero', $m->id, false). " >". $m->nombre."</option>";
                    }
                }
            }
        ?>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onClick="actualizaMensajero(document.getElementById('mensajero').value, )" data-bs-dismiss="modal">Atualizar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>