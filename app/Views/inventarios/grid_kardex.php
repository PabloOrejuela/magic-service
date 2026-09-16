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
                                    <th>Cod pedido</th>
                                    <th>Unidades</th>
                                    <th>Precio (Unidad)</th>
                                    <th>Observación</th>
                                </thead>
                                <tbody>
                                    <?php
                                        use App\Models\StockActualModel;
                                        $this->stockActualModel = new StockActualModel();

                                        $totalStock = 0;
                                        $precio_actual = 0;

                                        if (isset($kardex) && $kardex != NULL) {
                                            //echo '<pre>'.var_export($item, true).'</pre>';exit;
                                            foreach ($kardex as $key => $value) {
                                                
                                                echo '<tr>
                                                    <td>'.$value->fecha.'</td>
                                                    <td>'.$value->codigo.'</td>
                                                    <td>'.$value->item.'</td>
                                                    <td>'.$value->tipo_movimiento.'</td>
                                                    <td>'.$value->cod_pedido.'</td>
                                                ';
                                                echo '<td id="td-center">'.$value->unidades.'</td>';
                                                echo '<td id="td-right">'.$value->precio.'</td>';
                                                echo '<td>'.$value->observacion.'</td>';
                                                echo '</tr>';
                                                $totalStock += $value->unidades;
                                                $precio_actual = $value->precio;
                                                
                                                $stockActual = $this->stockActualModel
                                                    ->where('item', $value->codigo)
                                                    ->first();

                                                if ($stockActual) {
                                                    $this->stockActualModel->update($stockActual->id, [
                                                        'stock_actual' => $totalStock,
                                                    ]);
                                                } else {
                                                    $this->stockActualModel->insert([
                                                        'item' => $value->codigo,
                                                        'stock_actual' => $totalStock,
                                                    ]);
                                                }
                                            }
                                            echo '<tr><td colspan="5" id="lbl-stock">STOCK ACTUAL:</td>';
                                            echo '<td id="td-total-center">'.$totalStock.' Unidades</td>';
                                            echo '<td id="td-total-right">'.$precio_actual.'</td><td></td>';
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <div class="card-footer">
                                <a href="<?= site_url(); ?>inventario" class="btn btn-light" id="btn-cancela">Regresar al inventario</a>
                            </div>
                        </form>
                    </div></div><!-- /.card-body -->
                </div><!-- /.card-->
            </section>
        </div>
    </div>
</section>
