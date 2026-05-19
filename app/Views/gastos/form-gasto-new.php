<link rel="stylesheet" href="<?= site_url(); ?>/public/css/form-gastos.css">
<section class="content mb-5 frm-gastos">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-7 mb-3 mt-0">
        <!-- general form elements -->
        <div class="card card-light">
          <div class="card-header">
            <h3 class="card-title"><?= $subtitle; ?></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="<?= site_url().'gasto-insert';?>" method="post">
            <div class="card-body">

              <h4 id="mensaje-campos-requeridos">Los campos con asterisco * son obligatorios</h4>

              <div class="form-group col-md-6">
                <label for="negocio">Negocio *:</label>
                <select class="form-select form-control-border" id="negocio" name="negocio" required>
                  <option value="0" selected>--Seleccionar negocio--</option>
                  <?php if (isset($negocios)) {
                    foreach ($negocios as $key => $negocio) {
                      if ($negocio->id < 3) {
                        echo '<option value="'.$negocio->id.'" '.set_select('negocio', $negocio->id, false).' >'.$negocio->negocio.'</option>';
                      }
                    }
                  } ?>
                </select>
                <p id="error-message"><?= session('errors.negocio');?> </p>
              </div>

              <div class="form-group col-md-6">
                <label for="sucursal">Sucursal *:</label>
                <select class="form-select form-control-border" id="sucursal" name="sucursal" required disabled>
                  <option value="0" selected>--Seleccionar sucursal--</option>
                </select>
                <p id="error-message"><?= session('errors.sucursal');?> </p>
              </div>

              <div class="form-group col-md-6">
                <label for="tipo">Tipo de gasto *:</label>
                <select class="form-select form-control-border" id="tipo" name="tipo">
                  <option value="0" selected>--Seleccionar tipo de gasto--</option>
                  <?php if (isset($tipos_gasto)) {
                    foreach ($tipos_gasto as $key => $value) {
                      echo '<option value="'.$value->id.'" '.set_select('tipo', $value->id, false).' >'.$value->tipo_gasto.'</option>';
                    }
                  } ?>
                </select>
                <p id="error-message"><?= session('errors.tipo');?> </p>
              </div>

              <div class="form-group col-md-6" id="div-proveedores">
                <label for="proveedor">Proveedor *:</label>
                <select class="form-select form-control-border" id="proveedor" name="proveedor">
                  <option value="0" selected>--Seleccionar proveedor--</option>
                  <?php 
                    // if (isset($proveedores)) {
                    //   foreach ($proveedores as $key => $value) {
                    //     echo '<option value="'.$value->id.'" '.set_select('proveedor', $value->id, false).' >'.$value->nombre.'</option>';
                    //   }
                    // } 
                  ?>
                </select>
                <p id="error-message"><?= session('errors.proveedor');?> </p>
              </div>

              <div class="form-group col-md-12" id="div-gastovariable">
                <label for="detalleGastoVariable">Gasto variable:</label>
                <input type="text" class="form-control text" id="detalleGastoVariable" name="detalleGastoVariable" placeholder="Detalle gasto variable" value="<?= old('detalleGastoVariable'); ?>">
                <p id="error-message"><?= session('errors.detalleGastoVariable');?> </p>
              </div>

              <div class="form-group col-md-6" id="div-gastofijo">
                <label for="gastofijo">Gasto fijo *:</label>
                <select class="form-select form-control-border" id="gastofijo" name="gastofijo">
                  <option value="0" selected>--Seleccionar un gasto fijo--</option>
                  <?php if (isset($gastos_fijos)) {
                    foreach ($gastos_fijos as $key => $gastoFijo) {
                      echo '<option value="'.$gastoFijo->id.'" '.set_select('proveedor', $gastoFijo->id, false).' >'.$gastoFijo->gasto_fijo.'</option>';
                    }
                  } ?>
                </select>
                <p id="error-message"><?= session('errors.gastofijo');?> </p>
              </div>

            <!-- Bloques de detalle que se pueden clonar -->
            <div id="contenedor-datos">
                <?php
                // Obtenemos los datos antiguos si hay errores o envíos previos
                $fechas_old = old('fecha') ?? [''];
                $documentos_old = old('documento') ?? [''];
                $valores_old = old('valor') ?? [''];
                $descripciones_old = old('descripcion') ?? [''];
                $errores_detalle = session('errors') ?? [];
                ?>

                <?php for ($i = 0; $i < count($fechas_old); $i++): ?>
                <div class="bloque-datos">
                    <div class="form-group col-md-4">
                      <label for="fecha">Fecha *:</label>
                      <input type="date" class="form-control text" id="fecha" name="fecha[]" 
                              value="<?= $fechas_old[$i] ?>" required>
                      <p id="error-message">
                          <?= $errores_detalle[$i]['fecha'] ?? '' ?>
                      </p>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="documento">No. Documento / Factura:</label>
                      <input type="text" class="form-control text" id="documento" name="documento[]" 
                              placeholder="Número de documento" 
                              value="<?= $documentos_old[$i] ?>">
                      <p id="error-message">
                          <?= $errores_detalle[$i]['documento'] ?? '' ?>
                      </p>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="valor">Valor pagado *:</label>
                      <input type="text" class="form-control text" id="valor" name="valor[]" 
                              placeholder="Total pagado" 
                              value="<?= $valores_old[$i] ?>" required>
                      <p id="error-message">
                          <?= $errores_detalle[$i]['valor'] ?? '' ?>
                      </p>
                    </div>

                    <div class="form-group col-md-12">
                      <label for="observaciones">Observaciones:</label>
                      <textarea class="form-control" placeholder="Escriba las observaciones aquí" id="observaciones" 
                                  name="observaciones[]" cols="7" rows="5"><?= $descripciones_old[$i] ?></textarea>
                      <p id="error-message">
                          <?= $errores_detalle[$i]['observaciones'] ?? '' ?>
                      </p>
                    </div>

                    <?php if ($i > 0): ?>
                    <!-- Solo mostramos el botón eliminar si hay más de un bloque -->
                    <button type="button" class="btn btn-danger btn-eliminar mt-2">Eliminar</button>
                    <?php endif; ?>
                </div>
                <?php endfor; ?>
            </div>

            <button type="button" id="btn-agregar" class="btn btn-outline-success mb-3">+ Agregar otro gasto</button>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary" id="btnGuardar">Registrar</button>
              <a href="<?= site_url(); ?>gastos" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- JS para clonar los bloques de detalle -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btn-agregar').addEventListener('click', function() {
      let contenedor = document.getElementById('contenedor-datos');
      let bloques = contenedor.getElementsByClassName('bloque-datos');
      let clon = bloques[bloques.length - 1].cloneNode(true);

      // Limpiar valores del clon
      clon.querySelectorAll('input, textarea').forEach(el => el.value = '');
      // Limpiar mensajes de error
      clon.querySelectorAll('p#error-message').forEach(el => el.innerHTML = '');

      contenedor.appendChild(clon);
    });

    // Eliminar bloque
    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('btn-eliminar')) {
        let bloques = document.getElementsByClassName('bloque-datos');
        if (bloques.length > 1) {
          e.target.closest('.bloque-datos').remove();
        }
      }
    });
  });
</script> <!-- /.card -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url(); ?>public/js/form-gasto-new.js"></script>
<script>
  $(document).ready(function(){
      $("#celular_contacto").on( "change", function() {
          let string = $("#celular_contacto").val();
          
          $("#celular_contacto").val(string.replace(/[^\w]/gi, ''))
      })
  })

  $(document).ready(function(){
      $("#documento").on( "change", function() {
          let string = $("#documento").val();
          
          $("#documento").val(string.replace(/ /gi, ''))
      })
  })

  $(document).ready(function(){
      $("#valor").on( "change", function() {
          let cadena = $("#valor").val();
          let valor = cadena.replace(/,/g, '.')
          let cantidad = parseFloat(valor);

          $("#valor").val(cantidad.toFixed(2))
      })
  })

</script>

