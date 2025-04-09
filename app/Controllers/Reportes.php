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
        2 =>'Ultimo mes', 
        3 =>'Ultima semana', 
    ];

    public function acl() {
        $data['idroles'] = $this->session->idroles;
        $data['id'] = $this->session->id;
        $data['logged'] = $this->usuarioModel->_getLogStatus($data['id']);
        $data['nombre'] = $this->session->nombre;
        return $data;
    }

    public function frmReporteDiarioVentas(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte de Control Diario de Ventas';
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

    public function reporteDiarioVentas(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;

            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();
            
            $datos = [
                'negocio' => $this->request->getPostGet('negocio'),
                'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
            ];

            $data['res'] = $this->pedidoModel->_getPedidosReporteDiario($datos['fecha_inicio'], $datos['negocio']);
            $data['datos'] = $datos;

            $data['title']='Reportes';
            $data['subtitle']='Reporte de Control Diario de Ventas';
            $data['main_content']='reportes/reporte_diario_ventas';
            return view('dashboard/index', $data);
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
            $data['vendedores'] = $this->usuarioModel->where('idroles', 4)->orWhere('idrol_2', 4)->orWhere('es_vendedor', 1)->orderBy('nombre', 'asc')->findAll();

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
        ];

        $res = $this->pedidoModel->_getPedidosReporteDiario($datos['fecha_inicio'], $datos['negocio']);

        //echo '<pre>'.var_export($res, true).'</pre>';exit;

        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("Magic Service")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Reporte de Control Diario de Ventas')
            ->setSubject('Reportes Magic Service')
            ->setDescription('Reporte con datos de las ventas del día')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Reportes');

        $nombreDelDocumento = "MagicService - Reporte de Control Diario de Ventas.xlsx";

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

        $phpExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleCabecera);
        $phpExcel->getActiveSheet()->mergeCells('A1:J1');

        //COLUMNAS
        foreach (range('A','J') as $col) {
            $phpExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
        }
        

        //TITULO
        $hoja->setCellValue('A'.$fila, "REPORTE DE CONTROL DE VENTAS DIARIAS");

        $fila++;

        //CABECERA
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");

        if ($datos['negocio'] == 0) {

            $hoja->setCellValue('B'.$fila,'TODOS');

        } else if ($datos['negocio'] == 1){

            $hoja->setCellValue('B'.$fila,'MAGIC SERVICE');

        } else if ($datos['negocio'] ==2){

            $hoja->setCellValue('B'.$fila,'KARANA');

        }
        
        
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "DESDE:");
        $hoja->setCellValue('B'.$fila, $datos['fecha_inicio']);
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);


        $fila +=2;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':J'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "No.");
        $hoja->setCellValue('B'.$fila, "FECHA");
        $hoja->setCellValue('C'.$fila, "CLIENTE");
        $hoja->setCellValue('D'.$fila, "BANCO/PLATAFORMA");
        $hoja->setCellValue('E'.$fila, "VALOR TOTAL");
        $hoja->setCellValue('F'.$fila, "NEGOCIO");
        $hoja->setCellValue('G'.$fila, "VENDEDOR");
        $hoja->setCellValue('H'.$fila, "VENTA EXTRA");
        $hoja->setCellValue('I'.$fila, "OBSERVACION PEDIDO");
        $hoja->setCellValue('J'.$fila, "PAGO COMPROBADO");

        $fila++;
        
        //datos
        if ($res) {
            $num = 1;
            $suma = 0;
            foreach ($res as $key => $result) {
                //echo '<pre>'.var_export($result, true).'</pre>';exit;
                
                $vendedor = $this->usuarioModel->_getNombreUsuario($result->vendedor);
                $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
                $phpExcel->getActiveSheet()
                    ->getStyle('A'.$fila.':J'.$fila)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN)
                    ->setColor(new Color('FFFFFFF'));
                $hoja->setCellValue('A'.$fila, $num);
                $hoja->setCellValue('B'.$fila, $result->fecha);
                $hoja->setCellValue('C'.$fila, $result->cliente);

                if ($result->banco != 0) {
                    $banco = $this->bancoModel->_getBanco($result->banco);
                    $hoja->setCellValue('D'.$fila, $banco->banco);
                }else{
                    $hoja->setCellValue('D'.$fila, 'No definido');
                }
                
                $phpExcel->getActiveSheet()->getCell('E'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
                $phpExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleCurrency);
                $hoja->setCellValue('E'.$fila, number_format($result->total, 2, '.'));

                $hoja->setCellValue('F'.$fila, $result->negocio);
                $hoja->setCellValue('G'.$fila, $vendedor);

                $phpExcel->getActiveSheet()->getStyle('H'.$fila)->applyFromArray($styleTextoCentrado);
                if ($result->venta_extra == 1) {
                    $hoja->setCellValue('H'.$fila, 'SI');
                } else {
                    $hoja->setCellValue('H'.$fila, 'NO');
                }

                $phpExcel->getActiveSheet()->getStyle('I'.$fila)->applyFromArray($styleFila);
                $hoja->setCellValue('I'.$fila, $result->observaciones);

                $phpExcel->getActiveSheet()->getStyle('J'.$fila)->applyFromArray($styleTextoCentrado);
                if ($result->estado == 3 || $result->estado == 4) {

                    $hoja->setCellValue('J'.$fila, 'SI');
                } else {

                    $hoja->setCellValue('J'.$fila, 'NO');
                }
                
                $fila++;
                $num++;
                $suma += $result->total;
            }
            $phpExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleSubtituloDerecha);
            $hoja->setCellValue('D'.$fila, 'TOTAL:');

            $phpExcel->getActiveSheet()->getCell('E'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
            $phpExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleCurrencyBold);
            $hoja->setCellValue('E'.$fila, number_format($suma, 2, '.'));
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

    public function reporteEstadisticasVendedorExcel(){

        $datos = [
            'negocio' => $this->request->getPostGet('negocio'),
            'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
            'fecha_final' => $this->request->getPostGet('fecha_final'),
            'sugest' => $this->request->getPostGet('sugest'),
            'vendedor' => $this->request->getPostGet('vendedor'),
        ];

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

        $nombreDelDocumento = "MagicService - Reporte de estadisticas del vendedor.xlsx";

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
        $hoja->setCellValue('A'.$fila, "REPORTE DE ESTADÍSTICAS DE VENDEDOR");

        $fila++;

        //CABECERA
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        
        $hoja->setCellValue('A'.$fila, "NEGOCIO:");
        
        $hoja->setCellValue('B'.$fila, $datos['negocio'] == 1 ? 'MAGIC SERVICE' : 'KARANA');
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
        $hoja->setCellValue('A'.$fila, "DESDE:");
        $hoja->setCellValue('B'.$fila, $datos['fecha_inicio']);
        $fila++;
        $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);


        $fila +=2;

        $phpExcel->getActiveSheet()->getStyle('A'.$fila.':G'.$fila)->applyFromArray($styleCabecera);
        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A'.$fila, "No.");
        $hoja->setCellValue('B'.$fila, "FECHA");
        $hoja->setCellValue('C'.$fila, "CLIENTE");
        $hoja->setCellValue('D'.$fila, "VALOR TOTAL");
        $hoja->setCellValue('E'.$fila, "CATEGORIA");
        $hoja->setCellValue('F'.$fila, "VENDEDOR");
        $hoja->setCellValue('G'.$fila, "VENTA EXTRA");

        $fila++;
        
        //datos
        if ($res) {
            $num = 1;
            $suma = 0;
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

                $hoja->setCellValue('E'.$fila, 'CATEGORIA');
                $hoja->setCellValue('F'.$fila, $vendedor);

                $phpExcel->getActiveSheet()->getStyle('G'.$fila)->applyFromArray($styleTextoCentrado);
                if ($result->venta_extra == 1) {
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
