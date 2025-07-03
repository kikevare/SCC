<?php
   session_start();
   header("content-type: text/html; charset=iso-8859-1");
   include("../../includes/catalogos.class.php");   
   $xCat  = New Catalog();
   
   if( $_POST["id_entidad"] != 0 || $_POST["id_region"] != 0 )
      echo"<option value='0'>-- Seleccione --</option>";
   if( isset($_POST["id_entidad"]) )
      $xCat->shwMunicipio(0, $_POST["id_entidad"]);
   else if( isset($_POST["id_region"]) )
      $xCat->shwMunicipio(0, 0, $_POST["id_region"]);   
?>