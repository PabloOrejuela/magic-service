<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Gastos extends BaseController {
    
    public function index(){
        
        if ($this->session->gastos == 1) {
            
            $data['session'] = $this->session;
            $data['gastos'] = $this->gastoModel->_getGastos();

            //echo '<pre>'.var_export($data['gastos'], true).'</pre>';exit;
            $data['title']='Gastos';
            $data['subtitle']='Gastos';
            $data['main_content']='gastos/grid_gastos';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function gridGastoFiltrado(){
        
        if ($this->session->gastos == 1) {
            
            $data['session'] = $this->session;

            $data['mes'] = $this->request->getPostGet('mes');

            $fecha = explode('-', $data['mes']);
            $mes = $fecha[1];
            $anio = $fecha[0];
            $data['numDias'] = cal_days_in_month(0, $mes, $anio);
            $data['res'] = NULL;
            $data['inicioMes'] = date('w', strtotime($data['mes'].'-01'));
            $data['finMes'] = date('w', strtotime($data['mes'].'-'.$data['numDias']));

            $data['gastos'] = $this->gastoModel->_getGastosFiltrado($data['mes'].'-01', $data['mes'].'-'.$data['numDias']);

            $data['title']='Gastos';
            $data['subtitle']='Gastos';
            $data['main_content']='gastos/grid_gastos_filtrado';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    /**
     * Formulario para crear un nuevo GASTO
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function create() {

        if ($this->session->proveedores == 1) {
            
            $data['session'] = $this->session;
            $data['sucursales'] = $this->sucursalModel->orderBy('sucursal', 'asc')->findAll();
            $data['negocios'] = $this->negocioModel->orderBy('negocio', 'asc')->findAll();
            //$data['proveedores'] = $this->proveedorModel->orderBy('nombre', 'asc')->findAll();
            $data['tipos_gasto'] = $this->tipoGastoModel->orderBy('tipo_gasto', 'asc')->findAll();
            $data['gastos_fijos'] = $this->gastoFijoModel->orderBy('id', 'asc')->findAll();

            //echo '<pre>'.var_export($data['items'], true).'</pre>';exit;
            $data['title']='Gastos';
            $data['subtitle']='Registrar Gasto';
            $data['main_content']='gastos/form-gasto-new';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function getSucursalesByNegocio() {
        if ($this->request->isAJAX()) {
            $idNegocio = $this->request->getPost('idNegocio');
            $sucursales = $this->sucursalModel->_getSucursalesByNegocio($idNegocio);
            return $this->response->setJSON($sucursales);
        }
        return $this->response->setStatusCode(403);
    }

    public function insert() {
        if ($this->session->clientes != 1) {
            return redirect()->to('logout');
        }

        // Campos de detalle enviados como arrays
        $fechas = $this->request->getPostGet('fecha');
        $documentos = $this->request->getPostGet('documento');
        $valores = $this->request->getPostGet('valor');
        $observaciones = $this->request->getPostGet('observaciones');

        // Variables generales (cabecera)
        $gasto = [
            'idsucursal' => strtoupper($this->request->getPostGet('sucursal')),
            'idnegocio' => strtoupper($this->request->getPostGet('negocio')),
            'idproveedor' => strtoupper($this->request->getPostGet('proveedor')),
            'idtipogasto' => strtoupper($this->request->getPostGet('tipo')),
            'detalleGastoVariable' => strtoupper($this->request->getPostGet('detalleGastoVariable')),
            'gastofijo' => strtoupper($this->request->getPostGet('gastofijo')),
        ];

        $this->validation->setRuleGroup('gasto');

        if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }else{

            // Recorremos cada detalle para insertarlo por separado
            for ($i = 0; $i < count($fechas); $i++) {

                $gasto['documento'] = strtoupper($documentos[$i] ?? '');
                $gasto['observaciones'] = strtoupper($observaciones[$i] ?? '');
                $gasto['valor'] = strtoupper($valores[$i] ?? '');
                $gasto['fecha'] = strtoupper($fechas[$i] ?? '');
                //echo '<pre>'.var_export($gasto, true).'</pre>';
                $this->gastoModel->insert($gasto);
            }
            
        }

        return redirect()->to('gastos');
    }

    public function update(){

        if ($this->session->clientes == 1) {
            $id = strtoupper($this->request->getPostGet('id'));

            $gasto = [

                'detalleGastoVariable' => strtoupper($this->request->getPostGet('detalleGastoVariable')),
                'gastofijo' => strtoupper($this->request->getPostGet('gastofijo')),
                'fecha' => $this->request->getPostGet('fecha'),
                'documento' => strtoupper($this->request->getPostGet('documento')),
                'valor' => strtoupper($this->request->getPostGet('valor')),
                'observaciones' => strtoupper($this->request->getPostGet('observaciones')),
                'descripcion' => strtoupper($this->request->getPostGet('descripcion')),
            ];

            //echo '<pre>'.var_export($gasto, true).'</pre>';exit;

            $this->validation->setRuleGroup('gastoUpdate');
        
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //Actualizo el gasto
                $this->gastoModel->update($id, $gasto);
                return redirect()->to('gastos');
            }
        }else{

            return redirect()->to('logout');
        }
    }

    /**
     * Formulario para editar un nuevo Gasto
     *
     * @param Type $var 
     * @return type void view
     * @throws conditon
     **/
    public function edit($id) {

        if ($this->session->gastos == 1) {
            
            $data['session'] = $this->session;
            $data['sucursales'] = $this->sucursalModel->findAll();
            $data['negocios'] = $this->negocioModel->findAll();
            $data['proveedores'] = $this->proveedorModel->findAll();
            $data['tipos_gasto'] = $this->tipoGastoModel->orderBy('tipo_gasto', 'asc')->findAll();
            $data['gasto'] = $this->gastoModel->find($id);
            $data['gastos_fijos'] = $this->gastoFijoModel->orderBy('id', 'asc')->findAll();

            //echo '<pre>'.var_export($data['gasto'], true).'</pre>';exit;
            $data['title']='Gastos';
            $data['subtitle']='Editar Gasto';
            $data['main_content']='gastos/form-gasto-edit';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function getProveedoresByNegocioGastos(){

        $idnegocio = $this->request->getPostGet('idNegocio');
        $proveedores = $this->proveedorModel->where('idnegocio', $idnegocio)->findAll();
        return $this->response->setJSON($proveedores);
    }

}