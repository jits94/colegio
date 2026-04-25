<?php 

include_once "clases/registro.php";

$cod=$_POST["cod"];
$tipo=$_POST["tipo"];
$tipodoc=$_POST["tipodoc"];

$iProspecto = new registro();
$bArchivo=false;
$bError=false;
$archivos=0;
$error=0;
$merror="";
$contador=0;
//****************************************************************************
if(count($_FILES['uFile']['name'])){
    for($i=0; $i<count($_FILES['uFile']['name']); $i++) {
        $contador+=1;
        $tmpFilePath = $_FILES['uFile']['tmp_name'][$i];
        //do your upload stuff here
        //****************************************************************************
        $allowedExts = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
        $temp = explode(".", $_FILES['uFile']["name"][$i]);
        $extension = end($temp);
        if (in_array($extension, $allowedExts))
        {
            $bArchivo=true;
            if ($_FILES['uFile']["error"][$i] > 0)
            {
                $bError=true;
                $merror=" Error al recibir el archivo.";
                // echo "<pre>";
                // print_r($_FILES);
                // echo "</pre>";
            }else{
                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $string = '';
                for ($j = 0; $j < 4; $j++) {
                    $string .= $characters[rand(0, strlen($characters) - 1)];
                }
                $aux=$temp[0];
                if(strlen($aux)>20){
                    $aux=substr($aux,0,20);
                }
                $nuevonombre=$aux."_".$string.".".$extension;
                $nuevonombre=str_replace(" ","-",$nuevonombre);
                if (file_exists("imagenes/".$nuevonombre))
                {	
                    $string2="";
                    for ($i = 0; $i < 3; $i++) {
                        $string2 .= $characters[rand(0, strlen($characters) - 1)];
                    }
                    $nuevonombre=$temp[0]."_".$i."_".$string.$string2.$extension;
                }
                move_uploaded_file($_FILES['uFile']["tmp_name"][$i],"imagenes/".$nuevonombre);
                chmod("imagenes/".$nuevonombre, 0777);
                $iProspecto->AgregarArchivo($cod, $nuevonombre);	
                
               

            }
        }else{
            $bError=true;
            $merror=" El tipo de archivo enviado no esta permitido.";
        }

        //------------------------------------------------------------------------------------------
        if ($bError==false){

            $archivos+=1;
        }else{

            $error+=1;
        }
        //******************************************************************************************
    }

}else{
$merror="no entro a ningun lado";
}
if(($archivos>0) and ($error==0)){
  
    header('Location: ./registro.php?cod='.$_POST["cod"]);
    
}else{
    
    header('Location: ./registro.php?cod='.$_POST["cod"].'&error=adjunto&merror='.$merror.'#tabProductos');
   
}   
?>