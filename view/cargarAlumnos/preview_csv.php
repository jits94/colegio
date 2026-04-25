<?php
 
// error_reporting(E_ALL);
// ini_set('display_errors', 0);
// header('Content-Type: application/json; charset=utf-8');

if (!isset($_FILES['archivo'])) {
    echo json_encode(['error' => 'Archivo no recibido']);
    exit;
}

$ext = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
if ($ext !== 'csv') {
    echo json_encode(['error' => 'Solo se permite CSV']);
    exit;
}

function detectarDelimitador($archivo) {
    $delimitadores = [',',';','|'];
    $linea = fgets(fopen($archivo, 'r'));
    $mejor = ',';
    $max = 0;

    foreach ($delimitadores as $d) {
        $campos = count(str_getcsv($linea, $d));
        if ($campos > $max) {
            $max = $campos;
            $mejor = $d;
        }
    }
    return $mejor;
}

$tmp = $_FILES['archivo']['tmp_name'];
$delimitador = detectarDelimitador($tmp);

$handle = fopen($tmp, 'r');

$html = '  <div class="row">
                    <div class="col-md-12 mt-2 text-center">
                    <h4>Previsualización de los Datos</h4></div></div><br>
                    <table class="table datatable table-striped table-hover table-bordered" style="text-align:center; font-size:14px;" id="tablaHistorico"><tr><th>Apellidos</th><th>Nombre</th><th>Rude</th></tr>';
$filas = [];
$filaNum = 0;

while (($row = fgetcsv($handle, 1000, $delimitador)) !== false) {

 
    if ($filaNum == 0) {
        $filaNum++;
        continue; // saltar cabecera
    }
   $row = array_map(function($v){
        return mb_convert_encoding($v, 'UTF-8', 'auto');
    }, $row);

    //$nombre = mb_convert_encoding($row[0], 'UTF-8', 'auto');
     $apellido   = trim($row[0] ?? '');
     $nombre   = trim($row[1] ?? '');     
     $rude    = trim($row[2] ?? '');
  
     $incompleto = ($nombre == '' || $apellido == '' || $rude == '' );
    $color = "#9aec8f";
    $colorTexto = "#000000";
    if ($nombre == '' || $apellido == '' || $rude == '') {
        $errores++;
         $color = "#c96a71";
           $colorTexto = "#fffefe";
    }

    $html .= '<tr >
                <td style="background-color: '.$color.'; color:'.$colorTexto.'">'.$apellido.'</td>
                <td style="background-color: '.$color.'; color:'.$colorTexto.'">'.$nombre.'</td>
                <td style="background-color: '.$color.'; color:'.$colorTexto.'">'.$rude.'</td>               
              </tr>';

    $filas[] = [
         'apellido' => $apellido,
        'nombre' => $nombre,
        'rude' => $rude 
    ];

    $filaNum++;
 }

 fclose($handle);

 $html .= '</table>';

 $mensajeError = "";
if ($errores > 0) {
    $mensajeError = " Hay filas incompletas";
}

echo json_encode([
    'html' => $html,
    'filas' => $filas,
    'errores' => $errores,
    'mensajeError' => $mensajeError
]);