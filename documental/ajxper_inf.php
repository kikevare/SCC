<?php
   session_start();
   //-------------------------------------------------------------//
   $xLEVEL = substr_count($_SERVER["SCRIPT_NAME"], "/") - substr_count($_SESSION["xroot"], "/");
   for( $i = 0; $i < $xLEVEL; $i++ )  $xPath .= "../";
   //-------------------------------------------------------------//
   header("content-type: text/html; charset=iso-8859-1");
   include($xPath."includes/xsystem.php");
   include($xPath."includes/persona.class.php");
   $xSys = New System();
        
   $curp = $_POST["xid"];
   
   $xPersona = New Persona($curp);
   
   /*
   if( file_exists("../../doctos/fotos/personas/".$curp.".jpg") )
      $xfoto = "../../doctos/fotos/personas/".$curp.".jpg";
   else
   */
   $xfoto = $xPersona->getFoto();
   if( !empty($xfoto) )
      $xfoto = $xPath.$xfoto;
   else      
      $xfoto = $xPath."imgs/sin_foto.png";    
   
   echo"
      <table style='width: 100%;' cellpadding='0' cellspacing='0' border='0'>
      <tr>
         <td style='padding: 3px 7px 3px 3px;'>
            <div style='border: 1px dotted #cccccb; padding: 1px 1px 1px 1px; margin: 2px 5px 2px 5px; float: left;'>
               <img src='".$xfoto."' width='80' height='95' title='Fotografía' />
            </div>
         </td>
         <td style='border-left: 1px solid #cccccb; padding: 3px 3px 3px 7px;'>
            <table class='tbDataToolTip' style='float: left;' cellpadding='0' cellspacing='0' border='0'>
               <tr>
                  <td style='width: 100px; font-weight: bold;'>Especialidad:</td>
                  <td>".$xPersona->getEspecialidad()."</td>
               </tr>
               <tr>
                  <td style='font-weight: bold;'>Adscripción:</td>
                  <td>".$xPersona->AREAADSCRIP."</td>
               </tr>
               <tr>
                  <td style='font-weight: bold;'>C.U.I.P.:</td>
                  <td>".$xPersona->CUIP."</td>
               </tr>
               <tr>
                  <td style='font-weight: bold;'>Nivel de Estudios:</td>
                  <td>".$xPersona->getNivEstudios()." [".$xPersona->getStatEstudios()."]"."</td>
               </tr> 
               <tr>
                  <td style='font-weight: bold;'>Fecha Nacimiento:</td>
                  <td>".$xSys->FormatoCorto( date("d-m-Y", strtotime($xPersona->FECHANAC)) )."</td>
               </tr>
               <tr>
                  <td style='font-weight: bold;'>Edad:</td>
                  <td>".$xPersona->EDAD." Años</td>
               </tr>
               <tr>
                  <td style='font-weight: bold;'>Domicilio:</td>
                  <td>".$xPersona->CALLE." ".$xPersona->NUMEXT.", Col. ".$xPersona->COLONIA."</td>
               </tr>  
               <tr>
                  <td style='font-weight: bold;'>Teléfono Cel.:</td>
                  <td>".$xPersona->TELMOVIL."</td>
               </tr>            
            </table>
         </td>
      </tr>
      </table>          
   ";
?>