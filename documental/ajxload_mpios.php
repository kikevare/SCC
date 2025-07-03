<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=iso-8859-1");
   include($xPath."includes/catalogos.class.php");   
   $xCat  = New Catalog();
   
   if( $_POST["id_entidad"] != 0 || $_POST["id_region"] != 0 )
      echo"<option value='0'>-- Seleccione --</option>";
   if( isset($_POST["id_entidad"]) )
      $xCat->shwMunicipio(0, $_POST["id_entidad"]);
   else if( isset($_POST["id_region"]) )
      $xCat->shwMunicipio(0, 0, $_POST["id_region"]);
?>