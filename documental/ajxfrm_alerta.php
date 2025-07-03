<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=iso-8859-1");
   include($xPath."includes/xsystem.php");
   include($xPath."includes/medico.class.php");
   $xSys = New System();
   $xUsr = New Usuario();
   $xMed = New Medico($_POST["curp"]);

   $Datos = $xMed->getAlertaRiesgo($xUsr->xCurpEval);
   if( !$Datos ){
      $Evaluador = $xMed->getDatEvaluador($xUsr->xCurpEval);
      $autor = $Evaluador[0]["NOMENCLAT"]." ".$Evaluador[0]["NOMBRE"];
      $fecha = $xSys->FormatoCorto( date("d-m-Y") );
      $nota = "";
   }
   else{
      //$descripcion = $Datos[0]["DESCRIPCION"];
      $Evaluador = $xMed->getDatEvaluador($Datos[0]["AUTOR"]);
      $autor = $Evaluador[0]["NOMENCLAT"]." ".$Evaluador[0]["NOMBRE"];
      $fecha = $xSys->FormatoCorto( date("d-m-Y", strtotime($Datos[0]["FECHA"])) );
   }
/* <textarea cols="70" rows="10" name="nota" id="txtNota" class="text noResizeTextarea">'.$nota.'</textarea> */
   $html = '<fieldset class="border p-2">
         <legend class="w-auto">&nbsp; Ingrese detalles &nbsp;</legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
            <tr>
               <td class="styTdCampo" colspan="2">
                  <textarea cols="70" rows="10" name="descripcion" id="txtDescripcion" class="text noResizeTextarea"></textarea>
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo" style="text-align: left; width: 5%;">
                  Fecha:
               </td>
               <td class="styTdCampo" style="width: 95%;">
                  <input type="text" name"fecha" id="txtFechaAlerta" size="15" class="textread" value="'.$fecha.'">
               </td>
            </tr>
            <tr>
               <td class="styTdNombreCampo" style="text-align: left; width: 5%;">
                  Autor:
               </td>
               <td class="styTdCampo" style="width: 95%;">
                  <input type="text" name"evaluador" id="txtEvaluador" size="45" class="textread" value="'.$autor.'">
               </td>
            </tr>
         </table>
      </fieldset>';

   echo $html;
?>
