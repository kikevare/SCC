<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=iso-8859-1");
   include($xPath."includes/xsystem.php");
   include($xPath."includes/toxico.class.php");
   $xSys = New System();
      
   $xToxi = New Toxicologico($_POST["curp"]);   
   $fecha = $xSys->FormatoCorto( date("d-m-Y") );
   $html = '<table class="stytbContenido" style="width: 100%;" cellpadding="0" cellspacing="0" border="0">';
   $Datos = $xToxi->getAnteNotas();   
   foreach( $Datos As $registro ){
      $html .= '<tr>';
         $html .= '<td style="font-weight: bold; color: gray;">Área:</td>';
         $html .= '<td>'.$registro["AREA"].'</td>';
      $html .= '</tr>';
      $html .= '<tr>';
         $html .= '<td style="font-weight: bold; color: gray;">Nota:</td>';
         $html .= '<td>'.$registro["NOTA"].'</td>';
      $html .= '</tr>';
      $html .= '<tr style="border-bottom: 1px solid gray;">';
         $html .= '<td style="font-weight: bold; color: gray;">Fecha:</td>';
         $html .= '<td>'.$xSys->FormatoCorto( date("d-m-Y", strtotime($registro["FECHA"])) ).', '.$registro["HORA"].'</td>';
      $html .= '</tr>';
      $html .= '<tr>';
      $html .= '<td colspan="2"> <hr /> </td>';
      $html .= '</tr>';
   }
   $html .= '</table>';
   
   echo $html;
?>