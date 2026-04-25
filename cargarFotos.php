<?php 

include_once "clases/registro.php";

//$cod=$_POST["cod"];
// $nombre=$_POST["txtNombreActividad"];
// $fecha=$_POST["txtFecha"];
// $detalle=$_POST["txtdetalle"];
//$iProspecto = new registro();

//$cod = $iProspecto->registrarAcontecimiento($nombre, $detalle,$fecha);	             


// if($cod == 0){
//     echo 'Error al registrar el acontecimiento';
// }

//echo $cod;
//return;
$bArchivo=false;
$bError=false;
$archivos=0;
$error=0;
$merror="";
$contador=0;

 
echo  count($_FILES['uFile']['name']);
//****************************************************************************
//if(count($_FILES['uFile']['name'])){
   // for($i=0; $i<count($_FILES['uFile']['name']); $i++) {
        $contador+=1;
        $tmpFilePath = $_FILES['uFile']['tmp_name'];
        //do your upload stuff here
        //****************************************************************************
        $allowedExts = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG", "PDF");
        $temp = explode(".", $_FILES['uFile']["name"]);
        $extension = end($temp);
        echo $extension;
        if (in_array($extension, $allowedExts))
        {
            $bArchivo=true;
            if ($_FILES['uFile']["error"] > 0)
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
                if (file_exists("imagenes/respaldos/".$nuevonombre))
                {	
                    $string2="";
                    for ($i = 0; $i < 3; $i++) {
                        $string2 .= $characters[rand(0, strlen($characters) - 1)];
                    }
                    $nuevonombre=$temp[0]."_".$i."_".$string.$string2.$extension;
                }
                move_uploaded_file($_FILES['uFile']["tmp_name"],"imagenes/respaldos/".$nuevonombre);
                chmod("imagenes/respaldos/".$nuevonombre, 0777);
               // $iProspecto->AgregarArchivo2($cod, $nuevonombre);	                               
            }
        }else{
            $bError=true;
            echo " El tipo de archivo enviado no esta permitido.";
        }

        //------------------------------------------------------------------------------------------
        if ($bError==false){

            $archivos+=1;
        }else{

            $error+=1;
        }
        //******************************************************************************************
    //}

// }else{
// $merror="no entro a ningun lado";
// }
if(($archivos>0) and ($error==0)){
  
    //header('Location: ./acontecimientos.php?cod='.$cod);
    echo 'ok';
}else{
    
    echo $merror;
   
}   
?>