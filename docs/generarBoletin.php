<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
require_once('../assets/vendor/MPDF/vendor/autoload.php'); //instancio al vendor para traer todos las librerias de composer descargada
//require_once('../examples/prueba.php');
include_once('../clases/registro.php');


//estilos para paginacion
$mpdf = new \Mpdf\Mpdf([
    'pagenumPrefix' => ' Pagina ',
    'pagenumSuffix' => ' - ',
    'nbpgPrefix' => ' de ',
    'nbpgSuffix' => ' paginas',
    'mode' => 'utf-8',
    'format' => 'LETTER-L', // 👈 Horizontal
    'margin_top' => 5,
    'margin_footer' => 5
]);


 $iregistro = new registro();
 //$iProspecto2 = new registro();
 $codAlumno = $_GET['codAlumno'];
 $codCurso = $_GET['codCurso'];
 $gestion = $_GET['gestion'];
  
  
 
$mpdf->Setfooter('{PAGENO}{nbpg}'); //paginacion numero

$css = file_get_contents('./style-dgpc.css');  //traigo el css
$css2 = file_get_contents('./notables.css');  //traigo el css
$css3 = file_get_contents('./cssVehiculoPDF.css');

$content = ob_get_clean();

// fecha
$date = date("d-m-Y");

$unidad = $iregistro->DatosColegio();
// Ruta de la imagen
$mpdf->SetWatermarkImage(
    '../imagenes/boletin/Escudo_de_Bolivia.png',
    0.1,      // opacidad
    '',       // tamaño automático
    [100,50] // posición (x,y)
);

$mpdf->showWatermarkImage = true;

function ObtenerMes($mes){
    if($mes == 1){ return 'Enero'; }
    if($mes == 2){ return 'Febrero'; }
    if($mes == 3){ return 'Marzo'; }
    if($mes == 4){ return 'Abril'; }
    if($mes == 5){ return 'Mayo'; }
    if($mes == 6){ return 'Junio'; }
    if($mes == 7){ return 'Julio'; }
    if($mes == 8){ return 'Agosto'; }
    if($mes == 9){ return 'Septiembre'; }
    if($mes == 10){ return 'Octubre'; }
    if($mes == 11){ return 'Noviembre'; }
    if($mes == 12){ return 'Diciembre'; }

}


