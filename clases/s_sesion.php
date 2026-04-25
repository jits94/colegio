<?php
if(session_id()=="")
{
    @session_start();
   
    
}

if(!isset($_SESSION['usuario'])) {
    header('Location: ../login.php');
}
// error_reporting(E_ERROR);
// ini_set('display_errors', 1);
?>