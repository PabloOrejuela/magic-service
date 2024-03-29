<link rel="stylesheet" href="<?= site_url(); ?>public/css/kardex.css">
<!-- Main content -->
<section class="content mb-3">
      <div class="container-fluid">
        <div class="row">
            <section>
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-body">
                        <h3><?= $subtitle; ?></h3>
                        <form action="#" method="post">
                        <table id="table-kardex" class="table table-bordered table-striped">
                            
                            <thead>
                                <th>Fecha</th>
                                <th>Codigo</th>
                                <th>Item</th>
                                <th>Movimiento</th>
                                <th>Unidades</th>
                                <th>Precio (Unidad)</th>
                                <th>Observación</th>
                            </thead>
                            <tbody>
                                <?php
                                    use App\Models\StockActualModel;
                                    use App\Models\KardexModel;
                                    $this->stockActualModel = new StockActualModel();
                                    $this->kardexModel = new KardexModel();

                                    $totalStock = 0;
                                    $precio_actual = 0;

                                    if (isset($kardex) && $kardex != NULL) {
                                        
                                        foreach ($kardex as $key => $value) {
                                            //$stock = $this->stockActualModel->_getStock($value->codigo);
                                            //$precio_compra = $this->kardexModel->_getUltimoPrecio($value->codigo);
                                            //echo '<pre>'.var_export($precio_compra, true).'</pre>';exit;
                                            echo '<tr>
                                                <td>'.$value->fecha.'</td>
                                                <td>'.$value->codigo.'</td>
                                                <td>'.$value->item.'</td>
                                                <td>'.$value->tipo_movimiento.'</td>';
                                            echo '<td id="td-center">'.$value->unidades.'</td>';
                                            echo '<td id="td-right">'.$value->precio.'</td>';
                                            echo '<td>'.$value->observacion.'</td>';
                                            echo '</tr>';
                                            $totalStock += $value->unidades;
                                            $precio_actual = $value->precio;
                                        }
                                        echo '<tr><td colspan="4" id="lbl-stock">STOCK ACTUAL:</td>';
                                        echo '<td id="td-total-center">'.$totalStock.' Unidades</td>';
                                        echo '<td id="td-total-right">'.$precio_actual.'</td>';
                                        echo '</tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                        </form>
                    </div></div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>
