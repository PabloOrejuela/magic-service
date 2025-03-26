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
            $negocio = 1;
           

            if ($this->request->getPostGet('negocio') != 0) {
                $negocio = $this->request->getPostGet('negocio');
            }
            
            $datos = [
                'negocio' => $negocio,
                'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
                'fecha_final' => $this->request->getPostGet('fecha_final'),
                'sugest' => $this->request->getPostGet('sugest'),
            ];

            $data['res'] = $this->pedidoModel->_getPedidosRangoFechasProcedencias($datos['fecha_inicio'], $datos['fecha_final']);
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

            //DECLARO VARIABLES
            $negocio = 1;
           

            if ($this->request->getPostGet('negocio') != 0) {
                $negocio = $this->request->getPostGet('negocio');
            }
            
            $datos = [
                'negocio' => $negocio,
                'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
                'sugest' => $this->request->getPostGet('sugest'),
            ];

            $data['res'] = $this->pedidoModel->_getPedidosReporteDiario($datos['fecha_inicio']);
            $data['datos'] = $datos;

            $data['title']='Reportes';
            $data['subtitle']='Reporte de Control Diario de Ventas';
            $data['main_content']='reportes/reporte_diario_ventas';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
    }

    public function reporteDiarioVentasExcel(){

        //DECLARO VARIABLES
        $negocio = 1;
           

        if ($this->request->getPostGet('negocio') != 0) {
            $negocio = $this->request->getPostGet('negocio');
        }

        $datos = [
            'negocio' => $negocio,
            'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
            'sugest' => $this->request->getPostGet('sugest'),
        ];

        $res = $this->pedidoModel->_getPedidosReporteDiario($datos['fecha_inicio']);

        //echo '<pre>'.var_export($res, true).'</pre>';exit;

        $fila = 1;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("MYRP")
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
        
        $hoja->setCellValue('B'.$fila, $datos['negocio'] == 1 ? 'MAGIC SERVICE' : 'KARANA');
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
        $hoja->setCellValue('F'.$fila, "CATEGORIA");
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

                $hoja->setCellValue('F'.$fila, 'CATEGORIA');
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

    // public function reporteProcedenciasExcel(){

    //     //DECLARO VARIABLES
    //     $negocio = 1;
           

    //     if ($this->request->getPostGet('negocio') != 0) {
    //         $negocio = $this->request->getPostGet('negocio');
    //     }

    //     $datos = [
    //         'negocio' => $negocio,
    //         'fecha_inicio' => $this->request->getPostGet('fecha_inicio'),
    //         'fecha_final' => $this->request->getPostGet('fecha_final'),
    //         'sugest' => $this->request->getPostGet('sugest'),
    //     ];

    //     $res = $this->pedidoModel->_getPedidosRangoFechasProcedencias($datos['fecha_inicio'], $datos['fecha_final']);


    //     $fila = 1;

    //     //Creo la hoja
    //     $phpExcel = new Spreadsheet();
    //     $phpExcel
    //         ->getProperties()
    //         ->setCreator("MYRP")
    //         ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
    //         ->setTitle('Reporte de Procedencias')
    //         ->setSubject('Reportes Magic Service')
    //         ->setDescription('Reporte con datos de las procedencias')
    //         ->setKeywords('etiquetas o palabras clave separadas por espacios')
    //         ->setCategory('Reportes');

    //     $nombreDelDocumento = "MagicService - Reporte de Procedencias.xlsx";

    //     //Selecciono la pestaña
    //     $hoja = $phpExcel->getActiveSheet();

    //     $styleCabecera = [
    //         'font' => [
    //             'bold' => true,
    //         ],
    //         'fill' => [
    //             'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
    //             'rotation' => 90,
    //             'startColor' => [
    //                 'argb' => 'FF8000',
    //             ],
    //             'endColor' => [
    //                 'argb' => 'FF8000',
    //             ],
    //         ],
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //         ]
    //     ];

    //     $styleSubtitulo = [
    //         'font' => [
    //             'bold' => true,
    //         ],
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    //         ]
    //     ];

    //     $styleTextoCentrado = [
    //         'font' => [
    //             'bold' => false,
    //         ],
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //         ]
    //     ];

    //     $styleCurrency = [
    //         'font' => [
    //             'bold' => false,
    //         ],
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    //         ]
    //     ];

    //     $styleFila = [
    //         'font' => [
    //             'bold' => false,
    //         ],
    //         'alignment' => [
    //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    //         ]
    //     ];

    //     $currencyMask = new Currency(
    //         '$',
    //         2,
    //         Currency::SYMBOL_WITH_SPACING,
    //         Number::WITH_THOUSANDS_SEPARATOR,
    //         Currency::TRAILING_SYMBOL,
            
    //     );

    //     $phpExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleCabecera);
    //     $phpExcel->getActiveSheet()->mergeCells('A1:E1');

    //     //COLUMNAS
    //     foreach (range('A','G') as $col) {
    //         $phpExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
    //     }
        

    //     //TITULO
    //     $hoja->setCellValue('A'.$fila, "REPORTE DE PROCEDENCIAS");

    //     $fila++;

    //     //CABECERA
    //     $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
    //     $hoja->setCellValue('A'.$fila, "NEGOCIO:");
    //     $hoja->setCellValue('B'.$fila, $datos['negocio']);
    //     $fila++;
    //     $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
    //     $hoja->setCellValue('A'.$fila, "DESDE:");
    //     $hoja->setCellValue('B'.$fila, $datos['fecha_inicio']);
    //     $fila++;
    //     $phpExcel->getActiveSheet()->getStyle('A'.$fila)->applyFromArray($styleSubtitulo);
    //     $hoja->setCellValue('A'.$fila, "HASTA:");
    //     $hoja->setCellValue('B'.$fila, $datos['fecha_final']);

    //     $fila +=2;

    //     $phpExcel->getActiveSheet()->getStyle('A'.$fila.':E'.$fila)->applyFromArray($styleCabecera);
    //     //Edito la info que va a ir en el archivo excel
    //     $hoja->setCellValue('A'.$fila, "FECHA");
    //     $hoja->setCellValue('B'.$fila, "CLIENTE");
    //     $hoja->setCellValue('C'.$fila, "VALOR TOTAL");
    //     $hoja->setCellValue('D'.$fila, "PROCEDENCIA");
    //     $hoja->setCellValue('E'.$fila, "NEGOCIO");

    //     $fila++;
        
    //     //datos
    //     if ($res) {
    //         foreach ($res as $key => $result) {
    //             $phpExcel->getActiveSheet()->getStyle('A'.$fila.':C'.$fila)->applyFromArray($styleFila);
    //             $hoja->setCellValue('A'.$fila, $result->fecha);
    //             $hoja->setCellValue('B'.$fila, $result->cliente);
                
    //             $phpExcel->getActiveSheet()->getCell('C'.$fila)->getStyle()->getNumberFormat()->setFormatCode($currencyMask);
    //             $phpExcel->getActiveSheet()->getStyle('C'.$fila)->applyFromArray($styleCurrency);
    //             $hoja->setCellValue('C'.$fila, number_format($result->total, 2, '.'));

    //             $phpExcel->getActiveSheet()->getStyle('D'.$fila)->applyFromArray($styleTextoCentrado);
    //             if ($result->procedencia == "Seleccionar procedencia") {
    //                 $hoja->setCellValue('D'.$fila, 'Indeterminada');
    //             } else {
    //                 $hoja->setCellValue('D'.$fila, $result->procedencia);
    //             }

    //             $phpExcel->getActiveSheet()->getStyle('E'.$fila)->applyFromArray($styleTextoCentrado);
    //             $hoja->setCellValue('E'.$fila, $result->negocio);
    //             $fila++;
    //         }
    //     }else{

    //     }

    //     //Creo el writter y guardo la hoja
        
    //     $writter = new XlsxWriter($phpExcel, 'Xlsx');
        
    //     //Cabeceras para descarga
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment;filename="' . $nombreDelDocumento . '"');
    //     header('Cache-Control: max-age=0');
        
    //     $r = $writter->save('php://output');exit;
    //     // if ($r) {
    //     //     return redirect()->to('cargar_info_view');
    //     // }else{
    //     //     $error = 'Hubo un error u no se pudo descargar';
    //     //     return redirect()->to('cargar_info_view');
    //     // }        
    // }

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


    public function pruebaExcel(){

        $fila = 2;

        //Creo la hoja
        $phpExcel = new Spreadsheet();
        $phpExcel
            ->getProperties()
            ->setCreator("MYRP")
            ->setLastModifiedBy('Pablo Orejuela') // última vez modificado por
            ->setTitle('Prod 3 - Registros')
            ->setSubject('Reportes MYRP')
            ->setDescription('Reporte con los registros del Producto 3')
            ->setKeywords('etiquetas o palabras clave separadas por espacios')
            ->setCategory('Registros');

        $nombreDelDocumento = "Prod 3 - Registros.xlsx";

        //Selecciono la pestaña
        $hoja = $phpExcel->getActiveSheet();

        $styleCabecera = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
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

        $phpExcel->getActiveSheet()->getStyle('A1:N1')->applyFromArray($styleCabecera);

        //Edito la info que va a ir en el archivo excel
        $hoja->setCellValue('A1', "AMIE");
        $hoja->setCellValue('B1', "CENTRO EDUCATIVO");
        $hoja->setCellValue('C1', "CIUDAD");
        $hoja->setCellValue('D1', "PROVINCIA");
        $hoja->setCellValue('E1', "NOMBRE");
        $hoja->setCellValue('F1', "DOCUMENTO");
        $hoja->setCellValue('G1', "NACIONALIDAD");
        $hoja->setCellValue('H1', "ETNIA");
        $hoja->setCellValue('I1', "EDAD");
        $hoja->setCellValue('J1', "GÉNERO");
        $hoja->setCellValue('K1', "DISCAPACIDAD");
        $hoja->setCellValue('L1', "TIPO DISCAPACIDAD");
        $hoja->setCellValue('M1', "TELEFONO");
        $hoja->setCellValue('N1', "EMAIL");

       

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
