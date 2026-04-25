<?php

require_once('../assets/vendor/MPDF/vendor/autoload.php'); //instancio al vendor para traer todos las librerias de composer descargada
//require_once('../examples/prueba.php');
include_once('../clases/registro.php');


//estilos para paginacion
$mpdf = new \Mpdf\Mpdf([
    'pagenumPrefix' => ' Pagina ',
    'pagenumSuffix' => ' - ',
    'nbpgPrefix' => ' de ',
    'nbpgSuffix' => ' paginas',
    'mode' => 'utf-8', 'format' => [215.9, 279.4],
    'margin_top' => 5,
    'margin_footer' => 5
]);


 $iProspecto = new registro();
 //$iProspecto2 = new registro();
 $cod = $_GET['cod'];
// $codCliente = $_POST['codCliente'];

//   $historicos = $iProspecto2->traerHistoricosPDF(1);
//   $historicos->MoveFirst();
//   $fila2 = $historicos->Row();

  $fila = $iProspecto->traerDatosHistorico($cod);


$mpdf->Setfooter('{PAGENO}{nbpg}'); //paginacion numero

$css = file_get_contents('./style-dgpc.css');  //traigo el css
$css2 = file_get_contents('./notables.css');  //traigo el css
$css3 = file_get_contents('./cssVehiculoPDF.css');

$content = ob_get_clean();

// fecha
$date = date("d-m-Y");

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

//$content.='</div>';

//para datos del cliente
// $historicos->MoveFirst();
// while (!$historicos->EndOfSeek()) {
    
//     $fila = $historicos->Row();
$content .= '
<table  style="width:100%;padding-top:15px;" cellspacing="0" ><tr>
<td  style="text-align:CENTER;width:100%;">
<div>
<h3 style="font-weight:bold;font-size:16px;text-align:center;">INFORME DE LA ACTIVIDAD <br> '.strtoupper($fila->nombreActividad).'</h3>
</div>
</td>

</tr></table>';



$content .= '<table style="width:100%;margin-top:10px;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>1.- DATOS ACTIVIDAD</b></span></td></tr></table>';

$content .= '<table style="width:100%;margin-top:10px;" cellspacing="0">
<tr>
 
    <td style="width:60%;">
    <span style="font-size:14px;text-align:left;"><b>- Organización: </b>' . ucwords(strtolower($fila->organizacion)) . '</span>
       
    </td>   
    <td style="width:40%;">
    <span style="font-size:14px;text-align:left;"><b> - Fecha: </b>'.date("d", strtotime($fila->fecha)).' de '.ObtenerMes(date("m", strtotime($fila->fecha))).' del '.date("Y", strtotime($fila->fecha)).'</span>
    </td>
</tr>

</table>
';

$content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>2.- META</b></span></td></tr></table>';

// $meta = $iProspecto->cargarMetas(1);

// if($meta->RowCount() > 0){

//     $meta->MoveFirst();
  
     $content .= '<table style="width:100%;margin-top:15px;" cellspacing="0"> ';
//     while (!$meta->EndOfSeek()) {
//         $row = $meta->Row();
         $content .= '
        <tr>
            <td style="margin-top:10px;">
                <span style="font-size:14px;text-align:left;"> - '.$fila->nombreMeta.'</span>
            </td>  
        </tr>';
//     }
     $content .='</table>';
// }
$count = 3;
$objetivo = $iProspecto->cargarObjetivos($cod);

if($objetivo->RowCount() > 0){
   
    $objetivo->MoveFirst();
$content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- OBJETIVOS</b></span></td></tr></table>';

$content .= '<table style="width:100%;margin-top:10px;" cellspacing="0"> ';
while (!$objetivo->EndOfSeek()) {
    $row = $objetivo->Row();
    $content .= '<tr>
    <td>
    <span style="font-size:14px;text-align:justify;"> - ' . nl2br(ucfirst(strtolower($row->detalle))) . '</span>
    </td>  

</tr>';
}
$content .='
</table>
';
$count ++;
}


$descripcion = $iProspecto->cargarDescripcion($cod);

if($descripcion->RowCount() > 0){

    $descripcion->MoveFirst();
      
$content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- DESCRIPCION DE LA ACTIVIDAD</b></span></td></tr></table>';  
   
$content .= '<table style="width:100%;margin-top:10px;" cellspacing="0"> ';
while (!$descripcion->EndOfSeek()) {
    $row = $descripcion->Row();
    $content .= '<tr>
    <td>
    <span style="font-size:14px;text-align:justify;"> - ' . nl2br(ucfirst(strtolower($row->detalle))) . '</span>
    </td>  

</tr>';
}
$content .='
</table>
';
$count ++;
}


