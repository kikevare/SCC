<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=utf-8");   
   include($xPath."includes/xsystem.php");
   $xSys = New System();
   
   $cadena = $_POST["dato"];
   $fecha = substr($cadena, 4, 2)."-".substr($cadena, 2, 2)."-19".substr($cadena, 0, 2);
   
   echo $xSys->FormatoCorto($fecha);   
?>