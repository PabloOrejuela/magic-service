<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class Reportes extends BaseController {
    

    private $sugest = [
        1 => 'Día actual', 
        2 => 'Ultimo mes', 
        3 => 'Ultima semana', 
    ];

    private $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function item_pagado_update() {

        $id = $this->request->getPostGet('id');

        $data = [
            'pagado' => $this->request->getPostGet('pagado')
        ];

        $this->pedidoModel->update($id, $data);
        
        return redirect()->to('reporte_diario_ventas');
    }

    public function frmReporteDiarioVentas(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte de Control de Ventas';
            $data['main_content']='reportes/form_reporte_diario_ventas';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function frmReporteProcedencias(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte de Procedencias';
            $data['main_content']='reportes/form_reporte_procedencias';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function frmReporteMasterIngresos(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte Master de Ingresos';
            $data['main_content']='reportes/form_reporte_master_ingresos';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function frmReporteMasterGastos(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte Master de Gastos';
            $data['main_content']='reportes/form_reporte_master_gastos';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function frmReportePG(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte mensual de Pérdidas y Ganancias';
            $data['main_content']='reportes/form_reporte_pg';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function frmReporteDevoluciones(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte mensual de devoluciones';
            $data['main_content']='reportes/form_reporte_devoluciones';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteProcedencias(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;

            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            
            //DECLARO VARIABLES
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
                'fecha_final' => $this->request->getPostGet('fecha_final'),
                'sugest' => $this->request->getPostGet('sugest'),
            ];

            $data['res'] = $this->pedidoModel->_getPedidosRangoFechasProcedencias($datos['fecha_inicio'], $datos['fecha_final'], $datos['negocio']);
            
            $data['datos'] = $datos;
            //echo '<pre>'.var_export($data['res']->fecha , true).'</pre>';exit;

            $data['title']='Reportes';
            $data['subtitle']='Reporte de Procedencias';
            $data['main_content']='reportes/reporte_procedencias';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteMasterIngresos(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;

            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('mes'),
            ];

            $this->validation->setRuleGroup('reporteMasterIngresos');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                $fecha = explode('-', $datos['fecha']);
                $mes = $fecha[1];
                $anio = $fecha[0];
                $data['numDias'] = cal_days_in_month(0, $mes, $anio);
                $data['res'] = NULL;
                $data['inicioMes'] = date('w', strtotime($datos['fecha'].'-01'));
                $data['finMes'] = date('w', strtotime($datos['fecha'].'-'.$data['numDias']));
                $data['cadenaInicio'] = $this->cadenaInicio($data['inicioMes']);
                $data['cadenaFinal'] = $this->cadenaFinal($data['finMes']);

                //Obtengo los resultados de las ventas de cada día del mes elegido
                for ($i = 1; $i <= $data['numDias']; $i++) { 
                    $dia = $datos['fecha'].'-'.($i > 9 ? $i : '0'.$i);
                    
                    //OBTENDO EL RESULTADO DE VENTAS DE EL DÍA 
                    $res[$i]['res'] = $this->pedidoModel->_getSumatorialPedidosDia($dia, $datos['negocio']);
                    $res[$i]['dia'] = date('N', strtotime($dia));
                }

                $data['res'] = $res;
                $data['datos'] = $datos;

                $data['title']='Reportes';
                $data['subtitle']='Reporte Master de Ingresos';
                $data['main_content']='reportes/reporte_master_ingresos';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteMasterGastos(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;

            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('mes'),
            ];

            $this->validation->setRuleGroup('reporteMasterIngresos');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                $fecha = explode('-', $datos['fecha']);
                $mes = $fecha[1];
                $anio = $fecha[0];
                $data['numDias'] = cal_days_in_month(0, $mes, $anio);
                $data['res'] = NULL;
                $data['inicioMes'] = date('w', strtotime($datos['fecha'].'-01'));
                $data['finMes'] = date('w', strtotime($datos['fecha'].'-'.$data['numDias']));
                // $data['cadenaInicio'] = $this->cadenaInicio($data['inicioMes']);
                // $data['cadenaFinal'] = $this->cadenaFinal($data['finMes']);

                //Obtengo los gastos fijos del mes
                $tipoGasto = 3;
                $data['gastoFijo'] = $this->gastoModel->_getGastosTipoGasto($tipoGasto, $datos['negocio'], $datos['fecha'].'-01', $datos['fecha'].'-'.$data['numDias']);
                
                //Obtengo los gastos variables del mes
                $tipoGasto = 2;
                $data['gastoVariable'] = $this->gastoModel->_getGastosTipoGasto($tipoGasto, $datos['negocio'], $datos['fecha'].'-01', $datos['fecha'].'-'.$data['numDias']);

                //Obtengo los Insumos proveedores del mes
                $tipoGasto = 1;
                $data['gastoInsumosProveedores'] = $this->gastoModel->_getGastosTipoGasto($tipoGasto, $datos['negocio'], $datos['fecha'].'-01', $datos['fecha'].'-'.$data['numDias']);
 
                $data['datos'] = $datos;

                $data['title']='Reportes';
                $data['subtitle']='Reporte Master de Gastos';
                $data['main_content']='reportes/reporte_master_gastos';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteDevoluciones(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha' => $this->request->getPostGet('fecha'),
            ];

            $this->validation->setRuleGroup('reporteDevoluciones');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                $fecha = explode('-', $datos['fecha']);
                $mes = $fecha[1];
                $anio = $fecha[0];
                $data['numDias'] = cal_days_in_month(0, $mes, $anio);
                $data['res'] = NULL;
                $datos['fecha_inicio'] = $datos['fecha'].'-01';
                $datos['fecha_final'] = $datos['fecha'].'-'.$data['numDias'];
                
                $data['devoluciones'] = $this->pedidoModel->_getDevolucionesMesReporte($datos['fecha_inicio'], $datos['fecha_final'], $datos['negocio']);
                
                $data['datos'] = $datos;

                $data['title']='Reportes';
                $data['subtitle']='Reporte Devoluciones';
                $data['main_content']='reportes/reporte_devoluciones';
                return view('dashboard/index', $data);
            }

        }else{
            return redirect()->to('logout');
        }
    }

    public function cadenaInicio($inicioMes){
        if ($inicioMes == 2) {
            $dia = 2;
            return '<td></td>';
        }else if($inicioMes == 3) {
            $dia = 3;
            return '<td></td><td></td>';
        }else if($inicioMes == 4) {
            $dia = 4;
            return '<td></td><td></td><td></td>';
        }else if($inicioMes == 5) {
            $dia = 5;
            return '<td></td><td></td><td></td><td></td>';
        }else if($inicioMes == 6) {
            $dia = 6;
            return '<td></td><td></td><td></td><td></td><td></td>';
        }else if($inicioMes == 0) {
            $dia = 0;
            return '<td></td><td></td><td></td><td></td><td></td><td></td>';
        }
    }

    public function cadenaFinal($finMes){
        if ($finMes == 2) {
            return '<td></td><td></td><td></td><td></td><td></td>';
        }else if($finMes == 3) {
            return '<td></td><td></td><td></td><td></td>';
        }else if($finMes == 4) {
            return '<td></td><td></td><td></td>';
        }else if($finMes == 5) {
            return '<td></td><td></td>';
        }else if($finMes == 6) {
            return '<td></td>';
        }else if($finMes == 1) {
            return '<td></td><td></td><td></td><td></td><td></td><td></td>';
        }
    }

    public function reporteDiarioVentas(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;

            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
                'fecha_final' => $this->request->getPostGet('fecha_final'),
                'sugest' => $this->request->getPostGet('sugest'),
            ];
            
            //PONER ACÁ LA VALIDACION
            $this->validation->setRuleGroup('reporteVentas');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($datos, true).'</pre>';exit;
                $data['res'] = $this->pedidoModel->_getPedidosReporteDiario($datos['fecha_inicio'], $datos['fecha_final'], $datos['negocio']);
                $data['datos'] = $datos;

                $data['title']='Reportes';
                $data['subtitle']='Reporte de Control de Ventas';
                $data['main_content']='reportes/reporte_diario_ventas';
                return view('dashboard/index', $data);
            }
            
        }else{
            return redirect()->to('logout');
        }
    }

    public function frmReporteEstadisticasVendedor(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            $data['vendedores'] = $this->usuarioModel->where('estado', 1)->where('idroles', 4)->orWhere('idrol_2', 4)->orWhere('es_vendedor', 1)->orderBy('nombre', 'asc')->findAll();
            
            $data['title']='Reportes';
            $data['subtitle']='Reporte de estadísticas por vendedor';
            $data['main_content']='reportes/frm_reporte_estadisticas_vendedor';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteEstadisticasVendedor(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;

            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            $data['vendedores'] = $this->usuarioModel->where('idroles', 4)->orWhere('idrol_2', 4)->orWhere('es_vendedor', 1)->orderBy('nombre', 'asc')->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
                'fecha_final' => $this->request->getPostGet('fecha_final'),
                'sugest' => $this->request->getPostGet('sugest'),
                'vendedor' => $this->request->getPostGet('vendedor'),
            ];

            $this->validation->setRuleGroup('reporteEstadisticasVendedor');
        
            if (!$this->validation->withRequest($this->request)->run()) {
                //Depuración
                //dd($validation->getErrors());
                
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }else{ 
                //echo '<pre>'.var_export($datos, true).'</pre>';exit;
                $data['res'] = $this->pedidoModel->_getPedidosRangoFechasVendedor($datos);
                $data['datos'] = $datos;
                
                $data['title']='Reportes';
                $data['subtitle']='Reporte de estadísticas por vendedor';
                $data['main_content']='reportes/reporte_estadisticas_vendedor';
                return view('dashboard/index', $data);
            }
        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteDiarioVentasExcel(){

        $datos = [
            'negocio' => $this->request->getPostGet('negocio'),
            'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
            'fecha_final' => $this->request->getPostGet('fecha_final'),
            'sugest' => $this->request->getPostGet('sugest'),
        ];

        $datosNegocio = $this->negocioModel->where('id', $datos['negocio'])->findAll();

        $res = $this->pedidoModel->_getPedidosReporteDiario($datos['fecha_inicio'], $datos['fecha_final'], $datos['negocio']);

        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic Service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Reporte de Control de Ventas')
            ->setSubject('Reportes Magic Service')
            ->setDescription('Reporte con datos de las ventas por rango de fechas')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "MagicService - Reporte de Control de Ventas.xlsx";

        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF8000',
                ],
                'endColor' => [
                    'argb' => 'FF8000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleSubtitulo = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $styleSubtituloDerecha = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleTextoCentrado = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleCurrency = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleCurrencyBold = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleFila = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $currencyMask = new Currency(
            '$',
            2,
            Currency::SYMBOL_WITH_SPACING,
            Number::WITH_THOUSANDS_SEPARATOR,
            Currency::TRAILING_SYMBOL,
            
        );

        $phpExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()->mergeCells('A1:K1');

        //COLUMNAS
        foreach (range('A','K') as $col) {
            $phpExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        

        //TITULO
        $hoja->setCellValue('A'.$fila, "REPORTE DE CONTROL DE VENTAS");

        $fila++;

        //CABECERA
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");

        if ($datosNegocio) {
            $hoja->setCellValue('B'.$fila, $datosNegocio[0]->negocio);
        }else{
            $hoja->setCellValue('B'.$fila, 'TODOS');
        }
        
        
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "DESDE:");
        $hoja->setCellValue('B'.$fila, $datos['fecha_inicio']);
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);


        $fila +=2;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':K'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "No.");
        $hoja->setCellValue('B'.$fila, "CODIGO");
        $hoja->setCellValue('C'.$fila, "FECHA");
        $hoja->setCellValue('D'.$fila, "CLIENTE");
        $hoja->setCellValue('E'.$fila, "BANCO/PLATAFORMA");
        $hoja->setCellValue('F'.$fila, "VALOR TOTAL");
        $hoja->setCellValue('G'.$fila, "NEGOCIO");
        $hoja->setCellValue('H'.$fila, "VENDEDOR");
        $hoja->setCellValue('I'.$fila, "VENTA EXTRA");
        $hoja->setCellValue('J'.$fila, "OBSERVACION PEDIDO");
        $hoja->setCellValue('K'.$fila, "PAGO COMPROBADO");

        $fila++;

        $totalKarana = 0;
        $totalMagicService = 0;
        $ventasExtras = 0;

        //datos
        if ($res) {
            $num = 1;
            $suma = 0;
            

            foreach ($res as $key => $result) {
                //echo '<pre>'.var_export($result, true).'</pre>';exit;
                
                $vendedor = $this->usuarioModel->_getNombreUsuario($result->vendedor);
                $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
                $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':K'.$fila)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                $hoja->setCellValue('A'.$fila, $num);
                $hoja->setCellValue('B'.$fila, $result->cod_pedido);
                $hoja->setCellValue('C'.$fila, $result->fecha);
                $hoja->setCellValue('D'.$fila, $result->cliente);

                if ($result->banco != 0) {
                    $banco = $this->bancoModel->_getBanco($result->banco);
                    $hoja->setCellValue('E'.$fila, $banco->banco);
                }else{
                    $hoja->setCellValue('E'.$fila, 'No definido');
                }
                
                $phpExcel->getActiveSheet()->getCell('E'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
                $phpExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleCurrency);
                $hoja->setCellValue('F'.$fila, number_format($result->total, 2, '.'));

                $hoja->setCellValue('G'.$fila, $result->negocio);
                $hoja->setCellValue('H'.$fila, $vendedor);

                $phpExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray($styleTextoCentrado);
                if ($result->venta_extra == 1) {
                    $hoja->setCellValue('I'.$fila, 'SI');
                    $ventasExtras++;
                } else {
                    $hoja->setCellValue('I'.$fila, 'NO');
                }

                $phpExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray($styleFila);
                $hoja->setCellValue('J'.$fila, $result->observaciones);

                $phpExcel->getActiveSheet()->getStyle('K'.$fila)->applyFromArray($styleTextoCentrado);

                if ($result->pagado == 1) {

                    $hoja->setCellValue('K'.$fila, 'SI');
                } else {

                    $hoja->setCellValue('K'.$fila, 'NO');
                }

                if ($result->idnegocio == 1) {
                    $totalMagicService += $result->total;
                }elseif ($result->idnegocio == 2) {
                    $totalKarana += $result->total;
                }
                
                $fila++;
                $num++;
                
                $suma += $result->total;
            }
            $phpExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleSubtituloDerecha);
            $hoja->setCellValue('E'.$fila, 'TOTAL:');

            $phpExcel->getActiveSheet()->getCell('F'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
            $phpExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray($styleCurrencyBold);
            $hoja->setCellValue('F'.$fila, number_format($suma, 2, '.'));
            $phpExcel->getActiveSheet()->getCell('I'.$fila)->getStyle('I'.$fila)->applyFromArray($styleTextoCentrado);
            $hoja->setCellValue('I'.$fila, $ventasExtras);
        }else{
            $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
            $hoja->setCellValue('A'.$fila, 'NO HAY DATOS QUE MOSTRAR');
        }

        $fila++;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':B'.$fila)->applyFromArray($styleCabecera);
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");
        $hoja->setCellValue('B'.$fila, "TOTAL:");
        

        $fila++;
        $hoja->setCellValue('A'.$fila, "MAGIC SERVICE:");

        $phpExcel->getActiveSheet()->getCell('B'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
        $phpExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleCurrencyBold);
        $hoja->setCellValue('B'.$fila, number_format($totalMagicService, 2));

        $fila++;
        $hoja->setCellValue('A'.$fila, "KARANA:");
        
        $phpExcel->getActiveSheet()->getCell('B'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
        $phpExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleCurrencyBold);
        $hoja->setCellValue('B'.$fila, number_format($totalKarana, 2));        

        //Creo el writter y guardo la hoja
        $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
        //Cabeceras para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        
        $r = $writter->save('php://output');exit;
        // if ($r) {
        //     return redirect()->to('cargar_info_view');
        // }else{
        //     $error = 'Hubo un error u no se pudo descargar';
        //     return redirect()->to('cargar_info_view');
        // }        
    }

    public function reporteDevolucionesExcel(){

        $datos = [
            'negocio' => $this->request->getPostGet('negocio'),
            'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
            'fecha_final' => $this->request->getPostGet('fecha_final'),
        ];
        $fecha = explode('-', $datos['fecha_inicio']);
        $numMes = $fecha[1];

        $mes = $this->meses[(int)$numMes];

        $datosNegocio = $this->negocioModel->where('id', $datos['negocio'])->findAll();

        $res = $this->pedidoModel->_getDevolucionesMesReporte($datos['fecha_inicio'], $datos['fecha_final'], $datos['negocio']);

        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic Service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Reporte de Devoluciones')
            ->setSubject('Reportes Magic Service')
            ->setDescription('Reporte de las devoluciones generadas en un mes')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "MagicService - Reporte de Devoluciones ".$mes.".xlsx";

        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF8000',
                ],
                'endColor' => [
                    'argb' => 'FF8000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleSubtitulo = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $styleSubtituloDerecha = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleTextoCentrado = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleCurrency = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleCurrencyBold = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleFila = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $currencyMask = new Currency(
            '$',
            2,
            Currency::SYMBOL_WITH_SPACING,
            Number::WITH_THOUSANDS_SEPARATOR,
            Currency::TRAILING_SYMBOL,
            
        );

        $phpExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()->mergeCells('A1:I1');

        //COLUMNAS
        foreach (range('A','I') as $col) {
            $phpExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        

        //TITULO
        $hoja->setCellValue('A'.$fila, "REPORTE DE DEVOLUCIONES");

        $fila++;

        //CABECERA
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");

        if ($datosNegocio) {
            $hoja->setCellValue('B'.$fila, $datosNegocio[0]->negocio);
        }else{
            $hoja->setCellValue('B'.$fila, 'TODOS');
        }
        
        
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "MES:");
        $hoja->setCellValue('B'.$fila, $mes);
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);


        $fila +=2;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':I'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "No.");
        $hoja->setCellValue('B'.$fila, "CODIGO");
        $hoja->setCellValue('C'.$fila, "FECHA");
        $hoja->setCellValue('D'.$fila, "CLIENTE");
        $hoja->setCellValue('E'.$fila, "NEGOCIO");
        $hoja->setCellValue('F'.$fila, "VENDEDOR");
        $hoja->setCellValue('G'.$fila, "VALOR TOTAL");
        $hoja->setCellValue('H'.$fila, "VALOR DEVUELTO");
        $hoja->setCellValue('I'.$fila, "OBSERVACION DEVOLUCION");

        $fila++;

        $totalKarana = 0;
        $totalMagicService = 0;

        //datos
        if ($res) {
            $num = 1;
            $suma = 0;
            
            foreach ($res as $key => $result) {
                //echo '<pre>'.var_export($result, true).'</pre>';exit;
                
                $vendedor = $this->usuarioModel->_getNombreUsuario($result->vendedor);
                $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
                $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':I'.$fila)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                $hoja->setCellValue('A'.$fila, $num);
                $hoja->setCellValue('B'.$fila, $result->cod_pedido);
                $hoja->setCellValue('C'.$fila, $result->fecha);
                $hoja->setCellValue('D'.$fila, $result->cliente);
                $hoja->setCellValue('E'.$fila, $result->negocio);

                if ($result->idnegocio == 1) {
                    $totalMagicService += $result->valor_devuelto;
                }elseif ($result->idnegocio == 2) {
                    $totalKarana += $result->valor_devuelto;
                }

                $hoja->setCellValue('F'.$fila, $vendedor);
                
                $phpExcel->getActiveSheet()->getCell('G'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
                $phpExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($styleCurrency);
                $hoja->setCellValue('G'.$fila, number_format($result->total, 2, '.'));

                $phpExcel->getActiveSheet()->getCell('H'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
                $phpExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray($styleCurrency);
                $hoja->setCellValue('H'.$fila, number_format($result->valor_devuelto, 2, '.'));

                $phpExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray($styleFila);
                $hoja->setCellValue('I'.$fila, $result->observacion_devolucion);

                $fila++;
                $num++;
                
                $suma += $result->total;
            }
            $phpExcel->getActiveSheet()->getStyle('F'.$fila)->applyFromArray($styleSubtituloDerecha);
            $hoja->setCellValue('F'.$fila, 'TOTAL:');

            $phpExcel->getActiveSheet()->getCell('G'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
            $phpExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($styleCurrencyBold);
            $hoja->setCellValue('G'.$fila, number_format($suma, 2, '.'));

            $phpExcel->getActiveSheet()->getCell('H'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
            $phpExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray($styleCurrencyBold);
            $hoja->setCellValue('H'.$fila, number_format(($totalMagicService+$totalKarana), 2, '.'));

            
        }else{
            $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
            $hoja->setCellValue('A'.$fila, 'NO HAY DATOS QUE MOSTRAR');
        }

        $fila++;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':B'.$fila)->applyFromArray($styleCabecera);
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");
        $hoja->setCellValue('B'.$fila, "TOTAL:");
        

        $fila++;
        $hoja->setCellValue('A'.$fila, "MAGIC SERVICE:");

        $phpExcel->getActiveSheet()->getCell('B'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
        $phpExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleCurrencyBold);
        $hoja->setCellValue('B'.$fila, number_format($totalMagicService, 2));

        $fila++;
        $hoja->setCellValue('A'.$fila, "KARANA:");
        
        $phpExcel->getActiveSheet()->getCell('B'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
        $phpExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleCurrencyBold);
        $hoja->setCellValue('B'.$fila, number_format($totalKarana, 2));        

        //Creo el writter y guardo la hoja
        $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
        //Cabeceras para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        
        $r = $writter->save('php://output');exit;
        // if ($r) {
        //     return redirect()->to('cargar_info_view');
        // }else{
        //     $error = 'Hubo un error u no se pudo descargar';
        //     return redirect()->to('cargar_info_view');
        // }        
    }


    public function reporteEstadisticasVendedorExcel(){

        $datos = [
            'negocio' => $this->request->getPostGet('negocio'),
            'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
            'fecha_final' => $this->request->getPostGet('fecha_final'),
            'vendedor' => $this->request->getPostGet('vendedor'),
        ];

        $vendedor = $this->usuarioModel->_getNombreUsuario($datos['vendedor']);
        $datosNegocio = $this->negocioModel->where('id', $datos['negocio'])->findAll();

        $res = $this->pedidoModel->_getPedidosRangoFechasVendedor($datos);

        //echo '<pre>'.var_export($res, true).'</pre>';exit;

        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic Service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Reporte de Estadisticas de vendedor')
            ->setSubject('Reportes Magic Service')
            ->setDescription('Reporte con datos de el vendedor en un rango de tiempo definido')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "MagicService - Reporte de estadisticas del vendedor $vendedor.xlsx";

        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF8000',
                ],
                'endColor' => [
                    'argb' => 'FF8000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleSubtitulo = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $styleSubtituloDerecha = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleTextoCentrado = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleCurrency = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleCurrencyBold = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleFila = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $currencyMask = new Currency(
            '$',
            2,
            Currency::SYMBOL_WITH_SPACING,
            Number::WITH_THOUSANDS_SEPARATOR,
            Currency::TRAILING_SYMBOL,
            
        );

        $phpExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()->mergeCells('A1:G1');

        //COLUMNAS
        foreach (range('A','G') as $col) {
            $phpExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        

        //TITULO
        $hoja->setCellValue('A'.$fila, "REPORTE DE ESTADÍSTICAS DE VENDEDOR: ". $vendedor);

        $fila++;

        //CABECERA
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");

        if ($datosNegocio) {
            $hoja->setCellValue('B'.$fila, $datosNegocio[0]->negocio);
        }else{
            $hoja->setCellValue('B'.$fila, 'TODOS');
        }
        
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "DESDE:");
        $hoja->setCellValue('B'.$fila, $datos['fecha_inicio']);
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "HASTA:");
        $hoja->setCellValue('B'.$fila, $datos['fecha_final']);


        $fila +=2;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':G'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "No.");
        $hoja->setCellValue('B'.$fila, "FECHA");
        $hoja->setCellValue('C'.$fila, "CLIENTE");
        $hoja->setCellValue('D'.$fila, "VALOR TOTAL");
        $hoja->setCellValue('E'.$fila, "NEGOCIO");
        $hoja->setCellValue('F'.$fila, "VENDEDOR");
        $hoja->setCellValue('G'.$fila, "VENTA EXTRA");

        $fila++;
        
        //datos
        if ($res) {
            $num = 1;
            $suma = 0;
            $ventasExtras = 0;
            foreach ($res as $key => $result) {
                //echo '<pre>'.var_export($result, true).'</pre>';exit;
                
                $vendedor = $this->usuarioModel->_getNombreUsuario($result->vendedor);
                $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
                $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':G'.$fila)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                $hoja->setCellValue('A'.$fila, $num);
                $hoja->setCellValue('B'.$fila, $result->fecha);
                $hoja->setCellValue('C'.$fila, $result->cliente);

                $phpExcel->getActiveSheet()->getCell('D'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
                $phpExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleCurrency);
                $hoja->setCellValue('D'.$fila, number_format($result->total, 2, '.'));

                $hoja->setCellValue('E'.$fila, $result->negocio);
                $hoja->setCellValue('F'.$fila, $vendedor);

                $phpExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($styleTextoCentrado);
                if ($result->venta_extra == 1) {
                    $ventasExtras++;
                    $hoja->setCellValue('G'.$fila, 'SI');
                } else {
                    $hoja->setCellValue('G'.$fila, 'NO');
                }
                
                $fila++;
                $num++;
                $suma += $result->total;
            }
            $phpExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray($styleSubtituloDerecha);
            $hoja->setCellValue('C'.$fila, 'TOTAL:');

            $phpExcel->getActiveSheet()->getCell('D'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
            $phpExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleCurrencyBold);
            $hoja->setCellValue('D'.$fila, number_format($suma, 2, '.'));

            $phpExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($styleTextoCentrado);
            $hoja->setCellValue('G'.$fila, $ventasExtras);
        }else{
            $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
            $hoja->setCellValue('A'.$fila, 'NO HAY DATOS QUE MOSTRAR');
        }

        

        //Creo el writter y guardo la hoja
        $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
        //Cabeceras para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        
        $r = $writter->save('php://output');exit;
        // if ($r) {
        //     return redirect()->to('cargar_info_view');
        // }else{
        //     $error = 'Hubo un error u no se pudo descargar';
        //     return redirect()->to('cargar_info_view');
        // }        
    }

    public function reporteProcedenciasExcel(){
        
        //DECLARO VARIABLES

        $datos = [
            'negocio' => $this->request->getPostGet('negocio'),
            'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
            'fecha_final' => $this->request->getPostGet('fecha_final'),
            'sugest' => $this->request->getPostGet('sugest'),
        ];

        $datosNegocio = $this->negocioModel->where('id', $datos['negocio'])->findAll();
        
        $res = $this->pedidoModel->_getPedidosRangoFechasProcedencias($datos['fecha_inicio'], $datos['fecha_final'], $datos['negocio']);

        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic Service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Reporte de Procedencias')
            ->setSubject('Reportes Magic Service')
            ->setDescription('Reporte con datos de las procedencias')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "MagicService - Reporte de Procedencias.xlsx";
        
        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF8000',
                ],
                'endColor' => [
                    'argb' => 'FF8000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleSubtitulo = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $styleTextoCentrado = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleCurrency = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleFila = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $currencyMask = new Currency(
            '$',
            2,
            Currency::SYMBOL_WITH_SPACING,
            Number::WITH_THOUSANDS_SEPARATOR,
            Currency::TRAILING_SYMBOL,
            
        );

        $phpExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()->mergeCells('A1:E1');

        //COLUMNAS
        foreach (range('A','G') as $col) {
            $phpExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }

        //TITULO
        $hoja->setCellValue('A'.$fila, "REPORTE DE PROCEDENCIAS");

        $fila++;

        //CABECERA
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");

        if ($datosNegocio) {
            $hoja->setCellValue('B'.$fila, $datosNegocio[0]->negocio);
        }else{
            $hoja->setCellValue('B'.$fila, 'TODOS');
        }
        
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "DESDE:");
        $hoja->setCellValue('B'.$fila, $datos['fecha_inicio']);
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "HASTA:");
        $hoja->setCellValue('B'.$fila, $datos['fecha_final']);

        $fila +=2;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':E'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "FECHA");
        $hoja->setCellValue('B'.$fila, "CLIENTE");
        $hoja->setCellValue('C'.$fila, "VALOR TOTAL");
        $hoja->setCellValue('D'.$fila, "PROCEDENCIA");
        $hoja->setCellValue('E'.$fila, "NEGOCIO");

        $fila++;
        
        //datos
        if ($res) {
            foreach ($res as $key => $result) {
                $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
                $hoja->setCellValue('A'.$fila, $result->fecha);
                $hoja->setCellValue('B'.$fila, $result->cliente);
                
                $phpExcel->getActiveSheet()->getCell('C'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
                $phpExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray($styleCurrency);
                $hoja->setCellValue('C'.$fila, number_format($result->total, 2, '.'));

                $phpExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleTextoCentrado);
                if ($result->procedencia == "Seleccionar procedencia") {
                    $hoja->setCellValue('D'.$fila, 'Indeterminada');
                } else {
                    $hoja->setCellValue('D'.$fila, $result->procedencia);
                }

                $phpExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleTextoCentrado);
                $hoja->setCellValue('E'.$fila, $result->negocio);
                $fila++;
            }
        }else{

        }

        //Creo el writter y guardo la hoja
        
        $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
        //Cabeceras para descarga
        header('Content-Disposition: attachment;filename="'.urlencode($nombreDelDocumento).'"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        
        
        $r = $writter->save('php://output');exit;
        // if ($r) {
        //     return redirect()->to('cargar_info_view');
        // }else{
        //     $error = 'Hubo un error u no se pudo descargar';
        //     return redirect()->to('cargar_info_view');
        // }        
    }

    public function reporteMasterGastosExcel(){

        $datos = [
            'negocio' => $this->request->getPostGet('negocio'),
            'mes' => $this->request->getPostGet('mes'),
        ];

        $fecha = explode('-', $datos['mes']);
        $mes = $fecha[1];
        $anio = $fecha[0];
        $data['numDias'] = cal_days_in_month(0, $mes, $anio);
        $data['res'] = NULL;
        $data['inicioMes'] = date('w', strtotime($datos['mes'].'-01'));
        $data['finMes'] = date('w', strtotime($datos['mes'].'-'.$data['numDias']));
        $nombreMes = $this->meses[ltrim($mes, '0')];

        $datosNegocio = $this->negocioModel->where('id', $datos['negocio'])->findAll();

        //Obtengo los gastos fijos del mes
        $tipoGasto = 3;
        $gastoFijo = $this->gastoModel->_getGastosTipoGasto($tipoGasto, $datos['negocio'], $datos['mes'].'-01', $datos['mes'].'-'.$data['numDias']);

        //Obtengo los gastos variables del mes
        $tipoGasto = 2;
        $gastoVariable = $this->gastoModel->_getGastosTipoGasto($tipoGasto, $datos['negocio'], $datos['mes'].'-01', $datos['mes'].'-'.$data['numDias']);

        //Obtengo los Insumos proveedores del mes
        $tipoGasto = 1;
        $gastoInsumosProveedores = $this->gastoModel->_getGastosTipoGasto($tipoGasto, $datos['negocio'], $datos['mes'].'-01', $datos['mes'].'-'.$data['numDias']);

        
        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic Service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Reporte Master de Gastos')
            ->setSubject('Reportes Magic Service')
            ->setDescription('Reporte de los gastos del mes organizados por tipo de gasto')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "MagicService - Reporte Master de Gastos - $nombreMes.xlsx";

        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF8000',
                ],
                'endColor' => [
                    'argb' => 'FF8000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleCabeceraTotales = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF8000',
                ],
                'endColor' => [
                    'argb' => 'FF8000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleSubtitulo = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $styleSubtituloDerecha = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleTextoCentrado = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleCurrency = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleCurrencyBold = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleFila = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $currencyMask = new Currency(
            '$',
            2,
            Currency::SYMBOL_WITH_SPACING,
            Number::WITH_THOUSANDS_SEPARATOR,
            Currency::TRAILING_SYMBOL,
            
        );
        
        $hoja->getStyle('A1:K1')->applyFromArray($styleCabecera);
        $hoja->mergeCells('A1:K1');

        //COLUMNAS
        foreach (range('A','K') as $col) {
            $hoja->getColumnDimension($col)->setAutoSize(true);
        }
        

        //TITULO
        $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
        $hoja->setCellValue('A'.$fila, "REPORTE MASTER DE INGRESOS");

        $fila += 2;

        //CABECERA
        $hoja->getStyle('A'.$fila)->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':B'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");

        if ($datosNegocio) {
            $hoja->setCellValue('B'.$fila, $datosNegocio[0]->negocio);
        }else{
            $hoja->setCellValue('B'.$fila, 'TODOS');
        }
        
        $fila++;
        $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':B'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
        $hoja->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "MES:");
        $hoja->setCellValue('B'.$fila, $datos['mes']);

        $fila++;
        $hoja->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);

        $fila +=2;

        
        //$hoja->mergeCells('A'.$fila.':K'.$fila); 

        //$hoja->getStyle('A'.$fila.':K'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel

        $totalEgresos = 0;
        $totalGastosFijos = 0;
        $totalGastoVariable = 0;
        $totalGastoInsumosProveedores = 0;

        if ($gastoFijo) {
            
            foreach ($gastoFijo as $key => $gasto) {
                $totalGastosFijos += $gasto->valor;
            }

        }

        if ($gastoVariable) {

            foreach ($gastoVariable as $key => $gasto) {
                $totalGastoVariable += $gasto->valor;
            }
        }

        if ($gastoInsumosProveedores) {
                                                    
            foreach ($gastoInsumosProveedores as $key => $gasto) {
                
                $totalGastoInsumosProveedores += $gasto->valor;
            }
            
        }
        
        $hoja->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':C'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
        $hoja->setCellValue('A'.$fila, "FECHA");
        $hoja->setCellValue('B'.$fila, "GASTOS FIJOS");
        $hoja->getStyle('C'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
        $hoja->getStyle('C'.$fila)->applyFromArray($styleCabeceraTotales);
        
        $hoja->setCellValue('C'.$fila, $totalGastosFijos);

        $hoja->getStyle('D'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('D'.$fila, "");

        $phpExcel->getActiveSheet()
                    ->getStyle('E'.$fila.':G'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                    
        $hoja->getStyle('E'.$fila.':G'.$fila)->applyFromArray($styleCabecera);
        $hoja->setCellValue('E'.$fila, "FECHA");
        $hoja->setCellValue('F'.$fila, "GASTOS VARIABLES");
        $hoja->getStyle('G'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
        $hoja->getStyle('G'.$fila)->applyFromArray($styleCabeceraTotales);
        $hoja->setCellValue('G'.$fila, $totalGastoVariable);

        $hoja->getStyle('H'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('H'.$fila, "");

        $phpExcel->getActiveSheet()
                    ->getStyle('I'.$fila.':K'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));

        $hoja->getStyle('I'.$fila.':K'.$fila)->applyFromArray($styleCabecera);
        $hoja->setCellValue('I'.$fila, "FECHA");
        $hoja->setCellValue('J'.$fila, "INSUMOS PROVEEDORES");
        $hoja->getStyle('K'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
        $hoja->getStyle('K'.$fila)->applyFromArray($styleCabeceraTotales);
        $hoja->setCellValue('K'.$fila, $totalGastoInsumosProveedores);

        $fila = 8;
        
        if ($gastoFijo) {
            foreach ($gastoFijo as $key => $gasto) {

                $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':C'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                $hoja->setCellValue("A".$fila, $gasto->fecha);
                $hoja->setCellValue("B".$fila, $gasto->gasto_fijo);
                $hoja->getStyle('C'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
                $hoja->setCellValue("C".$fila, $gasto->valor);
                $fila++;
            }
        } else {
            
            $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':C'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
            $hoja->setCellValue("A".$fila, "No hay datos");
            $hoja->setCellValue("B".$fila, "");
            $hoja->setCellValue("C".$fila, "");
        }

        $fila = 8;

        if ($gastoVariable) {
            foreach ($gastoVariable as $key => $gasto) {
                
                $phpExcel->getActiveSheet()
                    ->getStyle('E'.$fila.':G'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                $hoja->setCellValue("E".$fila, $gasto->fecha);
                $hoja->setCellValue("F".$fila, $gasto->detalleGastoVariable);
                $hoja->getStyle('G'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
                $hoja->setCellValue("G".$fila, $gasto->valor);
                $fila++;
            }
        } else {
            $phpExcel->getActiveSheet()
                    ->getStyle('E'.$fila.':G'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
            $hoja->setCellValue("E".$fila, "No hay datos");
            $hoja->setCellValue("F".$fila, "");
            $hoja->setCellValue("G".$fila, "");
        }

        $fila = 8;

        if ($gastoInsumosProveedores) {
            foreach ($gastoInsumosProveedores as $key => $gasto) {
                $phpExcel->getActiveSheet()
                    ->getStyle('I'.$fila.':K'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                $hoja->setCellValue("I".$fila, $gasto->fecha);
                $hoja->setCellValue("J".$fila, $gasto->proveedor);
                $hoja->getStyle('K'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
                $hoja->setCellValue("K".$fila, $gasto->valor);
                $fila++;
            }
        } else {
            $phpExcel->getActiveSheet()
                    ->getStyle('I'.$fila.':K'.$fila)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
            $hoja->setCellValue("I".$fila, "No hay datos");
            $hoja->setCellValue("J".$fila, "");
            $hoja->setCellValue("K".$fila, "");
        }

        $fila +=3;

        $totalEgresos = $totalGastosFijos + $totalGastoVariable + $totalGastoInsumosProveedores;

        $phpExcel->getActiveSheet()
                    ->getStyle('E3'.':F3')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
        $hoja->getStyle('E3')->applyFromArray($styleCabecera);
        $hoja->setCellValue("E3", 'TOTAL DE EGRESOS POR GASTOS:');
        $hoja->getStyle('F3')->applyFromArray($styleSubtituloDerecha);
        $hoja->getStyle('F3')->getNumberFormat()->setFormatCode($currencyMask);
        $hoja->setCellValue("F3", $totalEgresos);

        //Creo el writter y guardo la hoja
        $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
        //Cabeceras para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        
        $r = $writter->save('php://output');exit;
        // if ($r) {
        //     return redirect()->to('cargar_info_view');
        // }else{
        //     $error = 'Hubo un error u no se pudo descargar';
        //     return redirect()->to('cargar_info_view');
        // }        
    }

    public function reporteMasterIngresosExcel(){

        $datos = [
            'negocio' => $this->request->getPostGet('negocio'),
            'fecha' => $this->request->getPostGet('mes'),
        ];

        $fecha = explode('-', $datos['fecha']);
        $mes = $fecha[1];
        $anio = $fecha[0];
        $numDias = cal_days_in_month(0, $mes, $anio);
        $res = NULL;
        $inicioMes = date('w', strtotime($datos['fecha'].'-01'));
        $finMes = date('w', strtotime($datos['fecha'].'-'.$numDias));
        // $cadenaInicio = $this->cadenaInicioExcel($inicioMes);
        // $cadenaFinal = $this->cadenaFinalExcel($finMes);

        $datosNegocio = $this->negocioModel->where('id', $datos['negocio'])->findAll();

        //Obtengo los resultados de las ventas de cada día del mes elegido
        for ($i = 1; $i <= $numDias; $i++) { 
            $dia = $datos['fecha'].'-'.($i > 9 ? $i : '0'.$i);
            
            //OBTENDO EL RESULTADO DE VENTAS DE EL DÍA 
            $res[$i]['res'] = $this->pedidoModel->_getSumatorialPedidosDia($dia, $datos['negocio']);
            $res[$i]['dia'] = date('N', strtotime($dia));
        }

        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic Service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Reporte Master de Ingresos')
            ->setSubject('Reportes Magic Service')
            ->setDescription('Reporte con la sumatoria de las ventas de cada día organizado por fechas')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "MagicService - Reporte Master de Ingresos.xlsx";

        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startColor' => [
                    'argb' => 'FF8000',
                ],
                'endColor' => [
                    'argb' => 'FF8000',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleSubtitulo = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $styleSubtituloDerecha = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleTextoCentrado = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];

        $styleCurrency = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleCurrencyBold = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleFila = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $currencyMask = new Currency(
            '$',
            2,
            Currency::SYMBOL_WITH_SPACING,
            Number::WITH_THOUSANDS_SEPARATOR,
            Currency::TRAILING_SYMBOL,
            
        );
        
        $hoja->getStyle('A1:H1')->applyFromArray($styleCabecera);
        $hoja->mergeCells('A1:H1');

        //COLUMNAS
        foreach (range('A','H') as $col) {
            $hoja->getColumnDimension($col)->setAutoSize(true);
        }
        

        //TITULO
        $hoja->setCellValue('A'.$fila, "REPORTE MASTER DE INGRESOS");

        $fila++;

        //CABECERA
        $hoja->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");

        if ($datosNegocio) {
            $hoja->setCellValue('B'.$fila, $datosNegocio[0]->negocio);
        }else{
            $hoja->setCellValue('B'.$fila, 'TODOS');
        }
        
        
        $fila++;
        $hoja->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "MES:");
        $hoja->setCellValue('B'.$fila, $datos['fecha']);

        $fila++;
        $hoja->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);

        $fila +=2;

        $hoja->getStyle('A'.$fila.':H'.$fila)->applyFromArray($styleCabecera);
        $hoja->mergeCells('A'.$fila.':G'.$fila); 

        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "VENTAS DIARIAS DE TODO EL MES");
        $hoja->setCellValue('H'.$fila, "TOTAL DE VENTAS SEMANAL");

        $fila +=2;

        $hoja->getStyle('A'.$fila.':H'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "LUNES");
        $hoja->setCellValue('B'.$fila, "MARTES");
        $hoja->setCellValue('C'.$fila, "MIERCOLES");
        $hoja->setCellValue('D'.$fila, "JUEVES");
        $hoja->setCellValue('E'.$fila, "VIERNES");
        $hoja->setCellValue('F'.$fila, "SABADO");
        $hoja->setCellValue('G'.$fila, "DOMINGO");
        $hoja->setCellValue('H'.$fila, '');

        $fila++;
        
        $dia = 1;
        $sumaSemana = 0;
        $sumaTotal = 0;
        $cols = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G'];

        $fila = 9;

        //datos
        if ($res) {

            foreach ($res as $key => $result) {
                if ($result['dia'] == 7) {
                    if ($result['res']) {
                        $hoja->setCellValue($cols[$result['dia']].$fila, number_format($result['res'], 2));
                        $hoja->setCellValue('H'.$fila, number_format($sumaSemana, 2));
                        $fila++;
                    }else{
                        $hoja->setCellValue($cols[$result['dia']].$fila, '0.00');
                        $hoja->setCellValue('H'.$fila, number_format($sumaSemana, 2));
                        $fila++;
                    }
                    $sumaTotal += $sumaSemana;
                    $sumaSemana = 0;
                }else{
                    $hoja->getStyle('A'.$fila.':H'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
                    $sumaSemana += $result['res'];
                    
                    if ($result['res']) {
                        $hoja->setCellValue($cols[$result['dia']].$fila, number_format($result['res'], 2));
                        
                    }else{
                        $hoja->setCellValue($cols[$result['dia']].$fila, '0.00');
                    }
                }
                
            }
            if ($finMes != 0) {
                $sumaTotal += $sumaSemana;
                $hoja->setCellValue('H'.$fila, number_format($sumaSemana, 2));
            }
            

        }else{
            $hoja->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
            $hoja->setCellValue('A'.$fila, 'NO HAY DATOS QUE MOSTRAR');
        }
        //TOTAL
        $fila++;
        $hoja->setCellValue("G".$fila, "TOTAL DEL MES:");
        $hoja->getStyle('H'.$fila)->getNumberFormat()->setFormatCode($currencyMask);
        $hoja->setCellValue("H".$fila, number_format($sumaTotal, 2));

             

        //Creo el writter y guardo la hoja
        $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
        //Cabeceras para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        
        $r = $writter->save('php://output');exit;
        // if ($r) {
        //     return redirect()->to('cargar_info_view');
        // }else{
        //     $error = 'Hubo un error u no se pudo descargar';
        //     return redirect()->to('cargar_info_view');
        // }        
    }

    /**
     *
     * Reporte de la cantidad de items sensibles que se necesitan en temporadas altas 
     * dependiando de los pedidos en un rango de fechas
     *
     * @param Type $var Description
     * @return type void
     * @throws conditon
     **/
    public function reporteItemsSensibles(){
        $data = $this->acl();
        
        if ($data['logged'] == 1 && $this->session->clientes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte de items sensibles por rango de fechas';
            $data['main_content']='reportes/frm_reporte_items_sensibles';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteListItems(){
        
        $items = $this->itemModel->findAll();

        $fila = 3;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Resportes')
            ->setSubject('Lista de Items')
            ->setDescription('Lista de Items')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "Lista_items.xlsx";

        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleTitulo = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'bottom' => ['borderStyle' => 'thick', 'color' => ['argb' => '00000000']],
                    'top' => ['borderStyle' => 'thick', 'color' => ['argb' => '00000000']],
                    'right' => ['borderStyle' => 'thick', 'color' => ['argb' => '00000000']],
                    'left' => ['borderStyle' => 'thick', 'color' => ['argb' => '00000000']],
                ],
            ],
        ];

        $styleFilaLeft = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ]
        ];

        $styleFilaRight = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ]
        ];

        $styleFilaCenter = [
            'font' => [
                'bold' => false,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        $phpExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleTitulo);
        $phpExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(20, 'pt');
        $phpExcel->getActiveSheet()->mergeCells('A1:C1');



        $phpExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $phpExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $phpExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        //Edito la info que va a ir en el archivo excel

        $hoja->setCellValue('A1', "LISTA DE ITEMS");

        $hoja->setCellValue('A2', "ITEM");
        $hoja->setCellValue('B2', "PRECIO");
        $hoja->setCellValue('C2', "CUANTIFICABLE");


        foreach ($items as $key => $item) {
            $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleFilaLeft);
            $phpExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $phpExcel->getActiveSheet()->getStyle('B'.$fila)->applyFromArray($styleFilaRight);
            $phpExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray($styleFilaCenter);

            $hoja->setCellValue('A'.$fila, $item->item);
            $hoja->setCellValue('B'.$fila, number_format($item->precio, 2));
            $hoja->setCellValue('C'.$fila, $item->cuantificable);

            $fila++;
        }
    
        //Creo el writter y guardo la hoja
        $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
        //Cabeceras para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
        header('Cache-Control: max-age=0');
        
        $r = $writter->save('php://output');exit;
        // if ($r) {
        //     return redirect()->to('cargar_info_view');
        // }else{
        //     $error = 'Hubo un error u no se pudo descargar';
        //     return redirect()->to('cargar_info_view');
        // }        
    }

}
