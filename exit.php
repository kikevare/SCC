<?php
   session_start();
   include_once("includes/xsystem.php");
   $xSys = New System();
   if( isset($_SESSION["admitted_xsice"]) ){
      $xUsr = New Usuario();
      $xSys->xLog($xUsr->xCveUsr, "--", "--", "Salir");      
   }
   session_unset();
   session_destroy();
   if( $_POST["x"] != 1 )
   session_unset();
   session_destroy();
      header("Location: ".$xSys->getServer()."login.php");
    
?>