/////////////////////////////////TESTIMONIOS////////////////////////////////////////////


$testimonio = $iProspecto->cargarTestimonios($cod);

if($testimonio->RowCount() > 0){

$content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- TESTIMONIOS</b></span></td></tr></table>';

    $testimonio->MoveFirst();
    
   
$content .= '<table style="width:100%;margin-top:10px;" cellspacing="0"> ';
while (!$testimonio->EndOfSeek()) {
    $row = $testimonio->Row();
    $content .= '
    <tr>
        <td>
            <span style="font-size:14px;text-align:left;"><b>Nombre: </b> ' . ucwords(strtolower($row->nombre)) . '</span>
        </td>  
    </tr>   
    <tr>
        <td style="padding-top:20px;">
            <span style="font-size:14px;text-align:justify;"> ' . nl2br(ucfirst(strtolower($row->detalle))) . '</span>
        </td>  
    </tr>';
}
$content .='
</table>
';
$count ++;
}



/////////////////////////////////FOTOS////////////////////////////////////////////


// $fotos = $iProspecto->cargarImagenes($cod);

// if($fotos->RowCount() > 0){

// $content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- FOTOS DE LA ACTIVIDAD</b></span></td></tr></table>';

// $fotos->MoveFirst();
     
// $content .= '<table style="width:100%;margin-top:5px;" cellspacing="0">  <tr>';
// $count = 0;
// while (!$fotos->EndOfSeek()) {
//     $row = $fotos->Row();

//    if($count == 2){
//     $content .= '</tr> <tr>';
//    }
//     $content .= '
   
//         <td style="width:100%;text-align:left; padding:7px">
//             <img src="../imagenes/'.$row->nombre.'" style="width:100%;"></img>
//         </td>
//     ';
//     $count++;
// }
// $content .=' </tr>
// </table>
// ';
// }

$fotos = $iProspecto->cargarImagenes($cod);

if($fotos->RowCount() > 0){

$content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- FOTOS DE LA ACTIVIDAD</b></span></td></tr></table>';

$fotos->MoveFirst();
     

$count = 0;
$tipoVista ='';


while (!$fotos->EndOfSeek()) {
    $row = $fotos->Row();

   if($row->tipoVista == 'Completa'){
    $content .= '
    <table style="width:100%;margin-top:5px;" cellspacing="0"> 
        <tr>
            <td style="width:100%;text-align:center; padding:3px">
                <img src="../imagenes/'.$row->nombre.'" style="width: 100%;height: 400px; "></img>
            </td>
        </tr>
    </table>';
   }
   else{
        $tipoVista = $row->tipoVista;
        if($count == 0 || $count == 2){
            if($count == 2){
                $content .= '</tr>
                </table>';
            }
            $content .= '
            <table style="width:100%;margin-top:5px; " cellspacing="0"> 
                <tr>';
           
        }
        $content .= '  
            <td style="width:50%;text-align:center; padding:3px; ">
                <img src="../imagenes/'.$row->nombre.'" style="max-width: 100%;height: 500px; "></img>
            </td>';
        $count++;
   }
  
}

if($tipoVista == 'Mitad' || $tipoVista == ''){
    $content .= '</tr>
    </table>';
}

}

//}





$mpdf->SetHTMLFooter('<div style="text-align: center;font-size:9px;"><b></b></div><div style="text-align: right;font-size:8px;"></div>'); // le da estilo al footer paginacion


$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
$mpdf->writeHtml($css2, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
$mpdf->writeHtml($content, \Mpdf\HTMLParserMode::HTML_BODY); // para el cuerpo del pdf



// $mpdf->AddPage();
// $content2 = '';



// $mpdf->SetHTMLFooter('<div style="text-align: center;font-size:9px;"><b>' . $fila->oficina . '</b></div><div style="text-align: right;font-size:8px;">{PAGENO}{nbpg}</div>'); // le da estilo al footer paginacion


// $mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
// $mpdf->writeHtml($css2, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
// $mpdf->writeHtml($content2, \Mpdf\HTMLParserMode::HTML_BODY); // para el cuerpo del pdf




//$mpdf->Output('reporte_'.$cod.'.pdf', 'D'); //descarga pdf

//$pdfname = "Historico" . "_" . $cod . "_" . $codVehi . ".pdf";
$pdfname = "historicos-" . $fila->organizacion . "-" .$fila->fecha .".pdf";
//$mpdf->Output('../spc/uploadetapas/' . $pdfname, 'F'); //guarda a ruta
//$idArchivo = $iProspecto->SubirSolicitudPreliminar( $pdfname,$cod , $codVehi);
//echo "ok";
$mpdf->Output('' . $pdfname . '', 'I'); //solo lectura
