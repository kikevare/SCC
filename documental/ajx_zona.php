<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=iso-8859-1");
   include($xPath."includes/invDocumental.class.php");   
   $xInvDoc  = New invDocumental();
   
   $xDatos= $xInvDoc->getZona($_POST["id_dependencia"]);
   $Datos["ID_MUNICIPIO"]= utf8_encode($xDatos["ID_MUNICIPIO"]);
   $Datos["ENTIDAD"]= utf8_encode($xDatos["ENTIDAD"]);
   $Datos["MUNICIPIO"]= utf8_encode($xDatos["MUNICIPIO"]);
    echo json_encode($Datos);
?>