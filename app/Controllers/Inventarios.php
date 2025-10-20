<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Inventarios extends BaseController {

    public function index(){
        $data = $this->acl();
        
        if ($data['is_logged'] == 1 && $this->session->inventarios == 1) {
            
            $data['session'] = $this->session;
            $data['items'] = $this->itemModel->_getItemsCuantificables();
            $data['movimientos'] = $this->movimientoInventarioModel->findAll();

            //echo '<pre>'.var_export($data['items']->id, true).'</pre>';exit;
            $data['title']='Inventarios';
            $data['subtitle']='Inventario de Items';
            $data['main_content']='inventarios/grid_inventarios';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function gestion_inventario(){
        $data = $this->acl();
        
        if ($data['is_logged'] == 1 && $this->session->inventarios == 1) {
            
            $data['session'] = $this->session;
            $data['items'] = $this->itemModel->_getItemsCuantificables();
            $data['movimientos'] = $this->movimientoInventarioModel->orderBy('descripcion', 'asc')->findAll();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Inventarios';
            $data['subtitle']='Gestión de Inventarios';
            $data['main_content']='inventarios/frm_gestion_inventarios';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function kardexItem($item){
        $data = $this->acl();
        
        if ($data['is_logged'] == 1 && $this->session->inventarios == 1) {
            
            $data['session'] = $this->session;
            $data['kardex'] = $this->kardexModel->_getKardex($item);
            $data['item'] = $this->itemModel->find($item);

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Inventarios';
            $data['subtitle']='Kardex del item: '.$data['item']->item;
            $data['main_content']='inventarios/grid_kardex';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    function get_item_cuantificable(){
        $name = $this->request->getPostGet('name');
        $items = $this->itemModel->_getItemCuantificable($name);
        
        echo json_encode($items);
    }

    function getStockActual(){
        $item = $this->request->getPostGet('id');
        $datos = $this->stockActualModel->_getStock($item);
        if ($datos != NULL) {
            $stock_actual = $datos->stock_actual;
        }else{
            $stock_actual = 0;
        }
        
        echo json_encode($stock_actual);
    }

    function registraMovimientoStock(){

        $movStock = [
            'item' => $this->request->getPostGet('id'),
            'movimiento' => $this->request->getPostGet('movimiento'),
            'unidades' => $this->request->getPostGet('unidades'),
            'stock_actual' => $this->request->getPostGet('stock_actual'),
            'observacion' => strtoupper($this->request->getPostGet('observacion')),
            'precio_actual' => strtoupper($this->request->getPostGet('precio')),
        ];
        $this->validation->setRuleGroup('gestionInventario');

        if (!$this->validation->withRequest($this->request)->run()) {
            //Depuración
            //dd($validation->getErrors());
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }else{
            //Insertar Movimiento en Kardex
            $this->kardexModel->_insert($movStock);

            //Actualizar Stock Actual
            $data['item'] = $movStock['item'];
            $data['totalUnidades'] = $this->kardexModel->_getSumaStockItem($movStock['item']);
            
            //Verifico si existe
            $existe = $this->stockActualModel->_getStock($movStock['item']);
            if ($existe) {
                $this->stockActualModel->_update($data);
            } else {
                $this->stockActualModel->_insert($data);
            }
            return redirect()->to('gestion-inventario');
        }
    }
}
