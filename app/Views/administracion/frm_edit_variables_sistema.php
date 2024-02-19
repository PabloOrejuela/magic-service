<link rel="stylesheet" href="<?= site_url(); ?>public/css/frm-variables-sistema.css">
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
                            <div class="card-body ">
                                <div class="form-group col-md-12">
                                    <label for="cedula">Estado:</label>
                                    <?php
                                        if ($variables) {
                                            foreach ($variables as $key => $value) {
                                                echo '<div class="mb-3 row">
                                                        <label for="'.$value->id.'" class="col-sm-8 col-form-label">'.$value->variable.'</label>
                                                        <div class="col-sm-4">
                                                            <input 
                                                                type="text" 
                                                                class="form-control" 
                                                                id="'.$value->id.'" 
                                                                placeholder="0"
                                                                name="'.$value->id.'"
                                                                value="'.$value->valor.'"
                                                                onchange="udpdateVariable('.$value->id.')"
                                                            >
                                                        </div>
                                                    </div>';
                                            }
                                        }
                                    ?>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div></div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url() ?>/public/js/frm-variables-sistema.js"></script>