function Unidades($num){
        switch($num) {
            case 1: return "UNO";
            case 2: return "DOS";
            case 3: return "TRES";
            case 4: return "CUATRO";
            case 5: return "CINCO";
            case 6: return "SEIS";
            case 7: return "SIETE";
            case 8: return "OCHO";
            case 9: return "NUEVE";
        }
        return "";
    }

    function Decenas($num){
        $decena = floor($num / 10);
        $unidad = $num - ($decena * 10);

        switch($decena) {
            case 1:
                switch($unidad) {
                    case 0: return "DIEZ";
                    case 1: return "ONCE";
                    case 2: return "DOCE";
                    case 3: return "TRECE";
                    case 4: return "CATORCE";
                    case 5: return "QUINCE";
                    default: return "DIECI" . Unidades($unidad);
                }
            case 2:
                switch($unidad) {
                    case 0: return "VEINTE";
                    default: return "VEINTI" . Unidades($unidad);
                }
            case 3: return "TREINTA" . ($unidad > 0 ? " Y " . Unidades($unidad) : "");
            case 4: return "CUARENTA" . ($unidad > 0 ? " Y " . Unidades($unidad) : "");
            case 5: return "CINCUENTA" . ($unidad > 0 ? " Y " . Unidades($unidad) : "");
            case 6: return "SESENTA" . ($unidad > 0 ? " Y " . Unidades($unidad) : "");
            case 7: return "SETENTA" . ($unidad > 0 ? " Y " . Unidades($unidad) : "");
            case 8: return "OCHENTA" . ($unidad > 0 ? " Y " . Unidades($unidad) : "");
            case 9: return "NOVENTA" . ($unidad > 0 ? " Y " . Unidades($unidad) : "");
            default: return Unidades($unidad);
        }
    }

    function DecenasY($strSin, $numUnidades) {
        if ($numUnidades > 0)
            return $strSin . " Y " . Unidades($numUnidades);
        return $strSin;
    }

    function Centenas($num) {
        $centenas = floor($num / 100);
        $decenas = $num - ($centenas * 100);

        switch($centenas) {
            case 1:
                if ($decenas > 0)
                    return "CIENTO " . Decenas($decenas);
                return "CIEN";
            case 2: return "DOSCIENTOS " . Decenas($decenas);
            case 3: return "TRESCIENTOS " . Decenas($decenas);
            case 4: return "CUATROCIENTOS " . Decenas($decenas);
            case 5: return "QUINIENTOS " . Decenas($decenas);
            case 6: return "SEISCIENTOS " . Decenas($decenas);
            case 7: return "SETECIENTOS " . Decenas($decenas);
            case 8: return "OCHOCIENTOS " . Decenas($decenas);
            case 9: return "NOVECIENTOS " . Decenas($decenas);
        }

        if ($num > 0)
            return Decenas($num);

        return "";
    }

    function Seccion($num, $divisor, $strSingular, $strPlural) {
        $cientos = floor($num / $divisor);
        $resto = $num - ($cientos * $divisor);
        $letras = "";

        if ($cientos > 0) {
            if ($cientos > 1)
                $letras = Centenas($cientos) . " " . $strPlural;
            else
                $letras = $strSingular;
        }

        if ($resto > 0)
            $letras .= "";

        return $letras;
    }

    function Miles($num) {
        $divisor = 1000;
        $cientos = floor($num / $divisor);
        $resto = $num - ($cientos * $divisor);
        $strMiles = Seccion($num, $divisor, "MIL", "MIL");
        $strCentenas = Centenas($resto);

        if ($strMiles == "")
            return $strCentenas;

        return $strMiles . " " . $strCentenas;
    }

    function Millones($num) {
        $divisor = 1000000;
        $cientos = floor($num / $divisor);
        $resto = $num - ($cientos * $divisor);
        $strMillones = Seccion($num, $divisor, "UN MILLON", "MILLONES");
        $strMiles = Miles($resto);

        if ($strMillones == "")
            return $strMiles;

        return $strMillones . " " . $strMiles;
    }

    function convertirNumeroATexto($num) {
        $enteros = floor($num);
        $centavos = round(($num - $enteros) * 100);
        $letrasCentavos = "";

        if ($enteros == 0) {
            $res = "CERO";
        } else {
            $res = Millones($enteros);
        }

        if ($centavos > 0) {
            $letrasCentavos = $centavos. "/100";
        }
        else{
            $letrasCentavos = "00/100";
        }

        return trim($res);
}

 

    $datos = $iregistro->obtenerAlumno(  $codAlumno);

    $content="";
  
     $content .= '<br>
    <table style="width:100%; font-size: 11px;  ">
        <tr>
            <td style="width:20%; text-align:center;" rowspan=5><img src="../imagenes/boletin/Escudo_de_Bolivia.png" alt="" style="width:10%;"><br><span style="font-size:9px;">Estado Plurinacional de Bolivia<br>Ministerio de Educación</span></td>
            <td style="width:65%; text-align:center;font-size: 14px; " colspan=4><b>Libreta Escolar Electrónica</b> </td>
            <td style="width:5%; text-align:center;" rowspan=5>
                <table style="width:100%; font-size: 12px; border-collapse:collapse; ">
                    <tr>
                        <td style="width:100%; text-align:center;font-size: 9px;" colspan=3>Rango de Valoración de las dimensiones </td>
                    </tr>
                    <tr>
                        <td  style="width:60%;text-align:left;font-size: 8px; border: 1px solid black;">En desarrollo</td>
                        <td  style="width:10%;text-align:center;font-size: 8px; border: 1px solid black;">ED</td>
                        <td  style="width:30%;text-align:center;font-size: 8px; border: 1px solid black;">Hasta 50</td>
                    </tr>
                     <tr>
                        <td  style="width:60%;text-align:left;font-size: 8px; border: 1px solid black;">Desarrollo aceptable</td>
                        <td  style="width:10%;text-align:center;font-size: 8px; border: 1px solid black;">DA</td>
                        <td  style="width:30%;text-align:center;font-size: 8px; border: 1px solid black;">51 - 68</td>
                    </tr>
                     <tr>
                        <td  style="width:60%;text-align:left;font-size: 8px; border: 1px solid black;">Desarrollo óptimo</td>
                        <td  style="width:10%;text-align:center;font-size: 8px; border: 1px solid black;">DO</td>
                        <td  style="width:30%;text-align:center;font-size: 8px; border: 1px solid black;">69 - 84</td>
                    </tr>
                     <tr>
                        <td  style="width:60%;text-align:left;font-size: 8px; border: 1px solid black;">Desarrollo pleno</td>
                        <td  style="width:10%;text-align:center;font-size: 8px; border: 1px solid black;">DP</td>
                        <td  style="width:30%;text-align:center;font-size: 8px; border: 1px solid black;">85 - 100</td>
                    </tr>
                </table>
            </td>
            <td style="width:10%; text-align:right;" rowspan=5>
                
                <img src="../imagenes/boletin/qr-code.png" alt="" style="width:11%;"><br>CASTELLANO
            </td>
        </tr>    
       
         <tr>            
            <td style="width:60%; text-align:center;font-size: 13px;" colspan=4> <b>Educación Primaria Comunitaria Vocacional</b></td>   
     
        </tr>
          <tr  >            
            <td style="width:13%; text-align:left; margin-left:10%;"><b>Unidad Educativa:</b></td>   
            <td style="width:27%; text-align:left;">'.$unidad->codigoUnidad.' - '.$unidad->unidadEducativa.'</td>   
            <td style="width:10%; text-align:left;"><b>Departamento:</b></td>   
            <td style="width:10%; text-align:left;">'.mb_strtoupper($unidad->departamento).'</td>            
        </tr>
         <tr>            
            <td style="width:13%; text-align:left; margin-left:10%;"><b>Distrito Educativo:</b></td>   
            <td style="width:27%; text-align:left;">'.$unidad->distritoEducativo.'</td>   
            <td style="width:10%; text-align:left;"><b>Dependencia:</b></td>   
            <td style="width:10%; text-align:left;">'.$unidad->dependencia.'</td>            
        </tr>

        <tr>            
            <td style="width:13%; text-align:left; margin-left:10%;"><b>Turno:</b></td>   
            <td style="width:27%; text-align:left;">'.$unidad->turno.'</td>   
            <td style="width:10%; text-align:left;"><b>Gestión:</b></td>   
            <td style="width:10%; text-align:left;">'.date('Y').'</td>            
        </tr>


        
    </table>';
 
    $content .= '<br><table style="width:100%;margin-top:10px; font-size: 10px; border-collapse:collapse; " cellspacing="4">
    <thead>';
    $content .='  <tr>';        
    $content .='    <th scope="col" style="text-align:left;border:1px solid black;padding: 4px" colspan=7>
    Códito Rude: &nbsp;&nbsp; 45634564687654  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
    Apellidos y Nombre: &nbsp;&nbsp; '.mb_strtoupper($datos->apellidos).' '.mb_strtoupper($datos->nombres).'  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
    Año de Escolaridad: &nbsp;&nbsp; '.mb_strtoupper($datos->grado).' 
    </th>';
   
    $content .='  </tr>';
    $content .='  <tr>';    
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;padding: 4px" colspan=7>Evaluación (Ser, Saber, Hacer y Decidir)</th>';
    $content .='  </tr>';
    $content .='  <tr>';    
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;" rowspan=3> Campos de Saberes y Conocimientos</th>';
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;" rowspan=3> Areas Curriculares</th>';
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;padding: 4px" colspan=5>Valoración Cuantitativa</th>';
    $content .='  </tr>';
    $content .='  <tr>';    
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;" rowspan=2>1er. Trismestre</th>';
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;" rowspan=2>2do. Trismestre</th>';
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;" rowspan=2>3er Trismestre</th>';
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;" colspan=2>Promedio Anual</th>';    
    $content .='  </tr>';
    $content .='  <tr>';    
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;padding: 4px">Numeral</th>';
    $content .='    <th scope="col" style="text-align:center;border:1px solid black;padding: 4px">Literal</th>';    
    $content .='  </tr>';
    $content .=' </thead>
    <tbody>';
     $res = $iregistro->traerBoletin( $codCurso,$gestion,$codAlumno);
    if($res->RowCount() > 0){

        $contadorSaberes = [];

        $res->MoveFirst();
        while (!$res->EndOfSeek()) {
            $fila = $res->Row();
            $contadorSaberes[$fila->saberesConocimiento] = ($contadorSaberes[$fila->saberesConocimiento] ?? 0) + 1;
        }
  
        $res->MoveFirst();
       $impreso = [];
        
        while (!$res->EndOfSeek()) {
            $fila = $res->Row();

            $notas1 = $iregistro->traerNotasAlumnos($fila->codMateria,$fila->codCursoAlumno,1,$gestion);
            $promedioPrimerTrimestre = $iregistro->calcularPromedio($notas1);

            $notas2 = $iregistro->traerNotasAlumnos($fila->codMateria,$fila->codCursoAlumno,2,$gestion);
            $promedioSegundoTrimestre = $iregistro->calcularPromedio($notas2);

            $notas3 = $iregistro->traerNotasAlumnos($fila->codMateria,$fila->codCursoAlumno,3,$gestion);
            $promedioTercerTrimestre = $iregistro->calcularPromedio($notas3);

            $promedioAnualTrimestre = number_format(($promedioPrimerTrimestre + $promedioSegundoTrimestre + $promedioTercerTrimestre) / 3,0);

            $content .= '<tr>';

            //SOLO imprimir la primera vez
            if (!isset($impreso[$fila->saberesConocimiento])) {
                $rowspan = $contadorSaberes[$fila->saberesConocimiento];
                $content .= '<td style="width:200px;text-align:left;border:1px solid black;padding:6px" rowspan="'.$rowspan.'">'
                        . $fila->saberesConocimiento .
                        '</td>';
                $impreso[$fila->saberesConocimiento] = true;
            }

            $content .= '<td style="width:200px;text-align:left;border:1px solid black;padding:6px">'
                    . $fila->areasCurriculares .
                    '</td>';

            $content .= '<td style="text-align:center;border:1px solid black;padding:6px">'.$promedioPrimerTrimestre.'</td>';
            $content .= '<td style="text-align:center;border:1px solid black;padding:6px">'.$promedioSegundoTrimestre.'</td>';
            $content .= '<td style="text-align:center;border:1px solid black;padding:6px">'.$promedioTercerTrimestre.'</td>';

            if ($promedioAnualTrimestre >= 50) {
                $content .= '<td style="text-align:center;border:1px solid black;">
                                <span class="badge bg-success rounded-pill">'.$promedioAnualTrimestre.'</span>
                            </td>';
            } else {
                $content .= '<td style="text-align:center;border:1px solid black;">
                                <span class="badge bg-danger rounded-pill">'.$promedioAnualTrimestre.'</span>
                            </td>';
            }

            $content .= '<td style="text-align:center;border:1px solid black;padding:6px">'
                    . strtoupper(convertirNumeroATexto($promedioAnualTrimestre)) .
                    '</td>';

            $content .= '</tr>';
        }


        // while (!$res->EndOfSeek()) {
        //     $fila = $res->Row();   
        //     $notas1 = $iregistro->traerNotasAlumnos($fila->codMateria,$fila->codCursoAlumno,1);
        //     $promedioPrimerTrimestre = $iregistro->calcularPromedio($notas1);
          
        //     $notas2 = $iregistro->traerNotasAlumnos($fila->codMateria,$fila->codCursoAlumno,2);
        //     $promedioSegundoTrimestre = $iregistro->calcularPromedio($notas2);

        //     $notas3 = $iregistro->traerNotasAlumnos($fila->codMateria,$fila->codCursoAlumno,3);
        //     $promedioTercerTrimestre = $iregistro->calcularPromedio($notas3);

        //     $promedioAnualTrimestre = number_format(($promedioPrimerTrimestre + $promedioSegundoTrimestre + $promedioTercerTrimestre ) / 3,0);

        //     $rowspan = "";
        //     if($fila->saberesConocimiento == 'CIENCIA TECNOLOGÍA Y PRODUCCIÓN'){
        //         $rowspan = "rowspan=2;";
        //     }

        //     if($fila->saberesConocimiento == 'COMUNIDAD Y SOCIEDAD'){
        //         $rowspan = "rowspan=5;";
        //     }

        //     $content .='<tr>';
        //     $content .='    <td style="width:200px;text-align:left;border:1px solid black; padding: 6px" '.$rowspan.' >'.$fila->saberesConocimiento.'</td>';
        //     $content .='    <td style="width:200px;text-align:left;border:1px solid black; padding: 6px" >'.$fila->areasCurriculares.'</td>';

         
        //     $content .='    <td style="text-align:center;border:1px solid black; padding: 6px">  '.$promedioPrimerTrimestre.' </td>';
        //     $content .='    <td style="text-align:center;border:1px solid black; padding: 6px">  '.$promedioSegundoTrimestre.' </td>';
        //     $content .='    <td style="text-align:center;border:1px solid black; padding: 6px">  '.$promedioTercerTrimestre.' </td>';

        //     if($promedioAnualTrimestre >= 50){
        //         $content .='    <td style="text-align:center;border:1px solid black;"> <span class="badge bg-success rounded-pill">'.$promedioAnualTrimestre.' </span></td>';  
        //     }
        //     else{
        //         $content .='    <td style="text-align:center;border:1px solid black; padding: 6px"> <span class="badge bg-danger rounded-pill">'.$promedioAnualTrimestre.' </span></td>';  
        //     }                       
        //     $content .='    <td style="text-align:center;border:1px solid black; padding: 6px">  '.strtoupper(convertirNumeroATexto($promedioAnualTrimestre)).'  </td>';  
        //     $content .=' </tr>';
        // }
    }
    $content .='
    </tbody>
  
    </table>
    ';
     
    $content .= '<table style="width:100%; font-size: 9px;  "><tr><td><b>Informe de Promoción: La o el Estudiante ha sido promovido(a) al año de escolaridad inmediato superior.</b></td></tr></table>';


    $content .= '
    <table style="width:100%; font-size: 10px; margin-top:100px;">
        <tr>
            <td style="width:30%; text-align:center;">Maestra/Maestro <br> Firma</td>
            <td style="width:40%; text-align:center;">Unidad Educativa <br> Sello</td>
            <td style="width:30%; text-align:center;">Directora/Director Unidad Educativa <br> Firma</td>
        </tr>
    </table>';

    $content .= '<table style="width:100%; font-size: 9px;  "><tr><td><b>Nota:</b> Para trámites administrativos, la directora o el Director Distrital de Educación y la Directora o el Director Departamental de Educación deberán firmar y sellar al reverso del presente documento</td></tr></table>';

     $content .= '<table style="width:100%; margin-top:10px; font-size: 9px; text-align:right; "><tr><td>Fecha de Impresión: '.date('d/m/Y H:i').'</td></tr></table>';

    $mpdf->SetHTMLFooter('<div style="text-align: center;font-size:9px;"><b></b></div><div style="text-align: right;font-size:8px;"></div>'); // le da estilo al footer paginacion


    $mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
    $mpdf->writeHtml($css2, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
    $mpdf->writeHtml($content, \Mpdf\HTMLParserMode::HTML_BODY); // para el cuerpo del pdf

 
//$mpdf->Output('reporte_'.$cod.'.pdf', 'D'); //descarga pdf
 
$pdfname = "boletin.pdf";
//$mpdf->Output('../spc/uploadetapas/' . $pdfname, 'F'); //guarda a ruta
//$idArchivo = $iProspecto->SubirSolicitudPreliminar( $pdfname,$cod , $codVehi);
//echo "ok";
$mpdf->Output('' . $pdfname . '', 'I'); //solo lectura
