<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=utf-8");
   include($xPath."includes/xsystem.php");
   include($xPath."includes/invDocumental.class.php");
   $xSys = New System();
   $xInvDoc = New invDocumental( $_SESSION["xCurp"] );
   $xUsr = New Usuario();
   
   $nvo_valor  = $_POST["nvo_valor"];
   $mupio      = $_POST["mupio"];
   
   //--- Nva persona quien consulta... 
   if( $xInvDoc->addZona($nvo_valor,$mupio) ){
      $xSys->xLog($xUsr->xCveUsr, "ctdependenciaexpcartilla", $xInvDoc->xLASTID, "Inserción");
      echo $xInvDoc->shwInvDepExpCartilla($xInvDoc->xLASTID);
            
   }
   else
      echo "0";
?>