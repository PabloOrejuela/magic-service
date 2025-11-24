<?php

namespace App\Validation;

class MyRules {
    
    public function yearOrMonth(string $str, string $fields, array $data): bool {

        $year     = trim($data['anio']  ?? '');
        $date     = trim($data['fecha'] ?? '');
        $negocio  = trim($data['negocio'] ?? ''); // campo adicional

        // 1. Debe existir año o fecha
        $okYearOrDate = ($year !== '' && $year !== '0') || $date !== '';

        // 2. Debe existir negocio
        $okNegocio = ($negocio !== '' && $negocio !== '0');

        // Puedes agregar todas las condiciones extra que quieras:
        return $okYearOrDate && $okNegocio;
    }


    
}
