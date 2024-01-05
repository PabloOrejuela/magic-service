<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class Reportes extends BaseController {
    public function index() {
        //
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
