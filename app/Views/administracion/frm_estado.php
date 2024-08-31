<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <section class="connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <div>
                            <div class="card-body">
                                <div class="form-group col-md-4">
                                    <label for="cedula">Estado:</label>
                                    <?php
                                        if ($estado[0]->estado == 1) {
                                            echo '<input type="text" class="form-control" id="cedula" name="cedula" placeholder="Documento" value="ACTIVO" disabled>';
                                        }
                                    ?>
                                </div>
                                
                            </div>
                            <form action="<?= site_url();?>desactivar" method="get">
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary"  id="btnGuardar">Desactivar</button>
                                </div>
                            </form>
                        </div>
                    </div></div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>
