<?php

$archivo = 'prueba.csv';

$handle = fopen($archivo, 'r');

while (($data = fgetcsv($handle, 1000, ',')) !== false) {
    print_r($data);
}

fclose($handle);

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// require 'assets/vendor/PhpSpreadsheet/autoload_ps.php';
 
// use PhpOffice\PhpSpreadsheet\IOFactory;

// echo "Autoload cargado<br>";

// $archivo =  'prueba.xlsx';

// if (!file_exists($archivo)) {
//     die('❌ No se encuentra prueba.xlsx');
// }

// $spreadsheet = IOFactory::load($archivo);
// $sheet = $spreadsheet->getActiveSheet();
// $data = $sheet->toArray();

// echo '<pre>';
// print_r($data);
// echo '</pre>';