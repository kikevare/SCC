<?php
   session_start();   
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//  
   include($xPath."includes/xsystem.php");
   include($xPath."includes/evaluaciones.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   
   $xEval = New Evaluaciones( $_POST["curp"] );
   
   $Datos[0]["NOTA"]       = $_POST["nota"];
   $Datos[0]["CURP_EVAL"]  = $xUsr->xCurpEval;
   /*
   $Datos[0]["TOXI"]       = $_POST["toxi"];
   $Datos[0]["MEDICO"]     = $_POST["medico"];
   $Datos[0]["PSICO"]      = $_POST["psico"];
   $Datos[0]["ESOCIAL"]    = $_POST["esocial"];
   $Datos[0]["POLI"]       = $_POST["poli"];
   */   
   $xRslt = $xEval->setAnteNota($Datos);
   if( $xRslt ){
      $xSys->xLog($xUsr->xCveUsr, "antenota", $xEval->xLASTID, "Inserción");
      echo"1";
   }
   else
      echo $xEval->xERROR;   
?>