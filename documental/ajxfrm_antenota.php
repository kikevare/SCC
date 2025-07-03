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
   $xUsr = New Usuario();
      
   $xToxi = New Toxicologico($_POST["curp"]);
   $Datos = $xToxi->getAnteNota($xUsr->xCurpEval);
   if( !$Datos ){
      $Evaluador = $xToxi->getDatEvaluador($xUsr->xCurpEval);
      $autor = $Evaluador[0]["NOMENCLAT"]." ".$Evaluador[0]["NOMBRE"];
      $fecha = $xSys->FormatoCorto( date("d-m-Y") );
      $nota = "";
   }      
   else{
      $nota = $Datos[0]["NOTA"];
      $Evaluador = $xToxi->getDatEvaluador($Datos[0]["AUTOR"]);
      $autor = $Evaluador[0]["NOMENCLAT"]." ".$Evaluador[0]["NOMBRE"];
      $fecha = $xSys->FormatoCorto( date("d-m-Y", strtotime($Datos[0]["FECHA"])) );
   }
     
   $html = '<fieldset id="fsContenido" style="width: 460px; float: left; margin-left: 5px;">
         <legend style="font: normal; font-size: 8pt;">&nbsp; Detalles de la Ante-Nota &nbsp;</legend>
         <table class="stytbContenido" cellpadding="0" cellspacing="0" border="0">
            <tr>                        
               <td class="styTdCampo" colspan="2"> 
                  <textarea cols="70" rows="10" name="nota" id="txtNota" class="text">'.$nota.'</textarea> 
               </td>
            </tr>
            <tr>       
               <td class="styTdNombreCampo" style="text-align: left; width: 5%;"> 
                  Fecha: 
               </td>                 
               <td class="styTdCampo" style="width: 95%;"> 
                  <input type="text" name"fecha" id="txtFechaAntenota" size="15" class="textread" value="'.$fecha.'">                                                
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

<?php
/*
<tr>     
               <td class="styTdNombreCampo" style="text-align: left; width: 5%;"> 
                  Para: 
               </td>                    
               <td class="styTdCampo" style="width: 95%;">';
            
               if( $_POST["area_actual"] != "toxicologico" )
                  $html .= '<input type="checkbox" name"toxicologico" id="ckToxicologico" checked="true"> Toxicología &nbsp;&nbsp;&nbsp;';
               if( $_POST["area_actual"] != "medico" )
                  $html .= '<input type="checkbox" name"medico" id="ckMedico" checked="true"> Médico &nbsp;&nbsp;&nbsp;';
               if( $_POST["area_actual"] != "psicologico" )
                  $html .= '<input type="checkbox" name"psicologico" id="ckPsicologico" checked="true"> Psicología &nbsp;&nbsp;&nbsp;';
               if( $_POST["area_actual"] != "esocial" )
                  $html .= '<input type="checkbox" name"esocial" id="ckESocial" checked="true"> E. Social &nbsp;&nbsp;&nbsp;';
               if( $_POST["area_actual"] != "poligrafo" )
                  $html .= '<input type="checkbox" name"poligrafo" id="ckPoligrafo" checked="true"> Polígrafo';
            
            $html .= '</td>
               </tr>';   
            $html .= '
*/
?>