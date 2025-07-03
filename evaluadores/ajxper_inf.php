<?php
   session_start();
   header("content-type: text/html; charset=iso-8859-1");
   include("../../includes/xsystem.php");
   include("../../includes/persona.class.php");
   $xSys = New System();
        
   $curp = $_POST["xid"];
   
   $xPersona = New Persona($curp);
   
   /*
   if( file_exists("../../doctos/fotos/personas/".$curp.".jpg") )
      $xfoto = "../../doctos/fotos/personas/".$curp.".jpg";
   else
   */
      $xfoto = "../../imgs/sin_foto.png";     
   
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
                  <td style='font-weight: bold;'>Cédula Profesional:</td>
                  <td>".$xPersona->CEDULA."</td>
               </tr>               
               <tr>
                  <td style='font-weight: bold;'>Nivel de Estudios:</td>
                  <td>".$xPersona->getNivEstudios()." [".$xPersona->getStatEstudios()."]"."</td>
               </tr> 
               <tr>
                  <td style='font-weight: bold;'>Carrera:</td>
                  <td>".$xPersona->CARRERA."</td>
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
                  <td style='font-weight: bold;'>Cartilla SMN:</td>
                  <td>".$xPersona->CARTILLA."</td>
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