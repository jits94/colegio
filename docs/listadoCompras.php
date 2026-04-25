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


 $iregistro = new registro();
 //$iProspecto2 = new registro();
 $fechaInicio = $_GET['fechaInicio'];
 $fechaFin = $_GET['fechaFin'];
 $tipoRespaldo = $_GET['tipoRespaldo'];
 $proveedor = $_GET['proveedor'];
  $ordenar = $_GET['ordenar'];
  $codProyecto = $_GET['codProyecto'];
  $fila = $iregistro->traerComprasProductoPDF($fechaInicio,$fechaFin,$tipoRespaldo,$proveedor,$ordenar,$codProyecto);


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
<h3 style="font-weight:bold;font-size:16px;text-align:center;">LISTADO DE COMRPAS</h3>
</div>
</td>

</tr></table>';



// $content .= '<table style="width:100%;margin-top:10px;" cellspacing="0" ><tr><td><span style="font-size:15px"><b>1.- DATOS ACTIVIDAD</b></span></td></tr></table>';

// $content .= '<table style="width:100%;margin-top:10px;" cellspacing="0">
// <tr>
 
//     <td style="width:60%;">
//     <span style="font-size:14px;text-align:left;"><b>- Organización: </b>' . ucwords(strtolower($fila->organizacion)) . '</span>
       
//     </td>   
//     <td style="width:40%;">
//     <span style="font-size:14px;text-align:left;"><b> - Fecha: </b>'.date("d", strtotime($fila->fecha)).' de '.ObtenerMes(date("m", strtotime($fila->fecha))).' del '.date("Y", strtotime($fila->fecha)).'</span>
//     </td>
// </tr>

// </table>
// ';
 
   
    $subtotalGlobal = 0;
    $descuentoGlobal = 0;
    $totalGlobal = 0;
    $content .= '<table style="width:100%;margin-top:10px; font-size: 12px; border-collapse:collapse; " cellspacing="4">
    <thead>
      <tr style="background-color: silver;">        
        <th style="text-align:left; border: 1px solid black; width: 9%; padding:5px;">Nro Compra</th>
        <th style="text-align:left; border: 1px solid black; width: 15%; padding:5px;">Fecha Compra</th>
       
        <th style="text-align:left; border: 1px solid black; width: 15%; padding:5px;">Proveedor</th>               
          <th style="text-align:left; border: 1px solid black; width: 30%; padding:5px;">Producto</th>        
        <th style="text-align:center; border: 1px solid black; width: 7%; padding:5px;">Cant</th>
        <th style="text-align:center; border: 1px solid black; width: 12%; padding:5px;">Precio</th>
        <th style="text-align:center; border: 1px solid black; width: 14%; padding:5px;">Total</th>      
      </tr>
    </thead>
    <tbody>';
   while (!$fila->EndOfSeek()) {
       $row = $fila->Row();
     
      
        $total = $row->cantidad * $row->precio;
          $totalGlobal =  $totalGlobal + $total;
        $producto = $row->producto;
        if($row->producto == ''){
            $producto = $row->nombreProducto;
        }
        $content .= '
        <tr>
            <td style="border: 1px solid black;padding:4px;">' . $row->codCompras . '</td>  
            <td style="border: 1px solid black;padding:4px;">' . date('d-m-Y',strtotime($row->fechaCompra)) . '</td>  
            <td style="border: 1px solid black;padding:4px;">' . ucwords(strtolower($row->proveedor)) . '</td>  
            <td style="border: 1px solid black;padding:4px;">' . ucwords(strtolower($producto)) . '</td>  
            <td style="border: 1px solid black;padding:4px;">' . $row->cantidad . '</td>  
            <td style="border: 1px solid black;padding:4px;">' . number_format($row->precio,2,',','.') . ' Bs</td>  
            <td style="border: 1px solid black;padding:4px;">' . number_format($total,2,',','.') . ' Bs</td>  
        </tr> ';
    }
    $content .='</tbody>
    </tbody>
    <tfoot>
        <tr style="background-color: silver;">
            <td colspan=5 style="text-align:right;border: 1px solid black;padding-right:10px;"><b>TOTAL COMPRAS:<b></td>            
            <td style=" border: 1px solid black;padding:4px;"><b>'.number_format($totalGlobal,2,',','.').' Bs</b></td>
        </tr>
    </tfoot>
    </table>
    ';
    $count ++;
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
$pdfname = "ListaCompras.pdf";
//$mpdf->Output('../spc/uploadetapas/' . $pdfname, 'F'); //guarda a ruta
//$idArchivo = $iProspecto->SubirSolicitudPreliminar( $pdfname,$cod , $codVehi);
//echo "ok";
$mpdf->Output('' . $pdfname . '', 'I'); //solo lectura
