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

  $fila = $iProspecto->traerDatosHistorico_acontecimientos($cod);


$mpdf->Setfooter('{PAGENO}{nbpg}'); //paginacion numero

$css = file_get_contents('./style-dgpc.css');  //traigo el css
$css2 = file_get_contents('./notables.css');  //traigo el css
$css3 = file_get_contents('./cssVehiculoPDF.css');

$content = ob_get_clean();

// fecha
$date = date("d-m-Y");

function ObtenerMes($mes){
    if($mes == 1){ return strtoupper('Enero'); }
    if($mes == 2){ return strtoupper('Febrero'); }
    if($mes == 3){ return strtoupper('Marzo'); }
    if($mes == 4){ return strtoupper('Abril'); }
    if($mes == 5){ return strtoupper('Mayo'); }
    if($mes == 6){ return strtoupper('Junio'); }
    if($mes == 7){ return strtoupper('Julio'); }
    if($mes == 8){ return strtoupper('Agosto'); }
    if($mes == 9){ return strtoupper('Septiembre'); }
    if($mes == 10){ return strtoupper('Octubre'); }
    if($mes == 11){ return strtoupper('Noviembre'); }
    if($mes == 12){ return strtoupper('Diciembre'); }

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
<h3 style="font-weight:bold;font-size:16px;text-align:center;">'.strtoupper($fila->nombre).'</h3>
<h3 style="font-weight:bold;font-size:16px;text-align:center;">'.date('d',strtotime($fila->fecha)) .' DE '. ObtenerMes(date('m',strtotime($fila->fecha))).' DEL '.date('y',strtotime($fila->fecha)).'</h3>
</div>
</td>

</tr></table>';


/////////////////////////////////FOTOS////////////////////////////////////////////


$fotos = $iProspecto->cargarImagenesAcontecimientos($cod);

if($fotos->RowCount() == 1){
    $fotos->MoveFirst();
    $row = $fotos->Row(); 
  
    if($row->portada == 'Si'){
     
        
        $content .= '<table style="width:100%;margin-top:55px;" cellspacing="0">  '; 
        $content .= '<tr>
        <td style="width:100%;text-align:center;">
            <img src="../imagenes/'.$row->nombre.'" style="max-width: 100%;height: 600px; ">
        </td> </tr>';   
        
        $content .='</table>';
    }


$content .= '<br><br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:17px">'.ucfirst(strtolower($fila->descripcion)).'</span></td></tr></table>';
}
else{
    if($fotos->RowCount() > 1){



        $fotos->MoveFirst();
       
     
        $count = 0;
        while (!$fotos->EndOfSeek()) {
            $row = $fotos->Row();
          
           if($count == 0 && $row->portada == 'Si'){
                $content .= '<table style="width:100%;margin-top:55px;" cellspacing="0">  '; 
                $content .= '<tr>
                <td style="width:100%;text-align:center;">
                    <img src="../imagenes/'.$row->nombre.'" style="max-width: 100%;height: 600px; ">
                </td> </tr>';                 
                $content .='</table>';
                
                $content .= '<br><br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:17px">'.ucfirst(strtolower($fila->descripcion)).'</span></td></tr></table>';
            }
            else{
                if($count == 0){
                    $content .= '<br><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:17px">'.ucfirst(strtolower($fila->descripcion)).'</span></td></tr></table>';
                }
                if($count % 2 == 0){
                    $content .= '<table style="width:100%;margin-top:25px;" cellspacing="0">  '; 
                    $content .= '<tr>
                        <td style="width:60%;text-align:center;">
                            <img src="../imagenes/'.$row->nombre.'" style="height: 450px;">
                        </td>
                        <td style="width:40%; padding-left:15px; text-align:justify;">
                            <span style="font-size:17px">'.ucfirst(strtolower($row->descripcion)).'</span>
                        </td> </tr>';             
                    $content .='</table>';
                }
                else{
                    $content .= '<table style="width:100%;margin-top:25px;" cellspacing="0">  '; 
                    $content .= '<tr>
                        <td style="width:40%; padding-right:15px; text-align:justify;">
                            <span style="font-size:17px">'.ucfirst(strtolower($row->descripcion)).'</span>
                        </td>
                        <td style="width:60%;text-align:center;">
                            <img src="../imagenes/'.$row->nombre.'" style="height: 450px;">
                        </td>
                        </tr>';             
                    $content .='</table>';
                }
                                     
               
            }
            $count++;
        }
       
        
    }
    else{
        $content .= '<hr><table style="width:100%;" cellspacing="0" ><tr><td><span style="font-size:15px">no hay fotos</span></td></tr></table>';
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
$pdfname = "acontecimientos-".$fila->nombre."-".$fila->fecha.".pdf";
//$mpdf->Output('../spc/uploadetapas/' . $pdfname, 'F'); //guarda a ruta
//$idArchivo = $iProspecto->SubirSolicitudPreliminar( $pdfname,$cod , $codVehi);
//echo "ok";
$mpdf->Output('' . $pdfname . '', 'I'); //solo lectura
