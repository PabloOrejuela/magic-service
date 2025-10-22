<link rel="stylesheet" href="<?= site_url(); ?>public/css/form-proveedor-new.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-7">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?= site_url().'proveedor-update';?>" method="post">
                        <div class="card-body">
                            <h4 id="mensaje-campos-requeridos">Los campos con asterisco * son obligatorios</h4>
                            <div class="form-group col-md-12">
                                <label for="nombre">Nombre *:</label>
                                <input 
                                    type="text" 
                                    class="form-control text" 
                                    id="nombre" 
                                    name="nombre" 
                                    placeholder="Nombre proveedor" 
                                    value="<?= $proveedor->nombre; ?>" 
                                    required
                                >
                                <p id="error-message"><?= session('errors.nombre');?> </p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="documento">RUC/Cédula *:</label>
                                <input 
                                    type="text" 
                                    class="form-control text" 
                                    id="documento" 
                                    name="documento" 
                                    placeholder="RUC / Cédula" 
                                    value="<?= $proveedor->documento; ?>" 
                                >
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group col-md-12">
                                <label for="contacto">Nombre Contacto *:</label>
                                <input 
                                    type="text" 
                                    class="form-control text" 
                                    id="contacto" 
                                    name="contacto" 
                                    placeholder="Nombre del contacto" 
                                    value="<?= $proveedor->contacto; ?>" 
                                    required
                                >
                                <p id="error-message"><?= session('errors.contacto');?> </p>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="celular_contacto">Celular Contacto *:</label>
                                <input 
                                    type="text" 
                                    class="form-control number" 
                                    id="celular_contacto" 
                                    name="celular_contacto" 
                                    placeholder="Teléfono contacto" 
                                    value="<?= $proveedor->celular_contacto;?>" 
                                >
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <?= form_hidden('id', $proveedor->id); ?>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btnGuardar">Actualizar</button>
                            <a href="<?= site_url(); ?>proveedores" class="btn btn-light" id="btn-cancela">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->
<script>
    $(document).ready(function(){
        $("#celular_contacto").on("change", function() {
            let string = $("#celular_contacto").val();
           
            $("#celular_contacto").val(string.replace(/[^\w]/gi, ''))
        })
    })

    $(document).ready(function(){
        $("#documento").on("change", function() {
            let string = $("#documento").val();
           
            $("#documento").val(string.replace(/ /gi, ''))
        })
    })
//+593 098 292 7991
</script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.min.js"></script> -->

