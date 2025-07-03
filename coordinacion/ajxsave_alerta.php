<?php
   session_start();
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   
   include($xPath."includes/xsystem.php");
   include($xPath."includes/evaluaciones.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xEval = New Evaluaciones( $_POST["curp"] );

   $Datos[0]["DESCRIPCION"] = $_POST["descripcion"];
   $Datos[0]["CURP_EVAL"]   = $xUsr->xCurpEval;
   $xRslt = $xEval->setAlertaRiesgo($Datos);
   if( $xRslt ){
      $xSys->xLog($xUsr->xCveUsr, "alerta riesgo", $xEval->xLASTID, "Insercion");
      echo"1";
   }else
      echo $xEval->xERROR;
?>
