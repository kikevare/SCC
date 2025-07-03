<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=iso-8859-1");
   include_once($xPath."includes/xsystem.php");
   include_once($xPath."includes/persona.class.php");
   $xSys = New System();
   $xPersona = New Persona();
   $xUsr = New Usuario();

   $curp_evaluador = $_POST["xId"];
   //$result = 'vacio';
   if( $xPersona->setBajaEval($curp_evaluador) ){
      $xSys->xLog($xUsr->xCveUsr, "tbevaluadores", $curp_evaluador, "BajaEval");
      $result = "ELEMENTO BORRADO";
   }else{
      $result = $xPersona->xERROR;
      //$result = 'mal :(';
   }

   echo $result;
?>
