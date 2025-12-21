<link rel="stylesheet" href="<?= site_url(); ?>/public/css/productos_relacionados_item.css">
<section class="content">
      <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-light">
                    <div class="card-header">
                        <h3 class="card-title"><?= $subtitle; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped" id="table-productos">
                            <thead>
                                <th>No.</th>
                                <th>ID</th>
                                <th>Producto / Arreglo</th>
                                <th>Imagen</th>
                            </thead>
                            <?php
                                $num = 1;
                                
                                if (isset($productos) && $productos != '' && !empty($productos)) {
                                    foreach ($productos as $producto) {
                                        echo '<tr>';
                                        echo '<td>'.$num.'</td>';
                                        echo '<td>'.$producto->idproducto.'</td>';
                                        echo '<td>'.$producto->producto.'</td>';
                                        if ($producto->image != '' && $producto->image != 'default-img') {
                                            echo '<td><img src="'.site_url().'public/images/productos/'.$producto->image.'.jpg" class="img-item-thumbnail" alt="Imagen"></td>';
                                        } else {
                                            echo '<td><img src="'.site_url().'public/images/default-img.png" class="img-item-thumbnail" alt="Imagen"></td>';
                                        }
                                        
                                        echo '</tr>';
                                        $num++;
                                    }
                                } else {
                                    echo '<tr>';
                                    echo '<td colspan="4">No se encontraron productos que utilicen el item seleccionado</td>';
                                    echo '</tr>';
                                }
                                
                            ?>
                        </table>
                        <div class="card-footer">
                            <a href="<?= site_url(); ?>items" class="btn btn-light cancelar" id="btn-cancela">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> <!-- /.card -->