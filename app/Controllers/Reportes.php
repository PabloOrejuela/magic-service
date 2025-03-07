<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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

    public function frmReporte(){
        
        $data = $this->acl();

        if ($data['logged'] == 1 && $this->session->reportes == 1) {
            
            $data['session'] = $this->session;
            $data['sugest'] = $this->sugest;
            $data['negocios'] = $this->negocioModel->findAll();

            $data['title']='Reportes';
            $data['subtitle']='Reporte';
            $data['main_content']='reportes/form-reporte';
            return view('dashboard/index', $data);
        }else{
            return redirect()->to('logout');
        }
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
