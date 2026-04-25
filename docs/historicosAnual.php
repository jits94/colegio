<?php

ini_set('default_socket_timeout', 7200);
set_time_limit(7200);
ini_set('memory_limit','2000M');
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

$mpdf->Setfooter('{PAGENO}{nbpg}'); //paginacion numero
$css = file_get_contents('./style-dgpc.css');  //traigo el css
$css2 = file_get_contents('./notables.css');  //traigo el css
$css3 = file_get_contents('./cssVehiculoPDF.css');

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
$cod = $_GET['cod'];
$mes = $_GET['mes'];
$anho = $_GET['gestion'];
$nombreMes = ObtenerMes($mes) . '.PNG';
//$content.='</div>';
//para datos del cliente
$historicos = $iProspecto->traerHistoricosPDF($cod, $mes,$anho);
$historicos->MoveFirst();
$countImagen = 0;


    $content = ob_get_clean();
    $mpdf->AddPage();    
    $content ='<table style="width:100%;" cellspacing="0"> 
    <tr>
        <td style="width:100%;">
            <img src="../imagenes/'.$nombreMes.'" style="width: 100%;"></img>
        </td>
    </tr>
</table>';
$mpdf->SetHTMLFooter('<div style="text-align: center;font-size:9px;"><b></b></div><div style="text-align: right;font-size:8px;"></div>'); // le da estilo al footer paginacion
$mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
$mpdf->writeHtml($css2, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
$mpdf->writeHtml($content, \Mpdf\HTMLParserMode::HTML_BODY); // para el cuerpo del pdf


while (!$historicos->EndOfSeek()) {

    $content = ob_get_clean();
    $mpdf->AddPage();
    $fila = $historicos->Row();
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

    $content .= '<table style="width:100%;margin-top:15px;" cellspacing="0"> ';
    $content .= '
            <tr>
                <td style="margin-top:10px;">
                    <span style="font-size:14px;text-align:left;"> - '.$fila->nombreMeta.'</span>
                </td>  
            </tr>';
    $content .='</table>';

    $count = 3;
    $datos = $iProspecto->cargarDatosHistoricos($fila->codHistorico);
    $total = $datos->RowCount();
    $contadorTotal= 0;
    if($datos->RowCount() > 0){
        $tipoAnterior ='';
        $datos->MoveFirst();
        $contador= 0;
        while (!$datos->EndOfSeek()) {
            $row2 = $datos->Row();
            /////////////////////////////////OBJETIVO////////////////////////////////////////////
            $contador++;
            $contadorTotal++;
            if($row2->tipo == 'objetivo'){
                if($contador == 1){
                    $content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- OBJETIVOS</b></span></td></tr></table>';
                    $content .= '<table style="width:100%;margin-top:10px;" cellspacing="0"> ';
                }
                    
                $content .= '<tr>
                <td>
                <span style="font-size:14px;text-align:justify;"> - ' . nl2br(ucfirst(strtolower($row2->detalle))) . '</span>
                </td>  
                </tr>';
                $tipoAnterior = $row2->tipo;
                continue;
            }
        
            if($tipoAnterior == 'objetivo'){
                $content .='
                </table>
                ';
                $contador= 1;
            }
        
            

            ///////////////////////////////// DESCRIPCION ////////////////////////////////////////////
            if($row2->tipo == 'descripcion'){
            
                if($contador == 1){
                    $count ++;
                    $content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- DESCRIPCION DE LA ACTIVIDAD</b></span></td></tr></table>';
                    $content .= '<table style="width:100%;margin-top:10px;" cellspacing="0"> ';
                }
                    
                $content .= '<tr>
                <td>
                <span style="font-size:14px;text-align:justify;"> - ' . nl2br(ucfirst(strtolower($row2->detalle))) . '</span>
                </td>  
                </tr>';
                $tipoAnterior = $row2->tipo;
                if($contadorTotal == $total){
                    $content .='
                    </table>
                    ';
                }
                else{
                    continue;
                }
                
            }
        
            if($tipoAnterior == 'descripcion'){
                $content .='
                </table>
                ';
                $contador= 1;
            }
        
            
            /////////////////////////////////TESTIMONIOS////////////////////////////////////////////
            if($row2->tipo == 'testimonio'){
            
                if($contador == 1){
                    $count ++;
                    $content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- TESTIMONIOS</b></span></td></tr></table>';
                    $content .= '<table style="width:100%;margin-top:10px;" cellspacing="0"> ';
                }
                    
                $content .= '
                <tr>
                    <td>
                        <span style="font-size:14px;text-align:left;"><b>Nombre: </b> ' . ucwords(strtolower($row2->nombre)) . '</span>
                    </td>  
                </tr>   
                <tr>
                    <td style="padding-top:20px;">
                        <span style="font-size:14px;text-align:justify;"> ' . nl2br(ucfirst(strtolower($row2->detalle))) . '</span>
                    </td>  
                </tr>';
                $tipoAnterior = $row2->tipo;
                if($contadorTotal == $total){
                    $content .='
                    </table>
                    ';
                }
                else{
                    continue;
                }
            }
        
            if($tipoAnterior == 'testimonio'){
                $content .='
                </table>
                ';
                $contador= 1;
            }
        
            /////////////////////////////////IMAGENES////////////////////////////////////////////
            if($row2->tipo == 'imagen'){
               
                if($contador == 1){
                    $count ++;

                    $content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>'.$count.'.- FOTOS DE LA ACTIVIDAD</b></span></td></tr></table>';
                
                    $tipoVista ='';
                    $contador++;
                }
                    
                if($row2->tipoVista == 'Completa'){
                    $content .= '
                    <table style="width:100%;margin-top:5px;" cellspacing="0"> 
                        <tr>
                            <td style="width:100%;text-align:center; padding:3px">
                                <img src="../imagenes/'.$row2->nombre.'" style="width: 100%;height: 400px; "></img>
                            </td>
                        </tr>
                    </table>';
                 
                    //$contador= 0;
                    //continue;
                }
                else{
                    $tipoVista = $row2->tipoVista;
                    if($countImagen == 0 || $countImagen == 2){
                        if($countImagen == 2){
                            $content .= '</tr>
                            </table>';
                        }
                        $content .= '
                        <table style="width:100%;margin-top:5px; " cellspacing="0"> 
                            <tr>';
                       
                    }
                    $content .= '  
                        <td style="width:50%;text-align:center; padding:3px; ">
                            <img src="../imagenes/'.$row2->nombre.'" style="max-width: 100%;height: 700px; "></img>
                        </td>';
                    $countImagen++;                                                                             
                }                 
                $tipoAnterior = $row2->tipo;    
            }       
        } //end while

        if($tipoAnterior == 'imagen' && ($tipoVista == 'Mitad' || $tipoVista == '')){
            $content .='</tr>
            </table>
            ';
            
        }  
    }

    $mpdf->SetHTMLFooter('<div style="text-align: center;font-size:9px;"><b></b></div><div style="text-align: right;font-size:8px;"></div>'); // le da estilo al footer paginacion
    $mpdf->writeHtml($css, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
    $mpdf->writeHtml($css2, \Mpdf\HTMLParserMode::HEADER_CSS);  //para el css
    $mpdf->writeHtml($content, \Mpdf\HTMLParserMode::HTML_BODY); // para el cuerpo del pdf

   

}
$pdfname = "historico_anual.pdf";
//$mpdf->Output($pdfname, 'D'); //descarga pdf

//$pdfname = "Historico" . "_" . $cod . "_" . $codVehi . ".pdf";

//$mpdf->Output('../spc/uploadetapas/' . $pdfname, 'F'); //guarda a ruta
//$idArchivo = $iProspecto->SubirSolicitudPreliminar( $pdfname,$cod , $codVehi);
//echo "ok";
$mpdf->Output('' . $pdfname . '', 'I'); //solo lectura
